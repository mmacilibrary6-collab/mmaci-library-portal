@extends('layouts.admin')

@section('title', 'Edit Calendar Event')
@section('page-title', 'Edit Calendar Event')

@section('content')

<div class="container-fluid admin-page py-4">
    <section class="admin-page-header">
        <div class="admin-page-heading">
            <span class="admin-page-icon"><i class="bi bi-calendar-event"></i></span>
            <div>
                <span class="admin-page-eyebrow">Website Content</span>
                <h2>Edit Calendar Event</h2>
                <p>Update the event details and publication status.</p>
            </div>
        </div>
        <a href="{{ route('admin.calendar.index') }}" class="admin-back-link">
            <i class="bi bi-arrow-left me-2"></i>Back to Events
        </a>
    </section>

    <section class="admin-form-card">
        @if ($errors->any())
            <div class="alert alert-danger border-0 rounded-4">
                <div class="fw-bold mb-2">Please correct the following errors:</div>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.calendar.update', $event) }}">
            @csrf
            @method('PUT')

            <div class="row g-4">
                <div class="col-12">
                    <label for="title" class="form-label">Event Title <span class="text-danger">*</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title', $event->title) }}" class="form-control @error('title') is-invalid @enderror" placeholder="Enter the event title" maxlength="255" required>
                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label for="event_date" class="form-label">Event Date <span class="text-danger">*</span></label>
                    <input type="date" id="event_date" name="event_date" value="{{ old('event_date', optional($event->event_date)->format('Y-m-d')) }}" class="form-control @error('event_date') is-invalid @enderror" required>
                    @error('event_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label for="start_time" class="form-label">Start Time</label>
                    <input type="time" id="start_time" name="start_time" value="{{ old('start_time', $event->start_time ? \Carbon\Carbon::parse($event->start_time)->format('H:i') : '') }}" class="form-control @error('start_time') is-invalid @enderror">
                    @error('start_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label for="end_time" class="form-label">End Time</label>
                    <input type="time" id="end_time" name="end_time" value="{{ old('end_time', $event->end_time ? \Carbon\Carbon::parse($event->end_time)->format('H:i') : '') }}" class="form-control @error('end_time') is-invalid @enderror">
                    @error('end_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-8">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" id="location" name="location" value="{{ old('location', $event->location) }}" class="form-control @error('location') is-invalid @enderror" placeholder="Example: MMACI Library Services Office" maxlength="255">
                    @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="published" {{ old('status', $event->status) === 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ old('status', $event->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="cancelled" {{ old('status', $event->status) === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" rows="6" class="form-control @error('description') is-invalid @enderror" placeholder="Write a short description of the event">{{ old('description', $event->description) }}</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.calendar.index') }}" class="btn btn-light border rounded-pill px-4">Cancel</a>
                <button type="submit" class="btn btn-warning rounded-pill px-4 fw-semibold"><i class="bi bi-check-circle me-2"></i>Save Changes</button>
            </div>
        </form>
    </section>
</div>

<style>
.admin-page-header{display:flex;align-items:center;justify-content:space-between;gap:20px;margin-bottom:24px}
.admin-page-heading{display:flex;align-items:center;gap:16px}
.admin-page-icon{width:60px;height:60px;display:grid;place-items:center;border-radius:18px;background:#f4b400;color:#0b2e59;font-size:1.4rem}
.admin-page-eyebrow{display:block;font-size:.75rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase;color:#8a94a6;margin-bottom:4px}
.admin-page-heading h2,.admin-page-heading p{margin:0}
.admin-page-heading h2{color:#0b2e59;font-weight:800}
.admin-page-heading p{color:#667085;margin-top:4px}
.admin-back-link{display:inline-flex;align-items:center;padding:12px 18px;border-radius:999px;border:1px solid #d8dee8;background:#fff;color:#0b2e59;font-weight:700;text-decoration:none;box-shadow:0 8px 18px rgba(11,46,89,.06)}
.admin-back-link:hover{background:#f8fafc;color:#0b2e59}
.admin-form-card{max-width:1100px;margin:0 auto;padding:32px;background:#fff;border:1px solid #e9edf2;border-radius:24px;box-shadow:0 14px 36px rgba(11,46,89,.08)}
.form-label{color:#344054;font-size:.9rem;font-weight:700}
.form-control,.form-select{min-height:52px;border:1px solid #d8dee8;border-radius:14px}
textarea.form-control{min-height:150px;resize:vertical}
.form-control:focus,.form-select:focus{border-color:#f4b400;box-shadow:0 0 0 .2rem rgba(244,180,0,.15)}
.form-actions{display:flex;justify-content:flex-end;gap:12px;padding-top:24px;margin-top:24px;border-top:1px solid #edf0f4}
@media (max-width:767.98px){.admin-page-header{flex-direction:column;align-items:flex-start}.admin-form-card{padding:22px}.form-actions{flex-direction:column-reverse}.form-actions .btn,.admin-back-link{width:100%;justify-content:center}}
</style>

@endsection
