@php
    $flashWrapperClass = trim(implode(' ', array_filter([
        $containerClass ?? '',
        $wrapperClass ?? '',
    ])));
@endphp

@if(session('success'))
    <div class="{{ $flashWrapperClass }}">
        <div class="alert alert-success alert-dismissible fade show {{ $successClass ?? '' }}" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="{{ $flashWrapperClass }}">
        <div class="alert alert-danger alert-dismissible fade show {{ $errorClass ?? '' }}" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <span>{{ session('error') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

@if(session('status'))
    <div class="{{ $flashWrapperClass }}">
        <div class="alert alert-success alert-dismissible fade show {{ $statusClass ?? '' }}" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <span>{{ session('status') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

@if($errors->any())
    <div class="{{ $flashWrapperClass }}">
        <div class="alert alert-danger alert-dismissible fade show {{ $errorsClass ?? '' }}" role="alert">
            <strong>Please correct the following:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif
