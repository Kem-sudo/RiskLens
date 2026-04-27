@extends('layouts.app')

@section('title', 'Edit Risk')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-edit me-2"></i> Edit Risk
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('risks.update', $risk->RiskID) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label">Risk Title <span class="text-danger">*</span></label>
                            <input type="text" name="risk_title" class="form-control" value="{{ $risk->Risk_Title }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Category <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-control" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->Category_ID }}" {{ $risk->Category_ID == $cat->Category_ID ? 'selected' : '' }}>
                                        {{ $cat->Category_Name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Risk Level <span class="text-danger">*</span></label>
                            <select name="risk_level" class="form-control" required>
                                <option value="Low" {{ $risk->Risk_Level == 'Low' ? 'selected' : '' }}>Low</option>
                                <option value="Medium" {{ $risk->Risk_Level == 'Medium' ? 'selected' : '' }}>Medium</option>
                                <option value="High" {{ $risk->Risk_Level == 'High' ? 'selected' : '' }}>High</option>
                                <option value="Critical" {{ $risk->Risk_Level == 'Critical' ? 'selected' : '' }}>Critical</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea name="description" rows="5" class="form-control" required>{{ $risk->Description }}</textarea>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-dark">
                                <i class="fas fa-update me-1"></i> Update Risk
                            </button>
                            <a href="{{ route('risks.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection