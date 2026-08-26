@php
    $book = $donatedBook ?? null;
    $isEditing = $book !== null;

    $currentImage = $book?->image_url
        ?? asset('images/image-fallback.svg');

    /*
    |--------------------------------------------------------------------------
    | Current status
    |--------------------------------------------------------------------------
    | New donated books default to Active.
    | Existing books use their saved status.
    | Validation errors preserve the previously selected value.
    */
    $currentStatus = (int) old(
        'status',
        $isEditing ? $book->status : 1
    );
@endphp

<div class="program-form">

    <div class="form-section">

        <div class="section-heading">

            <span class="section-icon">
                <i class="bi bi-book-half"></i>
            </span>

            <div>
                <h5>Book Information</h5>

                <p>
                    Enter the donated book details and visibility settings.
                </p>
            </div>

        </div>

        <div class="row g-4">

            <div class="col-lg-10">

                <label for="title" class="form-label">
                    Book Title <span>*</span>
                </label>

                <input
                    type="text"
                    name="title"
                    id="title"
                    value="{{ old('title', $book?->title) }}"
                    class="form-control @error('title') is-invalid @enderror"
                    placeholder="Example: Donated Science Reference"
                    maxlength="255"
                    required>

                @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="col-sm-6 col-lg-2">

                <label for="status" class="form-label">
                    Visibility
                </label>

                <select
                    name="status"
                    id="status"
                    class="form-select @error('status') is-invalid @enderror"
                    required>

                    <option
                        value="1"
                        @selected($currentStatus === 1)>

                        Active

                    </option>

                    <option
                        value="0"
                        @selected($currentStatus === 0)>

                        Hidden

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
                    Description <small>Optional</small>
                </label>

                <textarea
                    name="description"
                    id="description"
                    rows="4"
                    class="form-control @error('description') is-invalid @enderror"
                    placeholder="Write a short description for the donated book...">{{ old('description', $book?->description) }}</textarea>

                @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

        </div>

    </div>

    <div class="form-section">

        <div class="section-heading">

            <span class="section-icon image-icon">
                <i class="bi bi-image-fill"></i>
            </span>

            <div>
                <h5>Book Cover</h5>

                <p>
                    Upload a cover image for the donated book.
                </p>
            </div>

        </div>

        <div class="row g-4 align-items-stretch">

            <div class="col-lg-7">

                <div class="image-fields">

                    <div>

                        <label for="image_file" class="form-label">

                            Upload Image

                            <small>
                                {{ $isEditing ? 'Optional' : 'Required' }}
                            </small>

                        </label>

                        <label
                            for="image_file"
                            class="upload-area @error('image_file') upload-error @enderror">

                            <span class="upload-icon">
                                <i class="bi bi-cloud-arrow-up"></i>
                            </span>

                            <span class="upload-copy">

                                <strong id="uploadFileName">
                                    Choose an image
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
                            class="visually-hidden"
                            @error('image_file') aria-invalid="true" @enderror>

                        @error('image_file')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                </div>

            </div>

            <div class="col-lg-5">

                <div class="preview-panel">

                    <div class="preview-label">

                        <span>
                            Image Preview
                        </span>

                        <small id="previewStatus">
                            {{ $isEditing ? 'Current image' : 'Default preview' }}
                        </small>

                    </div>

                    <div class="program-image-preview">

                        <img
                            id="programImagePreview"
                            src="{{ $currentImage }}"
                            data-original="{{ $currentImage }}"
                            data-fallback="{{ asset('images/image-fallback.svg') }}"
                            alt="Donated book preview">

                        <span class="preview-overlay">
                            <i class="bi bi-eye"></i>
                            Preview
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="form-actions">

        <a
            href="{{ route('admin.donated-books.index') }}"
            class="btn-cancel">

            <i class="bi bi-arrow-left"></i>

            Cancel

        </a>

        <button type="submit" class="btn-save">

            <i class="bi {{ $isEditing ? 'bi-check-lg' : 'bi-plus-lg' }}"></i>

            {{ $isEditing ? 'Update Book' : 'Create Book' }}

        </button>

    </div>

