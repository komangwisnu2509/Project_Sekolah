@extends('layouts.landing')

@section('content')
<!-- Hero Header Section -->
<section class="page-hero py-5 text-white position-relative overflow-hidden" style="background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 50%, #1e1b4b 100%); margin-top: 70px;">
    <div class="container py-3 position-relative z-1" data-aos="fade-up">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('landing_page') }}" class="text-white-50 text-decoration-none">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('berita') }}" class="text-white-50 text-decoration-none">Berita</a></li>
                <li class="breadcrumb-item active text-warning" aria-current="page">{{ Str::limit($berita->judul, 40) }}</li>
            </ol>
        </nav>
        <div class="d-flex align-items-center gap-2 mb-2">
            <span class="badge bg-warning text-dark fw-bold px-3 py-1.5 rounded-pill">{{ $berita->kategori ?? 'Berita Sekolah' }}</span>
            <span class="text-white-50 small"><i class="bi bi-calendar3 me-1"></i> {{ \Carbon\Carbon::parse($berita->tanggal_publikasi)->translatedFormat('d F Y') }}</span>
        </div>
        <h1 class="fw-extrabold text-white display-5 mb-2" style="max-width: 900px; line-height: 1.25;">
            {{ $berita->judul }}
        </h1>
        <div class="d-flex align-items-center gap-3 text-white-50 small">
            <span><i class="bi bi-person-fill text-warning me-1"></i> Ditulis oleh: <strong>{{ $berita->penulis ?? 'Humas Utama Widyalaya Astika Dharma' }}</strong></span>
        </div>
    </div>
</section>

<!-- Main Article Content Section -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="row g-5">
            <!-- Left Main Article -->
            <div class="col-lg-8" data-aos="fade-up">
                <!-- Article Featured Image -->
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-4">
                    @if($berita->foto)
                        <img src="{{ str_starts_with($berita->foto, 'http') ? $berita->foto : asset('storage/'.$berita->foto) }}" class="w-100 object-fit-cover" style="max-height: 480px;" alt="{{ $berita->judul }}">
                    @else
                        <div class="w-100 bg-dark text-white-50 p-5 text-center" style="height: 320px;">
                            <i class="bi bi-newspaper fs-1 d-block mb-2"></i>
                            Dokumentasi Berita Utama Widyalaya Astika Dharma
                        </div>
                    @endif
                </div>

                <!-- Article Summary Callout if available -->
                @if($berita->ringkasan)
                    <div class="p-4 bg-light rounded-4 border-start border-4 border-primary mb-4 shadow-sm">
                        <p class="fw-semibold text-dark fs-5 mb-0" style="line-height: 1.6;">
                            "{{ $berita->ringkasan }}"
                        </p>
                    </div>
                @endif

                <!-- Main Content Text -->
                <div class="article-content text-dark fs-5 mb-4" style="line-height: 1.8; color: #334155 !important;">
                    {!! nl2br(e($berita->konten)) !!}
                </div>

                <!-- TAGS / HASHTAGS SECTION (FORMAT MATCHING SCREENSHOT) -->
                @if(!empty($berita->tags))
                    @php
                        $tagArray = array_filter(array_map('trim', explode(';', $berita->tags)));
                    @endphp
                    @if(count($tagArray) > 0)
                        <div class="my-4 pt-3 border-top">
                            <h6 class="fw-extrabold text-uppercase text-dark tracking-wider mb-3" style="font-size: 1rem; font-weight: 800; letter-spacing: 0.5px;">TAGS :</h6>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($tagArray as $tagItem)
                                    @php
                                        $cleanTag = ltrim($tagItem, '#');
                                    @endphp
                                    <a href="{{ route('berita', ['q' => $cleanTag]) }}" class="btn btn-outline-dark btn-sm rounded-pill px-3.5 py-1.5 fw-semibold text-decoration-none shadow-none hover-bg-primary" style="border: 1.5px solid #475569; color: #1e293b; background-color: #ffffff; font-size: 0.95rem; border-radius: 50px;">
                                        {{ $cleanTag }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endif

                <!-- Article Share & Action Buttons -->
                <div class="pt-4 border-top d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="d-flex align-items-center gap-2">
                        <span class="fw-bold text-muted me-2"><i class="bi bi-share-fill me-1"></i> Bagikan Berita:</span>
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($berita->judul . ' - ' . url()->current()) }}" target="_blank" class="btn btn-success btn-sm rounded-circle p-2 shadow-sm" style="width: 38px; height: 38px;" title="Bagikan ke WhatsApp">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="btn btn-primary btn-sm rounded-circle p-2 shadow-sm" style="width: 38px; height: 38px;" title="Bagikan ke Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <button onclick="navigator.clipboard.writeText(window.location.href); alert('Link berita telah disalin!')" class="btn btn-secondary btn-sm rounded-circle p-2 shadow-sm" style="width: 38px; height: 38px;" title="Salin Link Berita">
                            <i class="bi bi-link-45deg fs-6"></i>
                        </button>
                    </div>
                    <a href="{{ route('berita') }}" class="btn btn-outline-primary fw-bold rounded-pill px-4">
                        &larr; Lihat Berita Lainnya
                    </a>
                </div>
            </div>

            <!-- Right Sidebar: Recent News -->
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-light mb-4 position-sticky" style="top: 100px;">
                    <h5 class="fw-bold text-dark mb-4 border-start border-4 border-primary ps-3">
                        <i class="bi bi-newspaper text-primary me-2"></i>Berita Terkait & Lainnya
                    </h5>

                    <div class="d-flex flex-column gap-3">
                        @forelse($beritaLainnya as $bl)
                            <a href="{{ route('berita.detail', $bl->id) }}" class="card border-0 shadow-sm rounded-3 overflow-hidden text-decoration-none hover-card bg-white p-2">
                                <div class="row g-2 align-items-center">
                                    <div class="col-4">
                                        @if($bl->foto)
                                            <img src="{{ str_starts_with($bl->foto, 'http') ? $bl->foto : asset('storage/'.$bl->foto) }}" class="rounded-3 w-100 object-fit-cover" style="height: 70px;" alt="{{ $bl->judul }}">
                                        @else
                                            <div class="bg-secondary text-white rounded-3 d-flex align-items-center justify-content-center" style="height: 70px;">
                                                <i class="bi bi-newspaper"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-8">
                                        <span class="badge bg-primary bg-opacity-10 text-primary small px-2 py-0.5 rounded-pill mb-1" style="font-size: 0.7rem;">{{ $bl->kategori ?? 'Berita' }}</span>
                                        <h6 class="fw-bold text-dark mb-1 line-clamp-2 small hover-primary" style="line-height: 1.3;">
                                            {{ $bl->judul }}
                                        </h6>
                                        <small class="text-muted" style="font-size: 0.72rem;">
                                            <i class="bi bi-calendar3 me-1"></i> {{ \Carbon\Carbon::parse($bl->tanggal_publikasi)->translatedFormat('d M Y') }}
                                        </small>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <p class="text-muted small">Belum ada berita lainnya.</p>
                        @endforelse
                    </div>

                    <div class="mt-4 pt-3 border-top text-center">
                        <a href="{{ route('berita') }}" class="btn btn-primary btn-sm rounded-pill px-4 w-100 fw-bold">
                            Lihat Semua Portal Berita &rarr;
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
