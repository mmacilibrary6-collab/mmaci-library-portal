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

@php
    $coverEmptyText = $isEditing
        ? 'Leave empty to keep the current cover image.'
        : 'No cover image selected yet.';

    $coverDefaultStatus = $isEditing
        ? 'Current cover'
        : 'Default preview';
@endphp

<div class="gallery-form-shell">

    <section class="gallery-form-card">
        <div class="gallery-form-heading">
            <span class="gallery-form-icon">
                <i class="bi bi-folder2-open"></i>
            </span>

            <div>
                <h5>Gallery Folder</h5>
                <p>Create a folder title that groups uploaded photos together.</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12">
                <label for="title" class="form-label">
                    Folder Name <span>*</span>
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
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </section>

    <section class="gallery-form-card">
        <div class="gallery-form-heading">
            <span class="gallery-form-icon">
                <i class="bi bi-cloud-arrow-up-fill"></i>
            </span>

            <div>
                <h5>{{ $isEditing ? 'Folder Cover Image' : 'Folder Cover Image (Optional)' }}</h5>
                <p>
                    {{ $isEditing
                        ? 'Update the cover image shown on the admin and public gallery cards.'
                        : 'You can add a cover image now, or skip it and upload photos later.'
                    }}
                </p>
            </div>
        </div>

        <div class="row g-4 align-items-stretch">
            <div class="col-lg-6">
                <label
                    for="image"
                    class="gallery-upload-area @error('image') upload-error @enderror">

                    <input
                        type="file"
                        name="image"
                        id="image"
                        accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">

                    <span class="upload-icon">
                        <i class="bi bi-cloud-arrow-up"></i>
                    </span>

                    <strong id="coverPrompt">
                        {{ $isEditing
                            ? 'Choose a replacement cover image'
                            : 'Choose an optional cover image'
                        }}
                    </strong>

                    <span class="upload-description">
                        Click to browse your files
                    </span>

                    <span class="upload-requirements">
                        JPG, PNG or WEBP · Maximum 5 MB
                    </span>
                </label>

                <div id="selectedFileName" class="selected-file-name">
                    <i class="bi bi-file-earmark-image"></i>
                    <span>
                        {{ $isEditing
                            ? 'Leave empty to keep the current cover image.'
                            : 'No cover image selected yet.'
                        }}
                    </span>
                </div>

                @error('image')
                    <div class="gallery-error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-lg-6">
                <div class="preview-label-row">
                    <label class="form-label mb-0">Cover Preview</label>
                    <span id="previewStatus" class="preview-status">
                        {{ $isEditing ? 'Current cover' : 'Default preview' }}
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

    <section class="gallery-form-card">
        <div class="gallery-form-heading">
            <span class="gallery-form-icon">
                <i class="bi bi-images"></i>
            </span>

            <div>
                <h5>{{ $isEditing ? 'Add Images to This Folder' : 'Add Images After Saving' }}</h5>
                <p>
                    {{ $isEditing
                        ? 'Upload one or more photos that will appear in the public slideshow.'
                        : 'Save the folder first, then upload slideshow photos from the edit screen.'
                    }}
                </p>
            </div>
        </div>

        @if ($isEditing)
            <div class="row g-4 align-items-start">
                <div class="col-lg-6">
                    <label for="images" class="gallery-upload-area gallery-upload-area-secondary">
                        <input
                            type="file"
                            name="images[]"
                            id="images"
                            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                            multiple>

                        <span class="upload-icon">
                            <i class="bi bi-images"></i>
                        </span>

                        <strong id="imagesPrompt">Add photos to this folder</strong>
                        <span class="upload-description" id="imagesDescription">Select one or more images</span>
                        <span class="upload-requirements">JPG, PNG or WEBP · Multiple files allowed</span>
                    </label>

                    @error('images')
                        <div class="gallery-error-message">{{ $message }}</div>
                    @enderror
                    @error('images.*')
                        <div class="gallery-error-message">{{ $message }}</div>
                    @enderror

                    <div id="imagesSelected" class="selected-file-name">
                        <i class="bi bi-card-checklist"></i>
                        <span>No files selected.</span>
                    </div>

                    <button
                        type="submit"
                        formaction="{{ route('admin.gallery.images.store', $galleryItem) }}"
                        formmethod="POST"
                        class="gallery-upload-button mt-3">
                        Upload Selected Images
                    </button>
                </div>

                <div class="col-lg-6">
                    <div class="gallery-folder-image-list">
                        <div class="gallery-folder-list-head">
                            <h6 class="mb-0">Current folder images</h6>
                            <span class="badge rounded-pill text-bg-primary">
                                {{ $galleryItem->images->count() }} photos
                            </span>
                        </div>

                        <div class="row g-3">
                            @forelse ($galleryItem->images as $galleryImage)
                                <div class="col-6">
                                    <div class="gallery-folder-thumb">
                                        <img src="{{ $galleryImage->image_url }}" alt="Gallery photo">
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="gallery-empty-note">
                                        No images uploaded yet. Use the upload panel to add the first slideshow photos.
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="gallery-empty-note">
                Save the folder first, then upload images from the edit screen.
            </div>
        @endif
    </section>

    <section class="gallery-form-card">
        <div class="gallery-form-heading">
            <span class="gallery-form-icon">
                <i class="bi bi-eye-fill"></i>
            </span>

            <div>
                <h5>Visibility Settings</h5>
                <p>Control whether this folder is visible on the public website.</p>
            </div>
        </div>

        <input type="hidden" name="is_active" value="0">

        <label for="is_active" class="visibility-option">
            <span class="visibility-option-icon">
                <i class="bi bi-globe2"></i>
            </span>

            <span class="visibility-option-content">
                <strong>Display folder publicly</strong>
                <small>When enabled, visitors can see this folder in the gallery.</small>
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

    <div class="gallery-form-actions">
        <a
            href="{{ route('admin.gallery.index') }}"
            class="gallery-cancel-button">
            <i class="bi bi-x-lg"></i>
            Cancel
        </a>

        <button type="submit" class="gallery-submit-button">
            <i class="bi {{ $isEditing ? 'bi-check2-circle' : 'bi-plus-circle' }}"></i>
            {{ $isEditing ? 'Save Folder Changes' : 'Create Gallery Folder' }}
        </button>
    </div>
