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

    <section class="gallery-form-section">
        <div class="gallery-section-heading">
            <span class="gallery-section-icon">
                <i class="bi bi-folder2-open"></i>
            </span>

            <div>
                <h5>Gallery Folder</h5>
                <p>Create a folder title that groups uploaded images together.</p>
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

    <section class="gallery-form-section">
        <div class="gallery-section-heading">
            <span class="gallery-section-icon">
                <i class="bi bi-cloud-arrow-up-fill"></i>
            </span>

            <div>
                <h5>{{ $isEditing ? 'Folder Cover Image' : 'Folder Cover Image (Optional)' }}</h5>
                <p>
                    {{ $isEditing
                        ? 'Update the cover image shown in the admin and public gallery.'
                        : 'Add a cover image now, or leave it blank and upload photos later.'
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

                    <strong>
                        {{ $isEditing
                            ? 'Choose a replacement cover image'
                            : 'Choose an optional cover image'
                        }}
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

    <section class="gallery-form-section">
        <div class="gallery-section-heading">
            <span class="gallery-section-icon">
                <i class="bi bi-images"></i>
            </span>

            <div>
                <h5>{{ $isEditing ? 'Add Images to This Folder' : 'Upload Images After Saving' }}</h5>
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
                    <label for="images" class="gallery-upload-area">
                        <input
                            type="file"
                            name="images[]"
                            id="images"
                            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                            multiple>

                        <span class="upload-icon">
                            <i class="bi bi-images"></i>
                        </span>

                        <strong>Add photos to this folder</strong>
                        <span class="upload-description">Select one or more images</span>
                        <span class="upload-requirements">JPG, PNG or WEBP · Multiple files allowed</span>
                    </label>

                    @error('images')
                        <div class="gallery-error-message">{{ $message }}</div>
                    @enderror
                    @error('images.*')
                        <div class="gallery-error-message">{{ $message }}</div>
                    @enderror

                    <button
                        type="submit"
                        formaction="{{ route('admin.gallery.images.store', $galleryItem) }}"
                        formmethod="POST"
                        class="btn btn-primary mt-3">
                        Upload Selected Images
                    </button>
                </div>

                <div class="col-lg-6">
                    <div class="gallery-folder-image-list">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">Current folder images</h6>
                            <span class="badge bg-primary">{{ $galleryItem->images->count() }} photos</span>
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
                                    <div class="text-muted small">
                                        No images uploaded yet. Use the form on the left to add the first slideshow photos.
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="field-help">
                Images can be added after the folder is created.
            </div>
        @endif
    </section>

    <section class="gallery-form-section">
        <div class="gallery-section-heading">
            <span class="gallery-section-icon">
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
    .gallery-folder-thumb {
        aspect-ratio: 1 / .72;
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
</style>
@endpush
