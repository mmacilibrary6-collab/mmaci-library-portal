@extends('layouts.admin')

@section('title', 'Create Calendar Event')
@section('page-title', 'Create Calendar Event')

@section('content')

<div class="container-fluid calendar-form-page">

    <div class="calendar-page-container">

        {{-- Header --}}
        <section class="calendar-page-header">

            <div class="calendar-header-content">

                <span class="calendar-header-icon">
                    <i class="bi bi-calendar-plus"></i>
                </span>

                <div>
                    <span class="calendar-header-eyebrow">
                        Website Content
                    </span>

                    <h2>Create Calendar Event</h2>

                    <p>
                        Add a new activity or announcement to the library calendar.
                    </p>
                </div>

            </div>

            <a
                href="{{ route('admin.calendar.index') }}"
                class="calendar-back-button">

                <i class="bi bi-arrow-left"></i>
                Back to Events

            </a>

        </section>

        {{-- Errors --}}
<form
            method="POST"
            action="{{ route('admin.calendar.store') }}"
            novalidate>

            @csrf

            <div class="calendar-form">

                {{-- Event Information --}}
                <section class="calendar-form-section">

                    <div class="calendar-section-heading">

                        <span>
                            <i class="bi bi-calendar-event"></i>
                        </span>

                        <div>
                            <h5>Event Information</h5>
                            <p>Enter the event name and publication status.</p>
                        </div>

                    </div>

                    <div class="row g-4">

                        <div class="col-lg-8">

                            <label for="title" class="form-label">
                                Event Title <span>*</span>
                            </label>

                            <input
                                type="text"
                                id="title"
                                name="title"
                                value="{{ old('title') }}"
                                class="form-control @error('title') is-invalid @enderror"
                                placeholder="Example: Library Day Celebration"
                                maxlength="255"
                                required>

                            @error('title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <div class="col-lg-4">

                            <label for="status" class="form-label">
                                Status <span>*</span>
                            </label>

                            <select
                                id="status"
                                name="status"
                                class="form-select @error('status') is-invalid @enderror"
                                required>

                                <option
                                    value="published"
                                    @selected(old('status', 'published') === 'published')>
                                    Published
                                </option>

                                <option
                                    value="draft"
                                    @selected(old('status') === 'draft')>
                                    Draft
                                </option>

                                <option
                                    value="cancelled"
                                    @selected(old('status') === 'cancelled')>
                                    Cancelled
                                </option>

                            </select>

                            @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                </section>

                {{-- Schedule --}}
                <section class="calendar-form-section">

                    <div class="calendar-section-heading">

                        <span>
                            <i class="bi bi-clock-history"></i>
                        </span>

                        <div>
                            <h5>Event Schedule</h5>
                            <p>Select the event date and optional time range.</p>
                        </div>

                    </div>

                    <div class="row g-4">

                        <div class="col-lg-4">

                            <label for="event_date" class="form-label">
                                Event Date <span>*</span>
                            </label>

                            <input
                                type="date"
                                id="event_date"
                                name="event_date"
                                value="{{ old('event_date') }}"
                                class="form-control @error('event_date') is-invalid @enderror"
                                required>

                            @error('event_date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <div class="col-lg-4">

                            <label for="start_time" class="form-label">
                                Start Time
                            </label>

                            <input
                                type="time"
                                id="start_time"
                                name="start_time"
                                value="{{ old('start_time') }}"
                                class="form-control @error('start_time') is-invalid @enderror">

                            <div class="calendar-field-help">
                                Optional
                            </div>

                            @error('start_time')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <div class="col-lg-4">

                            <label for="end_time" class="form-label">
                                End Time
                            </label>

                            <input
                                type="time"
                                id="end_time"
                                name="end_time"
                                value="{{ old('end_time') }}"
                                class="form-control @error('end_time') is-invalid @enderror">

                            <div class="calendar-field-help">
                                Optional
                            </div>

                            @error('end_time')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                </section>

                {{-- Location and Description --}}
                <section class="calendar-form-section">

                    <div class="calendar-section-heading">

                        <span>
                            <i class="bi bi-geo-alt-fill"></i>
                        </span>

                        <div>
                            <h5>Additional Details</h5>
                            <p>Add the location and a short event description.</p>
                        </div>

                    </div>

                    <div class="row g-4">

                        <div class="col-12">

                            <label for="location" class="form-label">
                                Location
                            </label>

                            <div class="calendar-input-icon">

                                <i class="bi bi-geo-alt"></i>

                                <input
                                    type="text"
                                    id="location"
                                    name="location"
                                    value="{{ old('location') }}"
                                    class="form-control @error('location') is-invalid @enderror"
                                    placeholder="Example: MMACI Library Services Office"
                                    maxlength="255">

                            </div>

                            @error('location')
                                <div class="calendar-error-text">
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
                                rows="5"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Write a short description of the event">{{ old('description') }}</textarea>

                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                </section>

                {{-- Actions --}}
                <div class="calendar-form-actions">

                    <a
                        href="{{ route('admin.calendar.index') }}"
                        class="calendar-cancel-button">

                        <i class="bi bi-x-lg"></i>
                        Cancel

                    </a>

                    <button type="submit" class="calendar-submit-button">

                        <i class="bi bi-calendar-plus"></i>
                        Create Event

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection

@push('styles')
<style>
    .calendar-form-page {
        --calendar-navy: #0b2e59;
        --calendar-blue: #184b8c;
        --calendar-gold: #f4b400;
        padding: 24px;
    }

    .calendar-page-container {
        width: min(100%, 1120px);
        margin: 0 auto;
    }

    .calendar-page-header {
        position: relative;
        min-height: 142px;
        margin-bottom: 20px;
        padding: 27px 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        overflow: hidden;
        color: #fff;
        background:
            radial-gradient(
                circle at 88% 12%,
                rgba(244, 180, 0, .23),
                transparent 28%
            ),
            linear-gradient(
                125deg,
                var(--calendar-navy),
                var(--calendar-blue)
            );
        border-radius: 22px;
        box-shadow: 0 16px 36px rgba(11, 46, 89, .15);
    }

    .calendar-page-header::after {
        content: "";
        position: absolute;
        right: 16%;
        bottom: -86px;
        width: 180px;
        height: 180px;
        border: 27px solid rgba(255, 255, 255, .05);
        border-radius: 50%;
    }

    .calendar-header-content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 17px;
    }

    .calendar-header-icon {
        width: 60px;
        height: 60px;
        flex: 0 0 60px;
        display: grid;
        place-items: center;
        color: var(--calendar-navy);
        background: var(--calendar-gold);
        border-radius: 17px;
        font-size: 25px;
        box-shadow: 0 12px 25px rgba(0, 0, 0, .14);
    }

    .calendar-header-eyebrow {
        display: block;
        margin-bottom: 4px;
        color: #ffd96d;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .14em;
        text-transform: uppercase;
    }

    .calendar-page-header h2 {
        margin: 0 0 5px;
        font-size: clamp(23px, 3vw, 30px);
        font-weight: 800;
    }

    .calendar-page-header p {
        margin: 0;
        color: rgba(255, 255, 255, .72);
        font-size: 12px;
    }

    .calendar-back-button {
        position: relative;
        z-index: 1;
        min-height: 44px;
        padding: 0 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        color: #fff;
        background: rgba(255, 255, 255, .1);
        border: 1px solid rgba(255, 255, 255, .24);
        border-radius: 11px;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        backdrop-filter: blur(8px);
        transition: .2s ease;
    }

    .calendar-back-button:hover {
        color: var(--calendar-navy);
        background: #fff;
        border-color: #fff;
    }

    .calendar-error-alert {
        margin-bottom: 18px;
        padding: 16px 18px;
        display: flex;
        align-items: flex-start;
        gap: 13px;
        color: #883535;
        background: #fff7f7;
        border: 1px solid #f1caca;
        border-left: 4px solid #d84b4b;
        border-radius: 14px;
    }

    .calendar-error-icon {
        width: 37px;
        height: 37px;
        flex: 0 0 37px;
        display: grid;
        place-items: center;
        color: #cf4242;
        background: #fde4e4;
        border-radius: 10px;
    }

    .calendar-error-alert strong {
        display: block;
        font-size: 13px;
    }

    .calendar-error-alert p {
        margin: 2px 0 0;
        color: #a35b5b;
        font-size: 11px;
    }

    .calendar-error-alert ul {
        margin: 9px 0 0;
        padding-left: 18px;
        font-size: 11px;
    }

    .calendar-form {
        display: grid;
        gap: 16px;
    }

    .calendar-form-section {
        padding: 25px 27px;
        background: #fff;
        border: 1px solid #dfe5ed;
        border-radius: 18px;
        box-shadow: 0 10px 28px rgba(11, 46, 89, .06);
    }

    .calendar-section-heading {
        margin-bottom: 22px;
        display: flex;
        align-items: center;
        gap: 13px;
    }

    .calendar-section-heading > span {
        width: 43px;
        height: 43px;
        flex: 0 0 43px;
        display: grid;
        place-items: center;
        color: var(--calendar-navy);
        background: rgba(244, 180, 0, .18);
        border-radius: 12px;
        font-size: 18px;
    }

    .calendar-section-heading h5 {
        margin: 0 0 3px;
        color: var(--calendar-navy);
        font-size: 15px;
        font-weight: 800;
    }

    .calendar-section-heading p {
        margin: 0;
        color: #758194;
        font-size: 11px;
    }

    .calendar-form .form-label {
        margin-bottom: 8px;
        color: #263d58;
        font-size: 12px;
        font-weight: 700;
    }

    .calendar-form .form-label > span {
        color: #dc3545;
    }

    .calendar-form .form-control,
    .calendar-form .form-select {
        min-height: 47px;
        padding: 10px 14px;
        color: #263d58;
        background: #fbfcfe;
        border: 1px solid #dbe2eb;
        border-radius: 10px;
        font-size: 12px;
        box-shadow: none;
    }

    .calendar-form textarea.form-control {
        min-height: 125px;
        resize: vertical;
    }

    .calendar-form .form-control:focus,
    .calendar-form .form-select:focus {
        background: #fff;
        border-color: var(--calendar-blue);
        box-shadow: 0 0 0 4px rgba(24, 75, 140, .08);
    }

    .calendar-field-help {
        margin-top: 6px;
        color: #8a95a4;
        font-size: 9px;
    }

    .calendar-input-icon {
        position: relative;
    }

    .calendar-input-icon > i {
        position: absolute;
        z-index: 2;
        top: 50%;
        left: 14px;
        color: #8994a3;
        transform: translateY(-50%);
    }

    .calendar-input-icon .form-control {
        padding-left: 39px;
    }

    .calendar-error-text {
        margin-top: 6px;
        color: #dc3545;
        font-size: 10px;
    }

    .calendar-form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .calendar-cancel-button,
    .calendar-submit-button {
        min-height: 44px;
        padding: 0 17px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        border-radius: 10px;
        font-size: 11px;
        font-weight: 700;
        text-decoration: none;
        transition: .2s ease;
    }

    .calendar-cancel-button {
        color: #5f6d7e;
        background: #fff;
        border: 1px solid #d7dee7;
    }

    .calendar-submit-button {
        color: #fff;
        background: var(--calendar-navy);
        border: 1px solid var(--calendar-navy);
        box-shadow: 0 8px 18px rgba(11, 46, 89, .16);
    }

    .calendar-submit-button:hover {
        color: var(--calendar-navy);
        background: var(--calendar-gold);
        border-color: var(--calendar-gold);
    }

    @media (max-width: 767.98px) {
        .calendar-form-page {
            padding: 16px 10px;
        }

        .calendar-page-header {
            padding: 23px 20px;
            align-items: flex-start;
            flex-direction: column;
            border-radius: 18px;
        }

        .calendar-header-icon {
            width: 52px;
            height: 52px;
            flex-basis: 52px;
        }

        .calendar-back-button {
            width: 100%;
        }

        .calendar-form-section {
            padding: 21px 18px;
        }

        .calendar-form-actions {
            flex-direction: column-reverse;
        }

        .calendar-cancel-button,
        .calendar-submit-button {
            width: 100%;
        }
    }
</style>
@endpush
