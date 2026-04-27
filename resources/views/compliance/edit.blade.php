@extends('layouts.app')

@section('title', 'Edit Compliance Record')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-edit me-2"></i> Edit Compliance Record
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('compliance.update', $compliance->Compliance_ID) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label">Policy <span class="text-danger">*</span></label>
                            <select name="policy_id" class="form-control" required>
                                <option value="">Select Policy</option>
                                @foreach($policies as $policy)
                                    <option value="{{ $policy->Policy_ID }}" {{ $compliance->PolicyID == $policy->Policy_ID ? 'selected' : '' }}>
                                        {{ $policy->Policy_Title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-control" required>
                                <option value="Compliant" {{ $compliance->Status == 'Compliant' ? 'selected' : '' }}>Compliant</option>
                                <option value="Non-Compliant" {{ $compliance->Status == 'Non-Compliant' ? 'selected' : '' }}>Non-Compliant</option>
                                <option value="Partial" {{ $compliance->Status == 'Partial' ? 'selected' : '' }}>Partial</option>
                                <option value="Under Review" {{ $compliance->Status == 'Under Review' ? 'selected' : '' }}>Under Review</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Review Date <span class="text-danger">*</span></label>
                            <input type="date" name="review_date" class="form-control" value="{{ $compliance->Review_Date }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Remarks</label>
                            <textarea name="remarks" rows="3" class="form-control">{{ $compliance->Remarks }}</textarea>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-dark">
                                <i class="fas fa-update me-1"></i> Update Record
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