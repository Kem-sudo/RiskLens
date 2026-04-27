<?php

namespace App\Http\Controllers;

use App\Models\Policy;
use App\Models\PolicyAcknowledgment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PolicyController extends Controller
{
    private array $fullAccessRoles = ['Super Admin', 'System Admin'];
    private array $createEditRoles = ['Super Admin', 'System Admin', 'Compliance Officer'];

    public function index()
    {
        if ($response = $this->guardLoggedIn()) {
            return $response;
        }

        $policies = Policy::with(['creator', 'acknowledgments.user'])
            ->orderBy('Policy_ID', 'desc')
            ->get();

        return view('policies.index', compact('policies'));
    }

    public function create()
    {
        if ($response = $this->guardLoggedIn()) {
            return $response;
        }
        if ($response = $this->authorizeAny($this->createEditRoles, 'You do not have permission to add policies.')) {
            return $response;
        }

        return view('policies.create');
    }

    public function store(Request $request)
    {
        if ($response = $this->guardLoggedIn()) {
            return $response;
        }
        if ($response = $this->authorizeAny($this->createEditRoles, 'You do not have permission to add policies.')) {
            return $response;
        }

        $request->validate([
            'policy_title' => 'required|string|max:100',
            'description' => 'required|string',
        ]);

        Policy::create([
            'Created_by' => Session::get('user_id'),
            'Policy_Title' => $request->policy_title,
            'Description' => $request->description,
            'Created_at' => now(),
        ]);

        return redirect()->route('policies.index')->with('success', 'Policy created successfully.');
    }

    public function edit($id)
    {
        if ($response = $this->guardLoggedIn()) {
            return $response;
        }
        if ($response = $this->authorizeAny($this->createEditRoles, 'You do not have permission to edit policies.')) {
            return $response;
        }

        $policy = Policy::findOrFail($id);
        return view('policies.edit', compact('policy'));
    }

    public function update(Request $request, $id)
    {
        if ($response = $this->guardLoggedIn()) {
            return $response;
        }
        if ($response = $this->authorizeAny($this->createEditRoles, 'You do not have permission to update policies.')) {
            return $response;
        }

        $request->validate([
            'policy_title' => 'required|string|max:100',
            'description' => 'required|string',
        ]);

        $policy = Policy::findOrFail($id);
        $policy->update([
            'Policy_Title' => $request->policy_title,
            'Description' => $request->description,
        ]);

        return redirect()->route('policies.index')->with('success', 'Policy updated successfully.');
    }

    public function destroy($id)
    {
        if ($response = $this->guardLoggedIn()) {
            return $response;
        }
        if ($response = $this->authorizeAny($this->fullAccessRoles, 'Only Super Admin and System Admin can delete policies.')) {
            return $response;
        }

        $policy = Policy::findOrFail($id);
        $policy->delete();

        return redirect()->route('policies.index')->with('success', 'Policy deleted successfully.');
    }

    public function acknowledge($id)
    {
        if ($response = $this->guardLoggedIn()) {
            return $response;
        }

        $policy = Policy::findOrFail($id);
        PolicyAcknowledgment::firstOrCreate(
            [
                'Policy_ID' => $policy->Policy_ID,
                'User_ID' => Session::get('user_id'),
            ],
            [
                'Acknowledged_at' => now(),
            ]
        );

        return back()->with('success', 'Policy acknowledged successfully.');
    }

    public function usersForAcknowledgment($id)
    {
        if ($response = $this->guardLoggedIn()) {
            return $response;
        }
        if ($response = $this->authorizeAny($this->createEditRoles, 'You do not have permission to view acknowledgment details.')) {
            return $response;
        }

        $policy = Policy::with('acknowledgments.user')->findOrFail($id);
        $employees = User::whereHas('role', function ($query) {
            $query->where('Role_Name', 'Employee');
        })->get();

        return view('policies.acknowledgments', compact('policy', 'employees'));
    }

    private function guardLoggedIn()
    {
        if (!Session::get('is_logged_in')) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }
        return null;
    }

    private function authorizeAny(array $roles, string $message)
    {
        if (!in_array(Session::get('role_name'), $roles)) {
            return redirect()->route('dashboard')->with('error', $message);
        }
        return null;
    }
}
