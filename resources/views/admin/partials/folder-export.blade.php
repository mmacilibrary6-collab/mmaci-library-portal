<div class="modal fade folder-export-modal" id="folder-export-modal" tabindex="-1" aria-labelledby="folder-export-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <form method="GET" action="{{ route('admin.folder-export', $collection) }}" class="modal-content">
            <div class="modal-header">
                <div class="export-heading">
                    <span class="export-icon"><i class="bi bi-file-earmark-excel" aria-hidden="true"></i></span>
                    <div><h2 id="folder-export-title">Export to Excel</h2><span>{{ \App\Support\FolderQuery::COLLECTIONS[$collection][3] }}</span></div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="export-field">
                    <label class="export-label" id="export-programs-label">Programs</label>
                    <details class="export-selector" data-export-selector data-default="All programs">
                        <summary aria-labelledby="export-programs-label"><span data-selection-label>All programs</span><i class="bi bi-chevron-down" aria-hidden="true"></i></summary>
                        <div class="export-options">
                            <button type="button" class="export-clear" data-clear-selection>All programs</button>
                            @forelse($programs as $program)
                                <label class="export-option">
                                    <input type="checkbox" name="programs[]" value="{{ $program->id }}" @checked(request('program') == $program->id)>
                                    <span>{{ $program->title }}</span>
                                </label>
                            @empty
                                <span class="export-empty">No programs available</span>
                            @endforelse
                        </div>
                    </details>
                </div>
                @if($collection === 'periodicals')
                    <div class="export-field">
                        <label class="export-label" id="export-categories-label">Categories</label>
                        <details class="export-selector" data-export-selector data-default="All categories">
                            <summary aria-labelledby="export-categories-label"><span data-selection-label>All categories</span><i class="bi bi-chevron-down" aria-hidden="true"></i></summary>
                            <div class="export-options">
                                <button type="button" class="export-clear" data-clear-selection>All categories</button>
                                @foreach(\App\Models\PeriodicalFolder::CATEGORIES as $key => $category)
                                    <label class="export-option">
                                        <input type="checkbox" name="categories[]" value="{{ $key }}" @checked(request('category') === $key)>
                                        <span>{{ $category['label'] }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </details>
                    </div>
                @endif
                <div class="export-field">
                    <label for="export-search" class="export-label">Search <span>(optional)</span></label>
                    <input id="export-search" name="search" class="export-search" maxlength="255" value="{{ request('search') }}" placeholder="Search folders or programs">
                </div>
            </div>
            <div class="modal-footer">
                <a class="export-all" href="{{ route('admin.folder-export', $collection) }}">Export All Folders</a>
                <button class="export-download" type="submit"><i class="bi bi-download" aria-hidden="true"></i> Download Excel</button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
.folder-header-actions{display:flex;align-items:center;gap:10px;flex-shrink:0;flex-wrap:wrap}
.folder-export-trigger{display:inline-flex;align-items:center;justify-content:center;gap:7px;padding:10px 16px;border:1px solid rgba(255,255,255,.5);border-radius:9px;background:rgba(255,255,255,.1);color:#fff;font-size:12px;font-weight:800;white-space:nowrap;min-height:40px}
.folder-export-trigger:hover{background:rgba(255,255,255,.2);border-color:#fff}
.folder-export-trigger:focus-visible{outline:3px solid #f4b400;outline-offset:3px}
.folder-export-modal .modal-content{border:1px solid #dfe7f0;border-radius:20px;box-shadow:0 20px 60px rgba(11,46,89,.2);overflow:hidden}
.folder-export-modal .modal-header{padding:24px;border-bottom:1px solid #e6edf5;background:#f7f9fc;gap:15px}
.export-heading{display:flex;align-items:center;gap:12px;min-width:0}
.export-icon{display:grid;place-items:center;flex:0 0 44px;height:44px;border-radius:12px;color:#0b2e59;background:#f4b400;font-size:21px}
.export-heading h2{margin:0 0 3px;color:#0b2e59;font-size:20px;font-weight:800}
.export-heading div>span{font-size:12px;color:#728399}
.folder-export-modal .modal-body{padding:24px}
.export-field+.export-field{margin-top:18px}
.export-label{display:block;margin-bottom:8px;font-size:12px;font-weight:700;color:#18385f}
.export-label span{font-weight:400;color:#8290a3}
.export-selector,.export-search{width:100%;border:1px solid #d8e2ec;border-radius:11px;background:#fff;color:#18385f;font-size:13px}
.export-selector summary{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:13px 14px;cursor:pointer;list-style:none}
.export-selector summary::-webkit-details-marker{display:none}
.export-selector summary>span{overflow-wrap:anywhere}
.export-selector summary i{font-size:11px;flex-shrink:0}
.export-selector[open] summary{border-bottom:1px solid #e6edf5}
.export-options{max-height:220px;overflow-y:auto;padding:6px}
.export-option{display:flex;align-items:flex-start;gap:10px;padding:10px 9px;border-radius:7px;cursor:pointer;font-size:12px;line-height:1.6;color:#18385f}
.export-option:hover{background:#f0f5fb}
.export-option:has(input:checked){background:#edf3fa}
.export-option input{margin-top:4px;accent-color:#184b8c;flex-shrink:0}
.export-clear{border:0;background:transparent;color:#184b8c;font-weight:700;font-size:12px;padding:10px 9px;text-align:left;width:100%;border-radius:7px}
.export-clear:hover{background:#f0f5fb}
.export-empty{display:block;padding:10px;color:#8290a3;font-size:12px}
.export-search{padding:13px 14px;outline:none}
.export-search:focus,.export-selector:focus-within{border-color:#7fa2c7;box-shadow:0 0 0 3px rgba(24,75,140,.08)}
.folder-export-modal .modal-footer{padding:18px 24px;justify-content:space-between;gap:12px;border-top:1px solid #e6edf5;background:#f7f9fc}
.export-all{font-size:12px;font-weight:700;color:#184b8c;text-decoration:none}
.export-all:hover{text-decoration:underline}
.export-download{display:inline-flex;align-items:center;justify-content:center;gap:8px;border:0;border-radius:10px;background:#0b315e;color:white;padding:12px 17px;font-size:12px;font-weight:800}
.export-download:hover{background:#184b8c}
@media(max-width:767.98px){.folder-header-actions{width:100%}.folder-header-actions>*{flex:1}.folder-page-header .folder-header-actions .add-folder-button{width:auto}.folder-export-modal .modal-header,.folder-export-modal .modal-body{padding:20px}.folder-export-modal .modal-footer{padding:16px 20px}}
</style>
@endpush

@push('scripts')
<script>
document.querySelectorAll('[data-export-selector]').forEach(function (selector) {
    const checkboxes = Array.from(selector.querySelectorAll('input[type="checkbox"]'));
    function updateSelection() {
        const checked = checkboxes.filter(input => input.checked);
        selector.querySelector('[data-selection-label]').textContent = checked.length === 0
            ? selector.dataset.default
            : checked.length === 1 ? checked[0].nextElementSibling.textContent.trim() : checked.length + ' selected';
    }
    selector.addEventListener('change', updateSelection);
    selector.querySelector('[data-clear-selection]').addEventListener('click', function () {
        checkboxes.forEach(input => input.checked = false);
        updateSelection();
        selector.open = false;
    });
    updateSelection();
});
</script>
@endpush
