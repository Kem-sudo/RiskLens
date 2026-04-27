@extends('layouts.app')

@section('title', 'Create Policy')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><i class="fas fa-plus me-2"></i> Create Policy</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('policies.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Policy Title <span class="text-danger">*</span></label>
                            <input type="text" name="policy_title" class="form-control @error('policy_title') is-invalid @enderror" value="{{ old('policy_title') }}" required>
                            @error('policy_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea name="description" rows="5" class="form-control @error('description') is-invalid @enderror" required>{{ old('description') }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-dark" type="submit"><i class="fas fa-save me-1"></i> Save Policy</button>
                            <a href="{{ route('policies.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
