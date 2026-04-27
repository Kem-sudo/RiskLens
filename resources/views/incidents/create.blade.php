@extends('layouts.app')

@section('title', 'Create Incident')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><i class="fas fa-plus me-2"></i> Create Incident</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('incidents.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Incident Title <span class="text-danger">*</span></label>
                            <input type="text" name="incident_title" class="form-control @error('incident_title') is-invalid @enderror" value="{{ old('incident_title') }}" required>
                            @error('incident_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror" required>{{ old('description') }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                                    @foreach(['Open', 'In Progress', 'Resolved', 'Closed'] as $statusOption)
                                        <option value="{{ $statusOption }}" {{ old('status', 'Open') === $statusOption ? 'selected' : '' }}>{{ $statusOption }}</option>
                                    @endforeach
                                </select>
                                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Reported Date <span class="text-danger">*</span></label>
                                <input type="date" name="reported_date" class="form-control @error('reported_date') is-invalid @enderror" value="{{ old('reported_date', date('Y-m-d')) }}" required>
                                @error('reported_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Attachments (Optional)</label>
                            <input type="file" name="attachments[]" id="attachments" class="form-control @error('attachments.*') is-invalid @enderror" multiple>
                            @error('attachments.*')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <small class="text-muted">Accepted: JPG, PNG, PDF, DOC, XLS, TXT (max 5MB each)</small>
                            <ul id="selected-files" class="small mt-2 mb-0"></ul>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-dark" type="submit"><i class="fas fa-save me-1"></i> Save Incident</button>
                            <a href="{{ route('incidents.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('attachments').addEventListener('change', function () {
    const list = document.getElementById('selected-files');
    list.innerHTML = '';
    Array.from(this.files).forEach(file => {
        const item = document.createElement('li');
        item.textContent = file.name;
        list.appendChild(item);
    });
});
</script>
@endsection
