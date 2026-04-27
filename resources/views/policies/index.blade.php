@extends('layouts.app')

@section('title', 'Policy Management')

@section('content')
@php
    $role = session('role_name');
    $canCreateEdit = in_array($role, ['Super Admin', 'System Admin', 'Compliance Officer']);
    $canDelete = in_array($role, ['Super Admin', 'System Admin']);
@endphp
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-file-alt me-2"></i> Policy Management</span>
            @if($canCreateEdit)
                <a href="{{ route('policies.create') }}" class="btn btn-sm btn-dark"><i class="fas fa-plus me-1"></i> Add Policy</a>
            @endif
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Created By</th>
                            <th>Created At</th>
                            <th>Acknowledged</th>
                            <th width="220">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($policies as $policy)
                            <tr>
                                <td>{{ $policy->Policy_ID }}</td>
                                <td>{{ $policy->Policy_Title }}</td>
                                <td>{{ $policy->creator->Name ?? 'N/A' }}</td>
                                <td>{{ date('M d, Y', strtotime($policy->Created_at)) }}</td>
                                <td>{{ $policy->acknowledgments->count() }}</td>
                                <td>
                                    <form action="{{ route('policies.acknowledge', $policy->Policy_ID) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-success" type="submit">Acknowledge</button>
                                    </form>
                                    @if($canCreateEdit)
                                        <a href="{{ route('policies.edit', $policy->Policy_ID) }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-edit"></i></a>
                                        <a href="{{ route('policies.acknowledgments', $policy->Policy_ID) }}" class="btn btn-sm btn-outline-info">View</a>
                                    @endif
                                    @if($canDelete)
                                        <form action="{{ route('policies.destroy', $policy->Policy_ID) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" type="submit" onclick="return confirm('Delete this policy?')"><i class="fas fa-trash"></i></button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">No policies found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
