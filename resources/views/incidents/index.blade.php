@extends('layouts.app')

@section('title', 'Incident Tracking')

@section('content')
@php
    $role = session('role_name');
    $canCreate = in_array($role, ['Super Admin', 'System Admin', 'Department Manager', 'Employee']);
    $canEdit = in_array($role, ['Super Admin', 'System Admin', 'Compliance Officer', 'Internal Auditor']);
    $canDelete = in_array($role, ['Super Admin', 'System Admin']);
@endphp
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted mb-1">Open Incidents</h6>
                    <h3 class="mb-0">{{ $openIncidentsCount }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-exclamation-triangle me-2"></i> Incident Tracking</span>
            <div class="d-flex gap-2">
                <form method="GET" action="{{ route('incidents.index') }}" class="d-flex gap-2">
                    <select name="status" class="form-control form-control-sm" style="min-width: 170px;">
                        <option value="">All Status</option>
                        @foreach(['Open', 'In Progress', 'Resolved', 'Closed'] as $statusOption)
                            <option value="{{ $statusOption }}" {{ $status === $statusOption ? 'selected' : '' }}>{{ $statusOption }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-sm btn-outline-secondary" type="submit">Filter</button>
                </form>
                @if($canCreate)
                    <a href="{{ route('incidents.create') }}" class="btn btn-sm btn-dark"><i class="fas fa-plus me-1"></i> New Incident</a>
                @endif
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Reported By</th>
                            <th>Reported Date</th>
                            <th>Attachments</th>
                            <th width="140">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($incidents as $incident)
                            <tr>
                                <td>{{ $incident->Incident_ID }}</td>
                                <td>{{ $incident->Incident_Title }}</td>
                                <td><span class="badge bg-{{ $incident->status_badge_class }}">{{ $incident->Status }}</span></td>
                                <td>{{ $incident->reporter->Name ?? 'N/A' }}</td>
                                <td>{{ date('M d, Y', strtotime($incident->Reported_Date)) }}</td>
                                <td>{{ $incident->attachments->count() }}</td>
                                <td>
                                    @if($canEdit)
                                        <a href="{{ route('incidents.edit', $incident->Incident_ID) }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-edit"></i></a>
                                    @endif
                                    @if($canDelete)
                                        <form action="{{ route('incidents.destroy', $incident->Incident_ID) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this incident?')"><i class="fas fa-trash"></i></button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">No incidents found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
