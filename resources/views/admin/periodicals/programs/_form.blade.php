@php
    $program = $periodicalProgram ?? null;
    $isEditing = $program !== null;
    $currentImage = $program?->image_url ?? asset('images/readingarea.jpg');
@endphp
<div class="program-form">
    <div class="form-section"><div class="section-heading"><span class="section-icon"><i class="bi bi-book-half"></i></span><div><h5>Program Information</h5><p>Enter the periodical program details and display settings.</p></div></div>
        <div class="row g-4">
            <div class="col-lg-10"><label for="title" class="form-label">Program Title <span>*</span></label><input type="text" name="title" id="title" value="{{ old('title', $program?->title) }}" class="form-control @error('title') is-invalid @enderror" required>@error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="col-sm-6 col-lg-2"><label for="status" class="form-label">Visibility</label><select name="status" id="status" class="form-select @error('status') is-invalid @enderror"><option value="1" @selected(old('status', $program?->status ?? 1) == 1)>Active</option><option value="0" @selected(old('status', $program?->status ?? 1) == 0)>Hidden</option></select>@error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="col-12"><label for="description" class="form-label">Description <small>Optional</small></label><textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $program?->description) }}</textarea>@error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        </div>
    </div>
    <div class="form-section"><div class="section-heading"><span class="section-icon image-icon"><i class="bi bi-image-fill"></i></span><div><h5>Program Image</h5><p>Upload an image for the program.</p></div></div>
        <div class="row g-4 align-items-stretch">
            <div class="col-lg-7"><div class="image-fields"><div><label for="image_file" class="form-label">Upload Image <small>Recommended</small></label><label for="image_file" class="upload-area @error('image_file') upload-error @enderror"><span class="upload-icon"><i class="bi bi-cloud-arrow-up"></i></span><span class="upload-copy"><strong id="uploadFileName">Choose an image</strong><small>JPG, PNG or WEBP · Maximum 5 MB</small></span><span class="browse-button">Browse</span></label><input type="file" name="image_file" id="image_file" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" class="visually-hidden" @error('image_file') aria-invalid="true" @enderror>@error('image_file')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror</div></div></div>
            <div class="col-lg-5"><div class="preview-panel"><div class="preview-label"><span>Image Preview</span><small>Current image</small></div><div class="program-image-preview"><img id="programImagePreview" src="{{ $currentImage }}" data-original="{{ $currentImage }}" data-fallback="{{ $currentImage }}" alt="Periodical program preview"><span class="preview-overlay"><i class="bi bi-eye"></i>Preview</span></div></div></div>
        </div>
    </div>
    <div class="form-actions"><a href="{{ route('admin.periodical-programs.index') }}" class="btn-cancel"><i class="bi bi-arrow-left"></i> Cancel</a><button type="submit" class="btn-save"><i class="bi {{ $isEditing ? 'bi-check-lg' : 'bi-plus-lg' }}"></i> {{ $isEditing ? 'Update Program' : 'Create Program' }}</button></div>
</div>
