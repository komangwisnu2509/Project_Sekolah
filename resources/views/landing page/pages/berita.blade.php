@extends('layouts.landing')

@section('content')
<!-- Hero Header Section -->
<section class="page-hero py-5 text-white position-relative overflow-hidden" style="background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 50%, #1e1b4b 100%); margin-top: 70px;">
    <div class="container py-4 position-relative z-1" data-aos="fade-up">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <span class="badge bg-warning text-dark font-weight-bold px-3 py-2 rounded-pill mb-3 text-uppercase shadow-sm">
                    <i class="bi bi-newspaper me-1"></i> Portal Berita & Informasi Resmi
                </span>
                <h1 class="fw-extrabold text-white display-5 mb-2">Berita & Kabar Terbaru Sekolah</h1>
                <p class="lead text-light opacity-90 mb-0">
                    Dapatkan kabar terkini seputar prestasi, kegiatan akademik, inovasi penyiaran ASDHA TV, dan pengumuman resmi Utama Widyalaya Astika Dharma.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('landing_page') }}" class="btn btn-outline-light rounded-pill px-4 fw-bold">
                    &larr; Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Filter & Search Section -->
<section class="py-4 bg-light border-bottom">
    <div class="container">
        <form action="{{ route('berita') }}" method="GET" class="row g-3 align-items-center">
            <div class="col-md-6 col-lg-5">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" name="q" class="form-control border-start-0 ps-0" placeholder="Cari judul berita, topik, atau kata kunci..." value="{{ request('q') }}">
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <select name="kategori" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Semua Kategori Berita --</option>
                    @foreach($kategoris as $kat)
                        <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 col-lg-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary fw-bold rounded-3 px-4 w-100"><i class="bi bi-filter me-1"></i> Filter</button>
                @if(request('q') || request('kategori'))
                    <a href="{{ route('berita') }}" class="btn btn-outline-secondary rounded-3 px-3">Reset</a>
                @endif
            </div>
        </form>
    </div>
</section>

<!-- Berita List Grid -->
<section class="py-5 bg-white">
    <div class="container">
        @if(isset($beritaHighlight) && !request('q') && !request('kategori'))
            <!-- Featured Highlight News -->
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-5 hover-card transition-all">
                <div class="row g-0">
                    <div class="col-lg-7 position-relative overflow-hidden" style="min-height: 340px;">
                        @if($beritaHighlight->foto)
                            <img src="{{ str_starts_with($beritaHighlight->foto, 'http') ? $beritaHighlight->foto : asset('storage/'.$beritaHighlight->foto) }}" class="w-100 h-100 object-fit-cover" alt="{{ $beritaHighlight->judul }}">
                        @else
                            <div class="w-100 h-100 bg-dark bg-gradient d-flex align-items-center justify-content-center text-white-50">
                                <i class="bi bi-newspaper fs-1"></i>
                            </div>
                        @endif
                        <span class="position-absolute top-0 start-0 m-3 badge bg-danger text-white px-3 py-2 rounded-pill font-semibold shadow">
                            ⭐ BERITA UTAMA / HIGHLIGHT
                        </span>
                    </div>
                    <div class="col-lg-5 p-4 p-lg-5 d-flex flex-column justify-content-between bg-dark text-white">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <span class="badge bg-warning text-dark fw-bold px-3 py-1 rounded-pill">{{ $beritaHighlight->kategori ?? 'Berita Sekolah' }}</span>
                                <small class="text-white-50"><i class="bi bi-calendar3 me-1"></i> {{ \Carbon\Carbon::parse($beritaHighlight->tanggal_publikasi)->translatedFormat('d F Y') }}</small>
                            </div>
                            <h3 class="fw-bold text-white mb-3 hover-primary">
                                <a href="{{ route('berita.detail', $beritaHighlight->id) }}" class="text-white text-decoration-none">
                                    {{ $beritaHighlight->judul }}
                                </a>
                            </h3>
                            <p class="text-light opacity-80 mb-4 line-clamp-3">
                                {{ $beritaHighlight->ringkasan ?: Str::limit(strip_tags($beritaHighlight->konten), 160) }}
                            </p>
                        </div>
                        <div>
                            <a href="{{ route('berita.detail', $beritaHighlight->id) }}" class="btn btn-warning text-dark fw-bold rounded-pill px-4 py-2 shadow-sm">
                                Baca Selengkapnya &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <h4 class="fw-bold text-dark mb-4 border-start border-4 border-primary ps-3">
            <i class="bi bi-grid-fill text-primary me-2"></i>Daftar Berita Terbaru ({{ count($beritas) }})
        </h4>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @forelse($beritas as $b)
                <div class="col" data-aos="fade-up">
                    <div class="card h-100 border border-light-subtle shadow-sm rounded-4 overflow-hidden hover-card transition-all bg-white">
                        <div class="position-relative overflow-hidden" style="height: 220px; background-color: #f1f5f9;">
                            @if($b->foto)
                                <img src="{{ str_starts_with($b->foto, 'http') ? $b->foto : asset('storage/'.$b->foto) }}" class="w-100 h-100 object-fit-cover transition-transform" alt="{{ $b->judul }}">
                            @else
                                <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary fw-bold fs-1">
                                    <i class="bi bi-newspaper"></i>
                                </div>
                            @endif
                            <span class="position-absolute top-0 start-0 m-3 badge bg-primary text-white px-3 py-1.5 rounded-pill font-semibold shadow-sm">
                                {{ $b->kategori ?? 'Berita' }}
                            </span>
                        </div>
                        <div class="card-body p-4 d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex align-items-center text-muted small mb-2 gap-3">
                                    <span><i class="bi bi-calendar3 me-1 text-primary"></i> {{ \Carbon\Carbon::parse($b->tanggal_publikasi)->translatedFormat('d M Y') }}</span>
                                    <span><i class="bi bi-person-circle me-1 text-primary"></i> {{ $b->penulis ?? 'Humas ASDHA' }}</span>
                                </div>
                                <h5 class="fw-bold text-dark mb-2 line-clamp-2 hover-primary">
                                    <a href="{{ route('berita.detail', $b->id) }}" class="text-dark text-decoration-none">
                                        {{ $b->judul }}
                                    </a>
                                </h5>
                                <p class="text-secondary small mb-2 line-clamp-3">
                                    {{ $b->ringkasan ?: Str::limit(strip_tags($b->konten), 120) }}
                                </p>
                                @if(!empty($b->tags))
                                    @php
                                        $tagsPreview = array_slice(array_filter(array_map('trim', explode(';', $b->tags))), 0, 3);
                                    @endphp
                                    @if(count($tagsPreview) > 0)
                                        <div class="d-flex flex-wrap gap-1 mb-2">
                                            @foreach($tagsPreview as $tPrev)
                                                <span class="badge bg-light text-dark border px-2 py-1 small rounded-pill fw-normal" style="font-size: 0.72rem;">#{{ ltrim($tPrev, '#') }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                @endif
                            </div>
                            <div class="pt-3 border-top d-flex justify-content-between align-items-center">
                                <a href="{{ route('berita.detail', $b->id) }}" class="fw-bold text-primary text-decoration-none small">
                                    Baca Selengkapnya <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5 text-muted">
                    <i class="bi bi-newspaper fs-1 d-block mb-2 text-secondary"></i>
                    Belum ada berita yang diterbitkan untuk kategori atau pencarian ini.
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
