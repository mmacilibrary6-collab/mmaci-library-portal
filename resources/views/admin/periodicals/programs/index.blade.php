@extends('layouts.admin')
@section('title', 'Periodical Programs')
@section('page-title', 'Periodical Programs')
@section('content')
<div class="container-fluid donated-books-page">
    <section class="programs-hero">
        <div class="hero-copy">
            <span class="hero-icon"><i class="bi bi-newspaper"></i></span>
            <div>
                <span class="hero-eyebrow">Collection Management</span>
                <h2>Periodical Programs</h2>
                <p>Organize the program groups shown in the public periodical collection.</p>
            </div>
        </div>
        <a href="{{ route('admin.periodical-programs.create') }}" class="btn-add-program"><i class="bi bi-plus-lg"></i><span>Add Program</span></a>
    </section>
    @include('partials.flash-messages')
    <section class="programs-panel">
        <div class="panel-toolbar"><div><h5>Program List</h5><p>{{ $programs->total() }} {{ \Illuminate\Support\Str::plural('program', $programs->total()) }} found</p></div></div>
        <div class="table-responsive">
            <table class="table programs-table align-middle mb-0">
                <thead><tr><th class="number-column">#</th><th>Program</th><th>Description</th><th class="text-center">Status</th><th class="text-end">Actions</th></tr></thead>
                <tbody>
                @forelse($programs as $program)
                    <tr>
                        <td class="row-number">{{ ($programs->firstItem() ?? 1) + $loop->index }}</td>
                        <td><div class="program-identity"><div class="program-thumbnail"><img src="{{ $program->image_url }}" alt="{{ $program->title }}" onerror="this.onerror=null;this.src='{{ asset('images/readingarea.jpg') }}';"></div><div><strong>{{ $program->title }}</strong><small>Periodical program</small></div></div></td>
                        <td class="description-cell">{{ \Illuminate\Support\Str::limit($program->description ?: 'No description provided.', 85) }}</td>
                        <td class="text-center"><span class="status-badge {{ (int) $program->status === 1 ? 'active' : 'hidden' }}"><span></span>{{ (int) $program->status === 1 ? 'Active' : 'Hidden' }}</span></td>
                        <td><div class="table-actions"><a href="{{ route('admin.periodical-programs.edit', $program) }}" class="action-button edit"><i class="bi bi-pencil"></i></a><form action="{{ route('admin.periodical-programs.destroy', $program) }}" method="POST" onsubmit="return confirm('Delete this program?');">@csrf @method('DELETE')<button type="submit" class="action-button delete"><i class="bi bi-trash3"></i></button></form></div></td>
                    </tr>
                @empty
                    <tr><td colspan="5"><div class="empty-state"><span><i class="bi bi-newspaper"></i></span><h5>No programs found</h5><p>Add your first periodical program to get started.</p><a href="{{ route('admin.periodical-programs.create') }}">Add Program</a></div></td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection

@push('styles')
    @include('admin.periodicals._styles')
@endpush
