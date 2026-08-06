@csrf

@php
    $arrival = $newArrival ?? null;
    $isEditing = $arrival !== null;

    $fallbackImage = asset('images/readingarea.jpg');
    $currentImage = $arrival?->image_url ?? $fallbackImage;
    $storedImage = $arrival?->image;

    $externalImageUrl = old(
        'image_url',
        \Illuminate\Support\Str::startsWith(
            $storedImage ?? '',
            ['http://', 'https://']
        ) ? $storedImage : ''
    );

    $arrivalDate = old(
        'arrival_date',
        filled($arrival?->arrival_date)
            ? \Illuminate\Support\Carbon::parse(
                $arrival->arrival_date
            )->format('Y-m-d')
            : now()->format('Y-m-d')
    );
@endphp

<div class="arrival-form">
    <section class="form-section">
        <div class="section-heading">
            <span class="section-icon">
                <i class="bi bi-book-half"></i>
            </span>

            <div>
                <h5>Material Information</h5>

                <p>
                    Enter the accession number, publication details,
                    and availability.
                </p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <label
                    for="accession_number"
                    class="form-label">

                    Accession Number <span>*</span>
                </label>

                <div class="input-with-icon">
                    <i class="bi bi-upc-scan"></i>

                    <input
                        type="text"
                        name="accession_number"
                        id="accession_number"
                        value="{{ old(
                            'accession_number',
                            $arrival?->accession_number
                        ) }}"
                        class="form-control text-uppercase @error('accession_number') is-invalid @enderror"
                        placeholder="Example: ACC-2026-0001"
                        maxlength="100"
                        autocomplete="off"
                        required>
                </div>

                @error('accession_number')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @else
                    <div class="field-note">
                        Every material must have a unique accession number.
                    </div>
                @enderror
            </div>

            <div class="col-md-8">
                <label for="title" class="form-label">
                    Material Title <span>*</span>
                </label>

                <input
                    type="text"
                    name="title"
                    id="title"
                    value="{{ old('title', $arrival?->title) }}"
                    class="form-control @error('title') is-invalid @enderror"
                    placeholder="Enter the complete title"
                    required>

                @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="author" class="form-label">
                    Author <small>Optional</small>
                </label>

                <input
                    type="text"
                    name="author"
                    id="author"
                    value="{{ old('author', $arrival?->author) }}"
                    class="form-control @error('author') is-invalid @enderror"
                    placeholder="Enter the author name">

                @error('author')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="category" class="form-label">
                    Category <small>Optional</small>
                </label>

                <input
                    type="text"
                    name="category"
                    id="category"
                    value="{{ old('category', $arrival?->category) }}"
                    class="form-control @error('category') is-invalid @enderror"
                    placeholder="Example: Information Technology">

                @error('category')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="arrival_date" class="form-label">
                    Date of Arrival <span>*</span>
                </label>

                <input
                    type="date"
                    name="arrival_date"
                    id="arrival_date"
                    value="{{ $arrivalDate }}"
                    class="form-control @error('arrival_date') is-invalid @enderror"
                    required>

                @error('arrival_date')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-md-6">
                <label
                    for="availability_status"
                    class="form-label">

                    Availability <span>*</span>
                </label>

                <select
                    name="availability_status"
                    id="availability_status"
                    class="form-select @error('availability_status') is-invalid @enderror"
                    required>

                    <option
                        value="available"
                        @selected(
                            old(
                                'availability_status',
                                $arrival?->availability_status ?? 'available'
                            ) === 'available'
                        )>

                        Available
                    </option>

                    <option
                        value="unavailable"
                        @selected(
                            old(
                                'availability_status',
                                $arrival?->availability_status
                            ) === 'unavailable'
                        )>

                        Unavailable
                    </option>
                </select>

                @error('availability_status')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-12">
                <label for="description" class="form-label">
                    Description <small>Optional</small>
                </label>

                <textarea
                    name="description"
                    id="description"
                    rows="4"
                    class="form-control @error('description') is-invalid @enderror"
                    placeholder="Add a short description of this material...">{{ old('description', $arrival?->description) }}</textarea>

                @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </section>

    <section class="form-section">
        <div class="section-heading">
            <span class="section-icon cover-icon">
                <i class="bi bi-image-fill"></i>
            </span>

            <div>
                <h5>Cover Image</h5>

                <p>
                    Upload a cover image or provide a direct external image link.
                </p>
            </div>
        </div>

        <div class="row g-4 align-items-stretch">
            <div class="col-lg-7">
                <div class="image-fields">
                    <div>
                        <label
                            for="image_file"
                            class="form-label">

                            Upload Cover
                            <small>Recommended</small>
                        </label>

                        <label
                            for="image_file"
                            class="upload-area @error('image_file') upload-error @enderror">

                            <span class="upload-icon">
                                <i class="bi bi-cloud-arrow-up"></i>
                            </span>

                            <span class="upload-copy">
                                <strong id="arrivalFileName">
                                    Choose a cover image
                                </strong>

                                <small>
                                    JPG, PNG or WEBP · Maximum 5 MB
                                </small>
                            </span>

                            <span class="browse-button">
                                Browse
                            </span>
                        </label>

                        <input
                            type="file"
                            name="image_file"
                            id="image_file"
                            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                            class="visually-hidden">

                        @error('image_file')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="image-divider">
                        <span>or use an image link</span>
                    </div>

                    <div>
                        <label
                            for="image_url"
                            class="form-label">

                            External Image URL
                            <small>Optional</small>
                        </label>

                        <div class="input-with-icon">
                            <i class="bi bi-link-45deg"></i>

                            <input
                                type="url"
                                name="image_url"
                                id="image_url"
                                value="{{ $externalImageUrl }}"
                                class="form-control @error('image_url') is-invalid @enderror"
                                placeholder="https://example.com/book-cover.jpg">
                        </div>

                        @error('image_url')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @else
                            <div class="field-note">
                                An uploaded image takes priority over an image link.
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="preview-panel">
                    <div class="preview-label">
                        <span>Cover Preview</span>

                        <small id="arrivalPreviewStatus">
                            Current image
                        </small>
                    </div>

                    <div class="arrival-cover-preview">
                        <img
                            id="arrivalImagePreview"
                            src="{{ $currentImage }}"
                            data-original="{{ $currentImage }}"
                            data-fallback="{{ $fallbackImage }}"
                            alt="Cover preview">

                        <span class="preview-overlay">
                            <i class="bi bi-eye"></i>
                            Preview
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="form-actions">
        <a
            href="{{ route('admin.new-arrivals.index') }}"
            class="btn-cancel">

            <i class="bi bi-arrow-left"></i>
            Cancel
        </a>

        <button type="submit" class="btn-save">
            <i class="bi {{ $isEditing ? 'bi-check-lg' : 'bi-plus-lg' }}"></i>

            {{ $isEditing ? 'Update Arrival' : 'Create Arrival' }}
        </button>
    </div>
