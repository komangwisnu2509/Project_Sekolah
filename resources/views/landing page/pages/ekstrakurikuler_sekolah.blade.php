@extends('layouts.landing')

@section('content')
    <!-- Banner Header -->
    <div style="position: relative; height: 420px; display: flex; align-items: center; justify-content: center; text-align: center; color: white;">
        @php
            $headerBg = $profil?->hero_banner ? (str_starts_with($profil->hero_banner, 'http') ? $profil->hero_banner : asset('storage/'.$profil->hero_banner)) : 'https://images.unsplash.com/photo-1511632765486-a01980e01a18?q=80&w=2070&auto=format&fit=crop';
        @endphp
        <div style="position: absolute; inset: 0; background-image: url('{{ $headerBg }}'); background-size: cover; background-position: center; z-index: 1;"></div>
        <div style="position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(15,23,42,0.85), rgba(15,23,42,0.95)); z-index: 2;"></div>
        <div style="position: relative; z-index: 3; max-width: 850px; padding: 0 5%; margin-top: 50px;">
            <div style="display: inline-block; padding: 6px 18px; background: rgba(37,99,235,0.25); border: 1px solid rgba(59,130,246,0.4); border-radius: 50px; color: #93c5fd; font-size: 0.88rem; font-weight: 600; text-uppercase; letter-spacing: 1px; margin-bottom: 1rem;">
                🎨 Wadah Minat, Seni & Olahraga
            </div>
            <h1 style="font-size: 3.2rem; font-weight: 800; margin-bottom: 1rem; color: white; line-height: 1.2;">
                Ekstrakurikuler {{ $profil?->nama_sekolah ?? 'Astika Dharma' }}
            </h1>
            <div style="display: flex; gap: 0.5rem; justify-content: center; font-size: 0.98rem; opacity: 0.9;">
                <a href="{{ route('landing_page') }}" style="color: #93c5fd;">Beranda</a>
                <span style="color: #64748b;">/</span>
                <span style="color: #cbd5e1;">Akademik</span>
                <span style="color: #64748b;">/</span>
                <span style="color: #ffffff; font-weight: 600;">Ekstrakurikuler Sekolah</span>
            </div>
        </div>
    </div>
    
    <!-- Main Content Section -->
    <div class="container" style="padding: 4rem 5% 6rem; margin-top: -3rem; position: relative; z-index: 10;">
        
        <div style="background: var(--white); padding: 3.5rem 3rem; border-radius: var(--radius-lg); box-shadow: 0 20px 40px rgba(0,0,0,0.08); margin-bottom: 3.5rem;">
            <div style="text-align: center; max-width: 750px; margin: 0 auto 3rem;">
                <div style="display: inline-block; padding: 4px 14px; background: rgba(37,99,235,0.1); border-radius: 20px; color: var(--accent); font-weight: 700; font-size: 0.85rem; margin-bottom: 1rem;">
                    PENGEMBANGAN DIRI & KEPEMIMPINAN
                </div>
                <h2 class="section-title" style="font-size: 2.2rem; margin-bottom: 1rem; color: var(--primary);">
                    Temukan & Asah Minat Bakatmu
                </h2>
                <p style="font-size: 1.05rem; color: var(--text-muted); line-height: 1.7;">
                    Kegiatan ekstrakurikuler di {{ $profil?->nama_sekolah ?? 'SMK Astika Dharma' }} dirancang untuk membentuk karakter, melatih kerja sama tim, kepemimpinan, kreativitas, serta prestasi di luar bidang akademik.
                </p>
            </div>

            <!-- Grid Ekstrakurikuler -->
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 2rem;">
                @forelse($ekstrakurikulers as $index => $eks)
                @php
                    $namaEkskul = $eks->nama_ekskul ?? 'Ekstrakurikuler';
                    $fotoEkskul = $eks->foto ? (str_contains($eks->foto, 'http') ? $eks->foto : asset('storage/'.$eks->foto)) : 'https://images.unsplash.com/photo-1511632765486-a01980e01a18?auto=format&fit=crop&w=600&q=80';
                @endphp
                <div style="background: #ffffff; border-radius: var(--radius-md); border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 10px 20px rgba(0,0,0,0.04); transition: transform 0.3s ease, box-shadow 0.3s ease; display: flex; flex-direction: column;" data-aos="fade-up" data-aos-delay="{{ ($index % 3) * 100 }}">
                    <div style="position: relative; height: 220px; overflow: hidden;">
                        <img src="{{ $fotoEkskul }}" alt="{{ $namaEkskul }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;" onmouseover="this.style.transform='scale(1.06)'" onmouseout="this.style.transform='scale(1.0)'">
                        @if(!empty($eks->kategori))
                        <span style="position: absolute; top: 12px; right: 12px; background: rgba(37,99,235,0.9); color: #fff; padding: 4px 14px; border-radius: 20px; font-size: 0.78rem; font-weight: 700; backdrop-filter: blur(4px);">
                            {{ $eks->kategori }}
                        </span>
                        @endif
                    </div>
                    <div style="padding: 1.5rem; display: flex; flex-direction: column; flex-grow: 1;">
                        <h3 style="font-size: 1.35rem; font-weight: 700; color: var(--primary); margin-bottom: 0.5rem;">
                            {{ $namaEkskul }}
                        </h3>
                        
                        <div style="display: flex; flex-direction: column; gap: 0.4rem; font-size: 0.88rem; color: var(--text-muted); margin-bottom: 1.25rem;">
                            @if(!empty($eks->pembina))
                            <div><i class="bi bi-person-fill text-primary me-1.5"></i> Pembina: <strong>{{ $eks->pembina }}</strong></div>
                            @endif
                            @if(!empty($eks->hari_latihan))
                            <div><i class="bi bi-calendar-event text-warning me-1.5"></i> Jadwal: <strong>{{ $eks->hari_latihan }} {{ $eks->jam_latihan ? '('.$eks->jam_latihan.')' : '' }}</strong></div>
                            @endif
                            @if(!empty($eks->lokasi))
                            <div><i class="bi bi-geo-alt-fill text-danger me-1.5"></i> Lokasi: <strong>{{ $eks->lokasi }}</strong></div>
                            @endif
                        </div>

                        <p style="font-size: 0.95rem; color: var(--text-main); line-height: 1.6; margin-bottom: 1.5rem; flex-grow: 1; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ $eks->deskripsi ?? 'Pengembangan minat dan bakat peserta didik melalui kegiatan rutin dan kompetisi.' }}
                        </p>

                        <button type="button" class="btn btn-outline-primary btn-sm rounded-pill py-2 px-3 w-100 fw-semibold d-inline-flex align-items-center justify-content-center gap-1 mt-auto" data-bs-toggle="modal" data-bs-target="#modalEkskulPage_{{ $eks->id }}">
                            <i class="bi bi-info-circle me-1"></i> Detail & Deskripsi Lengkap
                        </button>
                    </div>
                </div>
                @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 4rem 2rem; background: #f8fafc; border-radius: 16px; border: 2px dashed #cbd5e1;">
                    <i class="bi bi-palette text-muted" style="font-size: 3rem;"></i>
                    <h4 class="fw-bold mt-3 text-secondary">Belum Ada Ekstrakurikuler Terdaftar</h4>
                    <p class="text-muted">Data ekstrakurikuler belum ditambahkan oleh administrator.</p>
                </div>
                @endforelse
            </div>

            <!-- Modals Ekstrakurikuler -->
            @foreach($ekstrakurikulers as $eks)
            @php
                $namaEkskul = $eks->nama_ekskul ?? 'Ekstrakurikuler';
                $fotoEkskul = $eks->foto ? (str_contains($eks->foto, 'http') ? $eks->foto : asset('storage/'.$eks->foto)) : 'https://images.unsplash.com/photo-1511632765486-a01980e01a18?auto=format&fit=crop&w=600&q=80';
            @endphp
            <div class="modal fade text-start" id="modalEkskulPage_{{ $eks->id }}" tabindex="-1" aria-labelledby="modalEkskulLabel_{{ $eks->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
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
                                    <h4 class="modal-title fw-bold mb-0 text-white" id="modalEkskulLabel_{{ $eks->id }}">{{ $namaEkskul }}</h4>
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
                                <p class="text-secondary leading-relaxed mb-0" style="font-size: 0.98rem; line-height: 1.7; white-space: pre-line;">
                                    {{ $eks->deskripsi ?? 'Kegiatan ekstrakurikuler ini aktif diselenggarakan untuk mengasah keterampilan, jiwa sosial, disiplin, dan prestasi peserta didik.' }}
                                </p>
                            </div>
                        </div>
                        <div class="modal-footer border-top bg-light p-3 d-flex justify-content-between align-items-center">
                            <span class="text-muted small"><i class="bi bi-building me-1"></i> {{ $profil?->nama_sekolah ?? 'SMK Astika Dharma' }}</span>
                            <button type="button" class="btn btn-secondary px-4 rounded-pill" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            </div>
        </div>

        <!-- Call to Action Footer -->
        <div style="background: linear-gradient(135deg, var(--primary) 0%, #1e293b 100%); padding: 3.5rem 3rem; border-radius: var(--radius-lg); text-align: center; color: white; box-shadow: 0 20px 40px rgba(15,23,42,0.25);" data-aos="fade-up">
            <h3 style="font-size: 2rem; font-weight: 800; color: white; margin-bottom: 1rem;">
                Kembangkan Bakat & Ukir Prestasi Bersama {{ $profil?->nama_sekolah ?? 'Sekolah Astika Dharma' }}
            </h3>
            <p style="font-size: 1.1rem; color: #cbd5e1; max-width: 650px; margin: 0 auto 2rem; line-height: 1.6;">
                Daftarkan diri Anda sekarang dan bergabunglah dengan beragam kegiatan ekstrakurikuler pilihan favoritmu!
            </p>
            <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                <a href="{{ route('ppdb.index') }}" class="btn btn-primary" style="padding: 0.85rem 2rem; border-radius: 50px; font-weight: 700;">
                    <i class="bi bi-pencil-square me-1"></i> Daftar PPDB Online
                </a>
                <a href="{{ route('landing_page') }}" class="btn btn-outline" style="padding: 0.85rem 2rem; border-radius: 50px; font-weight: 700; border-color: rgba(255,255,255,0.4); color: white;">
                    <i class="bi bi-house me-1"></i> Kembali ke Beranda
                </a>
            </div>
        </div>

    </div>
@endsection
