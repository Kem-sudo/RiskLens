@extends('layouts.app')

@section('title', 'Edit Policy')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><i class="fas fa-edit me-2"></i> Edit Policy</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('policies.update', $policy->Policy_ID) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Policy Title <span class="text-danger">*</span></label>
                            <input type="text" name="policy_title" class="form-control" value="{{ old('policy_title', $policy->Policy_Title) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea name="description" rows="5" class="form-control" required>{{ old('description', $policy->Description) }}</textarea>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-dark" type="submit"><i class="fas fa-save me-1"></i> Update Policy</button>
                            <a href="{{ route('policies.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
