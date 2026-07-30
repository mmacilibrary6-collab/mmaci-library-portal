@php
    $update = $libraryUpdate ?? null;
    $isEditing = $update !== null;
    $currentImage = $update?->image_url ?? asset('images/readingarea.jpg');
@endphp

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <div class="row g-4">
            <div class="col-lg-7">
                <label class="form-label">Update Title <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $update?->title) }}" placeholder="Example: Library Orientation 2026" required>
                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror

                <div class="mt-3">
                    <label class="form-label">Description <small class="text-muted">Optional</small></label>
                    <textarea name="description" rows="5" class="form-control @error('description') is-invalid @enderror" placeholder="Short optional description...">{{ old('description', $update?->description) }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mt-3">
                    <label class="form-label">Upload Image <span class="text-danger">*</span></label>
                    <input type="file" name="image_file" class="form-control @error('image_file') is-invalid @enderror" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
                    @error('image_file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="col-lg-5">
                <label class="form-label">Image Preview</label>
                <div class="border rounded-4 overflow-hidden bg-light" style="min-height: 280px;">
                    <img src="{{ $currentImage }}" alt="Library update preview" class="w-100 h-100" style="object-fit: cover; min-height: 280px;">
                </div>

                <div class="mt-3">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" min="0" class="form-control @error('sort_order') is-invalid @enderror" value="{{ old('sort_order', $update?->sort_order ?? 0) }}">
                    @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mt-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror">
                        <option value="1" @selected(old('status', $update?->status ?? 1) == 1)>Active</option>
                        <option value="0" @selected(old('status', $update?->status ?? 1) == 0)>Hidden</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-end gap-2 mt-3">
    <a href="{{ route('admin.library-updates.index') }}" class="btn btn-light border rounded-pill px-4">Cancel</a>
    <button type="submit" class="btn btn-admin rounded-pill px-4">{{ $isEditing ? 'Update Slide' : 'Create Slide' }}</button>
</div>
