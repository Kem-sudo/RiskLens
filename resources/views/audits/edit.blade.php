@extends('layouts.app')

@section('title', 'Edit Audit')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header"><i class="fas fa-edit me-2"></i> Edit Audit</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('audits.update', $audit->Audit_ID) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Audit Title <span class="text-danger">*</span></label>
                            <input type="text" name="audit_title" class="form-control" value="{{ old('audit_title', $audit->Audit_Title) }}" required>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Auditor <span class="text-danger">*</span></label>
                                <select name="auditor_id" class="form-control" required>
                                    @foreach($auditors as $auditor)
                                        <option value="{{ $auditor->User_ID }}" {{ old('auditor_id', $audit->Auditor_ID) == $auditor->User_ID ? 'selected' : '' }}>{{ $auditor->Name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Audit Date <span class="text-danger">*</span></label>
                                <input type="date" name="audit_date" class="form-control" value="{{ old('audit_date', $audit->Audit_Date) }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-control" required>
                                    @foreach(['Planning', 'In Progress', 'Completed'] as $statusOption)
                                        <option value="{{ $statusOption }}" {{ old('status', $audit->Status) === $statusOption ? 'selected' : '' }}>{{ $statusOption }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Findings</label>
                            <textarea name="findings" rows="4" class="form-control">{{ old('findings', $audit->Findings) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Link Compliance Records</label>
                            @php
                                $selectedCompliance = $audit->complianceItems->pluck('Compliance_ID')->toArray();
                            @endphp
                            <select name="compliance_ids[]" class="form-control" multiple>
                                @foreach($complianceItems as $item)
                                    <option value="{{ $item->Compliance_ID }}" {{ in_array($item->Compliance_ID, $selectedCompliance) ? 'selected' : '' }}>
                                        #{{ $item->Compliance_ID }} - {{ $item->policy->Policy_Title ?? 'Policy' }} ({{ $item->Status }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-dark" type="submit"><i class="fas fa-save me-1"></i> Update Audit</button>
                            <a href="{{ route('audits.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
