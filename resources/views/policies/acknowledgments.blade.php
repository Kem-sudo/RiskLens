@extends('layouts.app')

@section('title', 'Policy Acknowledgments')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <i class="fas fa-users me-2"></i> Acknowledgments: {{ $policy->Policy_Title }}
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Employee</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Acknowledged At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $employee)
                            @php
                                $ack = $policy->acknowledgments->firstWhere('User_ID', $employee->User_ID);
                            @endphp
                            <tr>
                                <td>{{ $employee->Name }}</td>
                                <td>{{ $employee->Email }}</td>
                                <td>
                                    @if($ack)
                                        <span class="badge bg-success">Acknowledged</span>
                                    @else
                                        <span class="badge bg-secondary">Pending</span>
                                    @endif
                                </td>
                                <td>{{ $ack ? date('M d, Y H:i', strtotime($ack->Acknowledged_at)) : 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">No employee records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
