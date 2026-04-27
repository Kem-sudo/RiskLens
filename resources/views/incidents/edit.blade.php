@extends('layouts.app')

@section('title', 'Edit Incident')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><i class="fas fa-edit me-2"></i> Edit Incident</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('incidents.update', $incident->Incident_ID) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Incident Title <span class="text-danger">*</span></label>
                            <input type="text" name="incident_title" class="form-control" value="{{ old('incident_title', $incident->Incident_Title) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea name="description" rows="4" class="form-control" required>{{ old('description', $incident->Description) }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-control" required>
                                    @foreach(['Open', 'In Progress', 'Resolved', 'Closed'] as $statusOption)
                                        <option value="{{ $statusOption }}" {{ old('status', $incident->Status) === $statusOption ? 'selected' : '' }}>{{ $statusOption }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Reported Date <span class="text-danger">*</span></label>
                                <input type="date" name="reported_date" class="form-control" value="{{ old('reported_date', date('Y-m-d', strtotime($incident->Reported_Date))) }}" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Add Attachments</label>
                            <input type="file" name="attachments[]" class="form-control" multiple>
                        </div>
                        @if($incident->attachments->count())
                            <div class="mb-3">
                                <label class="form-label">Current Attachments</label>
                                <ul class="list-group">
                                    @foreach($incident->attachments as $attachment)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <a href="{{ asset('storage/' . $attachment->File_Path) }}" target="_blank">{{ basename($attachment->File_Path) }}</a>
                                            <form action="{{ route('incidents.attachments.destroy', $attachment->Attachment_ID) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger" type="submit">Remove</button>
                                            </form>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-dark" type="submit"><i class="fas fa-save me-1"></i> Update Incident</button>
                            <a href="{{ route('incidents.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
