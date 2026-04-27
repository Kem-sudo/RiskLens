<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class RegisterController extends Controller
{
    public function showRegister()
    {
        // CHANGE THIS - look for auth/register.blade.php
        $roles = Role::where('Role_Name', '!=', 'Super Admin')->get();
        return view('auth.register', compact('roles'));  // ← Changed from 'register' to 'auth.register'
    }
    
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,Email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|exists:roles,Role_ID',
        ], [
            'email.unique' => 'This email is already registered.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password.min' => 'Password must be at least 6 characters.',
        ]);
        
        try {
            $user = User::create([
                'Role_ID' => $request->role,
                'Name' => $request->name,
                'Email' => $request->email,
                'Password' => Hash::make($request->password),
                'Status' => 'active',
                'Created_at' => now(),
            ]);
            
            session([
                'user_id' => $user->User_ID,
                'user_name' => $user->Name,
                'user_email' => $user->Email,
                'role_id' => $user->Role_ID,
                'role_name' => $user->role->Role_Name ?? 'Employee',
                'is_logged_in' => true
            ]);
            
            return redirect()->route('dashboard')->with('success', 'Account created successfully! Welcome to RiskLens!');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Registration failed: ' . $e->getMessage())->withInput();
        }
    }
}