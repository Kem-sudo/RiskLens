@extends('layouts.app')

@section('title', 'Internal Audits')

@section('content')
@php
    $role = session('role_name');
    $canManage = in_array($role, ['Super Admin', 'System Admin', 'Internal Auditor']);
@endphp
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-clipboard-list me-2"></i> Internal Audits</span>
            @if($canManage)
                <a href="{{ route('audits.create') }}" class="btn btn-sm btn-dark"><i class="fas fa-plus me-1"></i> New Audit</a>
            @endif
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Auditor</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Linked Compliance</th>
                            <th width="190">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($audits as $audit)
                            <tr>
                                <td>{{ $audit->Audit_ID }}</td>
                                <td>{{ $audit->Audit_Title }}</td>
                                <td>{{ $audit->auditor->Name ?? 'N/A' }}</td>
                                <td>{{ date('M d, Y', strtotime($audit->Audit_Date)) }}</td>
                                <td>
                                    <span class="badge bg-{{ $audit->Status === 'Completed' ? 'success' : ($audit->Status === 'In Progress' ? 'warning' : 'secondary') }}">
                                        {{ $audit->Status }}
                                    </span>
                                </td>
                                <td>{{ $audit->complianceItems->count() }}</td>
                                <td>
                                    <a href="{{ route('audits.report', $audit->Audit_ID) }}" class="btn btn-sm btn-outline-primary">Report</a>
                                    @if($canManage)
                                        <a href="{{ route('audits.edit', $audit->Audit_ID) }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('audits.destroy', $audit->Audit_ID) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this audit?')" type="submit"><i class="fas fa-trash"></i></button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">No audits found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
