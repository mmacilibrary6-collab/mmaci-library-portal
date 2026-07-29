@csrf

@php
    $resource = $openAccessResource ?? null;
    $isEditing = $resource !== null;

    $externalImageUrl = '';

    if (
        $resource &&
        filled($resource->image) &&
        \Illuminate\Support\Str::startsWith(
            $resource->image,
            ['http://', 'https://']
        )
    ) {
        $externalImageUrl = $resource->image;
    }

    $previewImage = $isEditing
        ? $resource->image_url
        : asset('images/default-resource.png');

    $isActive = (int) old(
        'is_active',
        $resource?->is_active ?? 1
    );
@endphp

<div class="resource-form">

    {{-- Basic Information --}}
    <section class="resource-form-section">

        <div class="resource-section-heading">

            <span class="resource-section-icon">
                <i class="bi bi-globe2"></i>
            </span>

            <div>
                <h5>Resource Information</h5>
                <p>Enter the name, website address, and description.</p>
            </div>

        </div>

        <div class="row g-4">

            <div class="col-lg-6">

                <label for="title" class="form-label">
                    Resource Title <span>*</span>
                </label>

                <input
                    type="text"
                    name="title"
                    id="title"
                    value="{{ old('title', $resource?->title) }}"
                    class="form-control @error('title') is-invalid @enderror"
                    placeholder="Example: Springer Nature"
                    maxlength="255"
                    required>

                @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="col-lg-6">

                <label for="website_url" class="form-label">
                    Website Link <span>*</span>
                </label>

                <div class="resource-input-group">

                    <i class="bi bi-link-45deg"></i>

                    <input
                        type="url"
                        name="website_url"
                        id="website_url"
                        value="{{ old('website_url', $resource?->website_url) }}"
                        class="form-control @error('website_url') is-invalid @enderror"
                        placeholder="https://example.com"
                        required>

                </div>

                <div class="field-help">
                    Visitors will be redirected to this website.
                </div>

                @error('website_url')
                    <div class="resource-error-message">
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
                    placeholder="Briefly describe this resource and the content it provides.">{{ old('description', $resource?->description) }}</textarea>

                <div class="field-help">
                    Keep the description clear and helpful for students.
                </div>

                @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

        </div>

    </section>

    {{-- Resource Image --}}
    <section class="resource-form-section">

        <div class="resource-section-heading">

            <span class="resource-section-icon">
                <i class="bi bi-image-fill"></i>
            </span>

            <div>
                <h5>Resource Logo or Image</h5>
                <p>Upload an image or provide a direct image URL.</p>
            </div>

        </div>

        <div class="row g-4 align-items-stretch">

            <div class="col-lg-7">

                <div class="row g-4">

                    <div class="col-12">

                        <label
                            for="image_file"
                            class="resource-upload-area @error('image_file') upload-error @enderror">

                            <input
                                type="file"
                                name="image_file"
                                id="image_file"
                                accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">

                            <span class="upload-icon">
                                <i class="bi bi-cloud-arrow-up"></i>
                            </span>

                            <strong>
                                Choose a logo or resource image
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

                            <span id="selectedResourceFile">
                                {{ $isEditing
                                    ? 'Leave empty to keep the current image.'
                                    : 'No image selected.'
                                }}
                            </span>

                        </div>

                        @error('image_file')
                            <div class="resource-error-message">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <div class="col-12">

                        <div class="alternative-divider">
                            <span>OR USE AN IMAGE URL</span>
                        </div>

                        <label for="image_url" class="form-label">
                            External Image URL
                        </label>

                        <div class="resource-input-group">

                            <i class="bi bi-link-45deg"></i>

                            <input
                                type="url"
                                name="image_url"
                                id="image_url"
                                value="{{ old('image_url', $externalImageUrl) }}"
                                class="form-control @error('image_url') is-invalid @enderror"
                                placeholder="https://example.com/logo.png">

                        </div>

                        <div class="field-help">
                            An uploaded image takes priority over the URL.
                        </div>

                        @error('image_url')
                            <div class="resource-error-message">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                </div>

            </div>

            <div class="col-lg-5">

                <div class="preview-heading">

                    <label class="form-label mb-0">
                        Image Preview
                    </label>

                    <span id="resourcePreviewStatus">
                        {{ $isEditing ? 'Current image' : 'Default image' }}
                    </span>

                </div>

                <div class="resource-image-preview">

                    <img
                        src="{{ $previewImage }}"
                        id="resourceImagePreview"
                        alt="Open access resource preview"
                        onerror="this.onerror=null; this.src='{{ asset('images/default-resource.png') }}';">

                    <span class="preview-badge">
                        <i class="bi bi-eye-fill"></i>
                        Live Preview
                    </span>

                </div>

            </div>

        </div>

    </section>

    {{-- Display Settings --}}
    <section class="resource-form-section">

        <div class="resource-section-heading">

            <span class="resource-section-icon">
                <i class="bi bi-sliders"></i>
            </span>

            <div>
                <h5>Display Settings</h5>
                <p>Set the position and visibility of this resource.</p>
            </div>

        </div>

        <div class="row g-4">

            <div class="col-lg-4">

                <label for="sort_order" class="form-label">
                    Sort Order
                </label>

                <input
                    type="number"
                    name="sort_order"
                    id="sort_order"
                    min="0"
                    value="{{ old('sort_order', $resource?->sort_order ?? 0) }}"
                    class="form-control @error('sort_order') is-invalid @enderror"
                    placeholder="0">

                <div class="field-help">
                    Lower numbers appear first.
                </div>

                @error('sort_order')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="col-lg-8">

                <label class="form-label">
                    Public Visibility
                </label>

                <input type="hidden" name="is_active" value="0">

                <label for="is_active" class="resource-visibility-option">

                    <span class="visibility-icon">
                        <i class="bi bi-eye-fill"></i>
                    </span>

                    <span class="visibility-content">

                        <strong>Display this resource publicly</strong>

                        <small>
                            Visitors can view and access this resource when enabled.
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

            </div>

        </div>

    </section>

    {{-- Buttons --}}
    <div class="resource-form-actions">

        <a
            href="{{ route('admin.open-access-resources.index') }}"
            class="resource-cancel-button">

            <i class="bi bi-x-lg"></i>
            Cancel

        </a>

        <button type="submit" class="resource-submit-button">

            <i class="bi {{ $isEditing ? 'bi-check2-circle' : 'bi-plus-circle' }}"></i>

            {{ $isEditing ? 'Update Resource' : 'Save Resource' }}

        </button>

    </div>

