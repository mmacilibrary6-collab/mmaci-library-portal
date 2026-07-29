@extends('layouts.admin')

@section('title', 'Edit New Arrival')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

        <div>
            <h2 class="fw-bold text-primary mb-1">
                Edit New Arrival
            </h2>

            <p class="text-muted mb-0">
                Update the information for
                <strong>{{ $newArrival->title }}</strong>.
            </p>
        </div>

        <a
            href="{{ route('admin.new-arrivals.index') }}"
            class="btn btn-outline-secondary">

            <i class="bi bi-arrow-left me-1"></i>
            Back to List

        </a>

    </div>

    @if ($errors->any())

        <div class="alert alert-danger alert-dismissible fade show">

            <div class="fw-semibold mb-2">
                Please correct the following errors:
            </div>

            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    @endif

    <form
        action="{{ route('admin.new-arrivals.update', $newArrival) }}"
        method="POST"
        enctype="multipart/form-data">

        @method('PUT')

        @include('admin.arrivals._form')

    </form>

</div>

@endsection