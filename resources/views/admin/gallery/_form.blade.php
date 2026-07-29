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

    $folderImages = $isEditing
        ? $galleryItem->images
        : collect();
@endphp

<div class="gallery-folder-form">

    {{-- Folder Information --}}
    <section class="gallery-form-section">

        <div class="gallery-section-heading">

            <span class="gallery-section-icon">
                <i class="bi bi-folder2-open"></i>
            </span>

            <div>
                <h5>Folder Information</h5>
                <p>Enter the name that will identify this gallery folder.</p>
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

                <div class="field-help">
                    Use a short and descriptive folder name.
                </div>

                @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

        </div>

    </section>

    {{-- Folder Cover --}}
    <section class="gallery-form-section">

        <div class="gallery-section-heading">

            <span class="gallery-section-icon">
                <i class="bi bi-card-image"></i>
            </span>

            <div>
                <h5>Folder Cover</h5>

                <p>
                    {{ $isEditing
                        ? 'Upload a replacement image or keep the current folder cover.'
                        : 'Choose an optional cover image for this gallery folder.'
                    }}
                </p>
            </div>

        </div>

        <div class="row g-4 align-items-stretch">

            <div class="col-lg-6 gallery-pane-column">

                <label
                    for="image"
                    class="gallery-upload-area @error('image') upload-error @enderror">

                    <input
                        type="file"
                        name="image"
                        id="image"
                        accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">

                    <span class="gallery-upload-icon">
                        <i class="bi bi-cloud-arrow-up"></i>
                    </span>

                    <strong>
                        {{ $isEditing
                            ? 'Choose a new folder cover'
                            : 'Choose a folder cover'
                        }}
                    </strong>

                    <span class="upload-description">
                        Click here to browse your files
                    </span>

                    <span class="upload-requirements">
                        JPG, PNG or WEBP · Maximum 5 MB
                    </span>

                </label>

                <div class="selected-file-row">

                    <i class="bi bi-file-earmark-image"></i>

                    <span id="selectedCoverName">
                        {{ $isEditing
                            ? 'Leave empty to keep the current cover.'
                            : 'No cover image selected.'
                        }}
                    </span>

                </div>

                @error('image')
                    <div class="gallery-error-message">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="col-lg-6 gallery-pane-column">

                <div class="preview-heading">

                    <label class="form-label mb-0">
                        Cover Preview
                    </label>

                    <span id="coverPreviewStatus">
                        {{ $isEditing ? 'Current cover' : 'Default preview' }}
                    </span>

                </div>

                <div class="gallery-cover-preview">

                    <img
                        src="{{ $currentImage }}"
                        id="galleryCoverPreview"
                        alt="{{ $galleryItem?->title ?? 'Gallery folder cover' }}"
                        onerror="this.onerror=null; this.src='{{ asset('images/readingarea.jpg') }}';">

                    <div class="cover-preview-shade"></div>

                    <span class="cover-folder-badge">
                        <i class="bi bi-folder-fill"></i>
                        Folder Cover
                    </span>

                    <span class="cover-preview-badge">
                        <i class="bi bi-eye-fill"></i>
                        Live Preview
                    </span>

                </div>

            </div>

        </div>

    </section>

    {{-- Folder Images --}}
    <section class="gallery-form-section">

        <div class="gallery-section-heading">

            <span class="gallery-section-icon">
                <i class="bi bi-images"></i>
            </span>

            <div>
                <h5>Folder Photos</h5>

                <p>
                    {{ $isEditing
                        ? 'Upload multiple photos that will appear inside this folder.'
                        : 'Create the folder first, then add photos from the edit page.'
                    }}
                </p>
            </div>

        </div>

        @if ($isEditing)

            <div class="row g-4">

                <div class="col-lg-5 gallery-pane-column">

                    <label for="images" class="gallery-upload-area gallery-multiple-upload">

                        <input
                            type="file"
                            name="images[]"
                            id="images"
                            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                            multiple>

                        <span class="gallery-upload-icon">
                            <i class="bi bi-images"></i>
                        </span>

                        <strong>Add photos to this folder</strong>

                        <span class="upload-description">
                            Select one or more images
                        </span>

                        <span class="upload-requirements">
                            Multiple files allowed
                        </span>

                    </label>

                    <div class="selected-file-row">

                        <i class="bi bi-card-checklist"></i>

                        <span id="selectedImagesCount">
                            No photos selected.
                        </span>

                    </div>

                    @error('images')
                        <div class="gallery-error-message">
                            {{ $message }}
                        </div>
                    @enderror

                    @error('images.*')
                        <div class="gallery-error-message">
                            {{ $message }}
                        </div>
                    @enderror

                    <button
                        type="submit"
                        formaction="{{ route('admin.gallery.images.store', $galleryItem) }}"
                        formmethod="POST"
                        class="upload-photos-button">

                        <i class="bi bi-cloud-arrow-up-fill"></i>
                        Upload Selected Photos

                    </button>

                </div>

                <div class="col-lg-7 gallery-pane-column">

                    <div class="current-folder-images">

                        <div class="current-images-heading">

                            <div>
                                <h6>Current Folder Photos</h6>
                                <p>Photos currently saved inside this folder.</p>
                            </div>

                            <span>
                                {{ $folderImages->count() }}
                                {{ \Illuminate\Support\Str::plural(
                                    'photo',
                                    $folderImages->count()
                                ) }}
                            </span>

                        </div>

                        <div class="folder-image-grid">

                            @forelse ($folderImages as $galleryImage)

                                <div class="folder-image-item">

                                    <img
                                        src="{{ $galleryImage->image_url }}"
                                        alt="Photo from {{ $galleryItem->title }}"
                                        loading="lazy"
                                        onerror="this.onerror=null; this.src='{{ asset('images/readingarea.jpg') }}';">

                                    <div class="folder-image-overlay">
                                        <i class="bi bi-image"></i>
                                    </div>

                                </div>

                            @empty

                                <div class="folder-images-empty">

                                    <i class="bi bi-images"></i>

                                    <strong>No photos uploaded</strong>

                                    <p>
                                        Use the upload panel to add the first photos.
                                    </p>

                                </div>

                            @endforelse

                        </div>

                    </div>

                </div>

            </div>

        @else

            <div class="photos-after-save">

                <span>
                    <i class="bi bi-info-circle-fill"></i>
                </span>

                <div>
                    <strong>Photos can be added after saving</strong>

                    <p>
                        Create this folder first. You can then upload multiple
                        photos from its edit page.
                    </p>
                </div>

            </div>

        @endif

    </section>

    {{-- Visibility --}}
    <section class="gallery-form-section">

        <div class="gallery-section-heading">

            <span class="gallery-section-icon">
                <i class="bi bi-eye-fill"></i>
            </span>

            <div>
                <h5>Visibility Settings</h5>
                <p>Control whether this folder appears on the public website.</p>
            </div>

        </div>

        <input type="hidden" name="is_active" value="0">

        <label for="is_active" class="gallery-visibility-option">

            <span class="visibility-icon">
                <i class="bi bi-globe2"></i>
            </span>

            <span class="visibility-content">

                <strong>Display this folder publicly</strong>

                <small>
                    Visitors can view this folder and its photos when enabled.
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

    {{-- Form Actions --}}
    <div class="gallery-form-actions">

        <a
            href="{{ route('admin.gallery.index') }}"
            class="gallery-cancel-button">

            <i class="bi bi-x-lg"></i>
            Cancel

        </a>

        <button type="submit" class="gallery-submit-button">

            <i class="bi {{ $isEditing ? 'bi-check2-circle' : 'bi-folder-plus' }}"></i>

            {{ $isEditing
                ? 'Save Folder Changes'
                : 'Create Gallery Folder'
            }}

        </button>

    </div>