</div>

@push('styles')
<style>
    .gallery-form-shell {
        display: grid;
        gap: 18px;
    }

    .gallery-form-card {
        padding: 24px 26px;
        background: #fff;
        border: 1px solid #dde4ed;
        border-radius: 20px;
        box-shadow: 0 14px 35px rgba(11, 46, 89, .06);
    }

    .gallery-form-heading {
        display: flex;
        align-items: center;
        gap: 13px;
        margin-bottom: 20px;
    }

    .gallery-form-icon {
        width: 44px;
        height: 44px;
        flex: 0 0 44px;
        display: grid;
        place-items: center;
        color: #0b2e59;
        background: rgba(244, 180, 0, .18);
        border-radius: 14px;
        font-size: 18px;
    }

    .gallery-form-heading h5 {
        margin: 0 0 3px;
        color: #0b2e59;
        font-size: 15px;
        font-weight: 800;
    }

    .gallery-form-heading p {
        margin: 0;
        color: #6f7b8d;
        font-size: 11px;
        line-height: 1.6;
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
        min-height: 48px;
        padding: 10px 14px;
        border-radius: 12px;
        border-color: #dce3ec;
        background: #fbfcfe;
        box-shadow: none;
    }

    .gallery-form .form-control:focus {
        border-color: #184b8c;
        box-shadow: 0 0 0 4px rgba(24, 75, 140, .08);
    }

    .gallery-upload-area {
        position: relative;
        min-height: 240px;
        padding: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 4px;
        text-align: center;
        cursor: pointer;
        background: linear-gradient(180deg, #f9fbfd, #f3f7fc);
        border: 1.5px dashed #cfd9e6;
        border-radius: 18px;
        transition: .2s ease;
    }

    .gallery-upload-area:hover {
        border-color: #184b8c;
        transform: translateY(-1px);
        box-shadow: 0 10px 24px rgba(11, 46, 89, .08);
    }

    .gallery-upload-area.upload-error {
        background: #fff7f7;
        border-color: #dc3545;
    }

    .gallery-upload-area input {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
    }

    .upload-icon {
        width: 56px;
        height: 56px;
        display: grid;
        place-items: center;
        color: #0b2e59;
        background: #fff;
        border: 1px solid #e3eaf3;
        border-radius: 16px;
        font-size: 24px;
        box-shadow: 0 8px 18px rgba(11, 46, 89, .07);
    }

    .gallery-upload-area strong {
        margin-top: 6px;
        color: #0b2e59;
        font-size: 13px;
        font-weight: 800;
    }

    .upload-description {
        color: #6f7b8d;
        font-size: 11px;
    }

    .upload-requirements {
        margin-top: 4px;
        padding: 5px 10px;
        color: #516072;
        background: #eaf0f7;
        border-radius: 999px;
        font-size: 9px;
        font-weight: 700;
    }

    .selected-file-name {
        min-height: 40px;
        margin-top: 10px;
        padding: 9px 12px;
        display: flex;
        align-items: center;
        gap: 8px;
        color: #5f6d80;
        background: #f7f9fc;
        border: 1px solid #e5ebf2;
        border-radius: 10px;
        font-size: 10px;
    }

    .selected-file-name i {
        color: #184b8c;
    }

    .gallery-error-message {
        margin-top: 8px;
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
        padding: 4px 9px;
        color: #184b8c;
        background: #eaf1f9;
        border-radius: 999px;
        font-size: 9px;
        font-weight: 700;
    }

    .gallery-image-preview {
        position: relative;
        height: 240px;
        overflow: hidden;
        background: #e9eef5;
        border: 1px solid #d9e1eb;
        border-radius: 18px;
    }

    .gallery-image-preview img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
    }

    .preview-overlay {
        position: absolute;
        left: 14px;
        bottom: 14px;
        padding: 7px 10px;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        color: #fff;
        background: rgba(11, 46, 89, .72);
        border-radius: 999px;
        font-size: 10px;
        font-weight: 700;
        backdrop-filter: blur(6px);
    }

    .gallery-folder-image-list {
        height: 100%;
        padding: 16px;
        background: #f7f9fc;
        border: 1px solid #e3e9f2;
        border-radius: 18px;
    }

    .gallery-folder-list-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        margin-bottom: 14px;
    }

    .gallery-folder-list-head h6 {
        color: #0b2e59;
        font-weight: 800;
    }

    .gallery-folder-thumb {
        aspect-ratio: 1 / .78;
        overflow: hidden;
        border-radius: 12px;
        background: #eef3f8;
        border: 1px solid #dde4ed;
    }

    .gallery-folder-thumb img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
    }

    .gallery-empty-note {
        padding: 14px 16px;
        color: #6f7b8d;
        background: #fff;
        border: 1px dashed #d8e1ec;
        border-radius: 14px;
        font-size: 12px;
    }

    .gallery-upload-button {
        min-height: 46px;
        padding: 0 18px;
        color: #fff;
        background: #184b8c;
        border: 0;
        border-radius: 12px;
        font-weight: 700;
        box-shadow: 0 12px 24px rgba(24, 75, 140, .18);
    }

    .gallery-upload-button:hover {
        color: #fff;
        background: #123d73;
    }

    .visibility-option {
        padding: 16px 18px;
        display: flex;
        align-items: center;
        gap: 14px;
        background: #f8fbfe;
        border: 1px solid #e0e7f0;
        border-radius: 16px;
    }

    .visibility-option-icon {
        width: 46px;
        height: 46px;
        flex: 0 0 46px;
        display: grid;
        place-items: center;
        color: #0b2e59;
        background: rgba(244, 180, 0, .18);
        border-radius: 14px;
        font-size: 18px;
    }

    .visibility-option-content {
        display: grid;
        gap: 2px;
        flex: 1;
    }

    .visibility-option-content strong {
        color: #0b2e59;
        font-size: 13px;
    }

    .visibility-option-content small {
        color: #6f7b8d;
        font-size: 11px;
    }

    .gallery-form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        padding: 0 2px;
    }

    .gallery-cancel-button,
    .gallery-submit-button {
        min-height: 46px;
        padding: 0 18px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 700;
    }

    .gallery-cancel-button {
        color: #4d5d71;
        background: #eef3f8;
        border: 1px solid #dde5ef;
    }

    .gallery-submit-button {
        color: #fff;
        background: #0b2e59;
        border: 0;
        box-shadow: 0 12px 24px rgba(11, 46, 89, .14);
    }

    .gallery-submit-button:hover {
        color: #fff;
        background: #0a2547;
    }

    @media (max-width: 991.98px) {
        .gallery-form-actions {
            justify-content: stretch;
            flex-direction: column-reverse;
        }

        .gallery-cancel-button,
        .gallery-submit-button {
            justify-content: center;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const imageInput = document.getElementById('image');
    const imagesInput = document.getElementById('images');
    const previewImage = document.getElementById('galleryImagePreview');
    const selectedFileName = document.getElementById('selectedFileName');
    const imagesSelected = document.getElementById('imagesSelected');
    const previewStatus = document.getElementById('previewStatus');

    if (imageInput && previewImage) {
        imageInput.addEventListener('change', function () {
            const file = this.files && this.files[0] ? this.files[0] : null;

            if (!file) {
                selectedFileName.querySelector('span').textContent = @json($coverEmptyText);
                previewStatus.textContent = @json($coverDefaultStatus);
                return;
            }

            selectedFileName.querySelector('span').textContent = file.name;
            previewStatus.textContent = 'New cover selected';

            const reader = new FileReader();
            reader.onload = function (event) {
                previewImage.src = event.target.result;
            };
            reader.readAsDataURL(file);
        });
    }

    if (imagesInput && imagesSelected) {
        imagesInput.addEventListener('change', function () {
            const files = Array.from(this.files || []);

            imagesSelected.querySelector('span').textContent = files.length
                ? `${files.length} file(s) selected`
                : 'No files selected.';
        });
    }
});
</script>
@endpush
