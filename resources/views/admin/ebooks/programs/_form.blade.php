@php
    $program = $ebookProgram ?? null;
    $isEditing = $program !== null;
    $status = (int) old('status', $program?->status ?? 1);
    $storedImage = $program?->image;
    $fallbackImage = asset('images/readingarea.jpg');
    $currentImage = $program?->image_url ?? $fallbackImage;

    $externalImageUrl = old(
        'image_url',
        \Illuminate\Support\Str::startsWith(
            $storedImage ?? '',
            ['http://', 'https://']
        ) ? $storedImage : ''
    );
@endphp

<div class="program-form">
    <div class="form-section">
        <div class="section-heading">
            <span class="section-icon">
                <i class="bi bi-mortarboard-fill"></i>
            </span>

            <div>
                <h5>Program Information</h5>
                <p>Enter the academic program details and display settings.</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-10">
                <label for="title" class="form-label">
                    Program Title <span>*</span>
                </label>

                <input
                    type="text"
                    name="title"
                    id="title"
                    value="{{ old('title', $program?->title) }}"
                    class="form-control @error('title') is-invalid @enderror"
                    placeholder="Example: Bachelor of Science in Information Systems"
                    required>

                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-sm-6 col-lg-2">
                <label for="status" class="form-label">Visibility</label>

                <select
                    name="status"
                    id="status"
                    class="form-select @error('status') is-invalid @enderror"
                    required>
                    <option value="1" @selected($status === 1)>Active</option>
                    <option value="0" @selected($status === 0)>Hidden</option>
                </select>

                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
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
                    placeholder="Briefly describe this academic program...">{{ old('description', $program?->description) }}</textarea>

                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
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
                <h5>Program Image</h5>
                <p>Upload an image or provide a direct external image link.</p>
            </div>
        </div>

        <div class="row g-4 align-items-stretch">
            <div class="col-lg-7">
                <div class="image-fields">
                    <div>
                        <label for="image_file" class="form-label">
                            Upload Image <small>Recommended</small>
                        </label>

                        <label for="image_file"
                               class="upload-area @error('image_file') upload-error @enderror">
                            <span class="upload-icon">
                                <i class="bi bi-cloud-arrow-up"></i>
                            </span>

                            <span class="upload-copy">
                                <strong id="uploadFileName">Choose an image</strong>
                                <small>JPG, PNG or WEBP · Maximum 5 MB</small>
                            </span>

                            <span class="browse-button">Browse</span>
                        </label>

                        <input
                            type="file"
                            name="image_file"
                            id="image_file"
                            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                            class="visually-hidden"
                            @error('image_file') aria-invalid="true" @enderror>

                        @error('image_file')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="image-divider">
                        <span>or use an image link</span>
                    </div>

                    <div>
                        <label for="image_url" class="form-label">
                            External Image URL <small>Optional</small>
                        </label>

                        <div class="input-with-icon">
                            <i class="bi bi-link-45deg"></i>
                            <input
                                type="url"
                                name="image_url"
                                id="image_url"
                                value="{{ $externalImageUrl }}"
                                class="form-control @error('image_url') is-invalid @enderror"
                                placeholder="https://example.com/program-image.jpg">
                        </div>

                        @error('image_url')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @else
                            <div class="field-note">
                                An uploaded file takes priority over an image link.
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="preview-panel">
                    <div class="preview-label">
                        <span>Image Preview</span>
                        <small id="previewStatus">Current image</small>
                    </div>

                    <div class="program-image-preview">
                        <img
                            id="programImagePreview"
                            src="{{ $currentImage }}"
                            data-original="{{ $currentImage }}"
                            data-fallback="{{ $fallbackImage }}"
                            alt="Program image preview">

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
        <a href="{{ route('admin.ebook-programs.index') }}" class="btn-cancel">
            <i class="bi bi-arrow-left"></i>
            Cancel
        </a>

        <button type="submit" class="btn-save">
            <i class="bi {{ $isEditing ? 'bi-check-lg' : 'bi-plus-lg' }}"></i>
            {{ $isEditing ? 'Update Program' : 'Create Program' }}
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
                margin-bottom: 8px;
                color: var(--text);
                font-size: 12px;
                font-weight: 700;
            }

            .program-form .form-label > span {
                color: #d94b4b;
            }

            .program-form .form-label small {
                margin-left: 4px;
                color: #9aa6b5;
                font-size: 9px;
                font-weight: 600;
                text-transform: uppercase;
            }

            .program-form .form-control,
            .program-form .form-select {
                min-height: 46px;
                padding: 10px 13px;
                border: 1px solid var(--line);
                border-radius: 11px;
                color: var(--text);
                font-size: 12px;
                box-shadow: none;
                transition: .2s ease;
            }

            .program-form textarea.form-control {
                min-height: 110px;
                resize: vertical;
            }

            .program-form .form-control:focus,
            .program-form .form-select:focus {
                border-color: var(--blue);
                box-shadow: 0 0 0 3px rgba(24, 75, 140, .1);
            }

            .program-form .form-control::placeholder {
                color: #adb6c2;
            }

            .program-form .image-fields {
                height: 100%;
                padding: 2px 0;
                display: flex;
                flex-direction: column;
                justify-content: center;
            }

            .program-form .upload-area {
                min-height: 88px;
                padding: 15px;
                display: flex;
                align-items: center;
                gap: 13px;
                border: 1.5px dashed #c9d4e1;
                border-radius: 13px;
                background: #f9fbfd;
                cursor: pointer;
                transition: .2s ease;
            }

            .program-form .upload-area:hover {
                border-color: var(--blue);
                background: #f3f7fc;
            }

            .program-form .upload-area.upload-error {
                border-color: #dc3545;
                background: #fff8f8;
            }

            .program-form .upload-icon {
                width: 44px;
                height: 44px;
                flex: 0 0 44px;
                display: grid;
                place-items: center;
                border-radius: 11px;
                background: #e6eef8;
                color: var(--blue);
                font-size: 20px;
            }

            .program-form .upload-copy {
                min-width: 0;
                flex: 1;
            }

            .program-form .upload-copy strong,
            .program-form .upload-copy small {
                display: block;
            }

            .program-form .upload-copy strong {
                overflow: hidden;
                color: var(--navy);
                font-size: 12px;
                text-overflow: ellipsis;
                white-space: nowrap;
            }

            .program-form .upload-copy small {
                margin-top: 3px;
                color: var(--muted);
                font-size: 9px;
            }

            .program-form .browse-button {
                padding: 7px 11px;
                border-radius: 8px;
                background: var(--navy);
                color: #fff;
                font-size: 10px;
                font-weight: 700;
            }

            .program-form .image-divider {
                margin: 17px 0;
                display: flex;
                align-items: center;
                gap: 10px;
                color: #9aa6b5;
                font-size: 9px;
                text-transform: uppercase;
            }

            .program-form .image-divider::before,
            .program-form .image-divider::after {
                content: "";
                height: 1px;
                flex: 1;
                background: #e8edf2;
            }

            .program-form .input-with-icon {
                position: relative;
            }

            .program-form .input-with-icon > i {
                position: absolute;
                top: 50%;
                left: 14px;
                z-index: 2;
                color: #8e9bad;
                font-size: 18px;
                transform: translateY(-50%);
            }

            .program-form .input-with-icon .form-control {
                padding-left: 42px;
            }

            .program-form .field-note {
                margin-top: 7px;
                color: var(--muted);
                font-size: 10px;
            }

            .program-form .invalid-feedback {
                margin-top: 6px;
                font-size: 10px;
            }

            .program-form .preview-panel {
                height: 100%;
                min-height: 290px;
                padding: 14px;
                border: 1px solid #e5eaf0;
                border-radius: 15px;
                background: #f8fafc;
            }

            .program-form .preview-label {
                margin-bottom: 10px;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .program-form .preview-label span {
                color: var(--navy);
                font-size: 11px;
                font-weight: 800;
            }

            .program-form .preview-label small {
                color: #95a1b1;
                font-size: 9px;
            }

            .program-form .program-image-preview {
                position: relative;
                overflow: hidden;
                height: 245px;
                border-radius: 12px;
                background: #e9eef4;
            }

            .program-form .program-image-preview img {
                width: 100%;
                height: 100%;
                display: block;
                object-fit: cover;
            }

            .program-form .preview-overlay {
                position: absolute;
                right: 10px;
                bottom: 10px;
                padding: 6px 9px;
                display: inline-flex;
                align-items: center;
                gap: 5px;
                border-radius: 8px;
                background: rgba(11, 46, 89, .82);
                color: #fff;
                font-size: 9px;
                font-weight: 700;
                backdrop-filter: blur(5px);
            }

            .program-form .form-actions {
                padding: 20px 4px 4px;
                display: flex;
                align-items: center;
                justify-content: flex-end;
                gap: 10px;
            }

            .program-form .btn-cancel,
            .program-form .btn-save {
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
                transition: .2s ease;
            }

            .program-form .btn-cancel {
                border: 1px solid var(--line);
                background: #fff;
                color: #66758a;
            }

            .program-form .btn-save {
                border: 0;
                background: var(--navy);
                color: #fff;
                box-shadow: 0 8px 18px rgba(11, 46, 89, .18);
            }

            .program-form .btn-cancel:hover {
                background: #f8fafc;
                color: var(--navy);
            }

            .program-form .btn-save:hover {
                background: var(--blue);
                color: #fff;
                transform: translateY(-1px);
            }

            @media (max-width: 575.98px) {
                .program-form .form-section {
                    padding: 19px 16px;
                    border-radius: 15px;
                }

                .program-form .upload-area {
                    align-items: flex-start;
                    flex-wrap: wrap;
                }

                .program-form .browse-button {
                    margin-left: 57px;
                }

                .program-form .form-actions {
                    align-items: stretch;
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
                const fileInput = document.getElementById('image_file');
                const urlInput = document.getElementById('image_url');
                const preview = document.getElementById('programImagePreview');
                const fileName = document.getElementById('uploadFileName');
                const previewStatus = document.getElementById('previewStatus');

                if (!fileInput || !urlInput || !preview) {
                    return;
                }

                const originalImage = preview.dataset.original;
                const fallbackImage = preview.dataset.fallback;
                const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
                let objectUrl = null;

                function releaseObjectUrl() {
                    if (objectUrl) {
                        URL.revokeObjectURL(objectUrl);
                        objectUrl = null;
                    }
                }

                function showUrlPreview() {
                    if (fileInput.files.length > 0) {
                        return;
                    }

                    releaseObjectUrl();
                    preview.src = urlInput.value.trim() || originalImage;
                    previewStatus.textContent = urlInput.value.trim()
                        ? 'Image link'
                        : 'Current image';
                }

                fileInput.addEventListener('change', function () {
                    const file = fileInput.files[0];

                    if (!file) {
                        fileName.textContent = 'Choose an image';
                        showUrlPreview();
                        return;
                    }

                    if (!allowedTypes.includes(file.type)) {
                        fileInput.value = '';
                        fileName.textContent = 'Choose an image';
                        preview.src = fallbackImage;
                        previewStatus.textContent = 'Invalid image';
                        alert('Please select a JPG, PNG, or WEBP image.');
                        return;
                    }

                    releaseObjectUrl();
                    objectUrl = URL.createObjectURL(file);
                    preview.src = objectUrl;
                    fileName.textContent = file.name;
                    previewStatus.textContent = 'New upload';
                });

                urlInput.addEventListener('input', showUrlPreview);

                preview.addEventListener('error', function () {
                    if (preview.src !== fallbackImage) {
                        preview.src = fallbackImage;
                        previewStatus.textContent = 'Fallback image';
                    }
                });

                window.addEventListener('beforeunload', releaseObjectUrl);
            });
        </script>
    @endpush
@endonce