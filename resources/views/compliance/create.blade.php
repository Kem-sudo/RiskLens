@extends('layouts.app')

@section('title', 'New Compliance Check')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-plus me-2"></i> New Compliance Check
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('compliance.store') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Policy <span class="text-danger">*</span></label>
                            <select name="policy_id" class="form-control @error('policy_id') is-invalid @enderror" required>
                                <option value="">Select Policy</option>
                                @foreach($policies as $policy)
                                    <option value="{{ $policy->Policy_ID }}" {{ old('policy_id') == $policy->Policy_ID ? 'selected' : '' }}>
                                        {{ $policy->Policy_Title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('policy_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                                <option value="Compliant" {{ old('status') == 'Compliant' ? 'selected' : '' }}>Compliant</option>
                                <option value="Non-Compliant" {{ old('status') == 'Non-Compliant' ? 'selected' : '' }}>Non-Compliant</option>
                                <option value="Partial" {{ old('status') == 'Partial' ? 'selected' : '' }}>Partial</option>
                                <option value="Under Review" {{ old('status') == 'Under Review' ? 'selected' : '' }}>Under Review</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Review Date <span class="text-danger">*</span></label>
                            <input type="date" name="review_date" class="form-control @error('review_date') is-invalid @enderror" 
                                   value="{{ old('review_date') }}" required>
                            @error('review_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Remarks</label>
                            <textarea name="remarks" rows="3" class="form-control @error('remarks') is-invalid @enderror">{{ old('remarks') }}</textarea>
                            @error('remarks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-dark">
                                <i class="fas fa-save me-1"></i> Save Record
                            </button>
                            <a href="{{ route('compliance.index') }}" class="btn btn-outline-secondary">
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