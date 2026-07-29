@csrf

@php
    $galleryItem = $gallery ?? null;
    $isEditing = $galleryItem !== null;

    $currentImage = $isEditing
        ? $galleryItem->image_url
        : asset('images/readingarea.jpg');

    $isActive = (int) old(
        'is_active',
        $galleryItem?->is_active ?? 1
    );
@endphp

<div class="gallery-form">

    {{-- Basic information --}}
    <section class="gallery-form-section">

        <div class="gallery-section-heading">

            <span class="gallery-section-icon">
                <i class="bi bi-card-image"></i>
            </span>

            <div>
                <h5>Gallery Information</h5>
                <p>Enter the title and display order of the gallery image.</p>
            </div>

        </div>

        <div class="row g-4">

            <div class="col-12">

                <label for="title" class="form-label">
                    Gallery Title <span>*</span>
                </label>

                <input
                    type="text"
                    name="title"
                    id="title"
                    value="{{ old('title', $galleryItem?->title) }}"
                    class="form-control @error('title') is-invalid @enderror"
                    placeholder="Example: Library Orientation 2026"
                    maxlength="255"
                    required>

                @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

        </div>

    </section>

    {{-- Image upload --}}
    <section class="gallery-form-section">

        <div class="gallery-section-heading">

            <span class="gallery-section-icon">
                <i class="bi bi-cloud-arrow-up-fill"></i>
            </span>

            <div>
                <h5>Gallery Photos</h5>
                <p>Upload one or more photos for this folder.</p>
            </div>

        </div>

        <div class="row g-4 align-items-stretch">

            <div class="col-lg-6">

                <label
                    for="images"
                    class="gallery-upload-area @error('image') upload-error @enderror">

                    <input
                        type="file"
                        name="images[]"
                        id="images"
                        accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                        multiple
                        {{ $isEditing ? '' : 'required' }}>

                    <span class="upload-icon">
                        <i class="bi bi-cloud-arrow-up"></i>
                    </span>

                    <strong>
                        {{ $isEditing ? 'Choose more photos' : 'Choose folder photos' }}
                    </strong>

                    <span class="upload-description">
                        Click here to browse your files
                    </span>

                    <span class="upload-requirements">
                        JPG, PNG or WEBP · Maximum 5 MB
                    </span>

                </label>

                <div id="selectedFileName" class="selected-file-name">

                    <i class="bi bi-file-earmark-image"></i>

                    <span>
                        {{ $isEditing
                            ? 'Leave empty to retain the current image.'
                            : 'No image selected.'
                        }}
                    </span>

                </div>

                @error('images')
                    <div class="gallery-error-message">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="col-lg-6">

                <div class="preview-label-row">

                    <label class="form-label mb-0">
                        Image Preview
                    </label>

                    <span id="previewStatus" class="preview-status">
                        {{ $isEditing ? 'Current image' : 'Default preview' }}
                    </span>

                </div>

                <div class="gallery-image-preview">

                    <img
                        src="{{ $currentImage }}"
                        id="galleryImagePreview"
                        alt="Gallery image preview"
                        onerror="this.onerror=null; this.src='{{ asset('images/readingarea.jpg') }}';">

                    <div class="preview-overlay">
                        <i class="bi bi-eye-fill"></i>
                        Live Preview
                    </div>

                </div>

            </div>

        </div>

    </section>

    {{-- Visibility --}}
    <section class="gallery-form-section">

        <div class="gallery-section-heading">

            <span class="gallery-section-icon">
                <i class="bi bi-eye-fill"></i>
            </span>

            <div>
                <h5>Visibility Settings</h5>
                <p>Control whether this image is visible on the public website.</p>
            </div>

        </div>

        <input type="hidden" name="is_active" value="0">

        <label for="is_active" class="visibility-option">

            <span class="visibility-option-icon">
                <i class="bi bi-globe2"></i>
            </span>

            <span class="visibility-option-content">

                <strong>Display folder publicly</strong>

                <small>
                    When enabled, visitors can see this folder in the gallery.
                </small>

            </span>

            <span class="form-check form-switch mb-0">

                <input
                    type="checkbox"
                    name="is_active"
                    id="is_active"
                    class="form-check-input"
                    value="1"
                    @checked($isActive === 1)>

            </span>

        </label>

    </section>

    {{-- Actions --}}
    <div class="gallery-form-actions">

        <a
            href="{{ route('admin.gallery.index') }}"
            class="gallery-cancel-button">

            <i class="bi bi-x-lg"></i>
            Cancel

        </a>

        <button type="submit" class="gallery-submit-button">

            <i class="bi {{ $isEditing ? 'bi-check2-circle' : 'bi-plus-circle' }}"></i>

            {{ $isEditing
                ? 'Update Gallery Image'
                : 'Save Gallery Image'
            }}

        </button>

    </div>