</div>

@once

    @push('styles')

        <style>

            .program-form {
                --navy: #0b2e59;
                --blue: #184b8c;
                --gold: #f4b400;
                --text: #253851;
                --muted: #7c899b;
                --line: #e3e9f0;
            }

            .program-form .form-section {
                margin-bottom: 18px;
                padding: 24px;
                border: 1px solid var(--line);
                border-radius: 18px;
                background: #fff;
                box-shadow: 0 8px 24px rgba(11, 46, 89, .05);
            }

            .program-form .section-heading {
                margin-bottom: 22px;
                padding-bottom: 17px;
                display: flex;
                align-items: center;
                gap: 12px;
                border-bottom: 1px solid #edf1f5;
            }

            .program-form .section-icon {
                width: 42px;
                height: 42px;
                flex: 0 0 42px;
                display: grid;
                place-items: center;
                border-radius: 12px;
                background: #eaf1f9;
                color: var(--blue);
                font-size: 18px;
            }

            .program-form .section-icon.image-icon {
                background: #fff5d7;
                color: #b98500;
            }

            .program-form .section-heading h5 {
                margin: 0 0 3px;
                color: var(--navy);
                font-size: 15px;
                font-weight: 800;
            }

            .program-form .section-heading p {
                margin: 0;
                color: var(--muted);
                font-size: 11px;
            }

            .program-form .form-label {
                margin-bottom: 10px;
                color: var(--text);
                font-size: 13px;
                font-weight: 700;
            }

            .program-form .form-label span,
            .program-form .form-label small {
                color: var(--muted);
                font-size: 11px;
                font-weight: 500;
            }

            .program-form .form-control,
            .program-form .form-select {
                min-height: 44px;
                border-color: var(--line);
                border-radius: 12px;
                color: var(--text);
                font-size: 13px;
                box-shadow: none;
            }

            .program-form .form-control:focus,
            .program-form .form-select:focus {
                border-color: rgba(24, 75, 140, .55);
                box-shadow: 0 0 0 .2rem rgba(24, 75, 140, .08);
            }

            .program-form textarea.form-control {
                min-height: 110px;
                resize: vertical;
            }

            .program-form .image-fields {
                display: flex;
                flex-direction: column;
                gap: 18px;
            }

            .program-form .upload-area {
                min-height: 182px;
                padding: 24px;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 16px;
                border: 1px dashed #d5deea;
                border-radius: 18px;
                background: linear-gradient(
                    180deg,
                    #fbfdff 0%,
                    #f7faff 100%
                );
                cursor: pointer;
                transition: .2s ease;
            }

            .program-form .upload-area:hover {
                border-color: rgba(24, 75, 140, .4);
                background: #f8fbff;
                transform: translateY(-1px);
            }

            .program-form .upload-area.upload-error {
                border-color: #dc3545;
                background: #fff8f8;
            }

            .program-form .upload-icon {
                width: 54px;
                height: 54px;
                flex: 0 0 54px;
                display: grid;
                place-items: center;
                border-radius: 16px;
                background: #eaf1f9;
                color: var(--blue);
                font-size: 22px;
            }

            .program-form .upload-copy {
                min-width: 0;
            }

            .program-form .upload-copy strong,
            .program-form .upload-copy small {
                display: block;
            }

            .program-form .upload-copy strong {
                margin-bottom: 4px;
                overflow: hidden;
                color: var(--navy);
                font-size: 15px;
                font-weight: 800;
                text-overflow: ellipsis;
                white-space: nowrap;
            }

            .program-form .upload-copy small {
                color: var(--muted);
                font-size: 11px;
            }

            .program-form .browse-button {
                margin-left: auto;
                padding: 10px 16px;
                flex-shrink: 0;
                border-radius: 999px;
                background: var(--gold);
                color: var(--navy);
                font-size: 11px;
                font-weight: 800;
            }

            .program-form .preview-panel {
                height: 100%;
                display: flex;
                flex-direction: column;
                gap: 12px;
            }

            .program-form .preview-label {
                display: flex;
                justify-content: space-between;
                gap: 12px;
                align-items: center;
            }

            .program-form .preview-label span {
                color: var(--navy);
                font-size: 13px;
                font-weight: 800;
            }

            .program-form .preview-label small {
                color: var(--muted);
                font-size: 11px;
            }

            .program-form .program-image-preview {
                position: relative;
                overflow: hidden;
                min-height: 280px;
                border-radius: 18px;
                background: #edf3f9;
            }

            .program-form .program-image-preview img {
                width: 100%;
                height: 100%;
                min-height: 280px;
                object-fit: cover;
            }

            .program-form .preview-overlay {
                position: absolute;
                right: 14px;
                bottom: 14px;
                padding: 9px 14px;
                display: inline-flex;
                align-items: center;
                gap: 8px;
                border-radius: 999px;
                background: rgba(11, 46, 89, .9);
                color: #fff;
                font-size: 11px;
                font-weight: 700;
            }

            .program-form .form-actions {
                display: flex;
                justify-content: flex-end;
                gap: 10px;
                margin-top: 18px;
            }

            .program-form .btn-cancel,
            .program-form .btn-save {
                min-height: 46px;
                padding: 0 18px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                border-radius: 999px;
                font-size: 13px;
                font-weight: 800;
                text-decoration: none;
                transition: .2s ease;
            }

            .program-form .btn-cancel {
                border: 1px solid var(--line);
                background: #fff;
                color: var(--text);
            }

            .program-form .btn-save {
                border: 0;
                background: var(--gold);
                color: var(--navy);
            }

            .program-form .btn-save:hover,
            .program-form .btn-cancel:hover {
                transform: translateY(-1px);
            }

            @media (max-width: 767.98px) {

                .program-form .form-section {
                    padding: 19px 16px;
                    border-radius: 15px;
                }

                .program-form .upload-area {
                    padding: 20px 16px;
                    flex-direction: column;
                    text-align: center;
                }

                .program-form .browse-button {
                    margin-left: 0;
                }

                .program-form .upload-copy strong {
                    white-space: normal;
                }

                .program-form .program-image-preview,
                .program-form .program-image-preview img {
                    min-height: 230px;
                }

                .program-form .form-actions {
                    flex-direction: column-reverse;
                }

                .program-form .btn-cancel,
                .program-form .btn-save {
                    width: 100%;
                }

            }

        </style>

    @endpush

    @push('scripts')

        <script>

            document.addEventListener('DOMContentLoaded', function () {

                const imageInput = document.getElementById('image_file');
                const imagePreview = document.getElementById('programImagePreview');
                const uploadFileName = document.getElementById('uploadFileName');
                const previewStatus = document.getElementById('previewStatus');

                if (!imageInput || !imagePreview) {
                    return;
                }

                imageInput.addEventListener('change', function () {

                    const file = this.files && this.files[0];

                    if (!file) {
                        imagePreview.src = imagePreview.dataset.original;
                        uploadFileName.textContent = 'Choose an image';
                        previewStatus.textContent = 'Current image';
                        return;
                    }

                    uploadFileName.textContent = file.name;
                    previewStatus.textContent = 'New image selected';

                    const reader = new FileReader();

                    reader.onload = function (event) {
                        imagePreview.src = event.target.result;
                    };

                    reader.onerror = function () {
                        imagePreview.src = imagePreview.dataset.fallback;
                        previewStatus.textContent = 'Preview unavailable';
                    };

                    reader.readAsDataURL(file);

                });

                imagePreview.addEventListener('error', function () {
                    this.src = this.dataset.fallback;
                });

            });

        </script>

    @endpush

@endonce
