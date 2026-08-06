@php
    $update = $libraryUpdate ?? null;
    $isEditing = $update !== null;
    $currentImage = $update?->image_url ?? asset('images/readingarea.jpg');
@endphp

<div class="library-update-form-card">
    <div class="form-card-body">
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="form-section-title">
                    <span class="section-icon">
                        <i class="bi bi-card-text"></i>
                    </span>

                    <div>
                        <h5>Update Information</h5>
                        <p>Enter the title, description, and image for this slide.</p>
                    </div>
                </div>

                <div class="form-group-custom">
                    <label for="title">
                        Update Title
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        id="title"
                        type="text"
                        name="title"
                        class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title', $update?->title) }}"
                        placeholder="Example: Library Orientation 2026"
                        required>

                    @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group-custom">
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

                    <small class="field-note">
                        Keep the description brief so it remains readable on the homepage.
                    </small>
                </div>

                <div class="form-group-custom mb-0">
                    <label for="image_file">
                        Upload Image

                        @unless($isEditing)
                            <span class="text-danger">*</span>
                        @endunless
                    </label>

                    <div class="upload-area">
                        <div class="upload-copy">
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
                        <small class="field-note">
                            Leave the image field empty to keep the current image.
                        </small>
                    @else
                        <small class="field-note">
                            A landscape image is recommended for the homepage slideshow.
                        </small>
                    @endif
                </div>
            </div>

            <div class="col-lg-5">
                <div class="form-section-title">
                    <span class="section-icon">
                        <i class="bi bi-image"></i>
                    </span>

                    <div>
                        <h5>Preview and Status</h5>
                        <p>Review the image and control whether the slide is visible.</p>
                    </div>
                </div>

                <div class="preview-wrapper">
                    <img
                        id="libraryUpdatePreview"
                        src="{{ $currentImage }}"
                        alt="Library update preview"
                        onerror="this.onerror=null;this.src='{{ asset('images/readingarea.jpg') }}';">

                    <div class="preview-label">
                        Homepage Preview
                    </div>
                </div>

                <div class="preview-note">
                    <i class="bi bi-info-circle"></i>
                    <span>
                        The preview changes automatically after selecting an image.
                    </span>
                </div>

                <div class="form-group-custom mb-0">
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

                    <small class="field-note">
                        Hidden slides will not appear on the public homepage.
                    </small>
                </div>
            </div>
        </div>
    </div>

    <div class="form-card-footer">
        <a
            href="{{ route('admin.library-updates.index') }}"
            class="btn-cancel">
            Cancel
        </a>

        <button type="submit" class="btn-submit">
            <i class="bi {{ $isEditing ? 'bi-check2-circle' : 'bi-plus-lg' }}"></i>

            {{ $isEditing ? 'Update Slide' : 'Create Slide' }}
        </button>
    </div>
</div>

@push('styles')
<style>
.library-update-form-card {
    overflow: hidden;
    background: #ffffff;
    border: 1px solid #e4eaf1;
    border-radius: 20px;
    box-shadow: 0 12px 30px rgba(25, 50, 80, 0.07);
}

.form-card-body {
    padding: 24px;
}

.form-section-title {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
    padding-bottom: 16px;
    border-bottom: 1px solid #edf0f4;
}

.section-icon {
    width: 42px;
    height: 42px;
    flex: 0 0 42px;
    display: grid;
    place-items: center;
    color: #0b2e59;
    background: #fff7d9;
    border-radius: 12px;
    font-size: 18px;
}

.form-section-title h5 {
    margin: 0 0 3px;
    color: #0b2e59;
    font-size: 15px;
    font-weight: 800;
}

.form-section-title p {
    margin: 0;
    color: #778599;
    font-size: 10px;
}

.form-group-custom {
    margin-bottom: 18px;
}

.form-group-custom label {
    display: block;
    margin-bottom: 7px;
    color: #344054;
    font-size: 11px;
    font-weight: 800;
}

.form-group-custom label small {
    color: #98a2b3;
    font-size: 9px;
    font-weight: 600;
}

.form-group-custom .form-control,
.form-group-custom .form-select {
    min-height: 45px;
    color: #344054;
    background: #ffffff;
    border: 1px solid #dfe6ef;
    border-radius: 10px;
    box-shadow: none;
    font-size: 12px;
}

