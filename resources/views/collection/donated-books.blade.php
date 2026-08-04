@extends('layouts.app')

@section('title', 'Donated Books | MMACI Library Services Office')

@section('content')
<section class="donated-books-hero">
    <div class="container">
        <div class="donated-books-hero-content">
            <h1>Donated Books</h1>
            <p>Browse donated books added to the library collection.</p>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item">Collection</li>
                    <li class="breadcrumb-item active" aria-current="page">Donated Books</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<section class="donated-books-intro">
    <div class="container">
        <div class="section-heading text-center mx-auto">
            <span class="eyebrow justify-content-center">Special Collection</span>
            <h2>Recently donated books for the community</h2>
            <p>
                These books have been donated to support learning and reading
                across the MMACI community.
            </p>
        </div>
    </div>
</section>

<section class="donated-books-grid">
    <div class="container">
        <div class="row g-4">
            @forelse($books as $book)
                <div class="col-xl-4 col-md-6">
                    <article class="donated-book-card modern-card h-100">
                        <div class="donated-book-image">
                            <img src="{{ $book->image_url }}" alt="{{ $book->title }}" loading="lazy" onerror="this.onerror=null;this.src='{{ asset('images/readingarea.jpg') }}';">
                        </div>
                        <div class="donated-book-body">
                            <h3>{{ $book->title }}</h3>
                            <p>{{ $book->description ?: 'A donated book available in the library collection.' }}</p>
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state text-center py-5">
                        <h3 class="section-title">No donated books available yet</h3>
                        <p class="section-description mb-0">Once donated books are added in the admin panel, they will appear here.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.donated-books-hero{position:relative;overflow:hidden;padding:110px 0 90px;color:#fff;background:radial-gradient(circle at 85% 20%, rgba(244,180,0,.24), transparent 28%),linear-gradient(135deg,var(--mmaci-navy),var(--mmaci-blue))}
.donated-books-hero::after{content:"";position:absolute;inset:0;background-image:radial-gradient(rgba(255,255,255,.13) 1px,transparent 1px);background-size:24px 24px;opacity:.45}
.donated-books-hero .container{position:relative;z-index:1}
.donated-books-hero-content{text-align:center}
.donated-books-hero h1{font-size:clamp(42px,6vw,66px);font-weight:800;letter-spacing:-.04em}
.donated-books-hero p{max-width:760px;margin:16px auto 0;color:rgba(255,255,255,.82);line-height:1.8}
.donated-books-intro{padding:80px 0 40px;background:var(--mmaci-light)}
.donated-books-grid{padding:0 0 90px;background:var(--mmaci-light)}
.donated-book-card{overflow:hidden;border-radius:20px;background:#fff}
.donated-book-image{height:260px;background:#e8eef6}
.donated-book-image img{width:100%;height:100%;object-fit:cover}
.donated-book-body{padding:24px}
.donated-book-body h3{margin:0 0 12px;color:var(--mmaci-navy);font-size:24px;font-weight:800;line-height:1.2}
.donated-book-body p{margin:0;color:var(--mmaci-muted);line-height:1.8}
@media (max-width: 767.98px){.donated-books-hero{padding:90px 0 70px}.donated-books-intro,.donated-books-grid{padding-left:0;padding-right:0}}
</style>
@endpush
