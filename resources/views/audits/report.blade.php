@extends('layouts.app')

@section('title', 'Audit Report')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-file-contract me-2"></i> Audit Findings Report</span>
            <button class="btn btn-sm btn-outline-secondary" onclick="window.print()">Print</button>
        </div>
        <div class="card-body">
            <h5>{{ $audit->Audit_Title }}</h5>
            <p class="mb-1"><strong>Auditor:</strong> {{ $audit->auditor->Name ?? 'N/A' }}</p>
            <p class="mb-1"><strong>Date:</strong> {{ date('M d, Y', strtotime($audit->Audit_Date)) }}</p>
            <p class="mb-3"><strong>Status:</strong> {{ $audit->Status }}</p>

            <h6>Findings</h6>
            <div class="border rounded p-3 mb-3">{{ $audit->Findings ?: 'No findings provided.' }}</div>

            <h6>Linked Compliance Records</h6>
            <ul class="mb-0">
                @forelse($audit->complianceItems as $item)
                    <li>#{{ $item->Compliance_ID }} - {{ $item->policy->Policy_Title ?? 'Policy' }} ({{ $item->Status }})</li>
                @empty
                    <li>No linked compliance records.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