</div>

@push('styles')
<style>
    .resource-form {
        --resource-navy: #0b2e59;
        --resource-blue: #184b8c;
        --resource-gold: #f4b400;
        overflow: hidden;
        background: #fff;
        border: 1px solid #dde4ed;
        border-radius: 20px;
        box-shadow: 0 14px 35px rgba(11, 46, 89, .08);
    }

    .resource-form-section {
        padding: 27px 30px;
        border-bottom: 1px solid #edf0f5;
    }

    .resource-section-heading {
        margin-bottom: 23px;
        display: flex;
        align-items: center;
        gap: 13px;
    }

    .resource-section-icon {
        width: 43px;
        height: 43px;
        flex: 0 0 43px;
        display: grid;
        place-items: center;
        color: var(--resource-navy);
        background: rgba(244, 180, 0, .17);
        border-radius: 12px;
        font-size: 18px;
    }

    .resource-section-heading h5 {
        margin: 0 0 3px;
        color: var(--resource-navy);
        font-size: 15px;
        font-weight: 800;
    }

    .resource-section-heading p {
        margin: 0;
        color: #7a8595;
        font-size: 11px;
    }

    .resource-form .form-label {
        margin-bottom: 8px;
        color: #243b57;
        font-size: 12px;
        font-weight: 700;
    }

    .resource-form .form-label > span {
        color: #dc3545;
    }

    .resource-form .form-label small {
        color: #8b95a3;
        font-size: 9px;
        font-weight: 500;
    }

    .resource-form .form-control {
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

    .resource-form textarea.form-control {
        min-height: 110px;
        resize: vertical;
    }

    .resource-form .form-control:focus {
        background: #fff;
        border-color: var(--resource-blue);
        box-shadow: 0 0 0 4px rgba(24, 75, 140, .09);
    }

    .resource-input-group {
        position: relative;
    }

    .resource-input-group > i {
        position: absolute;
        z-index: 2;
        top: 50%;
        left: 14px;
        color: #8490a0;
        transform: translateY(-50%);
    }

    .resource-input-group .form-control {
        padding-left: 39px;
    }

    .field-help {
        margin-top: 7px;
        color: #8a94a3;
        font-size: 10px;
    }

    .resource-error-message {
        margin-top: 6px;
        color: #dc3545;
        font-size: 10px;
        font-weight: 600;
    }

    .resource-upload-area {
        min-height: 205px;
        padding: 23px;
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

    .resource-upload-area:hover {
        background: #f3f7fc;
        border-color: var(--resource-blue);
        transform: translateY(-2px);
    }

    .resource-upload-area.upload-error {
        background: #fff7f7;
        border-color: #dc3545;
    }

    .resource-upload-area input {
        position: absolute;
        width: 1px;
        height: 1px;
        overflow: hidden;
        opacity: 0;
        pointer-events: none;
    }

    .upload-icon {
        width: 54px;
        height: 54px;
        margin-bottom: 12px;
        display: grid;
        place-items: center;
        color: var(--resource-navy);
        background: #fff;
        border: 1px solid #e1e7ef;
        border-radius: 15px;
        font-size: 24px;
        box-shadow: 0 8px 20px rgba(11, 46, 89, .08);
    }

    .resource-upload-area strong {
        margin-bottom: 4px;
        color: var(--resource-navy);
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
        background: #eaf0f7;
        border-radius: 999px;
        font-size: 9px;
        font-weight: 700;
    }

    .selected-file-row {
        min-height: 37px;
        margin-top: 8px;
        padding: 8px 11px;
        display: flex;
        align-items: center;
        gap: 8px;
        color: #687587;
        background: #f7f9fc;
        border-radius: 9px;
        font-size: 10px;
    }

    .selected-file-row i {
        color: var(--resource-blue);
    }

    .alternative-divider {
        margin-bottom: 18px;
        display: flex;
        align-items: center;
        gap: 10px;
        color: #8b96a5;
        font-size: 8px;
        font-weight: 800;
        letter-spacing: .08em;
    }

    .alternative-divider::before,
    .alternative-divider::after {
        content: "";
        height: 1px;
        flex: 1;
        background: #e2e7ee;
    }

    .preview-heading {
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .preview-heading > span {
        padding: 4px 8px;
        color: var(--resource-blue);
        background: #eaf1f9;
        border-radius: 999px;
        font-size: 9px;
        font-weight: 700;
    }

    .resource-image-preview {
        position: relative;
        height: 330px;
        padding: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background:
            linear-gradient(45deg, #f2f5f9 25%, transparent 25%),
            linear-gradient(-45deg, #f2f5f9 25%, transparent 25%),
            linear-gradient(45deg, transparent 75%, #f2f5f9 75%),
            linear-gradient(-45deg, transparent 75%, #f2f5f9 75%),
            #fafbfd;
        background-position: 0 0, 0 8px, 8px -8px, -8px 0;
        background-size: 16px 16px;
        border: 1px solid #d9e1eb;
        border-radius: 16px;
    }

    .resource-image-preview img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: contain;
    }

    .preview-badge {
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

    .resource-visibility-option {
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

    .resource-visibility-option:hover {
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
        color: var(--resource-navy);
        font-size: 12px;
    }

    .visibility-content small {
        color: #778396;
        font-size: 10px;
    }

    .resource-visibility-option .form-check-input {
        width: 42px;
        height: 22px;
        margin: 0;
        cursor: pointer;
        border-color: #bbc5d1;
        box-shadow: none;
    }

    .resource-visibility-option .form-check-input:checked {
        background-color: #198754;
        border-color: #198754;
    }

    .resource-form-actions {
        padding: 20px 30px;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        background: #fafbfd;
    }

    .resource-cancel-button,
    .resource-submit-button {
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

    .resource-cancel-button {
        color: #5f6d7e;
        background: #fff;
        border: 1px solid #d7dee7;
    }

    .resource-cancel-button:hover {
        color: var(--resource-navy);
        border-color: #aab7c7;
    }

    .resource-submit-button {
        color: #fff;
        background: var(--resource-navy);
        border: 1px solid var(--resource-navy);
        box-shadow: 0 8px 18px rgba(11, 46, 89, .16);
    }

    .resource-submit-button:hover {
        color: var(--resource-navy);
        background: var(--resource-gold);
        border-color: var(--resource-gold);
        transform: translateY(-1px);
    }

    @media (max-width: 767.98px) {
        .resource-form-section {
            padding: 22px 18px;
        }

        .resource-form-actions {
            padding: 17px 18px;
        }
    }

    @media (max-width: 575.98px) {
        .resource-form-actions {
            flex-direction: column-reverse;
        }

        .resource-cancel-button,
        .resource-submit-button {
            width: 100%;
        }

        .visibility-content small {
            display: none;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.getElementById('image_file');
        const urlInput = document.getElementById('image_url');
        const preview = document.getElementById('resourceImagePreview');
        const fileName = document.getElementById('selectedResourceFile');
        const previewStatus = document.getElementById('resourcePreviewStatus');
        const defaultImage = @json(asset('images/default-resource.png'));

        if (!fileInput || !urlInput || !preview) {
            return;
        }

        fileInput.addEventListener('change', function () {
            const file = this.files && this.files[0];

            if (!file) {
                return;
            }

            if (!file.type.startsWith('image/')) {
                this.value = '';

                if (fileName) {
                    fileName.textContent = 'Please choose a valid image.';
                }

                return;
            }

            if (fileName) {
                fileName.textContent = file.name;
            }

            if (previewStatus) {
                previewStatus.textContent = 'Uploaded image';
            }

            const reader = new FileReader();

            reader.addEventListener('load', function (event) {
                preview.src = event.target.result;
            });

            reader.readAsDataURL(file);
        });

        urlInput.addEventListener('input', function () {
            if (fileInput.files.length > 0) {
                return;
            }

            const imageUrl = this.value.trim();

            preview.src = imageUrl || defaultImage;

            if (previewStatus) {
                previewStatus.textContent = imageUrl
                    ? 'External image'
                    : 'Default image';
            }
        });
    });
</script>
@endpush