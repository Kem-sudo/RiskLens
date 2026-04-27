@extends('layouts.app')

@section('title', 'Compliance Monitoring')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-check-circle me-2"></i> Compliance Monitoring</span>
                    <a href="{{ route('compliance.create') }}" class="btn btn-sm btn-dark">
                        <i class="fas fa-plus me-1"></i> New Compliance Check
                    </a>
                </div>
                <div class="card-body p-0">
                    @if(session('success'))
                        <div class="alert alert-success m-3">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Policy</th>
                                    <th>Status</th>
                                    <th>Review Date</th>
                                    <th>Checked By</th>
                                    <th>Remarks</th>
                                    <th width="100">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($compliance as $item)
                                <tr>
                                    <td>{{ $item->Compliance_ID }}</td>
                                    <td>{{ $item->policy->Policy_Title ?? 'N/A' }}</td>
                                    <td>
                                        @php
                                            $badgeClass = 'secondary';
                                            if($item->Status == 'Compliant') $badgeClass = 'success';
                                            elseif($item->Status == 'Non-Compliant') $badgeClass = 'danger';
                                            elseif($item->Status == 'Partial') $badgeClass = 'warning';
                                            elseif($item->Status == 'Under Review') $badgeClass = 'info';
                                        @endphp
                                        <span class="badge bg-{{ $badgeClass }}">{{ $item->Status }}</span>
                                    </td>
                                    <td>{{ date('M d, Y', strtotime($item->Review_Date)) }}</td>
                                    <td>{{ $item->checker->Name ?? 'N/A' }}</td>
                                    <td>{{ Str::limit($item->Remarks, 30) ?? 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('compliance.edit', $item->Compliance_ID) }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('compliance.destroy', $item->Compliance_ID) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this compliance record?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3 opacity-25"></i>
                                        <p>No compliance records found. <a href="{{ route('compliance.create') }}">Add your first compliance check</a></p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection