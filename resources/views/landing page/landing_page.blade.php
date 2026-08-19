@extends('layouts.landing')

@section('content')
<!-- Hero -->
    <header class="hero" id="beranda">
        <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=2070&auto=format&fit=crop" alt="Sekolah Astika Dharma" class="hero-bg">
        <div class="hero-overlay"></div>
        <div class="hero-content" data-aos="fade-up" data-aos-duration="1000">
            <h1>MEMBENTUK GENERASI UNGGUL UNTUK MASA DEPAN</h1>
            <p>Pendidikan berkualitas untuk membangun karakter, kompetensi, dan kreativitas peserta didik. Mari mulai perjalanan prestasimu bersama Astika Dharma.</p>
            <div class="hero-btns">
                <a href="{{ route('register') }}" class="btn btn-primary">Daftar Sekarang</a>
                <a href="#profil" class="btn btn-outline">Jelajahi Sekolah</a>
            </div>
        </div>
    </header>

    <!-- Statistics -->
    <section class="container" style="position: relative;">
        <div class="stats" data-aos="fade-up" data-aos-delay="200" id="stats-section">
            <div class="stats-grid">
                <div class="stat-item">
                    <h3><span class="counter" data-target="{{ $siswaCount }}">0</span>+</h3>
                    <p>Siswa</p>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <h3><span class="counter" data-target="{{ $guruCount }}">0</span>+</h3>
                    <p>Guru & Staf</p>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <h3><span class="counter" data-target="{{ $alumniCount }}">0</span>+</h3>
                    <p>Alumni</p>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <h3><span class="counter" data-target="{{ $tahunDedikasi }}">0</span>+</h3>
                    <p>Tahun Dedikasi</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Tentang Sekolah -->
    <section class="about" id="profil">
        <div class="container about-grid">
            <div class="about-image" data-aos="fade-right" data-aos-duration="800">
                <img src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?q=80&w=2022&auto=format&fit=crop" alt="Tentang Astika Dharma">
            </div>
            <div class="about-text" data-aos="fade-left" data-aos-duration="800" data-aos-delay="200">
                <div class="about-badge">Tentang {{ $profil?->nama_sekolah ?? 'Astika Dharma' }}</div>
                <h2 class="section-title">Mengenal Lebih Dekat</h2>
                <p>{{ $profil?->visi ?? 'Sekolah Astika Dharma adalah lembaga pendidikan terkemuka yang berdedikasi untuk menciptakan lingkungan belajar yang inspiratif dan berpusat pada siswa.' }}</p>
                <p>{{ $profil?->misi ?? 'Dengan fasilitas modern dan tenaga pengajar yang berdedikasi, kami menyeimbangkan prestasi akademik dengan pembentukan karakter mulia.' }}</p>
                <a href="#" class="link-arrow">Selengkapnya <i data-lucide="arrow-right" size="18"></i></a>
            </div>
        </div>
    </section>

    <!-- Program Keahlian -->
    <section class="programs" id="program">
        <div class="container text-center">
            <h2 class="section-title" data-aos="fade-up">Program Keahlian</h2>
            <p class="section-subtitle mx-auto" data-aos="fade-up" data-aos-delay="100">Temukan bidang yang sesuai dengan minat dan masa depanmu. Kami menawarkan kurikulum unggul yang dirancang untuk kesuksesan industri.</p>
            
            <div class="programs-grid">
                @foreach($jurusans as $index => $jurusan)
                <div class="program-card" data-aos="fade-up" data-aos-delay="{{ 200 + ($index * 100) }}">
                    <div class="program-icon">
                        <i data-lucide="{{ ['monitor', 'briefcase', 'camera'][$index % 3] }}" size="28"></i>
                    </div>
                    <h3>{{ $jurusan->nama_jurusan }}</h3>
                    <p>{{ $jurusan->deskripsi ?? 'Pelajari skill unggulan dan kembangkan potensi diri untuk masa depan di industri terkait.' }}</p>
                    <a href="#" class="link-arrow">Lihat Kurikulum <i data-lucide="arrow-right" size="16"></i></a>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Fasilitas -->
    <section class="facilities bg-light" id="fasilitas">
        <div class="container">
            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2rem;" data-aos="fade-up">
                <div>
                    <h2 class="section-title" style="margin-bottom: 0;">Fasilitas Sekolah</h2>
                </div>
                <a href="#" class="link-arrow">Lihat Semua Fasilitas <i data-lucide="arrow-right" size="18"></i></a>
            </div>
            
            <div class="fac-grid">
                @foreach($fasilitas as $index => $fac)
                <div class="fac-item {{ $fac->is_large ? 'large' : '' }}" @if($index == 0) data-aos="zoom-in" data-aos-duration="800" @endif>
                    <img src="{{ $fac->foto }}" alt="{{ $fac->nama_fasilitas }}">
                    <div class="fac-overlay">
                        <div class="fac-content">
                            <h3>{{ $fac->nama_fasilitas }}</h3>
                            @if($fac->deskripsi)
                            <p>{{ $fac->deskripsi }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Ekstrakurikuler -->
    <section class="eksul" id="ekstrakurikuler">
        <div class="container">
            <h2 class="section-title" style="margin-bottom: 2rem;" data-aos="fade-up">Ekstrakurikuler</h2>
            <div class="eksul-wrapper" data-aos="fade-left" data-aos-delay="200">
                @foreach($ekstrakurikuler as $eks)
                <div class="eksul-card">
                    <img src="{{ $eks->foto }}" alt="{{ $eks->nama_ekstrakurikuler }}">
                    <div class="overlay"><h3>{{ $eks->nama_ekstrakurikuler }}</h3></div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Prestasi -->
    <section class="prestasi bg-light py-5" id="prestasi">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span style="color: var(--accent); font-weight: 700; text-transform: uppercase; letter-spacing: 1px; font-size: 0.9rem;">🏆 Hall of Fame & Siswa Berprestasi</span>
                <h2 class="section-title text-center mt-1" style="margin-bottom: 0;">Prestasi Kebanggaan Sekolah</h2>
                <p class="text-muted mt-2 mx-auto" style="max-width: 600px;">Daftar kejuaraan dan penghargaan yang berhasil diraih oleh siswa-siswi berbakat {{ $profil?->nama_sekolah ?? 'Sekolah Astika Dharma' }}.</p>
            </div>

            @if($prestasiUtama)
            <div class="prestasi-box mb-5" data-aos="flip-up" data-aos-duration="1000">
                <div class="prestasi-img">
                    <img src="{{ $prestasiUtama->foto_bukti ? asset('storage/'.$prestasiUtama->foto_bukti) : asset('storage/prestasi/default.jpg') }}" alt="Prestasi Utama">
                </div>
                <div class="prestasi-content">
                    <div class="prestasi-year">TAHUN {{ $prestasiUtama->tahun }} | {{ $prestasiUtama->peringkat }} - Tingkat {{ $prestasiUtama->tingkat }}</div>
                    <h2>{{ $prestasiUtama->judul_prestasi }}</h2>
                    <p style="color: var(--text-muted); margin-bottom: 1.5rem; font-size: 1.05rem;">
                        {{ $prestasiUtama->deskripsi ?: 'Berhasil meraih Juara dan mengharumkan nama sekolah dalam ajang kompetisi tingkat ' . $prestasiUtama->tingkat . '.' }}
                    </p>
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalLandingPrestasi{{ $prestasiUtama->id }}">
                            👁️ Lihat Detail Prestasi Ini
                        </button>
                        <a href="#daftar-prestasi-grid" class="btn btn-outline" style="border-color: var(--primary); color: var(--primary);">
                            🏆 Lihat Semua Daftar Prestasi ({{ count($prestasiList) }})
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Grid Daftar Prestasi Siswa -->
            @php
                $initialPrestasi = $prestasiList->take(3);
                $remainingPrestasi = $prestasiList->skip(3);
            @endphp

            <div id="daftar-prestasi-grid" class="row g-4 mt-2">
                @forelse($initialPrestasi as $index => $p)
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ ($index % 3) * 100 }}">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden bg-white hover-top" style="transition: transform 0.3s ease, box-shadow 0.3s ease;">
                        <div class="position-relative">
                            @if($p->foto_bukti)
                                <img src="{{ asset('storage/'.$p->foto_bukti) }}" class="card-img-top object-fit-cover" style="height: 200px;" alt="{{ $p->judul_prestasi }}">
                            @else
                                <div class="bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center p-4 text-center" style="height: 200px;">
                                    <i data-lucide="trophy" size="64" class="text-warning"></i>
                                </div>
                            @endif
                            <span class="position-absolute top-0 end-0 m-3 badge bg-warning text-dark fw-bold px-3 py-1 shadow-sm fs-7">
                                {{ $p->peringkat }}
                            </span>
                        </div>
                        <div class="card-body p-4 d-flex flex-column justify-content-between">
                            <div>
                                <span class="badge bg-primary bg-opacity-10 text-primary small mb-2 border border-primary">Tingkat {{ $p->tingkat }}</span>
                                <h4 class="fw-bold text-dark mb-1" style="font-size: 1.15rem; line-height: 1.4;">{{ $p->judul_prestasi }}</h4>
                                <small class="text-muted d-block mb-2">👤 {{ $p->nama_siswa }} | Kelas {{ $p->kelas }}</small>
                                <p class="text-muted small mb-3" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    {{ $p->deskripsi ?: 'Prestasi luar biasa yang diraih oleh siswa dalam kejuaraan ' . $p->tingkat . '.' }}
                                </p>
                            </div>
                            <button type="button" class="btn btn-outline-primary w-100 fw-bold rounded-3" data-bs-toggle="modal" data-bs-target="#modalLandingPrestasi{{ $p->id }}" style="border-radius: 10px;">
                                👁️ Detail & Deskripsi Singkat
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Modal Detail Pop-up Prestasi -->
                <div class="modal fade" id="modalLandingPrestasi{{ $p->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                            <div class="modal-header bg-dark text-white border-0 py-3" style="background: linear-gradient(90deg, #0F172A 0%, #1E293B 100%);">
                                <h5 class="modal-title fw-bold text-white mb-0">
                                    🏆 Detail Prestasi Siswa: {{ $p->judul_prestasi }}
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4" style="background: #FFFFFF;">
                                <div class="row g-4 align-items-center">
                                    <div class="col-md-5 text-center">
                                        @if($p->foto_bukti)
                                            <img src="{{ asset('storage/'.$p->foto_bukti) }}" alt="{{ $p->judul_prestasi }}" class="img-fluid rounded-3 shadow border object-fit-cover w-100" style="max-height: 280px;">
                                        @else
                                            <div class="bg-light p-4 rounded-3 border text-center">
                                                <i data-lucide="trophy" size="64" class="text-warning mx-auto mb-2"></i>
                                                <small class="text-muted d-block">Foto Dokumentasi Piala</small>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-7">
                                        <span class="badge bg-warning text-dark fw-bold px-3 py-1 fs-6 mb-2">{{ $p->peringkat }} - Tingkat {{ $p->tingkat }}</span>
                                        <h3 class="fw-bold text-primary mb-2">{{ $p->judul_prestasi }}</h3>
                                        
                                        <div class="p-3 bg-light rounded-3 mb-3 border">
                                            <div class="row g-2 small">
                                                <div class="col-6"><strong>Nama Siswa:</strong> <br><span class="text-dark fw-bold">{{ $p->nama_siswa }}</span></div>
                                                <div class="col-6"><strong>Kelas:</strong> <br><span class="text-dark">{{ $p->kelas }}</span></div>
                                                <div class="col-6 mt-2"><strong>Tahun Diraih:</strong> <br><span class="text-dark">{{ $p->tahun }}</span></div>
                                                <div class="col-6 mt-2"><strong>Penyelenggara:</strong> <br><span class="text-dark">{{ $p->penyelenggara ?: '-' }}</span></div>
                                            </div>
                                        </div>

                                        <div class="border-top pt-2">
                                            <h6 class="fw-bold text-dark mb-1">Deskripsi Singkat Kejuaraan:</h6>
                                            <p class="text-muted small mb-0" style="line-height: 1.7;">
                                                {{ $p->deskripsi ?: 'Siswa berhasil membuktikan keunggulannya dalam kompetisi ini dengan penuh semangat dan kerja keras hingga meraih juara.' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer bg-light border-0 py-3">
                                <button type="button" class="btn btn-secondary btn-sm px-4" data-bs-dismiss="modal">Tutup Modal</button>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5 text-muted">
                    <i data-lucide="trophy" size="48" class="text-muted mx-auto mb-2 opacity-50"></i>
                    <p class="mb-0">Belum ada daftar prestasi siswa terdaftar saat ini.</p>
                </div>
                @endforelse
            </div>

            <!-- Collapsible Grid for Remaining Prestasi Items -->
            @if(count($remainingPrestasi) > 0)
                <div class="collapse mt-4" id="collapseMorePrestasi">
                    <div class="row g-4">
                        @foreach($remainingPrestasi as $index => $p)
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden bg-white hover-top" style="transition: transform 0.3s ease, box-shadow 0.3s ease;">
                                <div class="position-relative">
                                    @if($p->foto_bukti)
                                        <img src="{{ asset('storage/'.$p->foto_bukti) }}" class="card-img-top object-fit-cover" style="height: 200px;" alt="{{ $p->judul_prestasi }}">
                                    @else
                                        <div class="bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center p-4 text-center" style="height: 200px;">
                                            <i data-lucide="trophy" size="64" class="text-warning"></i>
                                        </div>
                                    @endif
                                    <span class="position-absolute top-0 end-0 m-3 badge bg-warning text-dark fw-bold px-3 py-1 shadow-sm fs-7">
                                        {{ $p->peringkat }}
                                    </span>
                                </div>
                                <div class="card-body p-4 d-flex flex-column justify-content-between">
                                    <div>
                                        <span class="badge bg-primary bg-opacity-10 text-primary small mb-2 border border-primary">Tingkat {{ $p->tingkat }}</span>
                                        <h4 class="fw-bold text-dark mb-1" style="font-size: 1.15rem; line-height: 1.4;">{{ $p->judul_prestasi }}</h4>
                                        <small class="text-muted d-block mb-2">👤 {{ $p->nama_siswa }} | Kelas {{ $p->kelas }}</small>
                                        <p class="text-muted small mb-3" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                            {{ $p->deskripsi ?: 'Prestasi luar biasa yang diraih oleh siswa dalam kejuaraan ' . $p->tingkat . '.' }}
                                        </p>
                                    </div>
                                    <button type="button" class="btn btn-outline-primary w-100 fw-bold rounded-3" data-bs-toggle="modal" data-bs-target="#modalLandingPrestasi{{ $p->id }}" style="border-radius: 10px;">
                                        👁️ Detail & Deskripsi Singkat
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Detail Pop-up Prestasi -->
                        <div class="modal fade" id="modalLandingPrestasi{{ $p->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                                    <div class="modal-header bg-dark text-white border-0 py-3" style="background: linear-gradient(90deg, #0F172A 0%, #1E293B 100%);">
                                        <h5 class="modal-title fw-bold text-white mb-0">
                                            🏆 Detail Prestasi Siswa: {{ $p->judul_prestasi }}
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-4" style="background: #FFFFFF;">
                                        <div class="row g-4 align-items-center">
                                            <div class="col-md-5 text-center">
                                                @if($p->foto_bukti)
                                                    <img src="{{ asset('storage/'.$p->foto_bukti) }}" alt="{{ $p->judul_prestasi }}" class="img-fluid rounded-3 shadow border object-fit-cover w-100" style="max-height: 280px;">
                                                @else
                                                    <div class="bg-light p-4 rounded-3 border text-center">
                                                        <i data-lucide="trophy" size="64" class="text-warning mx-auto mb-2"></i>
                                                        <small class="text-muted d-block">Foto Dokumentasi Piala</small>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-md-7">
                                                <span class="badge bg-warning text-dark fw-bold px-3 py-1 fs-6 mb-2">{{ $p->peringkat }} - Tingkat {{ $p->tingkat }}</span>
                                                <h3 class="fw-bold text-primary mb-2">{{ $p->judul_prestasi }}</h3>
                                                
                                                <div class="p-3 bg-light rounded-3 mb-3 border">
                                                    <div class="row g-2 small">
                                                        <div class="col-6"><strong>Nama Siswa:</strong> <br><span class="text-dark fw-bold">{{ $p->nama_siswa }}</span></div>
                                                        <div class="col-6"><strong>Kelas:</strong> <br><span class="text-dark">{{ $p->kelas }}</span></div>
                                                        <div class="col-6 mt-2"><strong>Tahun Diraih:</strong> <br><span class="text-dark">{{ $p->tahun }}</span></div>
                                                        <div class="col-6 mt-2"><strong>Penyelenggara:</strong> <br><span class="text-dark">{{ $p->penyelenggara ?: '-' }}</span></div>
                                                    </div>
                                                </div>

                                                <div class="border-top pt-2">
                                                    <h6 class="fw-bold text-dark mb-1">Deskripsi Singkat Kejuaraan:</h6>
                                                    <p class="text-muted small mb-0" style="line-height: 1.7;">
                                                        {{ $p->deskripsi ?: 'Siswa berhasil membuktikan keunggulannya dalam kompetisi ini dengan penuh semangat dan kerja keras hingga meraih juara.' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer bg-light border-0 py-3">
                                        <button type="button" class="btn btn-secondary btn-sm px-4" data-bs-dismiss="modal">Tutup Modal</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Big Interactive Toggle Button -->
                <div class="text-center mt-5" data-aos="fade-up">
                    <button class="btn btn-outline-primary btn-lg rounded-pill fw-bold px-5 py-3 shadow-sm border-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMorePrestasi" aria-expanded="false" aria-controls="collapseMorePrestasi" id="btnTogglePrestasi" style="transition: all 0.3s ease;">
                        <i class="bi bi-chevron-down me-2"></i> Tampilkan Selengkapnya (Lihat {{ count($remainingPrestasi) }} Prestasi Lainnya)
                    </button>
                </div>
            @endif
        </div>
    </section>

    <!-- Berita -->
    <section class="news" id="berita">
        <div class="container">
            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2rem;" data-aos="fade-up">
                <div>
                    <h2 class="section-title" style="margin-bottom: 0;">Berita Terbaru</h2>
                </div>
                <a href="#" class="link-arrow">Semua Berita <i data-lucide="arrow-right" size="18"></i></a>
            </div>

            <div class="news-grid">
                <!-- Highlight News -->
                @if($beritaHighlight)
                <div class="news-main" data-aos="fade-right">
                    <img src="{{ $beritaHighlight->foto }}" alt="{{ $beritaHighlight->judul }}">
                    <div class="news-main-overlay">
                        <span class="news-date">{{ \Carbon\Carbon::parse($beritaHighlight->tanggal_publikasi)->translatedFormat('d F Y') }}</span>
                        <h3>{{ $beritaHighlight->judul }}</h3>
                        <a href="#" class="link-arrow" style="color: var(--white); opacity: 0.9;">Baca selengkapnya <i data-lucide="arrow-right" size="16"></i></a>
                    </div>
                </div>
                @endif
                <!-- Small News -->
                <div class="news-list">
                    @foreach($beritaList as $berita)
                    <div class="news-card">
                        <img src="{{ $berita->foto }}" alt="{{ $berita->judul }}">
                        <div class="news-card-content">
                            <span class="news-date" style="font-size: 0.75rem; color: var(--accent);">{{ \Carbon\Carbon::parse($berita->tanggal_publikasi)->translatedFormat('d F Y') }}</span>
                            <h4>{{ $berita->judul }}</h4>
                            <a href="#" class="link-arrow" style="font-size: 0.9rem; margin-top: 0.5rem;">Baca selengkapnya <i data-lucide="arrow-right" size="14"></i></a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Galeri (Masonry) -->
    <section class="gallery bg-light" id="galeri">
        <div class="container">
            <h2 class="section-title text-center" style="margin-bottom: 2rem;">Galeri Sekolah</h2>
            <div class="gallery-grid">
                @foreach($galeri as $gal)
                <div class="gallery-item"><img src="{{ $gal->foto }}" alt="{{ $gal->judul }}"></div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials">
        <div class="container">
            <h2 class="section-subtitle mx-auto" style="color: var(--accent); font-weight: 700; margin-bottom: 1rem; text-transform: uppercase;">Apa Kata Mereka?</h2>
            
            <div class="testi-slider">
                @foreach($testimoni as $index => $testi)
                <div class="testi-item" style="display: {{ $index == 0 ? 'block' : 'none' }};">
                    <p class="testi-content">"{{ $testi->konten }}"</p>
                    <div class="testi-author">
                        <h4>{{ $testi->nama }}</h4>
                        <p>{{ $testi->peran }}</p>
                    </div>
                </div>
                @endforeach
                
                <div class="testi-dots">
                    @foreach($testimoni as $index => $testi)
                    <div class="dot {{ $index == 0 ? 'active' : '' }}"></div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="faq bg-light" id="faq">
        <h2 class="section-title text-center" style="margin-bottom: 3rem;">Pertanyaan yang Sering Ditanyakan</h2>
        
        @foreach($faqs as $index => $faq)
        <details class="faq-item" {{ $index == 0 ? 'open' : '' }}>
            <summary class="faq-summary">
                {{ $faq->pertanyaan }}
                <i data-lucide="plus" class="faq-icon"></i>
            </summary>
            <div class="faq-content">
                {{ $faq->jawaban }}
            </div>
        </details>
        @endforeach
    </section>

    <!-- CTA PPDB -->
    <section class="cta" id="ppdb">
        <div class="container">
            <div class="cta-box">
                <div class="cta-decoration"></div>
                <h2>Siap Menjadi Bagian dari Astika Dharma?</h2>
                <p>Mulai perjalanan pendidikanmu bersama kami dan raih masa depan yang gemilang.</p>
                <div style="position: relative; z-index: 2;">
                    <a href="#kontak" class="btn btn-outline" style="margin-right: 1rem; border-color: white;">Hubungi Kami</a>
                    <a href="{{ route('register') }}" class="btn" style="background: var(--white); color: var(--primary);">Daftar Sekarang <i data-lucide="arrow-right" size="18"></i></a>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const collapseElem = document.getElementById('collapseMorePrestasi');
            const toggleBtn = document.getElementById('btnTogglePrestasi');
            if (collapseElem && toggleBtn) {
                collapseElem.addEventListener('show.bs.collapse', function () {
                    toggleBtn.innerHTML = '<i class="bi bi-chevron-up me-2"></i> Sembunyikan / Tutup Kembali';
                    toggleBtn.classList.remove('btn-outline-primary');
                    toggleBtn.classList.add('btn-primary', 'text-white');
                });
                collapseElem.addEventListener('hide.bs.collapse', function () {
                    toggleBtn.innerHTML = '<i class="bi bi-chevron-down me-2"></i> Tampilkan Selengkapnya (Lihat {{ isset($remainingPrestasi) ? count($remainingPrestasi) : 0 }} Prestasi Lainnya)';
                    toggleBtn.classList.remove('btn-primary', 'text-white');
                    toggleBtn.classList.add('btn-outline-primary');
                });
            }
        });
    </script>
@endsection
