@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
@php
    $canSeeCompliance = in_array($role, ['Super Admin', 'System Admin', 'Compliance Officer', 'Internal Auditor']);
    $canSeeAudits = in_array($role, ['Super Admin', 'System Admin', 'Compliance Officer', 'Internal Auditor']);
@endphp
<div class="container-fluid">
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="mb-1">Welcome, {{ $name }}</h5>
            <p class="text-muted mb-0">{{ $role }} | {{ $email }}</p>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-md-3">
            <div class="card"><div class="card-body"><h6 class="text-muted">Total Risks</h6><h3>{{ $totalRisks }}</h3></div></div>
        </div>
        <div class="col-md-3">
            <div class="card"><div class="card-body"><h6 class="text-muted">Open Incidents</h6><h3>{{ $openIncidents }}</h3></div></div>
        </div>
        @if($canSeeCompliance)
            <div class="col-md-3">
                <div class="card"><div class="card-body"><h6 class="text-muted">Compliance Rate</h6><h3>{{ $complianceRate }}%</h3></div></div>
            </div>
        @endif
        @if($canSeeAudits)
            <div class="col-md-3">
                <div class="card"><div class="card-body"><h6 class="text-muted">Completed Audits</h6><h3>{{ $completedAudits }}</h3></div></div>
            </div>
        @endif
    </div>

    <div class="row g-3">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">Risk Level Distribution</div>
                <div class="card-body"><canvas id="riskChart" height="160"></canvas></div>
            </div>
        </div>
        @if($canSeeCompliance)
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">Compliance Status</div>
                    <div class="card-body"><canvas id="complianceChart" height="160"></canvas></div>
                </div>
            </div>
        @endif
    </div>

    <div class="row g-3 mt-1">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">Recent Activities</div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($recentActivities as $activity)
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <div>{{ $activity['message'] }}</div>
                                    <small class="text-muted">{{ $activity['time'] }}</small>
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item text-muted">No recent activities.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">Quick Actions</div>
                <div class="card-body d-grid gap-2">
                    <a href="{{ route('risks.create') }}" class="btn btn-outline-secondary">Add Risk</a>
                    <a href="{{ route('incidents.create') }}" class="btn btn-outline-secondary">Report Incident</a>
                    @if($canSeeCompliance)<a href="{{ route('compliance.index') }}" class="btn btn-outline-secondary">Compliance Monitoring</a>@endif
                    <a href="{{ route('policies.index') }}" class="btn btn-outline-secondary">View Policies</a>
                    @if($canSeeAudits)<a href="{{ route('audits.index') }}" class="btn btn-outline-secondary">Audit Center</a>@endif
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const riskData = @json($riskLevelChart);
new Chart(document.getElementById('riskChart'), {
    type: 'bar',
    data: {
        labels: Object.keys(riskData),
        datasets: [{ data: Object.values(riskData), backgroundColor: ['#4caf50', '#ffb300', '#f44336', '#6a1b9a'] }]
    },
    options: { plugins: { legend: { display: false } } }
});

const complianceData = @json($complianceStatusChart);
const complianceChartEl = document.getElementById('complianceChart');
if (complianceChartEl) {
    new Chart(complianceChartEl, {
        type: 'doughnut',
        data: {
            labels: Object.keys(complianceData),
            datasets: [{ data: Object.values(complianceData), backgroundColor: ['#4caf50', '#f44336', '#ffb300', '#2196f3'] }]
        }
    });
}
</script>
@endsection