.form-group-custom textarea.form-control {
    min-height: 145px;
    resize: vertical;
}

.form-group-custom .form-control:focus,
.form-group-custom .form-select:focus {
    border-color: #184b8c;
    box-shadow: 0 0 0 3px rgba(24, 75, 140, 0.1);
}

.field-note {
    display: block;
    margin-top: 6px;
    color: #98a2b3;
    font-size: 9px;
    line-height: 1.5;
}

.upload-area {
    padding: 16px;
    background: #f8fafc;
    border: 1px dashed #b8c5d5;
    border-radius: 13px;
}

.upload-copy {
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

.upload-copy strong,
.upload-copy span {
    display: block;
}

.upload-copy strong {
    color: #344054;
    font-size: 11px;
    font-weight: 800;
}

.upload-copy span {
    margin-top: 3px;
    color: #98a2b3;
    font-size: 9px;
}

.upload-area input[type="file"] {
    padding: 8px;
    background: #ffffff;
}

.preview-wrapper {
    position: relative;
    height: 280px;
    overflow: hidden;
    background: #e9eef5;
    border: 1px solid #dfe6ef;
    border-radius: 15px;
}

.preview-wrapper img {
    width: 100%;
    height: 100%;
    display: block;
    object-fit: cover;
}

.preview-label {
    position: absolute;
    right: 0;
    bottom: 0;
    left: 0;
    padding: 30px 15px 12px;
    color: #ffffff;
    background: linear-gradient(
        transparent,
        rgba(7, 31, 62, 0.82)
    );
    font-size: 9px;
    font-weight: 800;
    letter-spacing: 0.09em;
    text-transform: uppercase;
}

.preview-note {
    display: flex;
    align-items: flex-start;
    gap: 7px;
    margin: 11px 0 18px;
    color: #667085;
    font-size: 9px;
    line-height: 1.5;
}

.preview-note i {
    color: #184b8c;
}

.form-card-footer {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 9px;
    padding: 17px 22px;
    background: #ffffff;
    border-top: 1px solid #e4eaf1;
}

.btn-cancel,
.btn-submit {
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

.btn-cancel {
    color: #475467;
    background: #ffffff;
    border: 1px solid #d0d5dd;
}

.btn-submit {
    color: #0b2e59;
    background: #f4b400;
    border: 1px solid #f4b400;
}

.btn-cancel:hover {
    color: #0b2e59;
    background: #f8fafc;
}

.btn-submit:hover {
    color: #0b2e59;
    background: #ffc72c;
    border-color: #ffc72c;
}

@media (max-width: 767.98px) {
    .form-card-body {
        padding: 18px;
    }

    .form-card-footer {
        padding: 17px 18px;
        flex-direction: column-reverse;
    }

    .btn-cancel,
    .btn-submit {
        width: 100%;
    }

    .preview-wrapper {
        height: 240px;
    }
}

.library-updates-page {
    padding: 24px;
}

.updates-hero {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
    padding: 28px 30px;
    border-radius: 22px;
    color: #ffffff;
    background: linear-gradient(125deg, #0b2e59, #184b8c);
    box-shadow: 0 16px 36px rgba(11, 46, 89, 0.16);
    margin-bottom: 22px;
}

.hero-copy {
    display: flex;
    align-items: center;
    gap: 18px;
}

.hero-icon {
    width: 62px;
    height: 62px;
    display: grid;
    place-items: center;
    border-radius: 18px;
    background: #f4b400;
    color: #0b2e59;
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

.btn-back-list {
    min-height: 46px;
    padding: 0 18px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    border-radius: 12px;
    background: #f4b400;
    color: #0b2e59;
    font-size: 12px;
    font-weight: 800;
    text-decoration: none;
}

.btn-back-list:hover {
    background: #ffc72c;
}

.updates-panel {
    overflow: hidden;
    border: 1px solid #e4eaf1;
    border-radius: 20px;
    background: #ffffff;
    box-shadow: 0 12px 30px rgba(25, 50, 80, 0.07);
}

@media (max-width: 991.98px) {
    .updates-hero,
    .form-card-body {
        flex-direction: column;
        align-items: stretch;
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