</div>

@push('styles')
<style>
    .gallery-folder-form {
        --gallery-navy: #0b2e59;
        --gallery-blue: #184b8c;
        --gallery-gold: #f4b400;
        display: grid;
        gap: 16px;
    }

    .gallery-form-section {
        padding: 25px 27px;
        background: #fff;
        border: 1px solid #dfe5ed;
        border-radius: 18px;
        box-shadow: 0 10px 28px rgba(11, 46, 89, .06);
        transition:
            border-color .2s ease,
            box-shadow .2s ease;
    }

    .gallery-form-section:hover {
        border-color: #cdd7e3;
        box-shadow: 0 15px 34px rgba(11, 46, 89, .09);
    }

    .gallery-section-heading {
        margin-bottom: 22px;
        display: flex;
        align-items: center;
        gap: 13px;
    }

    .gallery-section-icon {
        width: 44px;
        height: 44px;
        flex: 0 0 44px;
        display: grid;
        place-items: center;
        color: var(--gallery-navy);
        background: rgba(244, 180, 0, .18);
        border-radius: 13px;
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
        color: #758194;
        font-size: 11px;
        line-height: 1.6;
    }

    .gallery-pane-column {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .gallery-folder-form .form-label {
        margin-bottom: 8px;
        color: #243b57;
        font-size: 12px;
        font-weight: 700;
    }

    .gallery-folder-form .form-label > span {
        color: #dc3545;
    }

    .gallery-folder-form .form-control {
        min-height: 48px;
        padding: 10px 14px;
        color: #243b57;
        background: #fbfcfe;
        border: 1px solid #dce3ec;
        border-radius: 11px;
        font-size: 12px;
        box-shadow: none;
        transition: .2s ease;
    }

    .gallery-folder-form .form-control:focus {
        background: #fff;
        border-color: var(--gallery-blue);
        box-shadow: 0 0 0 4px rgba(24, 75, 140, .08);
    }

    .field-help {
        margin-top: 7px;
        color: #8a94a3;
        font-size: 10px;
    }

    .gallery-upload-area {
        position: relative;
        min-height: 248px;
        padding: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        text-align: center;
        cursor: pointer;
        background: linear-gradient(180deg, #f9fbfd, #f3f7fc);
        border: 2px dashed #cfd9e6;
        border-radius: 16px;
        transition: .2s ease;
    }

    .gallery-upload-area:hover {
        background: #f2f6fb;
        border-color: var(--gallery-blue);
        transform: translateY(-2px);
    }

    .gallery-upload-area.upload-error {
        background: #fff7f7;
        border-color: #dc3545;
    }

    .gallery-upload-area input {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
        opacity: 0;
    }

    .gallery-upload-icon {
        width: 55px;
        height: 55px;
        margin-bottom: 12px;
        display: grid;
        place-items: center;
        color: var(--gallery-navy);
        background: #fff;
        border: 1px solid #e1e8f0;
        border-radius: 15px;
        font-size: 24px;
        box-shadow: 0 8px 20px rgba(11, 46, 89, .08);
    }

    .gallery-upload-area strong {
        margin-bottom: 4px;
        color: var(--gallery-navy);
        font-size: 13px;
    }

    .upload-description {
        margin-bottom: 10px;
        color: #718096;
        font-size: 10px;
    }

    .upload-requirements {
        padding: 5px 10px;
        color: #667386;
        background: #e8eef5;
        border-radius: 999px;
        font-size: 9px;
        font-weight: 700;
    }

    .selected-file-row {
        width: 100%;
        min-height: 39px;
        margin-top: 0;
        padding: 8px 11px;
        display: flex;
        align-items: center;
        gap: 8px;
        color: #687587;
        background: #f7f9fc;
        border: 1px solid #e5eaf1;
        border-radius: 9px;
        font-size: 10px;
    }

    .selected-file-row i {
        color: var(--gallery-blue);
    }

    .gallery-error-message {
        margin-top: 7px;
        color: #dc3545;
        font-size: 10px;
        font-weight: 600;
    }

    .preview-heading {
        margin-bottom: 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .preview-heading > span {
        padding: 4px 8px;
        color: var(--gallery-blue);
        background: #eaf1f9;
        border-radius: 999px;
        font-size: 9px;
        font-weight: 700;
    }

    .gallery-cover-preview {
        position: relative;
        min-height: 248px;
        height: 100%;
        overflow: hidden;
        background: #e9eef5;
        border: 1px solid #d9e1eb;
        border-radius: 16px;
    }

    .gallery-cover-preview img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
        object-position: center;
        transition: transform .4s ease;
    }

    .gallery-cover-preview:hover img {
        transform: scale(1.035);
    }

    .cover-preview-shade {
        position: absolute;
        inset: 0;
        pointer-events: none;
        background: linear-gradient(
            180deg,
            rgba(11, 46, 89, .04),
            rgba(11, 46, 89, .38)
        );
    }

    .cover-folder-badge,
    .cover-preview-badge {
        position: absolute;
        min-height: 29px;
        padding: 0 10px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 999px;
        font-size: 9px;
        font-weight: 800;
    }

    .cover-folder-badge {
        top: 13px;
        left: 13px;
        color: var(--gallery-navy);
        background: var(--gallery-gold);
    }

    .cover-preview-badge {
        right: 13px;
        bottom: 13px;
        color: #fff;
        background: rgba(11, 46, 89, .80);
        backdrop-filter: blur(6px);
    }

    .gallery-multiple-upload {
        min-height: 248px;
    }

    .upload-photos-button {
        width: 100%;
        min-height: 44px;
        margin-top: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        color: #fff;
        background: var(--gallery-blue);
        border: 1px solid var(--gallery-blue);
        border-radius: 10px;
        font-size: 11px;
        font-weight: 700;
        transition: .2s ease;
    }

    .upload-photos-button:hover {
        background: var(--gallery-navy);
        border-color: var(--gallery-navy);
        transform: translateY(-1px);
    }

    .current-folder-images {
        min-height: 100%;
        padding: 17px;
        background: #f7f9fc;
        border: 1px solid #e3e9f2;
        border-radius: 16px;
    }

    .current-images-heading {
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .current-images-heading h6 {
        margin: 0 0 2px;
        color: var(--gallery-navy);
        font-size: 12px;
        font-weight: 800;
    }

    .current-images-heading p {
        margin: 0;
        color: #8490a0;
        font-size: 9px;
    }

    .current-images-heading > span {
        padding: 5px 9px;
        color: var(--gallery-blue);
        background: #e6eff9;
        border-radius: 999px;
        font-size: 9px;
        font-weight: 700;
    }

    .folder-image-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 9px;
    }

    .folder-image-item {
        position: relative;
        aspect-ratio: 1 / .78;
        overflow: hidden;
        background: #e9eef5;
        border: 1px solid #dce3ec;
        border-radius: 10px;
    }

    .folder-image-item img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
        transition: transform .3s ease;
    }

    .folder-image-item:hover img {
        transform: scale(1.06);
    }

    .folder-image-overlay {
        position: absolute;
        inset: 0;
        display: grid;
        place-items: center;
        color: #fff;
        background: rgba(11, 46, 89, .42);
        font-size: 17px;
        opacity: 0;
        transition: opacity .2s ease;
    }

    .folder-image-item:hover .folder-image-overlay {
        opacity: 1;
    }

    .folder-images-empty {
        grid-column: 1 / -1;
        min-height: 190px;
        padding: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        text-align: center;
        color: #788597;
        background: #fff;
        border: 1px dashed #d5dee9;
        border-radius: 13px;
    }

    .folder-images-empty > i {
        margin-bottom: 9px;
        color: #a4afbc;
        font-size: 27px;
    }

    .folder-images-empty strong {
        margin-bottom: 3px;
        color: var(--gallery-navy);
        font-size: 12px;
    }

    .folder-images-empty p {
        margin: 0;
        font-size: 10px;
    }

    .photos-after-save {
        padding: 16px 18px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        color: #315b8b;
        background: #f0f6fc;
        border: 1px solid #d5e5f5;
        border-radius: 13px;
    }

    .photos-after-save > span {
        width: 38px;
        height: 38px;
        flex: 0 0 38px;
        display: grid;
        place-items: center;
        color: var(--gallery-blue);
        background: #dceaf8;
        border-radius: 10px;
    }

    .photos-after-save strong {
        display: block;
        margin-bottom: 3px;
        color: var(--gallery-navy);
        font-size: 12px;
    }

    .photos-after-save p {
        margin: 0;
        color: #69809a;
        font-size: 10px;
    }

    .gallery-visibility-option {
        min-height: 76px;
        padding: 14px 16px;
        display: flex;
        align-items: center;
        gap: 13px;
        cursor: pointer;
        background: #f8fafd;
        border: 1px solid #dfe6ef;
        border-radius: 14px;
        transition: .2s ease;
    }

    .gallery-visibility-option:hover {
        background: #f3f7fc;
        border-color: #bfcddd;
    }

    .visibility-icon {
        width: 42px;
        height: 42px;
        flex: 0 0 42px;
        display: grid;
        place-items: center;
        color: #198754;
        background: #e5f6ed;
        border-radius: 11px;
        font-size: 17px;
    }

    .visibility-content {
        flex: 1;
        min-width: 0;
    }

    .visibility-content strong,
    .visibility-content small {
        display: block;
    }

    .visibility-content strong {
        margin-bottom: 3px;
        color: var(--gallery-navy);
        font-size: 12px;
    }

    .visibility-content small {
        color: #778396;
        font-size: 10px;
    }

    .gallery-visibility-option .form-check-input {
        width: 42px;
        height: 22px;
        margin: 0;
        cursor: pointer;
        border-color: #bbc5d1;
        box-shadow: none;
    }

    .gallery-visibility-option .form-check-input:checked {
        background-color: #198754;
        border-color: #198754;
    }

    .gallery-form-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
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
            padding: 21px 18px;
            border-radius: 15px;
        }

        .gallery-section-heading {
            align-items: flex-start;
        }

        .gallery-upload-area {
            min-height: 210px;
        }

        .gallery-cover-preview {
            height: 230px;
        }

        .folder-image-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .gallery-form-actions {
            flex-direction: column-reverse;
        }

        .gallery-cancel-button,
        .gallery-submit-button {
            width: 100%;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const coverInput = document.getElementById('image');
        const imagesInput = document.getElementById('images');
        const coverPreview = document.getElementById('galleryCoverPreview');
        const coverName = document.getElementById('selectedCoverName');
        const imagesCount = document.getElementById('selectedImagesCount');
        const previewStatus = document.getElementById('coverPreviewStatus');

        if (coverInput && coverPreview) {
            coverInput.addEventListener('change', function () {
                const file = this.files && this.files[0];

                if (!file) {
                    return;
                }

                if (!file.type.startsWith('image/')) {
                    this.value = '';

                    if (coverName) {
                        coverName.textContent = 'Please select a valid image.';
                    }

                    return;
                }

                if (coverName) {
                    coverName.textContent = file.name;
                }

                if (previewStatus) {
                    previewStatus.textContent = 'New cover selected';
                }

                const reader = new FileReader();

                reader.addEventListener('load', function (event) {
                    coverPreview.src = event.target.result;
                });

                reader.readAsDataURL(file);
            });
        }

        if (imagesInput && imagesCount) {
            imagesInput.addEventListener('change', function () {
                const files = Array.from(this.files || []);

                imagesCount.textContent = files.length
                    ? `${files.length} photo${files.length === 1 ? '' : 's'} selected.`
                    : 'No photos selected.';
            });
        }
    });
</script>
@endpush
