@extends('layouts.admin')
@section('title', 'Deleted Borrowing Records')
@section('content')
<div class="deleted-page">
    <header class="deleted-hero"><div><small>CIRCULATION MANAGEMENT</small><h1>Deleted Records</h1><p>Review removed borrowing records or restore them with their original reference.</p></div><a class="btn btn-light" href="{{ route('admin.borrowings.index') }}">Back to Borrowings</a></header>
    @if(session('success'))<div class="alert alert-success" role="status">{{ session('success') }}</div>@endif
    @if($errors->any())<div class="alert alert-danger" role="alert"><ul class="mb-0">@foreach(array_unique($errors->all()) as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <section class="deleted-panel">
        <div class="deleted-toolbar"><div><h2>Deletion Log</h2><p>{{ $records->total() }} deleted records</p></div>
            <form id="purge-selected" method="POST" action="{{ route('admin.borrowings.purge') }}" onsubmit="return confirm('Permanently delete the selected records? They cannot be restored.');">@csrf @method('DELETE')<input type="hidden" name="scope" value="selected"><button class="btn btn-outline-danger" @disabled($records->isEmpty())>Delete Selected</button></form>
            <form method="POST" action="{{ route('admin.borrowings.purge') }}" onsubmit="return confirm('Permanently delete ALL records in this deletion log, including other pages? This cannot be undone.');">@csrf @method('DELETE')<input type="hidden" name="scope" value="all"><input type="hidden" name="before_id" value="{{ \App\Models\Borrowing::onlyTrashed()->max('id') }}"><button class="btn btn-danger" @disabled($records->total() === 0)>Delete All</button></form>
        </div>
        <div class="table-responsive"><table class="table align-middle mb-0"><thead><tr><th><input type="checkbox" aria-label="Select all records on this page" onclick="document.querySelectorAll('[name=&quot;ids[]&quot;]').forEach(box => box.checked = this.checked)"></th><th>Reference</th><th>Borrower</th><th>Book</th><th>Status</th><th>Deleted</th><th>Deleted by</th><th></th></tr></thead><tbody>
        @forelse($records as $record)<tr><td><input type="checkbox" name="ids[]" form="purge-selected" value="{{ $record->id }}" aria-label="Select reference {{ $record->id }}"></td><td>#{{ $record->id }}</td><td>{{ $record->borrower?->name }}<small class="d-block text-muted">{{ $record->borrower?->id_number }}</small></td><td>{{ $record->bibliographical_description }}</td><td>{{ ucfirst($record->status) }}</td><td>{{ $record->deleted_at->format('M d, Y H:i') }}</td><td>{{ $record->deletedBy?->name ?? 'Unavailable' }}</td><td><form method="POST" action="{{ route('admin.borrowings.restore', $record->id) }}">@csrf @method('PATCH')<button class="btn btn-outline-primary btn-sm">Restore</button></form></td></tr>
        @empty<tr><td colspan="8" class="text-center py-5 text-muted">No deleted borrowing records.</td></tr>@endforelse
        </tbody></table></div><div class="p-3">{{ $records->links() }}</div>
    </section>
</div>
@endsection
@push('styles')
<style>
.deleted-page{max-width:1600px;margin:auto;padding:28px 34px;color:#0b315e}.deleted-hero{display:flex;align-items:center;justify-content:space-between;gap:20px;padding:30px;background:linear-gradient(115deg,#0d3b72,#365f7b);color:white;border-radius:24px;margin-bottom:22px}.deleted-hero small{color:#ffbd00;font-weight:800;letter-spacing:.08em}.deleted-hero h1{font-size:30px;font-weight:800;margin:8px 0}.deleted-hero p{margin:0;font-size:13px}.deleted-panel{border:1px solid #dfe7ef;background:white;border-radius:20px;overflow:hidden}.deleted-toolbar{padding:24px;display:flex;align-items:center;gap:12px;flex-wrap:wrap}.deleted-toolbar>div{margin-right:auto}.deleted-toolbar h2{font-size:20px;font-weight:800;margin:0}.deleted-toolbar p{font-size:12px;color:#728399;margin:4px 0 0}.deleted-panel th{background:#f6f9fc;color:#728399;font-size:10px;text-transform:uppercase;padding:14px}.deleted-panel td{font-size:12px;padding:14px;max-width:300px;overflow-wrap:anywhere}.deleted-panel .btn{font-size:12px;border-radius:9px}.deleted-panel table{min-width:900px}@media(max-width:767px){.deleted-page{padding:18px 12px}.deleted-hero{align-items:flex-start;flex-direction:column;padding:24px}.deleted-toolbar{padding:18px}}
</style>
@endpush
