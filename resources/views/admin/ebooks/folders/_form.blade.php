@php
    $folder = $ebookFolder ?? null;
    $isEditing = $folder !== null;

    $programId = old(
        'ebook_program_id',
        $folder?->ebook_program_id ?? ($selectedProgramId ?? '')
    );

    $status = (int) old('status', $folder?->status ?? 1);
@endphp

<div class="folder-form">
    <div class="form-section">
        <div class="section-heading">
            <span class="section-icon">
                <i class="bi bi-folder2-open"></i>
            </span>

            <div>
                <h5>Folder Information</h5>
                <p>Enter the basic details for this E-Book folder.</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-6">
                <label for="ebook_program_id" class="form-label">
                    Academic Program <span>*</span>
                </label>

                <select
                    name="ebook_program_id"
                    id="ebook_program_id"
                    class="form-select @error('ebook_program_id') is-invalid @enderror"
                    required>
                    <option value="" disabled @selected($programId === '')>
                        Choose an academic program
                    </option>

                    @foreach($programs as $program)
                        <option
                            value="{{ $program->id }}"
                            @selected((string) $programId === (string) $program->id)>
                            {{ $program->title }}
                        </option>
                    @endforeach
                </select>

                @error('ebook_program_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-lg-6">
                <label for="title" class="form-label">
                    Folder Name <span>*</span>
                </label>

                <input
                    type="text"
                    name="title"
                    id="title"
                    value="{{ old('title', $folder?->title) }}"
                    class="form-control @error('title') is-invalid @enderror"
                    placeholder="Example: First Semester"
                    required>

                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
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
                    placeholder="Briefly describe the resources inside this folder...">{{ old('description', $folder?->description) }}</textarea>

                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="form-section">
        <div class="section-heading">
            <span class="section-icon link-icon">
                <i class="bi bi-google"></i>
            </span>

            <div>
                <h5>Folder Access</h5>
                <p>Connect the folder to its Google Drive location.</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-10">
                <label for="drive_link" class="form-label">
                    Google Drive Folder Link <span>*</span>
                </label>

                <div class="input-with-icon">
                    <i class="bi bi-link-45deg"></i>
                    <input
                        type="url"
                        name="drive_link"
                        id="drive_link"
                        value="{{ old('drive_link', $folder?->drive_link) }}"
                        class="form-control @error('drive_link') is-invalid @enderror"
                        placeholder="https://drive.google.com/drive/folders/..."
                        required>
                </div>

                @error('drive_link')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @else
                    <div class="field-note">
                        <i class="bi bi-info-circle"></i>
                        Ensure the folder's sharing permission allows users to open it.
                    </div>
                @enderror
            </div>

            <div class="col-lg-2">
                <label for="status" class="form-label">Visibility</label>

                <select
                    name="status"
                    id="status"
                    class="form-select @error('status') is-invalid @enderror"
                    required>
                    <option value="1" @selected($status === 1)>Active</option>
                    <option value="0" @selected($status === 0)>Hidden</option>
                </select>

                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="form-actions">
        <a href="{{ route('admin.ebook-folders.index') }}" class="btn-cancel">
            <i class="bi bi-arrow-left"></i>
            Cancel
        </a>

        <button type="submit" class="btn-save">
            <i class="bi {{ $isEditing ? 'bi-check-lg' : 'bi-plus-lg' }}"></i>
            {{ $isEditing ? 'Update Folder' : 'Create Folder' }}
        </button>
    </div>
</div>

@once
    @push('styles')
        <style>
            .folder-form {
                --navy: #0b2e59;
                --blue: #184b8c;
                --gold: #f4b400;
                --text: #253851;
                --muted: #7c899b;
                --line: #e3e9f0;
            }

            .folder-form .form-section {
                margin-bottom: 18px;
                padding: 24px;
                border: 1px solid var(--line);
                border-radius: 18px;
                background: #fff;
                box-shadow: 0 8px 24px rgba(11, 46, 89, .05);
            }

            .folder-form .section-heading {
                margin-bottom: 22px;
                padding-bottom: 17px;
                display: flex;
                align-items: center;
                gap: 12px;
                border-bottom: 1px solid #edf1f5;
            }

            .folder-form .section-icon {
                width: 42px;
                height: 42px;
                flex: 0 0 42px;
                display: grid;
                place-items: center;
                border-radius: 12px;
                background: #eaf1f9;
                color: var(--blue);
                font-size: 18px;
            }

            .folder-form .section-icon.link-icon {
                background: #fff5d7;
                color: #b98500;
            }

            .folder-form .section-heading h5 {
                margin: 0 0 3px;
                color: var(--navy);
                font-size: 15px;
                font-weight: 800;
            }

            .folder-form .section-heading p {
                margin: 0;
                color: var(--muted);
                font-size: 11px;
            }

            .folder-form .form-label {
                margin-bottom: 8px;
                color: var(--text);
                font-size: 12px;
                font-weight: 700;
            }

            .folder-form .form-label > span {
                color: #d94b4b;
            }

            .folder-form .form-label small {
                margin-left: 4px;
                color: #9aa6b5;
                font-size: 9px;
                font-weight: 600;
                text-transform: uppercase;
            }

            .folder-form .form-control,
            .folder-form .form-select {
                min-height: 46px;
                padding: 10px 13px;
                border: 1px solid var(--line);
                border-radius: 11px;
                color: var(--text);
                font-size: 12px;
                box-shadow: none;
                transition: border-color .2s ease, box-shadow .2s ease;
            }

            .folder-form textarea.form-control {
                min-height: 110px;
                resize: vertical;
            }

            .folder-form .form-control:focus,
            .folder-form .form-select:focus {
                border-color: var(--blue);
                box-shadow: 0 0 0 3px rgba(24, 75, 140, .1);
            }

            .folder-form .form-control::placeholder {
                color: #adb6c2;
            }

            .folder-form .input-with-icon {
                position: relative;
            }

            .folder-form .input-with-icon > i {
                position: absolute;
                top: 50%;
                left: 14px;
                z-index: 2;
                color: #8e9bad;
                font-size: 18px;
                transform: translateY(-50%);
            }

            .folder-form .input-with-icon .form-control {
                padding-left: 42px;
            }

            .folder-form .field-note {
                margin-top: 8px;
                display: flex;
                align-items: center;
                gap: 6px;
                color: var(--muted);
                font-size: 10px;
            }

            .folder-form .invalid-feedback {
                margin-top: 6px;
                font-size: 10px;
            }

            .folder-form .form-actions {
                padding: 20px 4px 4px;
                display: flex;
                align-items: center;
                justify-content: flex-end;
                gap: 10px;
            }

            .folder-form .btn-cancel,
            .folder-form .btn-save {
                min-height: 44px;
                padding: 0 18px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                border-radius: 11px;
                font-size: 12px;
                font-weight: 750;
                text-decoration: none;
                transition: .2s ease;
            }

            .folder-form .btn-cancel {
                border: 1px solid var(--line);
                background: #fff;
                color: #66758a;
            }

            .folder-form .btn-save {
                border: 0;
                background: var(--navy);
                color: #fff;
                box-shadow: 0 8px 18px rgba(11, 46, 89, .18);
            }

            .folder-form .btn-cancel:hover {
                border-color: #cbd4df;
                color: var(--navy);
                background: #f8fafc;
            }

            .folder-form .btn-save:hover {
                background: var(--blue);
                color: #fff;
                transform: translateY(-1px);
            }

            @media (max-width: 575.98px) {
                .folder-form .form-section {
                    padding: 19px 16px;
                    border-radius: 15px;
                }

                .folder-form .form-actions {
                    align-items: stretch;
                    flex-direction: column-reverse;
                }

                .folder-form .btn-cancel,
                .folder-form .btn-save {
                    width: 100%;
                }
            }
        </style>
    @endpush
@endonce