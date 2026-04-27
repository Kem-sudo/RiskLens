<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compliance;
use App\Models\Policy;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class ComplianceController extends Controller
{
    // Display all compliance records
    public function index()
    {
        // Check if user has access
        $userRole = Session::get('role_name');
        $allowedRoles = ['Super Admin', 'System Admin', 'Compliance Officer', 'Internal Auditor'];
        
        if (!in_array($userRole, $allowedRoles)) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to view compliance records.');
        }
        
        $compliance = Compliance::with(['policy', 'checker'])->orderBy('Compliance_ID', 'desc')->get();
        return view('compliance.index', compact('compliance'));
    }

    // Show create form
    public function create()
    {
        $userRole = Session::get('role_name');
        $allowedRoles = ['Super Admin', 'System Admin', 'Compliance Officer', 'Internal Auditor'];
        
        if (!in_array($userRole, $allowedRoles)) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to add compliance records.');
        }
        
        $policies = Policy::all();
        return view('compliance.create', compact('policies'));
    }

    // Store new compliance record
    public function store(Request $request)
    {
        $userRole = Session::get('role_name');
        $allowedRoles = ['Super Admin', 'System Admin', 'Compliance Officer', 'Internal Auditor'];
        
        if (!in_array($userRole, $allowedRoles)) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to add compliance records.');
        }
        
        $request->validate([
            'policy_id' => 'required|exists:policies,Policy_ID',
            'status' => 'required|string',
            'review_date' => 'required|date',
            'remarks' => 'nullable|string'
        ]);

        Compliance::create([
            'PolicyID' => $request->policy_id,
            'Checked_by' => Session::get('user_id'),
            'Status' => $request->status,
            'Review_Date' => $request->review_date,
            'Remarks' => $request->remarks,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('compliance.index')->with('success', 'Compliance record added successfully!');
    }

    // Show edit form
    public function edit($id)
    {
        $userRole = Session::get('role_name');
        $allowedRoles = ['Super Admin', 'System Admin', 'Compliance Officer', 'Internal Auditor'];
        
        if (!in_array($userRole, $allowedRoles)) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to edit compliance records.');
        }
        
        $compliance = Compliance::findOrFail($id);
        $policies = Policy::all();
        return view('compliance.edit', compact('compliance', 'policies'));
    }

    // Update compliance record
    public function update(Request $request, $id)
    {
        $userRole = Session::get('role_name');
        $allowedRoles = ['Super Admin', 'System Admin', 'Compliance Officer', 'Internal Auditor'];
        
        if (!in_array($userRole, $allowedRoles)) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to update compliance records.');
        }
        
        $request->validate([
            'policy_id' => 'required|exists:policies,Policy_ID',
            'status' => 'required|string',
            'review_date' => 'required|date',
            'remarks' => 'nullable|string'
        ]);

        $compliance = Compliance::findOrFail($id);
        $compliance->update([
            'PolicyID' => $request->policy_id,
            'Status' => $request->status,
            'Review_Date' => $request->review_date,
            'Remarks' => $request->remarks,
            'updated_at' => now()
        ]);

        return redirect()->route('compliance.index')->with('success', 'Compliance record updated successfully!');
    }

    // Delete compliance record
    public function destroy($id)
    {
        $userRole = Session::get('role_name');
        $allowedRoles = ['Super Admin', 'System Admin'];
        
        if (!in_array($userRole, $allowedRoles)) {
            return redirect()->route('dashboard')->with('error', 'Only Super Admin and System Admin can delete compliance records.');
        }
        
        $compliance = Compliance::findOrFail($id);
        $compliance->delete();

        return redirect()->route('compliance.index')->with('success', 'Compliance record deleted successfully!');
    }
}