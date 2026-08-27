@php
    $folder = $periodicalFolder ?? null;
    $programs = $programs ?? collect();
    $selectedProgramId = old('periodical_program_id', $folder?->periodical_program_id ?? ($selectedProgramId ?? ''));
    $selectedCategory = old('category', $folder?->category ?? 'journal_newspaper');
    $selectedAccessionNumber = old('accession_number', $folder?->accession_number);
@endphp
<div class="program-form">
    <div class="form-section">
        <div class="section-heading">
            <span class="section-icon"><i class="bi bi-folder-fill"></i></span>
            <div>
                <h5>Folder Information</h5>
                <p>Enter the folder title, program, category, and link. Folders are sorted alphabetically automatically.</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-4">
                <label for="periodical_program_id" class="form-label">Program <span>*</span></label>
                <select name="periodical_program_id" id="periodical_program_id" class="form-select @error('periodical_program_id') is-invalid @enderror" required>
                    <option value="">Select program</option>
                    @foreach($programs as $program)
                        <option value="{{ $program->id }}" @selected((string) $selectedProgramId === (string) $program->id)>{{ $program->title }}</option>
                    @endforeach
                </select>
                @error('periodical_program_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-lg-4">
                <label for="category" class="form-label">Category <span>*</span></label>
                <select name="category" id="category" class="form-select @error('category') is-invalid @enderror" required>
                    <option value="journal_newspaper" @selected($selectedCategory === 'journal_newspaper')>Journal &amp; Newspaper Clippings</option>
                    <option value="magazine" @selected($selectedCategory === 'magazine')>Magazines</option>
                </select>
                @error('category')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-lg-4">
                <label for="title" class="form-label">Folder Title <span>*</span></label>
                <input type="text" name="title" id="title" value="{{ old('title', $folder?->title) }}" class="form-control @error('title') is-invalid @enderror" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-lg-4" id="accession_number_wrap">
                <label for="accession_number" class="form-label">Accession Number <span id="accession_number_required_mark">*</span></label>
                <input
                    type="text"
                    name="accession_number"
                    id="accession_number"
                    value="{{ $selectedAccessionNumber }}"
                    class="form-control @error('accession_number') is-invalid @enderror"
                    placeholder="e.g. JRN-0001">
                <small class="text-muted d-block mt-1">Required for journal &amp; newspaper clippings only.</small>
                @error('accession_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <label for="description" class="form-label">Description <small>Optional</small></label>
                <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $folder?->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-lg-8">
                <label for="folder_link" class="form-label">Folder Link <span>*</span></label>
                <input type="url" name="folder_link" id="folder_link" value="{{ old('folder_link', $folder?->folder_link) }}" class="form-control @error('folder_link') is-invalid @enderror" required>
                @error('folder_link')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-lg-2">
                <label for="status" class="form-label">Visibility</label>
                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                    <option value="1" @selected(old('status', $folder?->status ?? 1) == 1)>Active</option>
                    <option value="0" @selected(old('status', $folder?->status ?? 1) == 0)>Hidden</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="form-actions">
        <a href="{{ route('admin.periodical-folders.index') }}" class="btn-cancel"><i class="bi bi-arrow-left"></i> Cancel</a>
        <button type="submit" class="btn-save"><i class="bi {{ $folder ? 'bi-check-lg' : 'bi-plus-lg' }}"></i> {{ $folder ? 'Update Folder' : 'Create Folder' }}</button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const categoryInput = document.getElementById('category');
    const accessionWrap = document.getElementById('accession_number_wrap');
    const accessionInput = document.getElementById('accession_number');
    const requiredMark = document.getElementById('accession_number_required_mark');

    if (!categoryInput || !accessionWrap || !accessionInput || !requiredMark) {
        return;
    }

    const syncAccessionField = function () {
        const requiresAccession = categoryInput.value === 'journal_newspaper';

        accessionWrap.hidden = !requiresAccession;
        accessionInput.required = requiresAccession;
        accessionInput.disabled = !requiresAccession;
        requiredMark.hidden = !requiresAccession;

        if (!requiresAccession) {
            accessionInput.classList.remove('is-invalid');
        }
    };

    categoryInput.addEventListener('change', syncAccessionField);
    syncAccessionField();
});
</script>
