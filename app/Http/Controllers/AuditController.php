<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Compliance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuditController extends Controller
{
    private array $fullAccessRoles = ['Super Admin', 'System Admin', 'Internal Auditor'];
    private array $viewOnlyRoles = ['Compliance Officer'];

    public function index()
    {
        if ($response = $this->guardLoggedIn()) {
            return $response;
        }
        if ($response = $this->authorizeAccess()) {
            return $response;
        }

        $audits = Audit::with(['auditor', 'complianceItems'])
            ->orderBy('Audit_ID', 'desc')
            ->get();

        return view('audits.index', compact('audits'));
    }

    public function create()
    {
        if ($response = $this->guardLoggedIn()) {
            return $response;
        }
        if ($response = $this->authorizeAny($this->fullAccessRoles, 'You do not have permission to add audits.')) {
            return $response;
        }

        $auditors = User::whereHas('role', function ($query) {
            $query->whereIn('Role_Name', ['Super Admin', 'System Admin', 'Internal Auditor']);
        })->get();
        $complianceItems = Compliance::orderBy('Compliance_ID', 'desc')->get();

        return view('audits.create', compact('auditors', 'complianceItems'));
    }

    public function store(Request $request)
    {
        if ($response = $this->guardLoggedIn()) {
            return $response;
        }
        if ($response = $this->authorizeAny($this->fullAccessRoles, 'You do not have permission to add audits.')) {
            return $response;
        }

        $request->validate([
            'audit_title' => 'required|string|max:100',
            'auditor_id' => 'required|exists:users,User_ID',
            'findings' => 'nullable|string',
            'audit_date' => 'required|date',
            'status' => 'required|in:Planning,In Progress,Completed',
            'compliance_ids' => 'nullable|array',
            'compliance_ids.*' => 'exists:compliance,Compliance_ID',
        ]);

        $audit = Audit::create([
            'Auditor_ID' => $request->auditor_id,
            'Audit_Title' => $request->audit_title,
            'Findings' => $request->findings,
            'Audit_Date' => $request->audit_date,
            'Status' => $request->status,
        ]);

        $audit->complianceItems()->sync($request->compliance_ids ?? []);

        return redirect()->route('audits.index')->with('success', 'Audit created successfully.');
    }

    public function edit($id)
    {
        if ($response = $this->guardLoggedIn()) {
            return $response;
        }
        if ($response = $this->authorizeAny($this->fullAccessRoles, 'You do not have permission to edit audits.')) {
            return $response;
        }

        $audit = Audit::with('complianceItems')->findOrFail($id);
        $auditors = User::whereHas('role', function ($query) {
            $query->whereIn('Role_Name', ['Super Admin', 'System Admin', 'Internal Auditor']);
        })->get();
        $complianceItems = Compliance::orderBy('Compliance_ID', 'desc')->get();

        return view('audits.edit', compact('audit', 'auditors', 'complianceItems'));
    }

    public function update(Request $request, $id)
    {
        if ($response = $this->guardLoggedIn()) {
            return $response;
        }
        if ($response = $this->authorizeAny($this->fullAccessRoles, 'You do not have permission to update audits.')) {
            return $response;
        }

        $request->validate([
            'audit_title' => 'required|string|max:100',
            'auditor_id' => 'required|exists:users,User_ID',
            'findings' => 'nullable|string',
            'audit_date' => 'required|date',
            'status' => 'required|in:Planning,In Progress,Completed',
            'compliance_ids' => 'nullable|array',
            'compliance_ids.*' => 'exists:compliance,Compliance_ID',
        ]);

        $audit = Audit::findOrFail($id);
        $audit->update([
            'Auditor_ID' => $request->auditor_id,
            'Audit_Title' => $request->audit_title,
            'Findings' => $request->findings,
            'Audit_Date' => $request->audit_date,
            'Status' => $request->status,
        ]);

        $audit->complianceItems()->sync($request->compliance_ids ?? []);

        return redirect()->route('audits.index')->with('success', 'Audit updated successfully.');
    }

    public function destroy($id)
    {
        if ($response = $this->guardLoggedIn()) {
            return $response;
        }
        if ($response = $this->authorizeAny($this->fullAccessRoles, 'You do not have permission to delete audits.')) {
            return $response;
        }

        $audit = Audit::findOrFail($id);
        $audit->delete();

        return redirect()->route('audits.index')->with('success', 'Audit deleted successfully.');
    }

    public function report($id)
    {
        if ($response = $this->guardLoggedIn()) {
            return $response;
        }
        if ($response = $this->authorizeAccess()) {
            return $response;
        }

        $audit = Audit::with(['auditor', 'complianceItems.policy'])->findOrFail($id);
        return view('audits.report', compact('audit'));
    }

    private function guardLoggedIn()
    {
        if (!Session::get('is_logged_in')) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }
        return null;
    }

    private function authorizeAccess()
    {
        $role = Session::get('role_name');
        if (!in_array($role, array_merge($this->fullAccessRoles, $this->viewOnlyRoles))) {
            return redirect()->route('dashboard')->with('error', 'You do not have access to audits.');
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