</div>

@once
    @push('styles')
        <style>
            .arrival-form {
                --navy: #0b2e59;
                --blue: #184b8c;
                --gold: #f4b400;
                --text: #253851;
                --muted: #7c899b;
                --line: #e3e9f0;
            }

            .arrival-form .form-section {
                margin-bottom: 18px;
                padding: 24px;
                background: #ffffff;
                border: 1px solid var(--line);
                border-radius: 18px;
                box-shadow: 0 8px 24px rgba(11, 46, 89, 0.05);
            }

            .arrival-form .section-heading {
                display: flex;
                align-items: center;
                gap: 12px;
                margin-bottom: 22px;
                padding-bottom: 17px;
                border-bottom: 1px solid #edf1f5;
            }

            .arrival-form .section-icon {
                width: 42px;
                height: 42px;
                flex: 0 0 42px;
                display: grid;
                place-items: center;
                color: var(--blue);
                background: #eaf1f9;
                border-radius: 12px;
                font-size: 18px;
            }

            .arrival-form .section-icon.cover-icon {
                color: #b98500;
                background: #fff5d7;
            }

            .arrival-form .section-heading h5 {
                margin: 0 0 3px;
                color: var(--navy);
                font-size: 15px;
                font-weight: 800;
            }

            .arrival-form .section-heading p {
                margin: 0;
                color: var(--muted);
                font-size: 11px;
            }

            .arrival-form .form-label {
                margin-bottom: 8px;
                color: var(--text);
                font-size: 12px;
                font-weight: 700;
            }

            .arrival-form .form-label > span {
                color: #d94b4b;
            }

            .arrival-form .form-label small {
                margin-left: 4px;
                color: #9aa6b5;
                font-size: 9px;
                font-weight: 600;
                text-transform: uppercase;
            }

            .arrival-form .form-control,
            .arrival-form .form-select {
                min-height: 46px;
                padding: 10px 13px;
                color: var(--text);
                background: #ffffff;
                border: 1px solid var(--line);
                border-radius: 11px;
                box-shadow: none;
                font-size: 12px;
                transition: 0.2s ease;
            }

            .arrival-form textarea.form-control {
                min-height: 110px;
                resize: vertical;
            }

            .arrival-form .form-control:focus,
            .arrival-form .form-select:focus {
                border-color: var(--blue);
                box-shadow: 0 0 0 3px rgba(24, 75, 140, 0.10);
            }

            .arrival-form .form-control::placeholder {
                color: #adb6c2;
            }

            .arrival-form .input-with-icon {
                position: relative;
            }

            .arrival-form .input-with-icon > i {
                position: absolute;
                top: 50%;
                left: 14px;
                z-index: 2;
                color: #8e9bad;
                font-size: 18px;
                transform: translateY(-50%);
            }

            .arrival-form .input-with-icon .form-control {
                padding-left: 42px;
            }

            .arrival-form .field-note,
            .arrival-form .invalid-feedback {
                margin-top: 7px;
                font-size: 10px;
            }

            .arrival-form .field-note {
                color: var(--muted);
            }

            .arrival-form .image-fields {
                height: 100%;
                display: flex;
                flex-direction: column;
                justify-content: center;
            }

            .arrival-form .upload-area {
                min-height: 88px;
                padding: 15px;
                display: flex;
                align-items: center;
                gap: 13px;
                background: #f9fbfd;
                border: 1.5px dashed #c9d4e1;
                border-radius: 13px;
                cursor: pointer;
                transition: 0.2s ease;
            }

            .arrival-form .upload-area:hover {
                background: #f3f7fc;
                border-color: var(--blue);
            }

            .arrival-form .upload-area.upload-error {
                background: #fff8f8;
                border-color: #dc3545;
            }

            .arrival-form .upload-icon {
                width: 44px;
                height: 44px;
                flex: 0 0 44px;
                display: grid;
                place-items: center;
                color: var(--blue);
                background: #e6eef8;
                border-radius: 11px;
                font-size: 20px;
            }

            .arrival-form .upload-copy {
                min-width: 0;
                flex: 1;
            }

            .arrival-form .upload-copy strong,
            .arrival-form .upload-copy small {
                display: block;
            }

            .arrival-form .upload-copy strong {
                overflow: hidden;
                color: var(--navy);
                font-size: 12px;
                text-overflow: ellipsis;
                white-space: nowrap;
            }

            .arrival-form .upload-copy small {
                margin-top: 3px;
                color: var(--muted);
                font-size: 9px;
            }

            .arrival-form .browse-button {
                padding: 7px 11px;
                color: #ffffff;
                background: var(--navy);
                border-radius: 8px;
                font-size: 10px;
                font-weight: 700;
            }

            .arrival-form .image-divider {
                display: flex;
                align-items: center;
                gap: 10px;
                margin: 17px 0;
                color: #9aa6b5;
                font-size: 9px;
                text-transform: uppercase;
            }

            .arrival-form .image-divider::before,
            .arrival-form .image-divider::after {
                content: "";
                height: 1px;
                flex: 1;
                background: #e8edf2;
            }

            .arrival-form .preview-panel {
                min-height: 340px;
                height: 100%;
                padding: 14px;
                background: #f8fafc;
                border: 1px solid #e5eaf0;
                border-radius: 15px;
            }

            .arrival-form .preview-label {
                display: flex;
                justify-content: space-between;
                margin-bottom: 10px;
            }

            .arrival-form .preview-label span {
                color: var(--navy);
                font-size: 11px;
                font-weight: 800;
            }

            .arrival-form .preview-label small {
                color: #95a1b1;
                font-size: 9px;
            }

            .arrival-form .arrival-cover-preview {
                position: relative;
                width: min(100%, 225px);
                height: 290px;
                margin: 0 auto;
                overflow: hidden;
                background: #e9eef4;
                border-radius: 12px;
                box-shadow: 0 10px 24px rgba(11, 46, 89, 0.12);
            }

            .arrival-form .arrival-cover-preview img {
                width: 100%;
                height: 100%;
                display: block;
                object-fit: cover;
            }

            .arrival-form .preview-overlay {
                position: absolute;
                right: 9px;
                bottom: 9px;
                padding: 6px 9px;
                display: inline-flex;
                align-items: center;
                gap: 5px;
                color: #ffffff;
                background: rgba(11, 46, 89, 0.82);
                border-radius: 8px;
                font-size: 9px;
                font-weight: 700;
            }

            .arrival-form .form-actions {
                display: flex;
                justify-content: flex-end;
                gap: 10px;
                padding: 20px 4px 4px;
            }

            .arrival-form .btn-cancel,
            .arrival-form .btn-save {
                min-height: 44px;
                padding: 0 18px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                border-radius: 11px;
                font-size: 12px;
                font-weight: 750;
                text-decoration: none;
                transition: 0.2s ease;
            }

            .arrival-form .btn-cancel {
                color: #66758a;
                background: #ffffff;
                border: 1px solid var(--line);
            }

            .arrival-form .btn-save {
                color: #ffffff;
                background: var(--navy);
                border: 0;
                box-shadow: 0 8px 18px rgba(11, 46, 89, 0.18);
            }

            .arrival-form .btn-cancel:hover {
                color: var(--navy);
                background: #f8fafc;
            }

            .arrival-form .btn-save:hover {
                color: #ffffff;
                background: var(--blue);
                transform: translateY(-1px);
            }

            @media (max-width: 575.98px) {
                .arrival-form .form-section {
                    padding: 19px 16px;
                    border-radius: 15px;
                }

                .arrival-form .upload-area {
                    align-items: flex-start;
                    flex-wrap: wrap;
                }

                .arrival-form .browse-button {
                    margin-left: 57px;
                }

                .arrival-form .form-actions {
                    align-items: stretch;
                    flex-direction: column-reverse;
                }

                .arrival-form .btn-cancel,
                .arrival-form .btn-save {
                    width: 100%;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const fileInput =
                    document.getElementById('image_file');

                const urlInput =
                    document.getElementById('image_url');

                const preview =
                    document.getElementById('arrivalImagePreview');

                const fileName =
                    document.getElementById('arrivalFileName');

                const previewStatus =
                    document.getElementById('arrivalPreviewStatus');

                const accessionInput =
                    document.getElementById('accession_number');

                if (accessionInput) {
                    accessionInput.addEventListener(
                        'input',
                        function () {
                            this.value = this.value.toUpperCase();
                        }
                    );
                }

                if (!fileInput || !urlInput || !preview) {
                    return;
                }

                const originalImage = preview.dataset.original;
                const fallbackImage = preview.dataset.fallback;

                const allowedTypes = [
                    'image/jpeg',
                    'image/png',
                    'image/webp'
                ];

                let objectUrl = null;

                function releaseObjectUrl() {
                    if (objectUrl) {
                        URL.revokeObjectURL(objectUrl);
                        objectUrl = null;
                    }
                }

                function displayUrlImage() {
                    if (fileInput.files.length > 0) {
                        return;
                    }

                    releaseObjectUrl();

                    preview.src =
                        urlInput.value.trim() || originalImage;

                    previewStatus.textContent =
                        urlInput.value.trim()
                            ? 'Image link'
                            : 'Current image';
                }

                fileInput.addEventListener(
                    'change',
                    function () {
                        const file = fileInput.files[0];

                        if (!file) {
                            fileName.textContent =
                                'Choose a cover image';

                            displayUrlImage();
                            return;
                        }

                        if (!allowedTypes.includes(file.type)) {
                            fileInput.value = '';

                            fileName.textContent =
                                'Choose a cover image';

                            preview.src = fallbackImage;

                            previewStatus.textContent =
                                'Invalid image';

                            alert(
                                'Please select a JPG, PNG, or WEBP image.'
                            );

                            return;
                        }

                        releaseObjectUrl();

                        objectUrl =
                            URL.createObjectURL(file);

                        preview.src = objectUrl;
                        fileName.textContent = file.name;

                        previewStatus.textContent =
                            'New upload';
                    }
                );

                urlInput.addEventListener(
                    'input',
                    displayUrlImage
                );

                preview.addEventListener(
                    'error',
                    function () {
                        if (preview.src !== fallbackImage) {
                            preview.src = fallbackImage;

                            previewStatus.textContent =
                                'Fallback image';
                        }
                    }
                );

                window.addEventListener(
                    'beforeunload',
                    releaseObjectUrl
                );
            });
        </script>
    @endpush
@endonce