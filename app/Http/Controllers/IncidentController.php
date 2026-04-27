<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\IncidentAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class IncidentController extends Controller
{
    private array $fullAccessRoles = ['Super Admin', 'System Admin'];
    private array $updateRoles = ['Super Admin', 'System Admin', 'Compliance Officer', 'Internal Auditor'];
    private array $createRoles = ['Super Admin', 'System Admin', 'Department Manager', 'Employee'];

    public function index(Request $request)
    {
        if ($response = $this->guardLoggedIn()) {
            return $response;
        }

        $status = $request->query('status');
        $query = Incident::with(['reporter', 'attachments'])->orderBy('Incident_ID', 'desc');

        if (!empty($status)) {
            $query->where('Status', $status);
        }

        $incidents = $query->get();
        $openIncidentsCount = Incident::whereIn('Status', ['Open', 'In Progress'])->count();

        return view('incidents.index', compact('incidents', 'status', 'openIncidentsCount'));
    }

    public function create()
    {
        if ($response = $this->guardLoggedIn()) {
            return $response;
        }
        if ($response = $this->authorizeAny($this->createRoles, 'You do not have permission to add incidents.')) {
            return $response;
        }

        return view('incidents.create');
    }

    public function store(Request $request)
    {
        if ($response = $this->guardLoggedIn()) {
            return $response;
        }
        if ($response = $this->authorizeAny($this->createRoles, 'You do not have permission to add incidents.')) {
            return $response;
        }

        $request->validate([
            'incident_title' => 'required|string|max:100',
            'description' => 'required|string',
            'status' => 'required|in:Open,In Progress,Resolved,Closed',
            'reported_date' => 'required|date',
            'attachments.*' => 'nullable|file|max:5120|mimes:jpg,jpeg,png,pdf,doc,docx,xlsx,xls,txt',
        ]);

        $incident = Incident::create([
            'Reported_by' => Session::get('user_id'),
            'Incident_Title' => $request->incident_title,
            'Description' => $request->description,
            'Status' => $request->status,
            'Reported_Date' => $request->reported_date,
        ]);

        $this->storeAttachments($request, $incident->Incident_ID);

        return redirect()->route('incidents.index')->with('success', 'Incident added successfully!');
    }

    public function edit($id)
    {
        if ($response = $this->guardLoggedIn()) {
            return $response;
        }
        if ($response = $this->authorizeAny($this->updateRoles, 'You do not have permission to edit incidents.')) {
            return $response;
        }

        $incident = Incident::with('attachments')->findOrFail($id);

        return view('incidents.edit', compact('incident'));
    }

    public function update(Request $request, $id)
    {
        if ($response = $this->guardLoggedIn()) {
            return $response;
        }
        if ($response = $this->authorizeAny($this->updateRoles, 'You do not have permission to update incidents.')) {
            return $response;
        }

        $request->validate([
            'incident_title' => 'required|string|max:100',
            'description' => 'required|string',
            'status' => 'required|in:Open,In Progress,Resolved,Closed',
            'reported_date' => 'required|date',
            'attachments.*' => 'nullable|file|max:5120|mimes:jpg,jpeg,png,pdf,doc,docx,xlsx,xls,txt',
        ]);

        $incident = Incident::findOrFail($id);
        $incident->update([
            'Incident_Title' => $request->incident_title,
            'Description' => $request->description,
            'Status' => $request->status,
            'Reported_Date' => $request->reported_date,
        ]);

        $this->storeAttachments($request, $incident->Incident_ID);

        return redirect()->route('incidents.index')->with('success', 'Incident updated successfully!');
    }

    public function destroy($id)
    {
        if ($response = $this->guardLoggedIn()) {
            return $response;
        }
        if ($response = $this->authorizeAny($this->fullAccessRoles, 'Only Super Admin and System Admin can delete incidents.')) {
            return $response;
        }

        $incident = Incident::with('attachments')->findOrFail($id);
        foreach ($incident->attachments as $attachment) {
            if (!empty($attachment->File_Path)) {
                Storage::disk('public')->delete($attachment->File_Path);
            }
        }
        $incident->delete();

        return redirect()->route('incidents.index')->with('success', 'Incident deleted successfully!');
    }

    public function deleteAttachment($id)
    {
        if ($response = $this->guardLoggedIn()) {
            return $response;
        }
        if ($response = $this->authorizeAny($this->updateRoles, 'You do not have permission to remove attachments.')) {
            return $response;
        }

        $attachment = IncidentAttachment::findOrFail($id);
        if (!empty($attachment->File_Path)) {
            Storage::disk('public')->delete($attachment->File_Path);
        }
        $attachment->delete();

        return back()->with('success', 'Attachment removed successfully.');
    }

    private function storeAttachments(Request $request, int $incidentId): void
    {
        if (!$request->hasFile('attachments')) {
            return;
        }

        foreach ($request->file('attachments') as $file) {
            $path = $file->store('incident_attachments', 'public');
            IncidentAttachment::create([
                'Incident_ID' => $incidentId,
                'File_Path' => $path,
                'Uploaded_at' => now(),
            ]);
        }
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
