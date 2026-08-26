@csrf

@php
    $galleryItem = $gallery ?? null;
    $isEditing = $galleryItem !== null;
    $uploadMode = $uploadMode ?? false;

    $currentImage = $isEditing
        ? $galleryItem->image_url
        : asset('images/image-fallback.svg');

    $isActive = (int) old(
        'is_active',
        $galleryItem?->is_active ?? 1
    );

    $folderImages = $isEditing
        ? $galleryItem->images
        : collect();
@endphp

<div class="gallery-folder-form">

@if (! $uploadMode)

    {{-- Folder Information --}}
    <section class="gallery-form-card">

        <div class="gallery-form-heading">

            <span class="gallery-heading-icon">
                <i class="bi bi-folder2-open"></i>
            </span>

            <div>
                <h5>Folder Information</h5>
                <p>Enter a clear name for this gallery folder.</p>
            </div>

        </div>

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

        <div class="gallery-field-help">
            Use a short and descriptive folder name.
        </div>

        @error('title')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </section>

    {{-- Folder Cover --}}
    <section class="gallery-form-card">

        <div class="gallery-form-heading">

            <span class="gallery-heading-icon">
                <i class="bi bi-card-image"></i>
            </span>

            <div>
                <h5>Folder Cover</h5>

                <p>
                    {{ $isEditing
                        ? 'Choose a replacement or leave this empty to retain the current cover.'
                        : 'Choose an optional cover image for this folder.'
                    }}
                </p>
            </div>

        </div>

        <div class="gallery-cover-layout">

            {{-- Cover Upload --}}
            <div class="gallery-cover-column">

                <label
                    for="image"
                    class="gallery-drop-zone @error('image') has-error @enderror">

                    <input
                        type="file"
                        name="image"
                        id="image"
                        accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">

                    <span class="gallery-drop-icon">
                        <i class="bi bi-cloud-arrow-up"></i>
                    </span>

                    <strong>
                        {{ $isEditing
                            ? 'Choose a new folder cover'
                            : 'Choose a folder cover'
                        }}
                    </strong>

                    <small>Click here to browse your files</small>

                    <span class="gallery-file-rules">
                        JPG, PNG or WEBP · Maximum 5 MB
                    </span>

                </label>

                <div class="gallery-selected-file">

                    <i class="bi bi-file-earmark-image"></i>

                    <span id="selectedCoverName">
                        {{ $isEditing
                            ? 'No replacement selected.'
                            : 'No cover selected.'
                        }}
                    </span>

                </div>

                @error('image')
                    <div class="gallery-error">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            {{-- Cover Image --}}
            <div class="gallery-cover-column">

                <div class="gallery-cover-preview">

                    <img
                        src="{{ $currentImage }}"
                        id="galleryCoverPreview"
                        alt="{{ $galleryItem?->title ?? 'Gallery folder image' }}"
                        onerror="this.onerror=null; this.src='{{ asset('images/image-fallback.svg') }}';">

                </div>

            </div>

        </div>

    </section>

@endif

@if ($uploadMode)

    {{-- Folder Photos --}}
    <section class="gallery-form-card">

        <div class="gallery-form-heading">

            <span class="gallery-heading-icon">
                <i class="bi bi-images"></i>
            </span>

            <div>
                <h5>Folder Photos</h5>

                <p>
                    {{ $isEditing
                        ? 'Upload and view the photos stored inside this folder.'
                        : 'You can add photos after creating the folder.'
                    }}
                </p>
            </div>

        </div>

        @if ($isEditing)

            <div class="gallery-photos-layout">

                {{-- Upload Photos --}}
                <div class="gallery-photo-upload">

                    <label
                        for="images"
                        class="gallery-drop-zone photo-drop-zone">

                        <input
                            type="file"
                            name="images[]"
                            id="images"
                            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                            multiple>

                        <span class="gallery-drop-icon">
                            <i class="bi bi-images"></i>
                        </span>

                        <strong>Add photos to this folder</strong>

                        <small>Select one or more image files</small>

                        <span class="gallery-file-rules">
                            Multiple images allowed
                        </span>

                    </label>

                    <div class="gallery-selected-file">

                        <i class="bi bi-card-checklist"></i>

                        <span id="selectedImagesCount">
                            No photos selected.
                        </span>

                    </div>

                    @error('images')
                        <div class="gallery-error">
                            {{ $message }}
                        </div>
                    @enderror

                    @error('images.*')
                        <div class="gallery-error">
                            {{ $message }}
                        </div>
                    @enderror

                    <button
                        type="submit"
                        class="gallery-upload-button">

                        <i class="bi bi-cloud-arrow-up-fill"></i>
                        Upload Selected Photos

                    </button>

                </div>

                {{-- Current Photos --}}
                <div class="gallery-current-photos">

                    <div class="current-photos-heading">

                        <div>
                            <h6>Current Photos</h6>
                            <p>Photos saved inside this folder.</p>
                        </div>

                        <span>
                            {{ $folderImages->count() }}

                            {{ \Illuminate\Support\Str::plural(
                                'photo',
                                $folderImages->count()
                            ) }}
                        </span>

                    </div>

                    <div class="current-photos-grid">

                        @forelse ($folderImages as $galleryImage)

                            <div class="current-photo-item">

                                <img
                                    src="{{ $galleryImage->image_url }}"
                                    alt="Photo from {{ $galleryItem->title }}"
                                    loading="lazy"
                                    onerror="this.onerror=null; this.src='{{ asset('images/image-fallback.svg') }}';">

                                <button
                                    type="button"
                                    class="current-photo-delete"
                                    data-delete-url="{{ route('admin.gallery.images.destroy', [$galleryItem, $galleryImage]) }}"
                                    data-photo-label="Photo from {{ $galleryItem->title }}"
                                    aria-label="Delete photo from {{ $galleryItem->title }}">

                                    <i class="bi bi-trash3"></i>

                                </button>

                            </div>

                        @empty

                            <div class="current-photos-empty">

                                <i class="bi bi-images"></i>

                                <strong>No photos uploaded</strong>

                                <p>
                                    Select photos on the left to begin.
                                </p>

                            </div>

                        @endforelse

                    </div>

                </div>

            </div>

        @else

            <div class="gallery-information-box">

                <span>
                    <i class="bi bi-info-circle-fill"></i>
                </span>

                <div>
                    <strong>Save the folder first</strong>

                    <p>
                        After creating this folder, open its edit page to
                        upload multiple gallery photos.
                    </p>
                </div>

            </div>

        @endif

    </section>

