@extends('layouts.admin')

@section('title', 'Library Updates')
@section('page-title', 'Library Updates')

@section('content')
<div class="container-fluid library-updates-page">
    <section class="updates-hero">
        <div class="hero-copy">
            <span class="hero-icon">
                <i class="bi bi-megaphone-fill"></i>
            </span>

            <div>
                <span class="hero-eyebrow">Website Content</span>
                <h2>Library Updates</h2>
                <p>Manage the slideshow shown on the home page.</p>
            </div>
        </div>

        <a href="{{ route('admin.library-updates.create') }}" class="btn-add-update">
            <i class="bi bi-plus-lg"></i>
            Add Update
        </a>
    </section>

    <section class="updates-panel">
        <div class="panel-toolbar">
            <div class="toolbar-title">
                <h5>Update Records</h5>
                <p>{{ $updates->total() }} {{ \Illuminate\Support\Str::plural('slide', $updates->total()) }} found</p>
            </div>

            <form method="GET" action="{{ route('admin.library-updates.index') }}" class="filter-form">
                <div class="search-field">
                    <i class="bi bi-search"></i>
                    <input type="search" name="search" value="{{ request('search') }}" placeholder="Search updates..." aria-label="Search updates">
                </div>

                <button type="submit" class="filter-button">
                    <i class="bi bi-funnel"></i>
                    Filter
                </button>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table updates-table align-middle mb-0">
                <thead>
                    <tr>
                        <th class="number-column">#</th>
                        <th>Update</th>
                        <th class="text-center">Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($updates as $update)
                        <tr>
                            <td class="row-number">{{ ($updates->firstItem() ?? 1) + $loop->index }}</td>
                            <td>
                                <div class="update-identity">
                                    <img src="{{ $update->image_url }}" alt="{{ $update->title }}" onerror="this.onerror=null;this.src='{{ asset('images/image-fallback.svg') }}';">
                                    <div>
                                        <strong>{{ $update->title }}</strong>
                                        <span>{{ \Illuminate\Support\Str::limit($update->description ?? 'No description provided.', 72) }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="status-badge {{ $update->status ? 'active' : 'hidden' }}">
                                    <span></span>{{ $update->status ? 'Active' : 'Hidden' }}
                                </span>
                            </td>
                            <td>
                                <div class="table-actions justify-content-end">
                                    <a href="{{ route('admin.library-updates.edit', $update) }}" class="action-button edit" title="Edit {{ $update->title }}">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.library-updates.destroy', $update) }}" method="POST" onsubmit="return confirm('Delete this library update?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-button delete" title="Delete {{ $update->title }}">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <div class="empty-state">
                                    <span><i class="bi bi-image"></i></span>
                                    <h5>No library updates found</h5>
                                    <p>Add your first update slide for the homepage.</p>
                                    <a href="{{ route('admin.library-updates.create') }}"><i class="bi bi-plus-lg"></i> Add Update</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($updates->hasPages())
            <div class="panel-footer">
                <p>Showing {{ $updates->firstItem() }}–{{ $updates->lastItem() }} of {{ $updates->total() }}</p>
                <div>{{ $updates->withQueryString()->links() }}</div>
            </div>
        @endif
    </section>
</div>
@endsection

@push('styles')
<style>
.library-updates-page{padding:24px}
.updates-hero{display:flex;align-items:center;justify-content:space-between;gap:24px;padding:28px 30px;border-radius:22px;color:#fff;background:linear-gradient(125deg,#0b2e59,#184b8c);box-shadow:0 16px 36px rgba(11,46,89,.16);margin-bottom:22px}
.hero-copy{display:flex;align-items:center;gap:18px}
.hero-icon{width:62px;height:62px;display:grid;place-items:center;border-radius:18px;background:#f4b400;color:#0b2e59;font-size:27px}
.hero-eyebrow{display:block;margin-bottom:4px;color:#ffd96d;font-size:10px;font-weight:800;letter-spacing:.14em;text-transform:uppercase}
.updates-hero h2{margin:0 0 5px;font-size:clamp(24px,3vw,32px);font-weight:800}
.updates-hero p{margin:0;color:rgba(255,255,255,.72);font-size:12px}
.btn-add-update{min-height:46px;padding:0 18px;display:inline-flex;align-items:center;justify-content:center;gap:9px;border-radius:12px;background:#f4b400;color:#0b2e59;font-size:12px;font-weight:800;text-decoration:none}
.updates-panel{overflow:hidden;border:1px solid #e4eaf1;border-radius:20px;background:#fff;box-shadow:0 12px 30px rgba(25,50,80,.07)}
.panel-toolbar{padding:20px 22px;display:flex;align-items:center;justify-content:space-between;gap:20px;border-bottom:1px solid #e4eaf1}
.toolbar-title h5{margin:0 0 3px;color:#0b2e59;font-size:16px;font-weight:800}
.toolbar-title p{margin:0;color:#778599;font-size:10px}
.filter-form{display:flex;gap:7px}
.search-field{position:relative;width:min(100%,290px)}
.search-field i{position:absolute;top:50%;left:13px;transform:translateY(-50%);color:#95a1b1}
.search-field input{width:100%;height:41px;padding:0 13px 0 38px;border:1px solid #e4eaf1;border-radius:10px;font-size:11px}
.filter-button{height:41px;padding:0 16px;border:0;border-radius:10px;background:#f4b400;color:#0b2e59;font-size:11px;font-weight:800;display:inline-flex;align-items:center;gap:8px}
.updates-table thead th{padding:17px 18px;color:#667085;background:#f8fafc;border-bottom:1px solid #e4eaf1;font-size:.75rem;font-weight:800;letter-spacing:.5px;text-transform:uppercase}
.updates-table tbody td{padding:18px;border-color:#edf0f4;vertical-align:middle}
.update-identity{display:flex;align-items:center;gap:14px}
.update-identity img{width:56px;height:56px;object-fit:cover;border-radius:14px;background:#edf4fb}
.update-identity strong{display:block;color:#1d2939;font-weight:800}
.update-identity span{display:block;color:#667085;font-size:.8rem}
.status-badge{display:inline-flex;align-items:center;gap:6px;padding:6px 11px;border-radius:999px;font-size:.7rem;font-weight:800}
.status-badge.active{color:#067647;background:#ecfdf3}
.status-badge.hidden{color:#6941c6;background:#f4f3ff}
.status-badge span{width:8px;height:8px;border-radius:50%;background:currentColor}
.table-actions{display:flex;align-items:center;gap:8px}
.action-button{width:38px;height:38px;border:0;border-radius:10px;display:inline-flex;align-items:center;justify-content:center;text-decoration:none}
.action-button.edit{background:#edf4fb;color:#0b2e59}
.action-button.delete{background:#fef3f2;color:#b42318}
.empty-state{padding:70px 20px;text-align:center}
.empty-state>span{width:78px;height:78px;margin:0 auto 15px;display:grid;place-items:center;border-radius:24px;color:#cbd5e1;background:#f8fafc;font-size:2rem}
.empty-state h5{margin:0 0 8px;color:#344054;font-size:1.35rem;font-weight:800}
.empty-state p{margin:0 0 18px;color:#98a2b3}
.empty-state a{min-height:42px;padding:0 18px;display:inline-flex;align-items:center;gap:8px;border-radius:12px;background:#0b2e59;color:#fff;font-size:12px;font-weight:800;text-decoration:none}
.panel-footer{padding:18px 22px 22px;display:flex;align-items:center;justify-content:space-between;gap:16px;border-top:1px solid #e4eaf1}
.panel-footer p{margin:0;color:#778599;font-size:11px}
@media (max-width: 991.98px){.updates-hero,.panel-toolbar,.filter-form{flex-direction:column;align-items:stretch}.search-field,.filter-button,.btn-add-update{width:100%}}
@media (max-width: 767.98px){.library-updates-page{padding:18px}.updates-hero{padding:22px}.updates-panel{border-radius:18px}.panel-toolbar{padding:18px}.panel-footer{padding:16px 18px 18px;flex-direction:column;align-items:flex-start}.update-identity{min-width:unset}}
</style>
@endpush
