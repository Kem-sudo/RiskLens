@extends('layouts.app')

@section('title', 'Create Audit')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header"><i class="fas fa-plus me-2"></i> Create Audit</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('audits.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Audit Title <span class="text-danger">*</span></label>
                            <input type="text" name="audit_title" class="form-control @error('audit_title') is-invalid @enderror" value="{{ old('audit_title') }}" required>
                            @error('audit_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Auditor <span class="text-danger">*</span></label>
                                <select name="auditor_id" class="form-control @error('auditor_id') is-invalid @enderror" required>
                                    <option value="">Select Auditor</option>
                                    @foreach($auditors as $auditor)
                                        <option value="{{ $auditor->User_ID }}" {{ old('auditor_id') == $auditor->User_ID ? 'selected' : '' }}>{{ $auditor->Name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Audit Date <span class="text-danger">*</span></label>
                                <input type="date" name="audit_date" class="form-control" value="{{ old('audit_date', date('Y-m-d')) }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-control" required>
                                    @foreach(['Planning', 'In Progress', 'Completed'] as $statusOption)
                                        <option value="{{ $statusOption }}" {{ old('status', 'Planning') === $statusOption ? 'selected' : '' }}>{{ $statusOption }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Findings</label>
                            <textarea name="findings" rows="4" class="form-control">{{ old('findings') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Link Compliance Records</label>
                            <select name="compliance_ids[]" class="form-control" multiple id="compliance-select">
                                @foreach($complianceItems as $item)
                                    <option value="{{ $item->Compliance_ID }}">
                                        #{{ $item->Compliance_ID }} - {{ $item->policy->Policy_Title ?? 'Policy' }} ({{ $item->Status }})
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Hold Ctrl/Cmd to select multiple records.</small>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-dark" type="submit"><i class="fas fa-save me-1"></i> Save Audit</button>
                            <a href="{{ route('audits.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