@endif

@if (! $uploadMode)

    {{-- Visibility --}}
    <section class="gallery-form-card">

        <div class="gallery-form-heading">

            <span class="gallery-heading-icon">
                <i class="bi bi-eye-fill"></i>
            </span>

            <div>
                <h5>Visibility</h5>
                <p>Control whether visitors can see this folder publicly.</p>
            </div>

        </div>

        <input type="hidden" name="is_active" value="0">

        <label for="is_active" class="gallery-visibility">

            <span class="gallery-visibility-icon">
                <i class="bi bi-globe2"></i>
            </span>

            <span class="gallery-visibility-text">

                <strong>Display folder publicly</strong>

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

    {{-- Actions --}}
    <div class="gallery-form-actions">

        <a
            href="{{ route('admin.gallery.index') }}"
            class="gallery-cancel-button">

            <i class="bi bi-x-lg"></i>
            Cancel

        </a>

        <button type="submit" class="gallery-save-button">

            <i class="bi {{ $isEditing ? 'bi-check2-circle' : 'bi-folder-plus' }}"></i>

            {{ $isEditing
                ? 'Save Folder Changes'
                : 'Create Gallery Folder'
            }}

        </button>

    </div>

@endif

</div>

@push('styles')
<style>
    .gallery-folder-form {
        --gallery-navy: #0b2e59;
        --gallery-blue: #184b8c;
        --gallery-gold: #f4b400;
        width: 100%;
        display: grid;
        gap: 16px;
    }

    /* Form Cards */

    .gallery-form-card {
        width: 100%;
        padding: 24px 26px;
        background: #fff;
        border: 1px solid #dfe5ed;
        border-radius: 17px;
        box-shadow: 0 8px 24px rgba(11, 46, 89, .06);
    }

    .gallery-form-heading {
        margin-bottom: 21px;
        display: flex;
        align-items: center;
        gap: 13px;
    }

    .gallery-heading-icon {
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

    .gallery-form-heading h5 {
        margin: 0 0 3px;
        color: var(--gallery-navy);
        font-size: 15px;
        font-weight: 800;
    }

    .gallery-form-heading p {
        margin: 0;
        color: #748095;
        font-size: 11px;
        line-height: 1.5;
    }

    /* Input */

    .gallery-folder-form .form-label {
        margin-bottom: 8px;
        color: #263d58;
        font-size: 12px;
        font-weight: 700;
    }

    .gallery-folder-form .form-label > span {
        color: #dc3545;
    }

    .gallery-folder-form .form-control {
        min-height: 47px;
        padding: 10px 14px;
        color: #263d58;
        background: #fbfcfe;
        border: 1px solid #dbe2eb;
        border-radius: 10px;
        font-size: 12px;
        box-shadow: none;
    }

    .gallery-folder-form .form-control:focus {
        background: #fff;
        border-color: var(--gallery-blue);
        box-shadow: 0 0 0 4px rgba(24, 75, 140, .08);
    }

    .gallery-field-help {
        margin-top: 7px;
        color: #8893a2;
        font-size: 10px;
    }

    /* Cover Layout */

    .gallery-cover-layout {
        width: 100%;
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px;
        align-items: start;
    }

    .gallery-cover-column {
        min-width: 0;
    }

    /* Upload Area */

    .gallery-drop-zone {
        position: relative;
        width: 100%;
        height: 245px;
        padding: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        text-align: center;
        cursor: pointer;
        background: #f7f9fc;
        border: 2px dashed #cbd6e3;
        border-radius: 15px;
        transition: .2s ease;
    }

    .gallery-drop-zone:hover {
        background: #f1f6fb;
        border-color: var(--gallery-blue);
    }

    .gallery-drop-zone.has-error {
        background: #fff7f7;
        border-color: #dc3545;
    }

    .gallery-drop-zone input {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
        opacity: 0;
    }

    .gallery-drop-icon {
        width: 54px;
        height: 54px;
        margin-bottom: 12px;
        display: grid;
        place-items: center;
        color: var(--gallery-navy);
        background: #fff;
        border: 1px solid #e0e7ef;
        border-radius: 14px;
        font-size: 23px;
        box-shadow: 0 7px 18px rgba(11, 46, 89, .07);
    }

    .gallery-drop-zone strong {
        margin-bottom: 4px;
        color: var(--gallery-navy);
        font-size: 13px;
    }

    .gallery-drop-zone small {
        margin-bottom: 10px;
        color: #748095;
        font-size: 10px;
    }

    .gallery-file-rules {
        padding: 5px 10px;
        color: #637185;
        background: #e8eef5;
        border-radius: 999px;
        font-size: 9px;
        font-weight: 700;
    }

    .gallery-selected-file {
        min-height: 39px;
        margin-top: 9px;
        padding: 8px 11px;
        display: flex;
        align-items: center;
        gap: 8px;
        overflow: hidden;
        color: #647286;
        background: #f7f9fc;
        border: 1px solid #e3e9f0;
        border-radius: 9px;
        font-size: 10px;
    }

    .gallery-selected-file i {
        flex-shrink: 0;
        color: var(--gallery-blue);
    }

    .gallery-selected-file span {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .gallery-error {
        margin-top: 7px;
        color: #dc3545;
        font-size: 10px;
        font-weight: 600;
    }

    /* Cover Image */

    .gallery-cover-preview {
        width: 100%;
        height: 245px;
        overflow: hidden;
        background: #e9eef5;
        border: 1px solid #d8e0e9;
        border-radius: 15px;
    }

    .gallery-cover-preview img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
        object-position: center;
        transition: transform .35s ease;
    }

    .gallery-cover-preview:hover img {
        transform: scale(1.035);
    }

    /* Photos Layout */

    .gallery-photos-layout {
        width: 100%;
        display: grid;
        grid-template-columns: minmax(260px, 36%) minmax(0, 64%);
        gap: 20px;
        align-items: start;
    }

    .gallery-photo-upload {
        min-width: 0;
    }

    .photo-drop-zone {
        height: 225px;
    }

    .gallery-upload-button {
        width: 100%;
        min-height: 44px;
        margin-top: 9px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        color: #fff;
        background: var(--gallery-blue);
        border: 1px solid var(--gallery-blue);
        border-radius: 10px;
        font-size: 11px;
        font-weight: 700;
        transition: .2s ease;
    }

    .gallery-upload-button:hover {
        background: var(--gallery-navy);
        border-color: var(--gallery-navy);
    }

    /* Current Photos */

    .gallery-current-photos {
        min-width: 0;
        padding: 16px;
        background: #f7f9fc;
        border: 1px solid #e0e7ef;
        border-radius: 15px;
    }

    .current-photos-heading {
        margin-bottom: 13px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .current-photos-heading h6 {
        margin: 0 0 2px;
        color: var(--gallery-navy);
        font-size: 12px;
        font-weight: 800;
    }

    .current-photos-heading p {
        margin: 0;
        color: #8390a0;
        font-size: 9px;
    }

    .current-photos-heading > span {
        padding: 5px 9px;
        color: var(--gallery-blue);
        background: #e6eff9;
        border-radius: 999px;
        font-size: 9px;
        font-weight: 700;
        white-space: nowrap;
    }

    .current-photos-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 9px;
    }

    .current-photo-item {
        position: relative;
        min-width: 0;
        aspect-ratio: 4 / 3;
        overflow: hidden;
        background: #e8edf3;
        border: 1px solid #d9e1ea;
        border-radius: 9px;
    }

    .current-photo-item img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
        transition: transform .3s ease;
    }

    .current-photo-item:hover img {
        transform: scale(1.05);
    }

    .current-photo-delete {
        position: absolute;
        top: 7px;
        right: 7px;
        width: 30px;
        height: 30px;
        display: grid;
        place-items: center;
        color: #fff;
        background: rgba(216, 75, 75, .92);
        border: 0;
        border-radius: 999px;
        box-shadow: 0 8px 18px rgba(133, 35, 35, .24);
        opacity: 0;
        transform: translateY(-4px) scale(.96);
        transition: opacity .2s ease, transform .2s ease, background .2s ease;
        z-index: 2;
    }

    .current-photo-item:hover .current-photo-delete,
    .current-photo-item:focus-within .current-photo-delete {
        opacity: 1;
        transform: translateY(0) scale(1);
    }

    .current-photo-delete:hover {
        background: #c93d3d;
    }

    .current-photos-empty {
        grid-column: 1 / -1;
        min-height: 175px;
        padding: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        text-align: center;
        background: #fff;
        border: 1px dashed #d1dbe6;
        border-radius: 11px;
    }

    .current-photos-empty i {
        margin-bottom: 8px;
        color: #a1adbb;
        font-size: 27px;
    }

    .current-photos-empty strong {
        margin-bottom: 3px;
        color: var(--gallery-navy);
        font-size: 12px;
    }

    .current-photos-empty p {
        margin: 0;
        color: #7b8798;
        font-size: 10px;
    }

    /* Create Information */

    .gallery-information-box {
        padding: 15px 17px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        color: #315b8b;
        background: #f0f6fc;
        border: 1px solid #d4e4f4;
        border-radius: 12px;
    }

    .gallery-information-box > span {
        width: 38px;
        height: 38px;
        flex: 0 0 38px;
        display: grid;
        place-items: center;
        color: var(--gallery-blue);
        background: #dceaf8;
        border-radius: 10px;
    }

    .gallery-information-box strong {
        display: block;
        margin-bottom: 3px;
        color: var(--gallery-navy);
        font-size: 12px;
    }

    .gallery-information-box p {
        margin: 0;
        color: #69809a;
        font-size: 10px;
    }

    /* Visibility */

    .gallery-visibility {
        min-height: 76px;
        padding: 14px 16px;
        display: flex;
        align-items: center;
        gap: 13px;
        cursor: pointer;
        background: #f8fafd;
        border: 1px solid #dfe6ef;
        border-radius: 13px;
    }

    .gallery-visibility-icon {
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

    .gallery-visibility-text {
        flex: 1;
        min-width: 0;
    }

    .gallery-visibility-text strong,
    .gallery-visibility-text small {
        display: block;
    }

    .gallery-visibility-text strong {
        margin-bottom: 3px;
        color: var(--gallery-navy);
        font-size: 12px;
    }

    .gallery-visibility-text small {
        color: #778396;
        font-size: 10px;
    }

    .gallery-visibility .form-check-input {
        width: 42px;
        height: 22px;
        margin: 0;
        cursor: pointer;
        box-shadow: none;
    }

    .gallery-visibility .form-check-input:checked {
        background-color: #198754;
        border-color: #198754;
    }

    /* Actions */

    .gallery-form-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
    }

    .gallery-cancel-button,
    .gallery-save-button {
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

    .gallery-cancel-button {
        color: #5f6d7e;
        background: #fff;
        border: 1px solid #d7dee7;
    }

    .gallery-cancel-button:hover {
        color: var(--gallery-navy);
        border-color: #aab7c7;
    }

    .gallery-save-button {
        color: #fff;
        background: var(--gallery-navy);
        border: 1px solid var(--gallery-navy);
        box-shadow: 0 8px 18px rgba(11, 46, 89, .16);
    }

    .gallery-save-button:hover {
        color: var(--gallery-navy);
        background: var(--gallery-gold);
        border-color: var(--gallery-gold);
    }

    /* Responsive */

    @media (max-width: 991.98px) {
        .gallery-cover-layout,
        .gallery-photos-layout {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 575.98px) {
        .gallery-form-card {
            padding: 20px 17px;
            border-radius: 14px;
        }

        .gallery-form-heading {
            align-items: flex-start;
        }

        .gallery-drop-zone,
        .gallery-cover-preview {
            height: 215px;
        }

        .current-photos-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .gallery-visibility-text small {
            display: none;
        }

        .gallery-form-actions {
            flex-direction: column-reverse;
        }

        .gallery-cancel-button,
        .gallery-save-button {
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
        const imageCount = document.getElementById('selectedImagesCount');

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

                const reader = new FileReader();

                reader.addEventListener('load', function (event) {
                    coverPreview.src = event.target.result;
                });

                reader.readAsDataURL(file);
            });
        }

        if (imagesInput && imageCount) {
            imagesInput.addEventListener('change', function () {
                const files = Array.from(this.files || []);

                imageCount.textContent = files.length
                    ? `${files.length} photo${files.length === 1 ? '' : 's'} selected.`
                    : 'No photos selected.';
            });
        }
    });
</script>
@endpush
