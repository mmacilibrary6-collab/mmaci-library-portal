<div class="modal fade borrowing-export-modal" id="borrowing-export-modal" tabindex="-1" aria-labelledby="borrowing-export-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <form class="modal-content" method="GET" action="{{ route('admin.borrowings.export') }}">
            <div class="modal-header">
                <div class="borrowing-export-heading"><span><i class="bi bi-file-earmark-excel" aria-hidden="true"></i></span><div><h2 id="borrowing-export-title">Export to Excel</h2><small>Borrowing Management</small></div></div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="export-list" class="form-label">Master List</label>
                    <select id="export-list" name="list" class="form-select"><option value="borrowings">Borrowing records</option><option value="borrowers">Borrowers only (one row per borrower)</option></select>
                </div>
                <div class="row g-3">
                    <div class="col-sm-6"><label for="export-status" class="form-label">Status</label><select id="export-status" name="status" class="form-select"><option value="">All statuses</option>@foreach(['pending', 'approved', 'borrowed', 'overdue', 'returned', 'rejected'] as $status)<option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>@endforeach</select></div>
                    <div class="col-sm-6"><label for="export-type" class="form-label">Borrower Type</label><select id="export-type" name="borrower_type" class="form-select"><option value="">All borrowers</option><option value="student" @selected(request('borrower_type') === 'student')>Student</option><option value="faculty" @selected(request('borrower_type') === 'faculty')>Faculty</option><option value="other" @selected(request('borrower_type') === 'other')>Other / Specify</option></select></div>
                    <div class="col-12"><label for="export-search" class="form-label">Search <span class="text-muted fw-normal">(optional)</span></label><input id="export-search" name="search" class="form-control" maxlength="255" value="{{ request('search') }}" placeholder="Borrower, ID, accession or book"></div>
                </div>
            </div>
            <div class="modal-footer"><button type="button" class="borrowing-export-reset" onclick="this.form.querySelectorAll('input').forEach(input => input.value = ''); this.form.querySelectorAll('select:not([name=list])').forEach(select => select.value = '');">Clear filters</button><button type="submit" class="borrowing-export-download"><i class="bi bi-download" aria-hidden="true"></i> Download Excel</button></div>
        </form>
    </div>
</div>
@push('styles')
<style>
.borrowing-export-button{position:relative;z-index:1;flex-shrink:0;margin-left:auto;display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:11px 16px;border:1px solid rgba(255,255,255,.5);border-radius:10px;background:rgba(255,255,255,.1);color:#fff;font-size:12px;font-weight:800;white-space:nowrap}
.borrowing-export-button:hover{background:rgba(255,255,255,.2)}
.borrowing-export-modal .modal-content{border:1px solid #dfe7f0;border-radius:20px;overflow:hidden;box-shadow:0 20px 60px rgba(11,46,89,.2)}
.borrowing-export-modal .modal-header{padding:24px;background:#f7f9fc;border-bottom:1px solid #e6edf5;gap:15px}
.borrowing-export-heading{display:flex;align-items:center;gap:12px}
.borrowing-export-heading>span{display:grid;place-items:center;width:44px;height:44px;border-radius:12px;background:#f4b400;color:#0b2e59;font-size:21px}
.borrowing-export-heading h2{margin:0;color:#0b2e59;font-size:20px;font-weight:800}
.borrowing-export-heading small{color:#728399;font-size:12px}
.borrowing-export-modal .modal-body{padding:24px}
.borrowing-export-modal .form-label{font-size:12px;font-weight:700;color:#18385f}
.borrowing-export-modal .form-control,.borrowing-export-modal .form-select{border-color:#d8e2ec;border-radius:11px;font-size:13px;min-height:46px;color:#18385f}
.borrowing-export-modal .modal-footer{padding:18px 24px;justify-content:space-between;background:#f7f9fc;border-top:1px solid #e6edf5}
.borrowing-export-reset{border:0;background:transparent;color:#184b8c;font-size:12px;font-weight:700}
.borrowing-export-download{display:inline-flex;gap:8px;align-items:center;border:0;border-radius:10px;padding:12px 17px;background:#0b315e;color:#fff;font-size:12px;font-weight:800}
.borrowing-export-download:hover{background:#184b8c}
.borrowing-admin-page .borrow-hero{gap:20px;flex-wrap:wrap}
@media(max-width:767.98px){.borrowing-export-button{margin-left:0}}
</style>
@endpush
