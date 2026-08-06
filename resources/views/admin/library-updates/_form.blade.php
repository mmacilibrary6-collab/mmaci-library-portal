@php
    $update = $libraryUpdate ?? null;
    $isEditing = $update !== null;
    $currentImage = $update?->image_url ?? asset('images/readingarea.jpg');
@endphp

<section class="update-form-panel">
    <div class="form-panel-header">
        <div>
            <span class="panel-eyebrow">Slide Information</span>

            <h4>
                {{ $isEditing ? 'Edit Update Details' : 'New Update Details' }}
            </h4>

            <p>
                Fill in the information that will appear on the homepage slideshow.
            </p>
        </div>

        <span class="record-badge">
            <i class="bi {{ $isEditing ? 'bi-pencil' : 'bi-plus-lg' }}"></i>

            {{ $isEditing ? 'Editing' : 'New Record' }}
        </span>
    </div>

    <div class="form-panel-body">
        <div class="row g-4">
            <div class="col-xl-7">
                <div class="form-section-card">
                    <div class="section-heading-custom">
                        <span class="section-number">01</span>

                        <div>
                            <h5>Basic Information</h5>
                            <p>Add the slide title and optional description.</p>
                        </div>
                    </div>

                    <div class="custom-form-group">
                        <label for="title">
                            Update Title
                            <span class="required-mark">*</span>
                        </label>

                        <input
                            id="title"
                            type="text"
                            name="title"
                            value="{{ old('title', $update?->title) }}"
                            class="form-control @error('title') is-invalid @enderror"
                            placeholder="Example: Library Orientation 2026"
                            required>

                        @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="custom-form-group mb-0">
                        <label for="description">
                            Description
                            <small>Optional</small>
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            rows="6"
                            class="form-control @error('description') is-invalid @enderror"
                            placeholder="Write a short description for this update...">{{ old('description', $update?->description) }}</textarea>

                        @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                        <span class="field-help">
                            Keep the description brief so it remains readable
                            on the slideshow.
                        </span>
                    </div>
                </div>

                <div class="form-section-card mt-4">
                    <div class="section-heading-custom">
                        <span class="section-number">02</span>

                        <div>
                            <h5>Slide Image</h5>
                            <p>Upload the image that will appear on the homepage.</p>
                        </div>
                    </div>

                    <div class="custom-form-group mb-0">
                        <label for="image_file">
                            Upload Image

                            @unless($isEditing)
                                <span class="required-mark">*</span>
                            @endunless
                        </label>

                        <div class="upload-box">
                            <div class="upload-information">
                                <span class="upload-icon">
                                    <i class="bi bi-cloud-arrow-up"></i>
                                </span>

                                <div>
                                    <strong>Select an image</strong>
                                    <span>JPG, JPEG, PNG, or WebP</span>
                                </div>
                            </div>

                            <input
                                id="image_file"
                                type="file"
                                name="image_file"
                                class="form-control @error('image_file') is-invalid @enderror"
                                accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                {{ $isEditing ? '' : 'required' }}>
                        </div>

                        @error('image_file')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror

                        @if($isEditing)
                            <span class="field-help">
                                Leave this empty to keep the current image.
                            </span>
                        @else
                            <span class="field-help">
                                A landscape image is recommended for the homepage slideshow.
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-xl-5">
                <div class="form-section-card preview-settings-card">
                    <div class="section-heading-custom">
                        <span class="section-number">03</span>

                        <div>
                            <h5>Preview and Settings</h5>
                            <p>Review the image and configure slide visibility.</p>
                        </div>
                    </div>

                    <div class="image-preview">
                        <img
                            id="libraryUpdatePreview"
                            src="{{ $currentImage }}"
                            alt="Library update preview"
                            onerror="this.onerror=null;this.src='{{ asset('images/readingarea.jpg') }}';">

                        <div class="preview-overlay">
                            <span>Homepage Preview</span>
                        </div>
                    </div>

                    <div class="preview-message">
                        <i class="bi bi-info-circle"></i>

                        <span>
                            The preview updates automatically after selecting an image.
                        </span>
                    </div>

                    <div class="settings-grid">
                        <div class="custom-form-group mb-0">
                            <label for="sort_order">
                                Sort Order
                            </label>

                            <input
                                id="sort_order"
                                type="number"
                                name="sort_order"
                                min="0"
                                value="{{ old('sort_order', $update?->sort_order ?? 0) }}"
                                class="form-control @error('sort_order') is-invalid @enderror">

                            @error('sort_order')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <span class="field-help">
                                Lower numbers appear first.
                            </span>
                        </div>

                        <div class="custom-form-group mb-0">
                            <label for="status">
                                Status
                            </label>

                            <select
                                id="status"
                                name="status"
                                class="form-select @error('status') is-invalid @enderror">

                                <option
                                    value="1"
                                    @selected(old('status', $update?->status ?? 1) == 1)>
                                    Active
                                </option>

                                <option
                                    value="0"
                                    @selected(old('status', $update?->status ?? 1) == 0)>
                                    Hidden
                                </option>
                            </select>

                            @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <span class="field-help">
                                Hidden slides will not appear publicly.
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-panel-footer">
        <a
            href="{{ route('admin.library-updates.index') }}"
            class="cancel-button">

            Cancel
        </a>

        <button type="submit" class="submit-button">
            <i class="bi {{ $isEditing ? 'bi-check2-circle' : 'bi-plus-lg' }}"></i>

            {{ $isEditing ? 'Update Slide' : 'Create Slide' }}
        </button>
    </div>