</div>

@push('styles')
<style>
    .gallery-form {
        --gallery-navy: #0b2e59;
        --gallery-blue: #184b8c;
        --gallery-gold: #f4b400;
        --gallery-border: #dde4ed;
        overflow: hidden;
        background: #fff;
        border: 1px solid var(--gallery-border);
        border-radius: 20px;
        box-shadow: 0 14px 35px rgba(11, 46, 89, .08);
    }

    .gallery-form-section {
        padding: 27px 30px;
        border-bottom: 1px solid #edf0f5;
    }

    .gallery-section-heading {
        display: flex;
        align-items: center;
        gap: 13px;
        margin-bottom: 23px;
    }

    .gallery-section-icon {
        width: 43px;
        height: 43px;
        flex: 0 0 43px;
        display: grid;
        place-items: center;
        color: var(--gallery-navy);
        background: rgba(244, 180, 0, .17);
        border-radius: 12px;
        font-size: 18px;
    }

    .gallery-section-heading h5 {
        margin: 0 0 3px;
        color: var(--gallery-navy);
        font-size: 15px;
        font-weight: 800;
    }

    .gallery-section-heading p {
        margin: 0;
        color: #7a8595;
        font-size: 11px;
    }

    .gallery-form .form-label {
        margin-bottom: 8px;
        color: #243b57;
        font-size: 12px;
        font-weight: 700;
    }

    .gallery-form .form-label > span {
        color: #dc3545;
    }

    .gallery-form .form-control {
        min-height: 47px;
        padding: 10px 14px;
        color: #243b57;
        background: #fbfcfe;
        border: 1px solid #dce3ec;
        border-radius: 11px;
        font-size: 12px;
        box-shadow: none;
        transition: .2s ease;
    }

    .gallery-form .form-control:focus {
        background: #fff;
        border-color: var(--gallery-blue);
        box-shadow: 0 0 0 4px rgba(24, 75, 140, .09);
    }

    .field-help {
        margin-top: 7px;
        color: #8a94a3;
        font-size: 10px;
    }

    .gallery-upload-area {
        min-height: 242px;
        padding: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        text-align: center;
        cursor: pointer;
        background: #f8fafd;
        border: 2px dashed #ccd6e3;
        border-radius: 16px;
        transition: .2s ease;
    }

    .gallery-upload-area:hover {
        background: #f3f7fc;
        border-color: var(--gallery-blue);
        transform: translateY(-2px);
    }

    .gallery-upload-area.upload-error {
        background: #fff7f7;
        border-color: #dc3545;
    }

    .gallery-upload-area input {
        position: absolute;
        width: 1px;
        height: 1px;
        overflow: hidden;
        opacity: 0;
        pointer-events: none;
    }

    .upload-icon {
        width: 57px;
        height: 57px;
        margin-bottom: 13px;
        display: grid;
        place-items: center;
        color: var(--gallery-navy);
        background: #fff;
        border: 1px solid #e1e7ef;
        border-radius: 16px;
        font-size: 25px;
        box-shadow: 0 8px 20px rgba(11, 46, 89, .08);
    }

    .gallery-upload-area strong {
        margin-bottom: 4px;
        color: var(--gallery-navy);
        font-size: 13px;
    }

    .upload-description {
        margin-bottom: 11px;
        color: #718096;
        font-size: 11px;
    }

    .upload-requirements {
        padding: 5px 10px;
        color: #667386;
        background: #eaf0f7;
        border-radius: 999px;
        font-size: 9px;
        font-weight: 700;
    }

    .selected-file-name {
        min-height: 38px;
        margin-top: 9px;
        padding: 8px 11px;
        display: flex;
        align-items: center;
        gap: 8px;
        color: #687587;
        background: #f7f9fc;
        border-radius: 9px;
        font-size: 10px;
    }

    .selected-file-name i {
        color: var(--gallery-blue);
    }

    .gallery-error-message {
        margin-top: 7px;
        color: #dc3545;
        font-size: 10px;
        font-weight: 600;
    }

    .preview-label-row {
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .preview-status {
        padding: 4px 8px;
        color: var(--gallery-blue);
        background: #eaf1f9;
        border-radius: 999px;
        font-size: 9px;
        font-weight: 700;
    }

    .gallery-image-preview {
        position: relative;
        height: 242px;
        overflow: hidden;
        background: #e9eef5;
        border: 1px solid #d9e1eb;
        border-radius: 16px;
    }

    .gallery-image-preview img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
    }

    .preview-overlay {
        position: absolute;
        right: 12px;
        bottom: 12px;
        padding: 7px 10px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #fff;
        background: rgba(11, 46, 89, .84);
        border-radius: 8px;
        font-size: 9px;
        font-weight: 700;
        backdrop-filter: blur(6px);
    }

    .visibility-option {
        min-height: 79px;
        padding: 15px 17px;
        display: flex;
        align-items: center;
        gap: 13px;
        cursor: pointer;
        background: #f8fafd;
        border: 1px solid #dfe6ef;
        border-radius: 14px;
        transition: .2s ease;
    }

    .visibility-option:hover {
        background: #f3f7fc;
        border-color: #bfcddd;
    }

    .visibility-option-icon {
        width: 43px;
        height: 43px;
        flex: 0 0 43px;
        display: grid;
        place-items: center;
        color: #198754;
        background: #e5f6ed;
        border-radius: 12px;
        font-size: 18px;
    }

    .visibility-option-content {
        flex: 1;
        min-width: 0;
    }

    .visibility-option-content strong,
    .visibility-option-content small {
        display: block;
    }

    .visibility-option-content strong {
        margin-bottom: 3px;
        color: var(--gallery-navy);
        font-size: 12px;
    }

    .visibility-option-content small {
        color: #778396;
        font-size: 10px;
    }

    .visibility-option .form-check-input {
        width: 42px;
        height: 22px;
        margin: 0;
        cursor: pointer;
        border-color: #bbc5d1;
        box-shadow: none;
    }

    .visibility-option .form-check-input:checked {
        background-color: #198754;
        border-color: #198754;
    }

    .gallery-form-actions {
        padding: 20px 30px;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        background: #fafbfd;
    }

    .gallery-cancel-button,
    .gallery-submit-button {
        min-height: 44px;
        padding: 0 17px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border-radius: 10px;
        font-size: 11px;
        font-weight: 700;
        text-decoration: none;
        transition: .2s ease;
    }

    .gallery-cancel-button {
        color: #5f6d7e;
        background: #fff;
        border: 1px solid #d7dee7;
    }

    .gallery-cancel-button:hover {
        color: var(--gallery-navy);
        border-color: #aab7c7;
    }

    .gallery-submit-button {
        color: #fff;
        background: var(--gallery-navy);
        border: 1px solid var(--gallery-navy);
        box-shadow: 0 8px 18px rgba(11, 46, 89, .16);
    }

    .gallery-submit-button:hover {
        color: var(--gallery-navy);
        background: var(--gallery-gold);
        border-color: var(--gallery-gold);
        transform: translateY(-1px);
    }

    @media (max-width: 767.98px) {
        .gallery-form-section {
            padding: 22px 18px;
        }

        .gallery-form-actions {
            padding: 17px 18px;
        }
    }

    @media (max-width: 575.98px) {
        .gallery-form-actions {
            flex-direction: column-reverse;
        }

        .gallery-cancel-button,
        .gallery-submit-button {
            width: 100%;
        }

        .visibility-option-content small {
            display: none;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('galleryImagePreview');
        const selectedFileName = document.querySelector('#selectedFileName span');
        const previewStatus = document.getElementById('previewStatus');

        if (!imageInput || !imagePreview) {
            return;
        }

        imageInput.addEventListener('change', function () {
            const file = this.files && this.files[0];

            if (!file) {
                return;
            }

            if (!file.type.startsWith('image/')) {
                this.value = '';

                if (selectedFileName) {
                    selectedFileName.textContent = 'Please select a valid image.';
                }

                return;
            }

            if (selectedFileName) {
                selectedFileName.textContent = file.name;
            }

            if (previewStatus) {
                previewStatus.textContent = 'New image selected';
            }

            const reader = new FileReader();

            reader.addEventListener('load', function (event) {
                imagePreview.src = event.target.result;
            });

            reader.readAsDataURL(file);
        });
    });
</script>
@endpush
