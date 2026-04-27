@extends('layouts.app')

@section('title', 'Add New Risk')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-plus me-2"></i> Add New Risk
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('risks.store') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Risk Title <span class="text-danger">*</span></label>
                            <input type="text" name="risk_title" class="form-control @error('risk_title') is-invalid @enderror" 
                                   value="{{ old('risk_title') }}" required autofocus>
                            @error('risk_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Category <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->Category_ID }}" {{ old('category_id') == $cat->Category_ID ? 'selected' : '' }}>
                                        {{ $cat->Category_Name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Risk Level <span class="text-danger">*</span></label>
                            <select name="risk_level" class="form-control @error('risk_level') is-invalid @enderror" required>
                                <option value="Low" {{ old('risk_level') == 'Low' ? 'selected' : '' }}>Low</option>
                                <option value="Medium" {{ old('risk_level') == 'Medium' ? 'selected' : '' }}>Medium</option>
                                <option value="High" {{ old('risk_level') == 'High' ? 'selected' : '' }}>High</option>
                                <option value="Critical" {{ old('risk_level') == 'Critical' ? 'selected' : '' }}>Critical</option>
                            </select>
                            @error('risk_level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea name="description" rows="5" class="form-control @error('description') is-invalid @enderror" 
                                      required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-dark">
                                <i class="fas fa-save me-1"></i> Save Risk
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