</section>

@push('styles')
<style>
    .library-update-form-page {
        padding: 24px;
    }

    .updates-hero {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        margin-bottom: 22px;
        padding: 28px 30px;
        color: #ffffff;
        background: linear-gradient(125deg, #0b2e59, #184b8c);
        border-radius: 22px;
        box-shadow: 0 16px 36px rgba(11, 46, 89, 0.16);
    }

    .hero-copy {
        display: flex;
        align-items: center;
        gap: 18px;
    }

    .hero-icon {
        width: 62px;
        height: 62px;
        flex: 0 0 62px;
        display: grid;
        place-items: center;
        color: #0b2e59;
        background: #f4b400;
        border-radius: 18px;
        font-size: 27px;
    }

    .hero-eyebrow {
        display: block;
        margin-bottom: 4px;
        color: #ffd96d;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 0.14em;
        text-transform: uppercase;
    }

    .updates-hero h2 {
        margin: 0 0 5px;
        font-size: clamp(24px, 3vw, 32px);
        font-weight: 800;
    }

    .updates-hero p {
        margin: 0;
        color: rgba(255, 255, 255, 0.72);
        font-size: 12px;
    }

    .btn-back-list {
        min-height: 46px;
        padding: 0 18px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        color: #0b2e59;
        background: #f4b400;
        border: 0;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 800;
        text-decoration: none;
        transition:
            transform 0.2s ease,
            background 0.2s ease;
    }

    .btn-back-list:hover {
        color: #0b2e59;
        background: #ffc72c;
        transform: translateY(-1px);
    }

    .update-form-panel {
        overflow: hidden;
        background: #ffffff;
        border: 1px solid #e4eaf1;
        border-radius: 20px;
        box-shadow: 0 12px 30px rgba(25, 50, 80, 0.07);
    }

    .form-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 20px 22px;
        border-bottom: 1px solid #e4eaf1;
    }

    .panel-eyebrow {
        display: block;
        margin-bottom: 4px;
        color: #184b8c;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 0.12em;
        text-transform: uppercase;
    }

    .form-panel-header h4 {
        margin: 0 0 4px;
        color: #0b2e59;
        font-size: 16px;
        font-weight: 800;
    }

    .form-panel-header p {
        margin: 0;
        color: #778599;
        font-size: 10px;
    }

    .record-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 11px;
        color: #0b2e59;
        background: #fff7d9;
        border: 1px solid #f2dc88;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 800;
        white-space: nowrap;
    }

    .form-panel-body {
        padding: 22px;
        background: #f8fafc;
    }

    .form-section-card {
        height: 100%;
        padding: 21px;
        background: #ffffff;
        border: 1px solid #e4eaf1;
        border-radius: 16px;
    }

    .section-heading-custom {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 1px solid #edf0f4;
    }

    .section-number {
        width: 34px;
        height: 34px;
        flex: 0 0 34px;
        display: grid;
        place-items: center;
        color: #0b2e59;
        background: #fff7d9;
        border-radius: 10px;
        font-size: 10px;
        font-weight: 800;
    }

    .section-heading-custom h5 {
        margin: 0 0 3px;
        color: #0b2e59;
        font-size: 14px;
        font-weight: 800;
    }

    .section-heading-custom p {
        margin: 0;
        color: #8a96a8;
        font-size: 10px;
        line-height: 1.5;
    }

    .custom-form-group {
        margin-bottom: 18px;
    }

    .custom-form-group label {
        display: block;
        margin-bottom: 7px;
        color: #344054;
        font-size: 11px;
        font-weight: 800;
    }

    .custom-form-group label small {
        color: #98a2b3;
        font-size: 9px;
        font-weight: 600;
    }

    .required-mark {
        color: #d92d20;
    }

    .custom-form-group .form-control,
    .custom-form-group .form-select {
        min-height: 45px;
        color: #344054;
        background: #ffffff;
        border: 1px solid #dfe6ef;
        border-radius: 10px;
        box-shadow: none;
        font-size: 12px;
    }

    .custom-form-group textarea.form-control {
        min-height: 145px;
        resize: vertical;
    }

    .custom-form-group .form-control:focus,
    .custom-form-group .form-select:focus {
        border-color: #184b8c;
        box-shadow: 0 0 0 3px rgba(24, 75, 140, 0.1);
    }

    .field-help {
        display: block;
        margin-top: 6px;
        color: #98a2b3;
        font-size: 9px;
        line-height: 1.5;
    }

    .upload-box {
        padding: 16px;
        background: #f8fafc;
        border: 1px dashed #b8c5d5;
        border-radius: 13px;
    }

    .upload-information {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 13px;
    }

    .upload-icon {
        width: 44px;
        height: 44px;
        flex: 0 0 44px;
        display: grid;
        place-items: center;
        color: #184b8c;
        background: #edf4fb;
        border-radius: 12px;
        font-size: 19px;
    }

    .upload-information strong,
    .upload-information span {
        display: block;
    }

    .upload-information strong {
        color: #344054;
        font-size: 11px;
        font-weight: 800;
    }

    .upload-information span {
        margin-top: 3px;
        color: #98a2b3;
        font-size: 9px;
    }

    .upload-box input[type="file"] {
        padding: 8px;
        background: #ffffff;
    }

    .preview-settings-card {
        display: flex;
        flex-direction: column;
    }

    .image-preview {
        position: relative;
        height: 285px;
        overflow: hidden;
        background: #e9eef5;
        border: 1px solid #dfe6ef;
        border-radius: 15px;
    }

    .image-preview img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
    }

    .preview-overlay {
        position: absolute;
        right: 0;
        bottom: 0;
        left: 0;
        padding: 28px 15px 12px;
        background: linear-gradient(
            transparent,
            rgba(7, 31, 62, 0.82)
        );
    }

    .preview-overlay span {
        color: #ffffff;
        font-size: 9px;
        font-weight: 800;
        letter-spacing: 0.09em;
        text-transform: uppercase;
    }

    .preview-message {
        display: flex;
        align-items: flex-start;
        gap: 7px;
        margin: 11px 0 18px;
        color: #667085;
        font-size: 9px;
        line-height: 1.5;
    }

    .preview-message i {
        color: #184b8c;
    }

    .settings-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
        margin-top: auto;
    }

    .form-panel-footer {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 9px;
        padding: 17px 22px;
        border-top: 1px solid #e4eaf1;
    }

    .cancel-button,
    .submit-button {
        min-height: 42px;
        padding: 0 18px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border-radius: 11px;
        font-size: 11px;
        font-weight: 800;
        text-decoration: none;
    }

    .cancel-button {
        color: #475467;
        background: #ffffff;
        border: 1px solid #d0d5dd;
    }

    .submit-button {
        color: #0b2e59;
        background: #f4b400;
        border: 1px solid #f4b400;
    }

    .cancel-button:hover {
        color: #0b2e59;
        background: #f8fafc;
    }

    .submit-button:hover {
        color: #0b2e59;
        background: #ffc72c;
        border-color: #ffc72c;
    }

    @media (max-width: 991.98px) {
        .updates-hero {
            align-items: stretch;
            flex-direction: column;
        }

        .btn-back-list {
            width: 100%;
        }

        .settings-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 767.98px) {
        .library-update-form-page {
            padding: 18px;
        }

        .updates-hero {
            padding: 22px;
            border-radius: 18px;
        }

        .hero-icon {
            width: 54px;
            height: 54px;
            flex-basis: 54px;
            border-radius: 15px;
            font-size: 23px;
        }

        .form-panel-header {
            align-items: flex-start;
            flex-direction: column;
            padding: 18px;
        }

        .form-panel-body {
            padding: 18px;
        }

        .form-section-card {
            padding: 18px;
        }

        .settings-grid {
            grid-template-columns: 1fr;
        }

        .form-panel-footer {
            padding: 17px 18px;
            flex-direction: column-reverse;
        }

        .cancel-button,
        .submit-button {
            width: 100%;
        }
    }

    @media (max-width: 480px) {
        .library-update-form-page {
            padding: 14px;
        }

        .updates-hero {
            padding: 18px;
        }

        .hero-copy {
            align-items: flex-start;
        }

        .image-preview {
            height: 230px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const imageInput = document.getElementById('image_file');
        const previewImage = document.getElementById('libraryUpdatePreview');

        if (!imageInput || !previewImage) {
            return;
        }

        imageInput.addEventListener('change', function () {
            const file = this.files && this.files[0];

            if (!file) {
                return;
            }

            if (!file.type.startsWith('image/')) {
                this.value = '';
                return;
            }

            const reader = new FileReader();

            reader.onload = function (event) {
                previewImage.src = event.target.result;
            };

            reader.readAsDataURL(file);
        });
    });
</script>
@endpush