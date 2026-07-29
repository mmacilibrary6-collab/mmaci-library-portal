@extends('layouts.admin')

@section('title', 'Edit Calendar Event')
@section('page-title', 'Edit Calendar Event')

@section('content')

<div class="container-fluid py-4">

    <div class="page-header mb-4">

        <div>
            <h2 class="page-title mb-1">
                Edit Calendar Event
            </h2>

            <p class="text-muted mb-0">
                Update the event details and publication status.
            </p>
        </div>

        <a
            href="{{ route('admin.calendar.index') }}"
            class="btn btn-outline-secondary rounded-pill px-4">

            <i class="bi bi-arrow-left me-2"></i>
            Back to Events

        </a>

    </div>

    <div class="form-card">

        @if ($errors->any())

            <div class="alert alert-danger">

                <div class="fw-bold mb-2">
                    Please correct the following errors:
                </div>

                <ul class="mb-0">

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        <form
            method="POST"
            action="{{ route('admin.calendar.update', $event) }}">

            @csrf
            @method('PUT')

            <div class="row g-4">

                <div class="col-12">

                    <label for="title" class="form-label">
                        Event Title
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title', $event->title) }}"
                        class="form-control @error('title') is-invalid @enderror"
                        placeholder="Enter the event title"
                        maxlength="255"
                        required>

                    @error('title')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>

                <div class="col-md-4">

                    <label for="event_date" class="form-label">
                        Event Date
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="date"
                        id="event_date"
                        name="event_date"
                        value="{{ old('event_date', optional($event->event_date)->format('Y-m-d')) }}"
                        class="form-control @error('event_date') is-invalid @enderror"
                        required>

                    @error('event_date')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>

                <div class="col-md-4">

                    <label for="start_time" class="form-label">
                        Start Time
                    </label>

                    <input
                        type="time"
                        id="start_time"
                        name="start_time"
                        value="{{ old('start_time', $event->start_time ? \Carbon\Carbon::parse($event->start_time)->format('H:i') : '') }}"
                        class="form-control @error('start_time') is-invalid @enderror">

                    @error('start_time')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>

                <div class="col-md-4">

                    <label for="end_time" class="form-label">
                        End Time
                    </label>

                    <input
                        type="time"
                        id="end_time"
                        name="end_time"
                        value="{{ old('end_time', $event->end_time ? \Carbon\Carbon::parse($event->end_time)->format('H:i') : '') }}"
                        class="form-control @error('end_time') is-invalid @enderror">

                    @error('end_time')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>

                <div class="col-md-8">

                    <label for="location" class="form-label">
                        Location
                    </label>

                    <input
                        type="text"
                        id="location"
                        name="location"
                        value="{{ old('location', $event->location) }}"
                        class="form-control @error('location') is-invalid @enderror"
                        placeholder="Example: MMACI Library Services Office"
                        maxlength="255">

                    @error('location')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>

                <div class="col-md-4">

                    <label for="status" class="form-label">
                        Status
                        <span class="text-danger">*</span>
                    </label>

                    <select
                        id="status"
                        name="status"
                        class="form-select @error('status') is-invalid @enderror"
                        required>

                        <option
                            value="published"
                            {{ old('status', $event->status) === 'published' ? 'selected' : '' }}>
                            Published
                        </option>

                        <option
                            value="draft"
                            {{ old('status', $event->status) === 'draft' ? 'selected' : '' }}>
                            Draft
                        </option>

                        <option
                            value="cancelled"
                            {{ old('status', $event->status) === 'cancelled' ? 'selected' : '' }}>
                            Cancelled
                        </option>

                    </select>

                    @error('status')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>

                <div class="col-12">

                    <label for="description" class="form-label">
                        Description
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        rows="6"
                        class="form-control @error('description') is-invalid @enderror"
                        placeholder="Write a short description of the event">{{ old('description', $event->description) }}</textarea>

                    @error('description')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>

            </div>

            <div class="form-actions mt-4">

                <a
                    href="{{ route('admin.calendar.index') }}"
                    class="btn btn-light border rounded-pill px-4">

                    Cancel

                </a>

                <button
                    type="submit"
                    class="btn btn-warning rounded-pill px-4 fw-semibold">

                    <i class="bi bi-check-circle me-2"></i>
                    Save Changes

                </button>

            </div>

        </form>

    </div>

</div>

<style>

.page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
}

.page-title {
    color: #0B2E59;
    font-weight: 800;
}

.form-card {
    max-width: 1050px;
    margin: 0 auto;
    padding: 35px;
    background: #ffffff;
    border: 1px solid #e9edf2;
    border-radius: 22px;
    box-shadow: 0 12px 35px rgba(11, 46, 89, 0.08);
}

.form-label {
    color: #344054;
    font-size: 0.9rem;
    font-weight: 700;
}

.form-control,
.form-select {
    min-height: 52px;
    border: 1px solid #d8dee8;
    border-radius: 12px;
}

textarea.form-control {
    min-height: 145px;
    resize: vertical;
}

.form-control:focus,
.form-select:focus {
    border-color: #F4B400;
    box-shadow: 0 0 0 0.2rem rgba(244, 180, 0, 0.15);
}

.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    padding-top: 24px;
    border-top: 1px solid #edf0f4;
}

@media (max-width: 767.98px) {
    .page-header {
        align-items: flex-start;
        flex-direction: column;
    }

    .form-card {
        padding: 22px;
    }

    .form-actions {
        flex-direction: column-reverse;
    }

    .form-actions .btn {
        width: 100%;
    }
}

</style>

@endsection