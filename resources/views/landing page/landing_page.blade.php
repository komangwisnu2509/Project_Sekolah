@extends('layouts.landing')

@section('content')
    <!-- Hero -->
    @php
        $heroBannerImg = $profil?->hero_banner ? (str_starts_with($profil->hero_banner, 'http') ? $profil->hero_banner : asset('storage/'.$profil->hero_banner)) : 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=2070&auto=format&fit=crop';
    @endphp
    <header class="hero" id="beranda">
        <img src="{{ $heroBannerImg }}" alt="{{ $profil?->nama_sekolah ?? 'Sekolah Astika Dharma' }}" class="hero-bg">
        <div class="hero-overlay"></div>
        <div class="hero-content" data-aos="fade-up" data-aos-duration="1000">
            <h1>{{ strtoupper($profil?->nama_sekolah ?? 'SEKOLAH ASTIKA DHARMA') }}</h1>
            <p>{{ $profil?->slogan ?: 'Membentuk Generasi Unggul, Berkarakter, Berkualitas, dan Berbasis Teknologi Terdepan untuk Masa Depan Gemilang.' }}</p>
            <div class="hero-btns">
                <a href="{{ route('ppdb.index') }}" class="btn btn-primary">Daftar PPDB Online</a>
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
    @php
        $fotoTentangSection = $profil?->foto_tentang ? (str_starts_with($profil->foto_tentang, 'http') ? $profil->foto_tentang : asset('storage/'.$profil->foto_tentang)) : 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?q=80&w=2022&auto=format&fit=crop';
    @endphp
    <section class="about" id="profil">
        <div class="container about-grid">
            <div class="about-image" data-aos="fade-right" data-aos-duration="800">
                <img src="{{ $fotoTentangSection }}" alt="Tentang {{ $profil?->nama_sekolah ?? 'Astika Dharma' }}" style="border-radius: var(--radius-md); object-fit: cover; width: 100%; height: 100%; max-height: 400px;">
            </div>
            <div class="about-text" data-aos="fade-left" data-aos-duration="800" data-aos-delay="200">
                <div class="about-badge">Tentang {{ $profil?->nama_sekolah ?? 'Astika Dharma' }}</div>
                <h2 class="section-title">Mengenal Lebih Dekat</h2>
                @if($profil?->deskripsi_tentang)
                    <p style="white-space: pre-line;">{{ $profil->deskripsi_tentang }}</p>
                @else
                    <p>{{ $profil?->visi ?? 'Sekolah Astika Dharma adalah lembaga pendidikan terkemuka yang berdedikasi untuk menciptakan lingkungan belajar yang inspiratif dan berpusat pada siswa.' }}</p>
                    <p>{{ $profil?->misi ?? 'Dengan fasilitas modern dan tenaga pengajar yang berdedikasi, kami menyeimbangkan prestasi akademik dengan pembentukan karakter mulia.' }}</p>
                @endif
                <a href="{{ route('tentang_sekolah') }}" class="link-arrow">Selengkapnya <i data-lucide="arrow-right" size="18"></i></a>
            </div>
        </div>
    </section>

    <!-- Program Keahlian -->
    <section class="programs" id="program">
        <div class="container text-center">
            <h2 class="section-title" data-aos="fade-up">Program Keahlian</h2>
            <p class="section-subtitle mx-auto mb-3" data-aos="fade-up" data-aos-delay="100">Temukan bidang yang sesuai dengan minat dan masa depanmu. Klik pada salah satu jurusan untuk melihat foto dan informasi selengkapnya.</p>
            
            <div class="d-lg-none text-center mb-3">
                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-20 rounded-pill px-3.5 py-1.5 fw-semibold small shadow-sm">
                    <i class="bi bi-arrows-expand me-1"></i> Geser Kesamping (Swipe ➔)
                </span>
            </div>
            
            <div class="programs-grid">
                @foreach($jurusans as $index => $jurusan)
                @php
                    $jurusanFoto = $jurusan->foto ? asset('storage/'.$jurusan->foto) : 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?auto=format&fit=crop&w=800&q=80';
                    $iconName = $jurusan->icon ?: ['monitor', 'code', 'camera', 'briefcase', 'cpu', 'tools'][$index % 6];
                @endphp
                <div class="program-card cursor-pointer shadow-sm position-relative" data-aos="fade-up" data-aos-delay="{{ 200 + ($index * 100) }}" data-bs-toggle="modal" data-bs-target="#jurusanModal_{{ $jurusan->id }}" style="cursor: pointer; transition: all 0.3s ease;">
                    @if($jurusan->foto)
                        <div class="program-img-wrapper mb-3 overflow-hidden rounded-3" style="height: 160px;">
                            <img src="{{ $jurusanFoto }}" alt="{{ $jurusan->nama_jurusan }}" class="w-100 h-100 object-fit-cover program-card-img" style="transition: transform 0.4s ease;">
                        </div>
                    @else
                        <div class="program-icon mb-3">
                            <i data-lucide="{{ $iconName }}" size="28"></i>
                        </div>
                    @endif
                    <h3 class="fw-bold text-dark fs-5 mb-2">{{ $jurusan->nama_jurusan }}</h3>
                    <p class="text-muted small mb-3 line-clamp-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; min-height: 42px;">
                        {{ $jurusan->deskripsi ?? 'Pelajari skill unggulan dan kembangkan potensi diri untuk masa depan di industri terkait.' }}
                    </p>
                    <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3 py-1 fw-semibold mt-auto d-inline-flex align-items-center gap-1">
                        <i class="bi bi-info-circle me-1"></i> Detail & Foto <i data-lucide="arrow-right" size="14"></i>
                    </button>
                </div>
                @endforeach
            </div>

            <!-- Modals Program Keahlian -->
            @foreach($jurusans as $jurusan)
            @php
                $jurusanFoto = $jurusan->foto ? asset('storage/'.$jurusan->foto) : 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?auto=format&fit=crop&w=800&q=80';
            @endphp
            <div class="modal fade text-start" id="jurusanModal_{{ $jurusan->id }}" tabindex="-1" aria-labelledby="jurusanModalLabel_{{ $jurusan->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg overflow-hidden rounded-4">
                        <div class="modal-header border-0 bg-primary text-white p-4 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-3">
                                <span class="badge bg-white text-primary p-2.5 rounded-circle shadow-sm">
                                    <i class="bi bi-award-fill fs-5"></i>
                                </span>
                                <div>
                                    <span class="badge bg-light text-primary fw-bold text-uppercase px-2.5 py-1 mb-1">Program Keahlian</span>
                                    <h4 class="modal-title fw-bold mb-0 text-white" id="jurusanModalLabel_{{ $jurusan->id }}">{{ $jurusan->nama_jurusan }}</h4>
                                </div>
                            </div>
                            <button type="button" class="btn-close btn-close-white ms-auto shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4 text-start">
                            <div class="jurusan-banner-img mb-4 rounded-3 overflow-hidden border shadow-sm" style="max-height: 320px;">
                                <img src="{{ $jurusanFoto }}" alt="{{ $jurusan->nama_jurusan }}" class="w-100 h-100 object-fit-cover" style="max-height: 320px; object-fit: cover; width: 100%;">
                            </div>
                            <div class="mb-4">
                                <h5 class="fw-bold text-dark d-flex align-items-center gap-2 mb-2">
                                    <i class="bi bi-card-text text-primary fs-5"></i> Ringkasan Program
                                </h5>
                                <p class="text-secondary leading-relaxed mb-0" style="font-size: 0.98rem; line-height: 1.7;">
                                    {{ $jurusan->deskripsi ?? 'Program keahlian ini dirancang untuk membekali peserta didik dengan pengetahuan teori dan keterampilan praktis berbasis kurikulum industri unggulan.' }}
                                </p>
                            </div>
                            <div class="p-3 bg-light rounded-3 border">
                                <h5 class="fw-bold text-dark d-flex align-items-center gap-2 mb-2">
                                    <i class="bi bi-stars text-warning fs-5"></i> Detail Kompetensi & Prospek Karir
                                </h5>
                                @if($jurusan->detail_informasi)
                                    <div class="text-dark small leading-relaxed" style="white-space: pre-line; line-height: 1.7; font-size: 0.93rem;">
                                        {{ $jurusan->detail_informasi }}
                                    </div>
                                @else
                                    <ul class="mb-0 ps-3 text-secondary small leading-relaxed" style="line-height: 1.7;">
                                        <li>Kurikulum berbasis kebutuhan dunia usaha dan dunia industri (DUDI).</li>
                                        <li>Fasilitas laboratorium praktikum standar industri.</li>
                                        <li>Peluang karir yang luas serta bimbingan wirausaha mandiri.</li>
                                        <li>Sertifikasi kompetensi keahlian nasional.</li>
                                    </ul>
                                @endif
                            </div>
                        </div>
                        <div class="modal-footer border-top-0 bg-light px-4 py-3 d-flex justify-content-between align-items-center">
                            <span class="text-muted small"><i class="bi bi-building me-1"></i> {{ $profil?->nama_sekolah ?? 'SMK Astika Dharma' }}</span>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-secondary px-4 rounded-pill" data-bs-dismiss="modal">Tutup</button>
                                <a href="{{ route('ppdb.index') }}" class="btn btn-primary fw-bold px-4 rounded-pill">
                                    <i class="bi bi-person-plus-fill me-1"></i> Daftar PPDB Jurusan Ini
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Fasilitas -->
    <section class="facilities bg-light" id="fasilitas">
        <div class="container">
            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2rem;" data-aos="fade-up">
                <div>
                    <h2 class="section-title" style="margin-bottom: 0;">Fasilitas Sekolah</h2>
                </div>
                <a href="{{ route('fasilitas_sekolah') }}" class="link-arrow">Lihat Semua Fasilitas <i data-lucide="arrow-right" size="18"></i></a>
            </div>
            
            <div class="d-lg-none text-center mb-3">
                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-20 rounded-pill px-3.5 py-1.5 fw-semibold small shadow-sm">
                    <i class="bi bi-arrows-expand me-1"></i> Geser Kesamping (Swipe ➔)
                </span>
            </div>

            <div class="fac-grid">
                @forelse($fasilitas as $index => $fac)
                @php
                    $fotoFac = $fac->foto ? (str_starts_with($fac->foto, 'http') ? $fac->foto : asset($fac->foto)) : 'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=600&q=80';
                @endphp
                <div class="fac-item {{ $fac->is_large ? 'large' : '' }}" @if($index == 0) data-aos="zoom-in" data-aos-duration="800" @endif style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modalFacLanding_{{ $fac->id }}">
                    <img src="{{ $fotoFac }}" alt="{{ $fac->nama_fasilitas }}">
                    <div class="fac-overlay">
                        <div class="fac-content">
                            <h3 class="mb-1">{{ $fac->nama_fasilitas }}</h3>
                            <button type="button" class="btn btn-light btn-sm rounded-pill px-3 py-1 mt-2 fw-semibold text-primary shadow-sm d-inline-flex align-items-center gap-1" style="font-size: 0.82rem;">
                                <i class="bi bi-info-circle-fill text-primary me-1"></i> Deskripsi Singkat <i data-lucide="arrow-right" size="14"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-4 text-muted w-100">Belum ada foto fasilitas terdaftar.</div>
                @endforelse
            </div>

            <!-- Modals Fasilitas -->
            @foreach($fasilitas as $fac)
            @php
                $fotoFac = $fac->foto ? (str_starts_with($fac->foto, 'http') ? $fac->foto : asset($fac->foto)) : 'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=600&q=80';
            @endphp
            <div class="modal fade text-start" id="modalFacLanding_{{ $fac->id }}" tabindex="-1" aria-labelledby="modalFacLandingLabel_{{ $fac->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content border-0 shadow-lg overflow-hidden rounded-4">
                        <div class="modal-header border-0 bg-primary text-white p-4 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-3">
                                <span class="badge bg-white text-primary p-2.5 rounded-circle shadow-sm">
                                    <i class="bi bi-building fs-5"></i>
                                </span>
                                <div>
                                    <span class="badge bg-light text-primary fw-bold text-uppercase px-2.5 py-1 mb-1">Fasilitas Sekolah</span>
                                    <h4 class="modal-title fw-bold mb-0 text-white" id="modalFacLandingLabel_{{ $fac->id }}">{{ $fac->nama_fasilitas }}</h4>
                                </div>
                            </div>
                            <button type="button" class="btn-close btn-close-white ms-auto shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <div class="rounded-3 overflow-hidden border shadow-sm mb-4" style="max-height: 350px;">
                                <img src="{{ $fotoFac }}" alt="{{ $fac->nama_fasilitas }}" class="w-100 h-100 object-fit-cover" style="max-height: 350px; object-fit: cover; width: 100%;">
                            </div>
                            <div class="p-3 bg-light rounded-3 border">
                                <h5 class="fw-bold text-dark d-flex align-items-center gap-2 mb-2">
                                    <i class="bi bi-card-text text-primary fs-5"></i> Deskripsi Singkat Fasilitas
                                </h5>
                                <p class="text-secondary leading-relaxed mb-0" style="font-size: 1rem; line-height: 1.7; white-space: pre-line;">
                                    {{ $fac->deskripsi ?? 'Fasilitas modern ini disediakan untuk menunjang kelancaran, kenyamanan, serta efektivitas proses belajar mengajar di SMK Astika Dharma.' }}
                                </p>
                            </div>
                        </div>
                        <div class="modal-footer border-top bg-light px-4 py-3 d-flex justify-content-between align-items-center">
                            <span class="text-muted small"><i class="bi bi-building me-1"></i> {{ $profil?->nama_sekolah ?? 'SMK Astika Dharma' }}</span>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-secondary px-4 rounded-pill" data-bs-dismiss="modal">Tutup</button>
                                <a href="{{ route('fasilitas_sekolah') }}" class="btn btn-primary px-4 rounded-pill">
                                    <i class="bi bi-grid-fill me-1"></i> Lihat Semua Fasilitas &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Ekstrakurikuler -->
    <section class="eksul bg-white py-5" id="ekstrakurikuler">
        <div class="container">
            <div class="d-flex justify-content-between align-items-end mb-4 flex-wrap gap-2" data-aos="fade-up">
                <div>
                    <span style="color: var(--accent); font-weight: 700; text-transform: uppercase; letter-spacing: 1px; font-size: 0.9rem;">🎨 Pengembangan Minat & Bakat</span>
                    <h2 class="section-title text-start mt-1 mb-0">Ekstrakurikuler Sekolah</h2>
                    <p class="text-muted mt-1 mb-0" style="max-width: 600px;">Wadah bagi seluruh peserta didik untuk mengasah bakat, kepemimpinan, seni, dan kreativitas.</p>
                </div>
                <a href="{{ route('ekstrakurikuler_sekolah') }}" class="link-arrow">Lihat Semua Ekstrakurikuler <i data-lucide="arrow-right" size="18"></i></a>
            </div>
            
            <div class="eksul-wrapper" data-aos="fade-left" data-aos-delay="200">
                @forelse($ekstrakurikuler as $eks)
                @php
                    $namaEkskul = $eks->nama_ekskul ?? $eks->nama_ekstrakurikuler ?? 'Ekstrakurikuler';
                    $fotoEkskul = $eks->foto ? (str_contains($eks->foto, 'http') ? $eks->foto : asset('storage/'.$eks->foto)) : 'https://images.unsplash.com/photo-1511632765486-a01980e01a18?auto=format&fit=crop&w=600&q=80';
                @endphp
                <div class="eksul-card" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modalEkskulLanding_{{ $eks->id }}">
                    <img src="{{ $fotoEkskul }}" alt="{{ $namaEkskul }}">
                    <div class="overlay">
                        @if(!empty($eks->kategori))
                            <span class="badge bg-warning text-dark fw-bold mb-1 small">{{ $eks->kategori }}</span>
                        @endif
                        <h3 class="mb-1">{{ $namaEkskul }}</h3>
                        @if(!empty($eks->hari_latihan))
                            <small class="text-white-50 d-block mt-1 mb-2"><i class="bi bi-clock me-1"></i>Latihan: {{ $eks->hari_latihan }}</small>
                        @endif
                        <button type="button" class="btn btn-light btn-sm rounded-pill px-3 py-1 fw-semibold text-primary shadow-sm d-inline-flex align-items-center gap-1" style="font-size: 0.82rem;">
                            <i class="bi bi-info-circle-fill text-primary me-1"></i> Deskripsi Singkat <i data-lucide="arrow-right" size="14"></i>
                        </button>
                    </div>
                </div>
                @empty
                <div class="text-center py-4 text-muted w-100">Belum ada daftar ekstrakurikuler terdaftar.</div>
                @endforelse
            </div>

            <!-- Modals Ekstrakurikuler -->
            @foreach($ekstrakurikuler as $eks)
            @php
                $namaEkskul = $eks->nama_ekskul ?? $eks->nama_ekstrakurikuler ?? 'Ekstrakurikuler';
                $fotoEkskul = $eks->foto ? (str_contains($eks->foto, 'http') ? $eks->foto : asset('storage/'.$eks->foto)) : 'https://images.unsplash.com/photo-1511632765486-a01980e01a18?auto=format&fit=crop&w=600&q=80';
            @endphp
            <div class="modal fade text-start" id="modalEkskulLanding_{{ $eks->id }}" tabindex="-1" aria-labelledby="modalEkskulLandingLabel_{{ $eks->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content border-0 shadow-lg overflow-hidden rounded-4 text-start">
                        <div class="modal-header border-0 bg-primary text-white p-4 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-3">
                                <span class="badge bg-white text-primary p-2.5 rounded-circle shadow-sm">
                                    <i class="bi bi-star-fill fs-5"></i>
                                </span>
                                <div>
                                    @if(!empty($eks->kategori))
                                        <span class="badge bg-warning text-dark fw-bold text-uppercase px-2.5 py-1 mb-1" style="font-size: 0.75rem;">{{ $eks->kategori }}</span>
                                    @endif
                                    <h4 class="modal-title fw-bold mb-0 text-white" id="modalEkskulLandingLabel_{{ $eks->id }}">{{ $namaEkskul }}</h4>
                                </div>
                            </div>
                            <button type="button" class="btn-close btn-close-white ms-auto shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4 bg-white">
                            <div class="rounded-3 overflow-hidden border shadow-sm mb-4" style="max-height: 350px;">
                                <img src="{{ $fotoEkskul }}" alt="{{ $namaEkskul }}" class="w-100 h-100 object-fit-cover" style="max-height: 350px; object-fit: cover; width: 100%;">
                            </div>

                            <div class="row g-3 mb-4">
                                @if(!empty($eks->pembina))
                                <div class="col-md-4">
                                    <div class="p-3 bg-light rounded-3 border">
                                        <small class="text-muted d-block fw-bold mb-1" style="font-size: 0.75rem;">PEMBINA</small>
                                        <span class="fw-bold text-dark small"><i class="bi bi-person-badge text-primary me-1.5"></i>{{ $eks->pembina }}</span>
                                    </div>
                                </div>
                                @endif
                                @if(!empty($eks->hari_latihan))
                                <div class="col-md-4">
                                    <div class="p-3 bg-light rounded-3 border">
                                        <small class="text-muted d-block fw-bold mb-1" style="font-size: 0.75rem;">JADWAL LATIHAN</small>
                                        <span class="fw-bold text-dark small"><i class="bi bi-calendar-check text-warning me-1.5"></i>{{ $eks->hari_latihan }} {{ $eks->jam_latihan ? '('.$eks->jam_latihan.')' : '' }}</span>
                                    </div>
                                </div>
                                @endif
                                @if(!empty($eks->lokasi))
                                <div class="col-md-4">
                                    <div class="p-3 bg-light rounded-3 border">
                                        <small class="text-muted d-block fw-bold mb-1" style="font-size: 0.75rem;">LOKASI LATIHAN</small>
                                        <span class="fw-bold text-dark small"><i class="bi bi-geo-alt text-danger me-1.5"></i>{{ $eks->lokasi }}</span>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <div class="p-3 bg-light rounded-3 border">
                                <h5 class="fw-bold text-dark d-flex align-items-center gap-2 mb-2">
                                    <i class="bi bi-card-text text-primary fs-5"></i> Deskripsi Singkat Ekstrakurikuler
                                </h5>
                                <p class="text-secondary leading-relaxed mb-0" style="font-size: 0.95rem; line-height: 1.7; white-space: pre-line;">
                                    {{ $eks->deskripsi ?? 'Kegiatan ekstrakurikuler ini aktif diselenggarakan untuk mengasah keterampilan, jiwa sosial, disiplin, dan prestasi peserta didik di SMK Astika Dharma.' }}
                                </p>
                            </div>
                        </div>
                        <div class="modal-footer border-top bg-light px-4 py-3 d-flex justify-content-between align-items-center">
                            <span class="text-muted small"><i class="bi bi-building me-1"></i> {{ $profil?->nama_sekolah ?? 'SMK Astika Dharma' }}</span>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-secondary px-4 rounded-pill" data-bs-dismiss="modal">Tutup</button>
                                <a href="{{ route('ekstrakurikuler_sekolah') }}" class="btn btn-primary px-4 rounded-pill">
                                    <i class="bi bi-grid-fill me-1"></i> Lihat Semua Ekstrakurikuler &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- ASDHA TV - Media Jurnalisme & Youtube Channel -->
    <section class="asdha-tv-section py-5 position-relative overflow-hidden" id="asdhatv" style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #0f172a 100%); color: #ffffff;">
        <div class="container position-relative" style="z-index: 2;">
            <div class="row align-items-center g-5">
                <div class="col-lg-6" data-aos="fade-right" data-aos-duration="1000">
                    <span class="badge bg-danger text-white px-3 py-2 rounded-pill fw-bold mb-3 shadow-sm d-inline-flex align-items-center gap-2">
                        <i class="bi bi-youtube fs-5"></i> ASDHA TV - OFFICIAL YOUTUBE
                    </span>
                    <h2 class="display-6 fw-bold text-white mb-3">Wadah Jurnalisme Visual & Kreativitas Siswa</h2>
                    <p class="text-light opacity-85 leading-relaxed mb-4" style="font-size: 1.05rem; line-height: 1.8;">
                        <strong>ASDHA TV</strong> (<code>@asdhatv</code>) merupakan kanal YouTube resmi yang dikelola secara aktif oleh siswa-siswi <strong>Utama Widyalaya Astika Dharma (SMA Hindu Astika Dharma)</strong>. Kanal ini menjadi ruang berekspresi untuk mengabarkan berita sekolah, dokumentasi keagamaan, serta inovasi pembelajaran berbasis kearifan lokal.
                    </p>
                    
                    <div class="row g-3 mb-4">
                        <div class="col-sm-6">
                            <div class="p-3 rounded-3" style="background: rgba(255, 255, 255, 0.07); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.12);">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                        <i class="bi bi-camera-reels fs-5"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-0 text-white">Jurnalisme Digital</h6>
                                        <small class="text-light opacity-75">Liputan & Wawancara</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="p-3 rounded-3" style="background: rgba(255, 255, 255, 0.07); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.12);">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle bg-warning text-dark d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                        <i class="bi bi-flower1 fs-5"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-0 text-white">Tri Hita Karana</h6>
                                        <small class="text-light opacity-75">Budaya & Keagamaan</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-3 align-items-center">
                        <a href="https://youtube.com/@asdhatv?si=6dcfwv3FKNSWBKNu" target="_blank" class="btn btn-danger btn-lg px-4 rounded-pill fw-bold shadow d-inline-flex align-items-center gap-2" style="background: #ff0000; border: none;">
                            <i class="bi bi-youtube fs-5"></i> Kunjungi Channel ASDHA TV &rarr;
                        </a>
                        <a href="{{ route('tentang_sekolah') }}" class="btn btn-outline-light btn-lg px-4 rounded-pill fw-semibold">
                            Profil Sekolah
                        </a>
                    </div>
                </div>

                <div class="col-lg-6" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                    <div class="card border-0 rounded-4 overflow-hidden shadow-2xl" style="background: rgba(15, 23, 42, 0.9); border: 1px solid rgba(255, 255, 255, 0.15) !important;">
                        <div class="position-relative" style="height: 280px; background: url('https://images.unsplash.com/photo-1574717024653-61fd2cf4d44d?q=80&w=1200&auto=format&fit=crop') center/cover no-repeat;">
                            <div class="position-absolute inset-0 bg-dark bg-opacity-50 d-flex flex-column align-items-center justify-content-center p-4 text-center">
                                <button type="button" class="btn btn-danger rounded-circle p-3 shadow-lg hover-scale mb-3" data-bs-toggle="modal" data-bs-target="#modalVideoAsdha_1" style="width: 70px; height: 70px; display: flex; align-items: center; justify-content: center; background: #ff0000; border: none;">
                                    <i class="bi bi-play-fill text-white fs-1"></i>
                                </button>
                                <span class="badge bg-black bg-opacity-75 text-white px-3 py-1.5 rounded-pill small fw-semibold">Putar Clip Highlights ASDHA TV</span>
                            </div>
                        </div>
                        <div class="card-body p-4 text-white">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="fw-bold mb-0 text-white"><i class="bi bi-tv me-2 text-danger"></i>ASDHA TV (@asdhatv)</h5>
                                <span class="badge bg-danger text-white">Kanal Resmi</span>
                            </div>
                            <p class="text-light opacity-80 small mb-3">
                                Kepala Sekolah: <strong>I Ketut Suena, S.Pd</strong> | Lokasi: Rendang, Karangasem, Bali.
                            </p>
                            <div class="p-3 rounded-3 bg-white bg-opacity-10 border border-white border-opacity-10 small">
                                <i class="bi bi-quote text-warning me-1"></i>
                                "Wadah penyiaran kreatif yang membina talenta siswa dalam bidang teknologi, penyiaran digital, dan pelestarian budaya spiritual Hindu."
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Video Clips Grid Showcase -->
            <div class="mt-5 pt-4 border-top border-white border-opacity-10" data-aos="fade-up" data-aos-duration="1000">
                <div class="d-flex justify-content-between align-items-end mb-4 flex-wrap gap-2">
                    <div>
                        <span class="badge bg-warning text-dark fw-bold text-uppercase px-3 py-1 rounded-pill mb-2" style="font-size: 0.75rem;">🎬 Clip Highlights Video</span>
                        <h3 class="fw-bold text-white mb-1">Tonton Video Kegiatan ASDHA TV & Sekolah</h3>
                        <p class="text-light opacity-75 mb-0 small">Kumpulan tayangan video liputan jurnalisme visual, seni budaya, dan inovasi Astika Dharma.</p>
                    </div>
                    <a href="https://youtube.com/@asdhatv?si=6dcfwv3FKNSWBKNu" target="_blank" class="btn btn-outline-light btn-sm rounded-pill px-3 py-1.5 fw-semibold d-inline-flex align-items-center gap-1">
                        <i class="bi bi-youtube text-danger me-1"></i> Lihat Lebih Banyak di YouTube &rarr;
                    </a>
                </div>

                <div class="row g-4">
                    <!-- Clip 1 -->
                    <div class="col-md-6 col-lg-3">
                        <div class="card h-100 border-0 rounded-4 overflow-hidden shadow-sm bg-dark text-white position-relative" style="border: 1px solid rgba(255,255,255,0.1) !important;">
                            <div class="position-relative overflow-hidden" style="height: 160px;">
                                <img src="https://images.unsplash.com/photo-1574717024653-61fd2cf4d44d?q=80&w=800&auto=format&fit=crop" class="w-100 h-100 object-fit-cover" alt="Clip Jurnalisme ASDHA TV">
                                <div class="position-absolute inset-0 bg-dark bg-opacity-40 d-flex align-items-center justify-content-center">
                                    <button type="button" class="btn btn-danger rounded-circle p-2.5 shadow" data-bs-toggle="modal" data-bs-target="#modalVideoAsdha_1" style="background: #ff0000; border: none;">
                                        <i class="bi bi-play-fill text-white fs-3"></i>
                                    </button>
                                </div>
                                <span class="position-absolute top-0 start-0 m-2 badge bg-danger text-white small">📰 Jurnalisme Digital</span>
                            </div>
                            <div class="card-body p-3">
                                <h6 class="fw-bold text-white mb-1 line-clamp-2" style="font-size: 0.92rem;">Liputan Jurnalisme Visual & Berita Sekolah ASDHA TV</h6>
                                <p class="text-light opacity-75 small mb-0" style="font-size: 0.8rem;">Kreativitas tim liputan siswa mengabarkan aktivitas terkini.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Clip 2 -->
                    <div class="col-md-6 col-lg-3">
                        <div class="card h-100 border-0 rounded-4 overflow-hidden shadow-sm bg-dark text-white position-relative" style="border: 1px solid rgba(255,255,255,0.1) !important;">
                            <div class="position-relative overflow-hidden" style="height: 160px;">
                                <img src="https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?q=80&w=800&auto=format&fit=crop" class="w-100 h-100 object-fit-cover" alt="Clip Utsawa Dharmagita">
                                <div class="position-absolute inset-0 bg-dark bg-opacity-40 d-flex align-items-center justify-content-center">
                                    <button type="button" class="btn btn-danger rounded-circle p-2.5 shadow" data-bs-toggle="modal" data-bs-target="#modalVideoAsdha_2" style="background: #ff0000; border: none;">
                                        <i class="bi bi-play-fill text-white fs-3"></i>
                                    </button>
                                </div>
                                <span class="position-absolute top-0 start-0 m-2 badge bg-warning text-dark small">🕉️ Seni & Budaya</span>
                            </div>
                            <div class="card-body p-3">
                                <h6 class="fw-bold text-white mb-1 line-clamp-2" style="font-size: 0.92rem;">Utsawa Dharmagita & Pasraman Astika Dharma</h6>
                                <p class="text-light opacity-75 small mb-0" style="font-size: 0.8rem;">Pelestarian budaya Hindu & pementasan seni spiritual.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Clip 3 -->
                    <div class="col-md-6 col-lg-3">
                        <div class="card h-100 border-0 rounded-4 overflow-hidden shadow-sm bg-dark text-white position-relative" style="border: 1px solid rgba(255,255,255,0.1) !important;">
                            <div class="position-relative overflow-hidden" style="height: 160px;">
                                <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?q=80&w=800&auto=format&fit=crop" class="w-100 h-100 object-fit-cover" alt="Clip Cek Kesehatan">
                                <div class="position-absolute inset-0 bg-dark bg-opacity-40 d-flex align-items-center justify-content-center">
                                    <button type="button" class="btn btn-danger rounded-circle p-2.5 shadow" data-bs-toggle="modal" data-bs-target="#modalVideoAsdha_3" style="background: #ff0000; border: none;">
                                        <i class="bi bi-play-fill text-white fs-3"></i>
                                    </button>
                                </div>
                                <span class="position-absolute top-0 start-0 m-2 badge bg-success text-white small">🏥 Program CKG Bali</span>
                            </div>
                            <div class="card-body p-3">
                                <h6 class="fw-bold text-white mb-1 line-clamp-2" style="font-size: 0.92rem;">Peninjauan Cek Kesehatan Gratis (CKG) Sekolah</h6>
                                <p class="text-light opacity-75 small mb-0" style="font-size: 0.8rem;">Program percontohan kesehatan sekolah oleh Kementerian RI.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Clip 4 -->
                    <div class="col-md-6 col-lg-3">
                        <div class="card h-100 border-0 rounded-4 overflow-hidden shadow-sm bg-dark text-white position-relative" style="border: 1px solid rgba(255,255,255,0.1) !important;">
                            <div class="position-relative overflow-hidden" style="height: 160px;">
                                <img src="https://images.unsplash.com/photo-1517694712202-14dd9538aa97?q=80&w=800&auto=format&fit=crop" class="w-100 h-100 object-fit-cover" alt="Clip Inovasi Pembelajaran">
                                <div class="position-absolute inset-0 bg-dark bg-opacity-40 d-flex align-items-center justify-content-center">
                                    <button type="button" class="btn btn-danger rounded-circle p-2.5 shadow" data-bs-toggle="modal" data-bs-target="#modalVideoAsdha_4" style="background: #ff0000; border: none;">
                                        <i class="bi bi-play-fill text-white fs-3"></i>
                                    </button>
                                </div>
                                <span class="position-absolute top-0 start-0 m-2 badge bg-info text-dark small">🚀 Inovasi Belajar</span>
                            </div>
                            <div class="card-body p-3">
                                <h6 class="fw-bold text-white mb-1 line-clamp-2" style="font-size: 0.92rem;">Pembelajaran Deep Learning & Eko-Kreativitas</h6>
                                <p class="text-light opacity-75 small mb-0" style="font-size: 0.8rem;">Inovasi metode belajar aktif berbasis kearifan lokal.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modals Play Video Clips ASDHA TV -->
    <div class="modal fade" id="modalVideoAsdha_1" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 overflow-hidden bg-dark text-white shadow-2xl">
                <div class="modal-header border-0 bg-black p-3 d-flex justify-content-between align-items-center">
                    <h6 class="modal-title fw-bold text-white mb-0 d-flex align-items-center gap-2">
                        <i class="bi bi-youtube text-danger fs-5"></i> ASDHA TV - Liputan Jurnalisme Visual Siswa
                    </h6>
                    <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden;">
                    <iframe src="https://www.youtube.com/embed/live_stream?channel=asdhatv" style="position: absolute; top:0; left:0; width:100%; height:100%; border:0;" allowfullscreen title="ASDHA TV Video Clip 1"></iframe>
                </div>
                <div class="modal-footer border-0 bg-black p-3 d-flex justify-content-between align-items-center">
                    <span class="small text-white-50"><i class="bi bi-info-circle me-1"></i> Utama Widyalaya Astika Dharma</span>
                    <a href="https://youtube.com/@asdhatv?si=6dcfwv3FKNSWBKNu" target="_blank" class="btn btn-danger btn-sm rounded-pill px-3 fw-bold">
                        <i class="bi bi-youtube me-1"></i> Buka di YouTube @asdhatv
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalVideoAsdha_2" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 overflow-hidden bg-dark text-white shadow-2xl">
                <div class="modal-header border-0 bg-black p-3 d-flex justify-content-between align-items-center">
                    <h6 class="modal-title fw-bold text-white mb-0 d-flex align-items-center gap-2">
                        <i class="bi bi-youtube text-danger fs-5"></i> ASDHA TV - Utsawa Dharmagita & Pasraman
                    </h6>
                    <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden;">
                    <iframe src="https://www.youtube.com/embed/live_stream?channel=asdhatv" style="position: absolute; top:0; left:0; width:100%; height:100%; border:0;" allowfullscreen title="ASDHA TV Video Clip 2"></iframe>
                </div>
                <div class="modal-footer border-0 bg-black p-3 d-flex justify-content-between align-items-center">
                    <span class="small text-white-50"><i class="bi bi-info-circle me-1"></i> Utama Widyalaya Astika Dharma</span>
                    <a href="https://youtube.com/@asdhatv?si=6dcfwv3FKNSWBKNu" target="_blank" class="btn btn-danger btn-sm rounded-pill px-3 fw-bold">
                        <i class="bi bi-youtube me-1"></i> Buka di YouTube @asdhatv
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalVideoAsdha_3" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 overflow-hidden bg-dark text-white shadow-2xl">
                <div class="modal-header border-0 bg-black p-3 d-flex justify-content-between align-items-center">
                    <h6 class="modal-title fw-bold text-white mb-0 d-flex align-items-center gap-2">
                        <i class="bi bi-youtube text-danger fs-5"></i> ASDHA TV - Cek Kesehatan Gratis (CKG) Bali
                    </h6>
                    <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden;">
                    <iframe src="https://www.youtube.com/embed/live_stream?channel=asdhatv" style="position: absolute; top:0; left:0; width:100%; height:100%; border:0;" allowfullscreen title="ASDHA TV Video Clip 3"></iframe>
                </div>
                <div class="modal-footer border-0 bg-black p-3 d-flex justify-content-between align-items-center">
                    <span class="small text-white-50"><i class="bi bi-info-circle me-1"></i> Utama Widyalaya Astika Dharma</span>
                    <a href="https://youtube.com/@asdhatv?si=6dcfwv3FKNSWBKNu" target="_blank" class="btn btn-danger btn-sm rounded-pill px-3 fw-bold">
                        <i class="bi bi-youtube me-1"></i> Buka di YouTube @asdhatv
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalVideoAsdha_4" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 overflow-hidden bg-dark text-white shadow-2xl">
                <div class="modal-header border-0 bg-black p-3 d-flex justify-content-between align-items-center">
                    <h6 class="modal-title fw-bold text-white mb-0 d-flex align-items-center gap-2">
                        <i class="bi bi-youtube text-danger fs-5"></i> ASDHA TV - Pembelajaran Deep Learning
                    </h6>
                    <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden;">
                    <iframe src="https://www.youtube.com/embed/live_stream?channel=asdhatv" style="position: absolute; top:0; left:0; width:100%; height:100%; border:0;" allowfullscreen title="ASDHA TV Video Clip 4"></iframe>
                </div>
                <div class="modal-footer border-0 bg-black p-3 d-flex justify-content-between align-items-center">
                    <span class="small text-white-50"><i class="bi bi-info-circle me-1"></i> Utama Widyalaya Astika Dharma</span>
                    <a href="https://youtube.com/@asdhatv?si=6dcfwv3FKNSWBKNu" target="_blank" class="btn btn-danger btn-sm rounded-pill px-3 fw-bold">
                        <i class="bi bi-youtube me-1"></i> Buka di YouTube @asdhatv
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Tenaga Pendidik & Staff Sekolah -->
    <section class="guru-staff-section py-5 bg-light" id="guru-staff">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2" data-aos="fade-up">
                <div>
                    <span style="color: var(--accent); font-weight: 700; text-transform: uppercase; letter-spacing: 1px; font-size: 0.9rem;">👨‍🏫 Tim Pengajar & Staff</span>
                    <h2 class="section-title text-start mt-1 mb-0">Tenaga Pendidik & Staff Sekolah</h2>
                    <p class="text-muted mt-1 mb-0">Guru dan staff berdedikasi tinggi yang siap membimbing dan mengajar peserta didik.</p>
                </div>
                <a href="{{ route('guru_staff') }}" class="btn btn-outline-primary fw-bold rounded-pill px-4">
                    Lihat Semua Guru & Staff &rarr;
                </a>
            </div>

            <div class="row g-4" data-aos="fade-up" data-aos-delay="100">
                @forelse($gurus->take(4) as $g)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card border-0 shadow-sm rounded-4 h-100 text-center overflow-hidden hover-card" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modalGuruLanding_{{ $g->id }}">
                        <div style="height: 220px; background-color: #f1f5f9;" class="position-relative overflow-hidden">
                            @if($g->foto)
                                <img src="{{ asset('storage/'.$g->foto) }}" alt="{{ $g->nama }}" class="w-100 h-100 object-fit-cover">
                            @else
                                <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary fw-bold fs-1">
                                    {{ strtoupper(substr($g->nama, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div class="card-body p-3 d-flex flex-column justify-content-between">
                            <div>
                                <h6 class="fw-bold text-dark mb-1">{{ $g->nama }}</h6>
                                <span class="badge bg-primary bg-opacity-10 text-primary fw-bold px-2.5 py-1 rounded-pill small">{{ $g->mata_pelajaran }}</span>
                                @if($g->nip)
                                    <small class="text-muted d-block mt-1.5 font-monospace" style="font-size: 0.75rem;">NIP: {{ $g->nip }}</small>
                                @endif
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3 py-1 mt-2.5 fw-semibold w-100" style="font-size: 0.8rem;">
                                <i class="bi bi-person-lines-fill me-1"></i> Detail Profil
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-4 text-muted">Belum ada data guru/staff terdaftar.</div>
                @endforelse
            </div>

            <!-- Modals Guru & Staff -->
            @foreach($gurus->take(4) as $g)
            <div class="modal fade text-start" id="modalGuruLanding_{{ $g->id }}" tabindex="-1" aria-labelledby="modalGuruLandingLabel_{{ $g->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content border-0 shadow-lg overflow-hidden rounded-4">
                        <div class="modal-header border-0 bg-primary text-white p-4 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-3">
                                <span class="badge bg-white text-primary p-2.5 rounded-circle shadow-sm">
                                    <i class="bi bi-person-workspace fs-5"></i>
                                </span>
                                <div>
                                    <span class="badge bg-light text-primary fw-bold text-uppercase px-2.5 py-1 mb-1" style="font-size: 0.75rem;">Tenaga Pendidik / Guru</span>
                                    <h4 class="modal-title fw-bold mb-0 text-white" id="modalGuruLandingLabel_{{ $g->id }}">{{ $g->nama }}</h4>
                                </div>
                            </div>
                            <button type="button" class="btn-close btn-close-white ms-auto shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4 bg-white">
                            <div class="row g-4 align-items-center">
                                <div class="col-md-5">
                                    <div class="rounded-4 overflow-hidden border shadow-sm" style="height: 300px; background-color: #f1f5f9;">
                                        @if($g->foto)
                                            <img src="{{ asset('storage/'.$g->foto) }}" alt="{{ $g->nama }}" class="w-100 h-100 object-fit-cover">
                                        @else
                                            <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary fw-bold fs-1">
                                                {{ strtoupper(substr($g->nama, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <h4 class="fw-bold text-dark mb-1">{{ $g->nama }}</h4>
                                    <p class="text-primary fw-bold mb-3"><i class="bi bi-journal-bookmark-fill me-1.5"></i>Mata Pelajaran: {{ $g->mata_pelajaran ?? 'Pengajar' }}</p>
                                    
                                    <div class="p-3 bg-light rounded-3 border mb-3">
                                        <div class="row g-2 small">
                                            @if($g->nip)
                                            <div class="col-12">
                                                <span class="text-muted d-block fw-bold">NIP / NUPTK:</span>
                                                <span class="font-monospace fw-bold text-dark">{{ $g->nip }}</span>
                                            </div>
                                            @endif
                                            <div class="col-6 mt-2">
                                                <span class="text-muted d-block fw-bold">STATUS:</span>
                                                <span class="badge bg-success bg-opacity-10 text-success fw-bold px-2 py-1 rounded">{{ $g->status ?? 'Aktif' }}</span>
                                            </div>
                                            <div class="col-6 mt-2">
                                                <span class="text-muted d-block fw-bold">INSTANSI:</span>
                                                <span class="fw-bold text-dark">{{ $profil?->nama_sekolah ?? 'SMK Astika Dharma' }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="p-3 bg-light rounded-3 border">
                                        <h6 class="fw-bold text-dark mb-1"><i class="bi bi-person-badge-fill me-1 text-primary"></i> Peran & Pengabdian</h6>
                                        <p class="text-secondary small leading-relaxed mb-0">
                                            Berdedikasi penuh untuk membimbing peserta didik dalam meningkatkan kompetensi keahlian, pembentukan karakter mulia, dan persiapan karir masa depan.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-top bg-light px-4 py-3 d-flex justify-content-between align-items-center">
                            <span class="text-muted small"><i class="bi bi-building me-1"></i> {{ $profil?->nama_sekolah ?? 'SMK Astika Dharma' }}</span>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-secondary px-4 rounded-pill" data-bs-dismiss="modal">Tutup</button>
                                <a href="{{ route('guru_staff') }}" class="btn btn-primary px-4 rounded-pill">
                                    <i class="bi bi-people-fill me-1"></i> Lihat Semua Guru & Staff &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
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
            <div class="prestasi-box mb-5 p-3 p-md-4" data-aos="fade-up" data-aos-duration="900">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-4 col-md-5">
                        <div class="prestasi-img-card shadow-sm" style="height: 280px !important; border-radius: 16px; overflow: hidden;">
                            <img src="{{ $prestasiUtama->foto_bukti ? asset('storage/'.$prestasiUtama->foto_bukti) : asset('storage/prestasi/default.jpg') }}" alt="{{ $prestasiUtama->judul_prestasi }}">
                            <div class="prestasi-img-overlay"></div>
                            <div class="position-absolute top-0 start-0 m-3 z-2">
                                <span class="badge bg-warning text-dark fw-bold px-3 py-2 rounded-pill shadow-sm d-inline-flex align-items-center gap-1" style="font-size: 0.8rem; letter-spacing: 0.5px;">
                                    <i class="bi bi-star-fill"></i> PRESTASI UTAMA
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-7 ps-lg-3">
                        <div class="prestasi-content-inner">
                            <!-- Badges Row -->
                            <div class="d-flex align-items-center gap-2 flex-wrap mb-3">
                                <span class="badge bg-warning bg-opacity-20 text-dark border border-warning border-opacity-25 px-3 py-2 rounded-pill fw-bold" style="font-size: 0.85rem;">
                                    <i class="bi bi-trophy-fill text-warning me-1"></i> {{ $prestasiUtama->peringkat }}
                                </span>
                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-20 px-3 py-2 rounded-pill fw-bold" style="font-size: 0.85rem;">
                                    <i class="bi bi-geo-alt-fill me-1"></i> Tingkat {{ $prestasiUtama->tingkat }}
                                </span>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-20 px-3 py-2 rounded-pill fw-bold" style="font-size: 0.85rem;">
                                    <i class="bi bi-calendar-event me-1"></i> Tahun {{ $prestasiUtama->tahun }}
                                </span>
                                @if(!empty($prestasiUtama->kategori))
                                <span class="badge bg-info bg-opacity-10 text-dark border border-info border-opacity-20 px-3 py-2 rounded-pill fw-bold" style="font-size: 0.85rem;">
                                    <i class="bi bi-tag-fill me-1 text-info"></i> {{ $prestasiUtama->kategori }}
                                </span>
                                @endif
                            </div>

                            <!-- Title -->
                            <h2 class="text-capitalize">{{ $prestasiUtama->judul_prestasi }}</h2>

                            <!-- Student Identity Card -->
                            <div class="p-3 rounded-4 my-3 border d-flex align-items-center gap-3" style="background-color: #F8FAFC; border-color: #E2E8F0 !important;">
                                <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px;">
                                    <i class="bi bi-person-fill fs-5"></i>
                                </div>
                                <div class="overflow-hidden">
                                    <div class="text-muted fw-semibold text-uppercase" style="font-size: 0.725rem; letter-spacing: 0.5px;">Raihan Prestasi Oleh</div>
                                    <div class="fw-bold text-dark fs-6 text-truncate">
                                        {{ $prestasiUtama->nama_siswa }}
                                        @if($prestasiUtama->kelas)
                                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-20 ms-1 rounded-pill px-2 py-1 fw-semibold" style="font-size: 0.75rem;">
                                                Kelas {{ $prestasiUtama->kelas }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <p class="text-secondary mb-4" style="font-size: 0.975rem; line-height: 1.65; color: #475569;">
                                {{ $prestasiUtama->deskripsi ?: 'Berhasil meraih Juara dan mengharumkan nama sekolah dalam ajang kompetisi tingkat ' . $prestasiUtama->tingkat . '.' }}
                            </p>

                            <!-- Action Buttons -->
                            <div class="d-flex align-items-center gap-3 flex-wrap pt-3 border-top" style="border-color: #F1F5F9 !important;">
                                <button type="button" class="btn btn-primary px-4 py-2.5 rounded-pill fw-bold shadow-sm hover-elevate d-inline-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalLandingPrestasi{{ $prestasiUtama->id }}" style="font-size: 0.95rem;">
                                    <i class="bi bi-eye-fill"></i> Lihat Detail Prestasi
                                </button>
                                <a href="#daftar-prestasi-grid" class="btn btn-outline-primary px-4 py-2.5 rounded-pill fw-bold hover-elevate d-inline-flex align-items-center gap-2" style="font-size: 0.95rem;">
                                    <i class="bi bi-trophy-fill"></i> Semua Daftar Prestasi ({{ count($prestasiList) }})
                                </a>
                            </div>
                        </div>
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
                                <i class="bi bi-eye-fill me-1"></i> Detail & Deskripsi Singkat
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
                                        <i class="bi bi-eye-fill me-1"></i> Detail & Deskripsi Singkat
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
                    <h2 class="section-title" style="margin-bottom: 0;">Berita & Pengumuman Terbaru</h2>
                </div>
            </div>

            <div class="news-grid">
                <!-- Highlight News -->
                @if($beritaHighlight)
                @php
                    $fotoHighlight = $beritaHighlight->foto ? (str_starts_with($beritaHighlight->foto, 'http') ? $beritaHighlight->foto : asset($beritaHighlight->foto)) : 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&w=600&q=80';
                @endphp
                <div class="news-main" data-aos="fade-right">
                    <img src="{{ $fotoHighlight }}" alt="{{ $beritaHighlight->judul }}">
                    <div class="news-main-overlay">
                        <span class="news-date">{{ \Carbon\Carbon::parse($beritaHighlight->tanggal_publikasi)->translatedFormat('d F Y') }}</span>
                        <h3>{{ $beritaHighlight->judul }}</h3>
                        <p class="text-white-50 small mb-2 d-none d-md-block">{{ Str::limit(strip_tags($beritaHighlight->konten), 120) }}</p>
                        <button type="button" class="btn btn-sm btn-light fw-bold rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalBeritaLanding{{ $beritaHighlight->id }}">
                            Baca Selengkapnya &rarr;
                        </button>
                    </div>
                </div>

                <!-- Modal Detail Highlight -->
                <div class="modal fade" id="modalBeritaLanding{{ $beritaHighlight->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content border-0 shadow-lg rounded-4">
                            <div class="modal-header bg-dark text-white py-3">
                                <h5 class="modal-title fw-bold text-white"><i class="bi bi-newspaper me-2 text-warning"></i>{{ $beritaHighlight->judul }}</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body p-4">
                                <img src="{{ $fotoHighlight }}" class="img-fluid rounded-3 mb-3 w-100 object-fit-cover" style="max-height: 350px;">
                                <small class="text-muted d-block mb-3">📅 Dipublikasikan pada: {{ \Carbon\Carbon::parse($beritaHighlight->tanggal_publikasi)->translatedFormat('d F Y') }} | Kategori: {{ $beritaHighlight->kategori ?: 'Pengumuman' }}</small>
                                <div class="text-dark" style="line-height: 1.8;">{!! nl2br(e($beritaHighlight->konten)) !!}</div>
                            </div>
                            <div class="modal-footer bg-light border-0 py-2">
                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Small News List -->
                <div class="news-list">
                    @forelse($beritaList as $berita)
                    @php
                        $fotoB = $berita->foto ? (str_starts_with($berita->foto, 'http') ? $berita->foto : asset($berita->foto)) : 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&w=600&q=80';
                    @endphp
                    <div class="news-card shadow-sm rounded-3 overflow-hidden bg-white mb-3">
                        <img src="{{ $fotoB }}" alt="{{ $berita->judul }}">
                        <div class="news-card-content p-3">
                            <span class="news-date" style="font-size: 0.75rem; color: var(--accent);">{{ \Carbon\Carbon::parse($berita->tanggal_publikasi)->translatedFormat('d F Y') }}</span>
                            <h4 class="fw-bold mb-2" style="font-size: 1rem;">{{ $berita->judul }}</h4>
                            <button type="button" class="btn btn-link text-primary p-0 border-0 fw-bold small text-decoration-none" data-bs-toggle="modal" data-bs-target="#modalBeritaLanding{{ $berita->id }}">
                                Baca selengkapnya &rarr;
                            </button>
                        </div>
                    </div>

                    <!-- Modal Detail Small Berita -->
                    <div class="modal fade" id="modalBeritaLanding{{ $berita->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content border-0 shadow-lg rounded-4">
                                <div class="modal-header bg-dark text-white py-3">
                                    <h5 class="modal-title fw-bold text-white"><i class="bi bi-newspaper me-2 text-warning"></i>{{ $berita->judul }}</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <img src="{{ $fotoB }}" class="img-fluid rounded-3 mb-3 w-100 object-fit-cover" style="max-height: 350px;">
                                    <small class="text-muted d-block mb-3">📅 Dipublikasikan pada: {{ \Carbon\Carbon::parse($berita->tanggal_publikasi)->translatedFormat('d F Y') }} | Kategori: {{ $berita->kategori ?: 'Berita' }}</small>
                                    <div class="text-dark" style="line-height: 1.8;">{!! nl2br(e($berita->konten)) !!}</div>
                                </div>
                                <div class="modal-footer bg-light border-0 py-2">
                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    @if(!$beritaHighlight)
                        <div class="text-center py-4 text-muted w-100">Belum ada berita atau pengumuman dipublikasikan.</div>
                    @endif
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <!-- Agenda & Event Acara Sekolah -->
    @if(count($agendas) > 0)
    <section class="agenda bg-white py-5" id="agenda">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span style="color: var(--accent); font-weight: 700; text-transform: uppercase; letter-spacing: 1px; font-size: 0.9rem;">📅 Kalender Kegiatan</span>
                <h2 class="section-title text-center mt-1" style="margin-bottom: 0;">Agenda & Event Acara Sekolah</h2>
                <p class="text-muted mt-2 mx-auto" style="max-width: 600px;">Jadwal kegiatan, seminar, ujian, dan acara penting sekolah yang akan datang.</p>
            </div>

            <div class="row g-4">
                @foreach($agendas as $agenda)
                <div class="col-md-6 col-lg-4" data-aos="fade-up">
                    <div class="card h-100 border-0 shadow-sm rounded-4 p-4 bg-light border-start border-4 border-primary">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="bg-primary text-white rounded-3 p-3 text-center" style="min-width: 65px;">
                                <span class="d-block fw-bold fs-4" style="line-height: 1;">{{ \Carbon\Carbon::parse($agenda->tanggal)->format('d') }}</span>
                                <span class="small text-uppercase">{{ \Carbon\Carbon::parse($agenda->tanggal)->translatedFormat('M Y') }}</span>
                            </div>
                            <div>
                                <span class="badge bg-primary bg-opacity-10 text-primary small border border-primary mb-1">{{ $agenda->kategori ?: 'Agenda Sekolah' }}</span>
                                <h5 class="fw-bold text-dark mb-0" style="font-size: 1.1rem;">{{ $agenda->judul }}</h5>
                            </div>
                        </div>
                        <p class="text-muted small mb-3">{{ $agenda->deskripsi ?: 'Kegiatan penting sekolah.' }}</p>
                        <div class="mt-auto d-flex justify-content-between align-items-center small text-muted border-top pt-2">
                            <span><i class="bi bi-clock me-1"></i>{{ $agenda->waktu_mulai ? substr($agenda->waktu_mulai,0,5) : '08:00' }} WITA</span>
                            <span><i class="bi bi-geo-alt me-1"></i>{{ $agenda->lokasi ?: 'Aula Sekolah' }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Galeri Kegiatan Sekolah -->
    <section class="gallery bg-light py-5" id="galeri">
        <div class="container">
            <div class="text-center mb-4" data-aos="fade-up">
                <span style="color: var(--accent); font-weight: 700; text-transform: uppercase; letter-spacing: 1px; font-size: 0.9rem;">📸 Dokumentasi & Kegiatan</span>
                <h2 class="section-title text-center mt-1 mb-0">Galeri Kegiatan Sekolah</h2>
                <p class="text-muted mt-1 mx-auto" style="max-width: 600px;">Kumpulan momen berharga, dokumentasi acara, praktikum, dan suasana kegiatan di {{ $profil?->nama_sekolah ?? 'SMK Astika Dharma' }}.</p>
            </div>

            <div class="gallery-grid" data-aos="fade-up" data-aos-delay="100">
                @forelse($galeri as $gal)
                @php
                    $fotoG = $gal->foto ? (str_starts_with($gal->foto, 'http') ? $gal->foto : asset($gal->foto)) : 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=600&q=80';
                    $judulGaleri = $gal->judul ?? $gal->caption ?? 'Dokumentasi Sekolah';
                @endphp
                <div class="gallery-item position-relative overflow-hidden rounded-4 shadow-sm cursor-pointer" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modalGaleriLanding_{{ $gal->id }}">
                    <img src="{{ $fotoG }}" alt="{{ $judulGaleri }}" class="w-100 h-100 object-fit-cover" style="transition: transform 0.4s ease;">
                    <div class="gallery-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-3 text-white" style="background: linear-gradient(to top, rgba(15,23,42,0.85) 0%, rgba(15,23,42,0.2) 60%, transparent 100%); opacity: 0; transition: opacity 0.3s ease;">
                        @if(!empty($gal->kategori))
                            <span class="badge bg-primary bg-opacity-75 text-white align-self-start mb-2 px-2.5 py-1 rounded-pill small"><i class="bi bi-camera-fill me-1"></i> {{ $gal->kategori }}</span>
                        @endif
                        <h6 class="fw-bold text-white mb-1 text-truncate">{{ $judulGaleri }}</h6>
                        <button type="button" class="btn btn-light btn-sm rounded-pill px-3 py-1 fw-semibold text-primary shadow-sm align-self-start mt-1 d-inline-flex align-items-center gap-1" style="font-size: 0.8rem;">
                            <i class="bi bi-zoom-in me-1"></i> Lihat Foto & Detail
                        </button>
                    </div>
                </div>
                @empty
                <div class="text-center py-4 text-muted w-100">Belum ada foto galeri terdaftar.</div>
                @endforelse
            </div>

            <!-- Modals Galeri Lightbox -->
            @foreach($galeri as $gal)
            @php
                $fotoG = $gal->foto ? (str_starts_with($gal->foto, 'http') ? $gal->foto : asset($gal->foto)) : 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=600&q=80';
                $judulGaleri = $gal->judul ?? $gal->caption ?? 'Dokumentasi Sekolah';
            @endphp
            <div class="modal fade text-start" id="modalGaleriLanding_{{ $gal->id }}" tabindex="-1" aria-labelledby="modalGaleriLandingLabel_{{ $gal->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content border-0 shadow-lg overflow-hidden rounded-4">
                        <div class="modal-header border-0 bg-dark text-white p-4 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-3">
                                <span class="badge bg-white text-dark p-2.5 rounded-circle shadow-sm">
                                    <i class="bi bi-camera-fill fs-5 text-primary"></i>
                                </span>
                                <div>
                                    <span class="badge bg-primary fw-bold text-uppercase px-2.5 py-1 mb-1" style="font-size: 0.75rem;">{{ $gal->kategori ?? 'Dokumentasi Kegiatan' }}</span>
                                    <h4 class="modal-title fw-bold mb-0 text-white" id="modalGaleriLandingLabel_{{ $gal->id }}">{{ $judulGaleri }}</h4>
                                </div>
                            </div>
                            <button type="button" class="btn-close btn-close-white ms-auto shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-0 bg-black text-center">
                            <div class="p-2" style="background-color: #0f172a;">
                                <img src="{{ $fotoG }}" alt="{{ $judulGaleri }}" class="w-100 object-fit-contain rounded-2" style="max-height: 480px; object-fit: contain;">
                            </div>
                            <div class="p-4 text-start bg-white text-dark">
                                <h5 class="fw-bold text-dark mb-2 d-flex align-items-center gap-2">
                                    <i class="bi bi-card-text text-primary fs-5"></i> Keterangan Foto Dokumentasi
                                </h5>
                                <p class="text-secondary leading-relaxed mb-0" style="font-size: 0.98rem; line-height: 1.7; white-space: pre-line;">
                                    {{ $gal->deskripsi ?? $gal->keterangan ?? 'Dokumentasi kegiatan dan momen kebersamaan warga SMK Astika Dharma.' }}
                                </p>
                            </div>
                        </div>
                        <div class="modal-footer border-top bg-light px-4 py-3 d-flex justify-content-between align-items-center">
                            <span class="text-muted small"><i class="bi bi-building me-1"></i> {{ $profil?->nama_sekolah ?? 'SMK Astika Dharma' }}</span>
                            <button type="button" class="btn btn-secondary px-4 rounded-pill" data-bs-dismiss="modal">Tutup Foto</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <style>
            .gallery-item:hover .gallery-overlay { opacity: 1 !important; }
            .gallery-item:hover img { transform: scale(1.06) !important; }
        </style>
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
    <section class="faq bg-light py-5" id="faq">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3" data-aos="fade-up">
                <div>
                    <span style="color: var(--accent); font-weight: 700; text-transform: uppercase; letter-spacing: 1px; font-size: 0.9rem;">❓ Informasi & Bantuan</span>
                    <h2 class="section-title text-start mt-1 mb-0">Pertanyaan yang Sering Ditanyakan</h2>
                </div>
                <button type="button" class="btn btn-primary fw-bold rounded-pill px-4 shadow-sm d-inline-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalAjukanPertanyaan">
                    <i class="bi bi-question-circle-fill fs-5"></i> Ajukan Pertanyaan ke Sekolah
                </button>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2 fs-5"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @forelse($faqs as $index => $faq)
            <details class="faq-item" {{ $index == 0 ? 'open' : '' }}>
                <summary class="faq-summary fw-bold">
                    <span>
                        {{ $faq->pertanyaan }}
                        @if($faq->nama_penanya)
                            <small class="badge bg-primary bg-opacity-10 text-primary ms-2 rounded-pill fw-normal" style="font-size: 0.78rem;">(Ditanyakan oleh: {{ $faq->nama_penanya }})</small>
                        @endif
                    </span>
                    <i data-lucide="plus" class="faq-icon"></i>
                </summary>
                <div class="faq-content">
                    <p class="mb-0">{{ $faq->jawaban }}</p>
                </div>
            </details>
            @empty
                <div class="text-center py-4 text-muted">Belum ada FAQ yang ditampilkan. Klik tombol di atas untuk mengajukan pertanyaan pertama Anda!</div>
            @endforelse
        </div>
    </section>

    <!-- Modal Ajukan Pertanyaan Baru ke Sekolah -->
    <div class="modal fade text-start" id="modalAjukanPertanyaan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header bg-dark text-white p-3.5 d-flex justify-content-between align-items-center">
                    <h5 class="modal-title fw-bold text-white mb-0 d-flex align-items-center gap-2">
                        <i class="bi bi-patch-question-fill text-warning fs-5"></i> Ajukan Pertanyaan ke Pihak Sekolah
                    </h5>
                    <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('faq.tanya') }}#faq" method="POST">
                    @csrf
                    <div class="modal-body p-4 bg-white">
                        <div class="p-3 bg-light rounded-3 border-start border-4 border-primary mb-3">
                            <small class="text-secondary d-block" style="line-height: 1.5;">
                                Punya pertanyaan seputar pendaftaran PPDB, program keahlian, atau kegiatan di Utama Widyalaya Astika Dharma? Kirimkan pertanyaan Anda di bawah ini untuk ditinjau & dijawab oleh Admin Sekolah.
                            </small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-dark">Nama Lengkap Anda <span class="text-danger">*</span></label>
                            <input type="text" name="nama_penanya" class="form-control rounded-3" required placeholder="Tuliskan nama lengkap Anda...">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-dark">Email / No. WhatsApp (Opsional)</label>
                            <input type="text" name="email_penanya" class="form-control rounded-3" placeholder="Contoh: 081234567890 / email@domain.com">
                            <small class="text-muted" style="font-size: 0.78rem;">Untuk notifikasi atau tanggapan langsung dari sekolah.</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-dark">Pertanyaan Anda <span class="text-danger">*</span></label>
                            <textarea name="pertanyaan" class="form-control rounded-3" rows="4" required placeholder="Tuliskan pertanyaan Anda secara jelas dan lengkap..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-0 py-3">
                        <button type="button" class="btn btn-secondary btn-sm rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4 fw-bold shadow-sm">
                            <i class="bi bi-send-fill me-1"></i> Kirim Pertanyaan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
    <!-- Kontak Resmi & Sosial Media Sekolah -->
    <section class="contact-section py-5 bg-white position-relative" id="kontak">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-bold mb-2 uppercase" style="letter-spacing: 1px;">
                    <i class="bi bi-headset me-1"></i> Layanan Informasi
                </span>
                <h2 class="section-title text-center mb-1">Kontak Resmi & Sosial Media Sekolah</h2>
                <p class="text-muted mt-2 mx-auto" style="max-width: 650px;">
                    Hubungi kami atau ikuti media sosial resmi {{ $profil?->nama_sekolah ?? 'Utama Widyalaya Astika Dharma' }} untuk mendapatkan informasi kegiatan, penyiaran ASDHA TV, dan pendaftaran siswa baru.
                </p>
            </div>

            @php
                $waNum = preg_replace('/[^0-9]/', '', $profil?->whatsapp ?? $profil?->telepon ?? '081234567890');
                if (str_starts_with($waNum, '0')) {
                    $waNum = '62' . substr($waNum, 1);
                }
                $igUser = ltrim($profil?->instagram ?? 'asdhatv', '@');
                if (str_starts_with($igUser, 'http')) {
                    $igUrl = $igUser;
                } else {
                    $igUrl = 'https://instagram.com/' . $igUser;
                }

                $ttUser = ltrim($profil?->tiktok ?? 'asdhatv', '@');
                if (str_starts_with($ttUser, 'http')) {
                    $ttUrl = $ttUser;
                } else {
                    $ttUrl = 'https://tiktok.com/@' . $ttUser;
                }

                $ytUrl = $profil?->youtube ?: 'https://youtube.com/@asdhatv?si=6dcfwv3FKNSWBKNu';
                $emailResmi = $profil?->email ?: 'info@astikadharma.sch.id';
                $telpResmi = $profil?->telepon ?: '081234567890';
            @endphp

            <div class="row g-4 justify-content-center" data-aos="fade-up" data-aos-delay="100">
                <!-- WhatsApp Card -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-4 p-4 text-center bg-light transition-hover border-bottom border-4 border-success">
                        <div class="rounded-circle bg-success text-white d-inline-flex align-items-center justify-content-center mb-3 mx-auto shadow-sm" style="width: 60px; height: 60px; background: #25D366 !important;">
                            <i class="bi bi-whatsapp fs-3"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">WhatsApp Resmi</h5>
                        <p class="text-muted small mb-3">Chat langsung dengan panitia PPDB & Humas Sekolah</p>
                        <a href="https://wa.me/{{ $waNum }}?text=Halo%20Admin%20Astika%20Dharma,%20saya%20ingin%20bertanya%20informasi%20sekolah" target="_blank" class="btn btn-success btn-sm rounded-pill fw-bold w-100 py-2 shadow-sm d-inline-flex align-items-center justify-content-center gap-1" style="background: #25D366; border: none;">
                            <i class="bi bi-chat-dots-fill me-1"></i> Chat via WhatsApp
                        </a>
                    </div>
                </div>

                <!-- Instagram Card -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-4 p-4 text-center bg-light transition-hover border-bottom border-4 border-danger">
                        <div class="rounded-circle text-white d-inline-flex align-items-center justify-content-center mb-3 mx-auto shadow-sm" style="width: 60px; height: 60px; background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);">
                            <i class="bi bi-instagram fs-3"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Instagram Official</h5>
                        <p class="text-muted small mb-3">Dokumentasi foto harian & info kegiatan terkini</p>
                        <a href="{{ $igUrl }}" target="_blank" class="btn btn-danger btn-sm rounded-pill fw-bold w-100 py-2 shadow-sm d-inline-flex align-items-center justify-content-center gap-1" style="background: #e1306c; border: none;">
                            <i class="bi bi-instagram me-1"></i> Follow Instagram
                        </a>
                    </div>
                </div>

                <!-- TikTok Card -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-4 p-4 text-center bg-light transition-hover border-bottom border-4 border-dark">
                        <div class="rounded-circle bg-dark text-white d-inline-flex align-items-center justify-content-center mb-3 mx-auto shadow-sm" style="width: 60px; height: 60px;">
                            <i class="bi bi-tiktok fs-3"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">TikTok Official</h5>
                        <p class="text-muted small mb-3">Konten kreatif siswa & liputan singkat ASDHA TV</p>
                        <a href="{{ $ttUrl }}" target="_blank" class="btn btn-dark btn-sm rounded-pill fw-bold w-100 py-2 shadow-sm d-inline-flex align-items-center justify-content-center gap-1">
                            <i class="bi bi-tiktok me-1"></i> Tonton di TikTok
                        </a>
                    </div>
                </div>

                <!-- Email Resmi Card -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-4 p-4 text-center bg-light transition-hover border-bottom border-4 border-warning">
                        <div class="rounded-circle bg-warning text-dark d-inline-flex align-items-center justify-content-center mb-3 mx-auto shadow-sm" style="width: 60px; height: 60px;">
                            <i class="bi bi-envelope-at-fill fs-3 text-white"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Email Resmi</h5>
                        <p class="text-muted small mb-3">{{ $emailResmi }}</p>
                        <a href="mailto:{{ $emailResmi }}" class="btn btn-warning btn-sm text-dark rounded-pill fw-bold w-100 py-2 shadow-sm d-inline-flex align-items-center justify-content-center gap-1">
                            <i class="bi bi-send-fill me-1"></i> Kirim Email
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function switchHeroVideo(url, title) {
            const player = document.getElementById('heroMainPlayer');
            if (player) {
                player.src = url;
                player.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }

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
