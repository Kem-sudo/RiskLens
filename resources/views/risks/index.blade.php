@extends('layouts.app')

@section('title', 'Risk Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-chart-line me-2"></i> Risk Management</span>
                    <a href="{{ route('risks.create') }}" class="btn btn-sm btn-dark">
                        <i class="fas fa-plus me-1"></i> Add New Risk
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
                                    <th>Risk Title</th>
                                    <th>Category</th>
                                    <th>Level</th>
                                    <th>Reported By</th>
                                    <th>Date</th>
                                    <th width="100">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($risks as $risk)
                                <tr>
                                    <td>{{ $risk->RiskID }}</td>
                                    <td>{{ $risk->Risk_Title }}</td>
                                    <td>{{ $risk->category->Category_Name ?? 'N/A' }}</td>
                                    <td>
                                        @php
                                            $badgeClass = 'secondary';
                                            if($risk->Risk_Level == 'Low') $badgeClass = 'success';
                                            elseif($risk->Risk_Level == 'Medium') $badgeClass = 'warning';
                                            elseif($risk->Risk_Level == 'High') $badgeClass = 'danger';
                                            elseif($risk->Risk_Level == 'Critical') $badgeClass = 'dark';
                                        @endphp
                                        <span class="badge bg-{{ $badgeClass }}">{{ $risk->Risk_Level }}</span>
                                    </td>
                                    <td>{{ $risk->reporter->Name ?? 'N/A' }}</td>
                                    <td>{{ date('M d, Y', strtotime($risk->Created_at)) }}</td>
                                    <td>
                                        <a href="{{ route('risks.edit', $risk->RiskID) }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('risks.destroy', $risk->RiskID) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this risk?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3 opacity-25"></i>
                                        <p>No risks found. <a href="{{ route('risks.create') }}">Add your first risk</a></p>
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