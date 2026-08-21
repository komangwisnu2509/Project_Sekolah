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
            <p class="section-subtitle mx-auto" data-aos="fade-up" data-aos-delay="100">Temukan bidang yang sesuai dengan minat dan masa depanmu. Klik pada salah satu jurusan untuk melihat foto dan informasi selengkapnya.</p>
            
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

                <!-- Modal Detail Program Keahlian -->
                <div class="modal fade" id="jurusanModal_{{ $jurusan->id }}" tabindex="-1" aria-labelledby="jurusanModalLabel_{{ $jurusan->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content border-0 shadow-lg overflow-hidden rounded-4">
                            <div class="modal-header border-0 bg-primary text-white p-4">
                                <div class="d-flex align-items-center gap-3">
                                    <span class="badge bg-white text-primary p-2.5 rounded-circle shadow-sm">
                                        <i class="bi bi-award-fill fs-5"></i>
                                    </span>
                                    <div class="text-start">
                                        <span class="badge bg-light text-primary fw-bold text-uppercase px-2.5 py-1 mb-1">Program Keahlian</span>
                                        <h4 class="modal-title fw-bold mb-0 text-white" id="jurusanModalLabel_{{ $jurusan->id }}">{{ $jurusan->nama_jurusan }}</h4>
                                    </div>
                                </div>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4 text-start">
                                <!-- Banner Foto Jurusan -->
                                <div class="jurusan-banner-img mb-4 rounded-3 overflow-hidden border shadow-sm" style="max-height: 320px;">
                                    <img src="{{ $jurusanFoto }}" alt="{{ $jurusan->nama_jurusan }}" class="w-100 h-100 object-fit-cover" style="max-height: 320px; object-fit: cover; width: 100%;">
                                </div>

                                <!-- Ringkasan & Deskripsi -->
                                <div class="mb-4">
                                    <h5 class="fw-bold text-dark d-flex align-items-center gap-2 mb-2">
                                        <i class="bi bi-card-text text-primary fs-5"></i> Ringkasan Program
                                    </h5>
                                    <p class="text-secondary leading-relaxed mb-0" style="font-size: 0.98rem; line-height: 1.7;">
                                        {{ $jurusan->deskripsi ?? 'Program keahlian ini dirancang untuk membekali peserta didik dengan pengetahuan teori dan keterampilan praktis berbasis kurikulum industri unggulan.' }}
                                    </p>
                                </div>

                                <!-- Detail Informasi & Prospek Kerja -->
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
                                <span class="text-muted small"><i class="bi bi-building me-1"></i> SMK Astika Dharma</span>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Tutup</button>
                                    @if(Route::has('ppdb.public'))
                                        <a href="{{ route('ppdb.public') }}" class="btn btn-primary fw-bold px-3">
                                            <i class="bi bi-person-plus-fill me-1"></i> Daftar PPDB Jurusan Ini
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
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
                @forelse($fasilitas as $index => $fac)
                @php
                    $fotoFac = $fac->foto ? (str_starts_with($fac->foto, 'http') ? $fac->foto : asset($fac->foto)) : 'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=600&q=80';
                @endphp
                <div class="fac-item {{ $fac->is_large ? 'large' : '' }}" @if($index == 0) data-aos="zoom-in" data-aos-duration="800" @endif>
                    <img src="{{ $fotoFac }}" alt="{{ $fac->nama_fasilitas }}">
                    <div class="fac-overlay">
                        <div class="fac-content">
                            <h3>{{ $fac->nama_fasilitas }}</h3>
                            @if($fac->deskripsi)
                            <p>{{ $fac->deskripsi }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-4 text-muted w-100">Belum ada foto fasilitas terdaftar.</div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Ekstrakurikuler -->
    <section class="eksul bg-white py-5" id="ekstrakurikuler">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span style="color: var(--accent); font-weight: 700; text-transform: uppercase; letter-spacing: 1px; font-size: 0.9rem;">🎨 Pengembangan Minat & Bakat</span>
                <h2 class="section-title text-center mt-1" style="margin-bottom: 0;">Ekstrakurikuler Sekolah</h2>
                <p class="text-muted mt-2 mx-auto" style="max-width: 600px;">Wadah bagi seluruh peserta didik untuk mengasah bakat, kepemimpinan, seni, dan kreativitas.</p>
            </div>
            
            <div class="eksul-wrapper" data-aos="fade-left" data-aos-delay="200">
                @forelse($ekstrakurikuler as $eks)
                @php
                    $namaEkskul = $eks->nama_ekskul ?? $eks->nama_ekstrakurikuler ?? 'Ekstrakurikuler';
                    $fotoEkskul = $eks->foto ? (str_contains($eks->foto, 'http') ? $eks->foto : asset('storage/'.$eks->foto)) : 'https://images.unsplash.com/photo-1511632765486-a01980e01a18?auto=format&fit=crop&w=600&q=80';
                @endphp
                <div class="eksul-card">
                    <img src="{{ $fotoEkskul }}" alt="{{ $namaEkskul }}">
                    <div class="overlay">
                        @if(!empty($eks->kategori))
                            <span class="badge bg-warning text-dark fw-bold mb-1 small">{{ $eks->kategori }}</span>
                        @endif
                        <h3>{{ $namaEkskul }}</h3>
                        @if(!empty($eks->hari_latihan))
                            <small class="text-white-50 d-block mt-1"><i class="bi bi-clock me-1"></i>Latihan: {{ $eks->hari_latihan }}</small>
                        @endif
                    </div>
                </div>
                @empty
                <div class="text-center py-4 text-muted w-100">Belum ada daftar ekstrakurikuler terdaftar.</div>
                @endforelse
            </div>
        </div>
    </section>

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
                    <div class="card border-0 shadow-sm rounded-4 h-100 text-center overflow-hidden">
                        <div style="height: 220px; background-color: #f1f5f9;" class="position-relative overflow-hidden">
                            @if($g->foto)
                                <img src="{{ asset('storage/'.$g->foto) }}" alt="{{ $g->nama }}" class="w-100 h-100 object-fit-cover">
                            @else
                                <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary fw-bold fs-1">
                                    {{ strtoupper(substr($g->nama, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div class="card-body p-3">
                            <h6 class="fw-bold text-dark mb-1">{{ $g->nama }}</h6>
                            <span class="badge bg-primary bg-opacity-10 text-primary fw-bold px-2.5 py-1 rounded-pill small">{{ $g->mata_pelajaran }}</span>
                            @if($g->nip)
                                <small class="text-muted d-block mt-2 font-monospace" style="font-size: 0.75rem;">NIP: {{ $g->nip }}</small>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-4 text-muted">Belum ada data guru/staff terdaftar.</div>
                @endforelse
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

    <!-- Galeri (Masonry) -->
    <section class="gallery bg-light" id="galeri">
        <div class="container">
            <h2 class="section-title text-center" style="margin-bottom: 2rem;">Galeri Sekolah</h2>
            <div class="gallery-grid">
                @forelse($galeri as $gal)
                @php
                    $fotoG = $gal->foto ? (str_starts_with($gal->foto, 'http') ? $gal->foto : asset($gal->foto)) : 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=600&q=80';
                @endphp
                <div class="gallery-item"><img src="{{ $fotoG }}" alt="{{ $gal->judul }}"></div>
                @empty
                <div class="text-center py-4 text-muted w-100">Belum ada foto galeri terdaftar.</div>
                @endforelse
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
