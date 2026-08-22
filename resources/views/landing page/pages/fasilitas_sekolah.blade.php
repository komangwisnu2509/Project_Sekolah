@extends('layouts.landing')

@section('content')
    <!-- Banner Header -->
    <div style="position: relative; height: 420px; display: flex; align-items: center; justify-content: center; text-align: center; color: white;">
        @php
            $headerBg = $profil?->hero_banner ? (str_starts_with($profil->hero_banner, 'http') ? $profil->hero_banner : asset('storage/'.$profil->hero_banner)) : 'https://images.unsplash.com/photo-1562774053-701939374585?q=80&w=2070&auto=format&fit=crop';
        @endphp
        <div style="position: absolute; inset: 0; background-image: url('{{ $headerBg }}'); background-size: cover; background-position: center; z-index: 1;"></div>
        <div style="position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(15,23,42,0.85), rgba(15,23,42,0.95)); z-index: 2;"></div>
        <div style="position: relative; z-index: 3; max-width: 850px; padding: 0 5%; margin-top: 50px;">
            <div style="display: inline-block; padding: 6px 18px; background: rgba(37,99,235,0.25); border: 1px solid rgba(59,130,246,0.4); border-radius: 50px; color: #93c5fd; font-size: 0.88rem; font-weight: 600; text-uppercase; letter-spacing: 1px; margin-bottom: 1rem;">
                Sarana & Prasarana Moderen
            </div>
            <h1 style="font-size: 3.2rem; font-weight: 800; margin-bottom: 1rem; color: white; line-height: 1.2;">
                Fasilitas {{ $profil?->nama_sekolah ?? 'Astika Dharma' }}
            </h1>
            <div style="display: flex; gap: 0.5rem; justify-content: center; font-size: 0.98rem; opacity: 0.9;">
                <a href="{{ route('landing_page') }}" style="color: #93c5fd;">Beranda</a>
                <span style="color: #64748b;">/</span>
                <span style="color: #cbd5e1;">Profil</span>
                <span style="color: #64748b;">/</span>
                <span style="color: #ffffff; font-weight: 600;">Fasilitas Sekolah</span>
            </div>
        </div>
    </div>
    
    <!-- Main Content Section -->
    <div class="container" style="padding: 4rem 5% 6rem; margin-top: -3rem; position: relative; z-index: 10;">
        
        <div style="background: var(--white); padding: 3rem; border-radius: var(--radius-lg); box-shadow: 0 20px 40px rgba(0,0,0,0.08); margin-bottom: 3.5rem;">
            <div style="text-align: center; max-width: 750px; margin: 0 auto 3rem;">
                <div style="display: inline-block; padding: 4px 14px; background: rgba(37,99,235,0.1); border-radius: 20px; color: var(--accent); font-weight: 700; font-size: 0.85rem; margin-bottom: 1rem;">
                    LINGKUNGAN BELAJAR IDEAL
                </div>
                <h2 class="section-title" style="font-size: 2.2rem; margin-bottom: 1rem; color: var(--primary);">
                    Menunjang Prestasi & Kenyamanan Belajar Siswa
                </h2>
                <p style="font-size: 1.05rem; color: var(--text-muted); line-height: 1.7;">
                    Kami menyediakan berbagai fasilitas pendidikan terkini berstandar nasional dan industri untuk memastikan setiap proses pembelajaran berjalan efektif, inspiratif, dan menyenangkan.
                </p>
            </div>

            <!-- Grid Fasilitas -->
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 2rem;">
                @forelse($fasilitas as $index => $fac)
                @php
                    $fotoFac = $fac->foto ? (str_starts_with($fac->foto, 'http') ? $fac->foto : asset($fac->foto)) : 'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=600&q=80';
                @endphp
                <div style="background: #ffffff; border-radius: var(--radius-md); border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 10px 20px rgba(0,0,0,0.04); transition: transform 0.3s ease, box-shadow 0.3s ease; display: flex; flex-direction: column;" data-aos="fade-up" data-aos-delay="{{ ($index % 3) * 100 }}">
                    <div style="position: relative; height: 220px; overflow: hidden;">
                        <img src="{{ $fotoFac }}" alt="{{ $fac->nama_fasilitas }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;" onmouseover="this.style.transform='scale(1.06)'" onmouseout="this.style.transform='scale(1.0)'">
                        <span style="position: absolute; top: 12px; right: 12px; background: rgba(15,23,42,0.85); color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 0.78rem; font-weight: 600; backdrop-filter: blur(4px);">
                            Fasilitas Unggulan
                        </span>
                    </div>
                    <div style="padding: 1.5rem; display: flex; flex-direction: column; flex-grow: 1;">
                        <h3 style="font-size: 1.35rem; font-weight: 700; color: var(--primary); margin-bottom: 0.75rem;">
                            {{ $fac->nama_fasilitas }}
                        </h3>
                        <p style="font-size: 0.95rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 1.5rem; flex-grow: 1;">
                            {{ $fac->deskripsi ?? 'Fasilitas modern yang dirancang khusus untuk mendukung kegiatan akademik, praktikum, dan pengembangan bakat siswa.' }}
                        </p>
                        <button type="button" class="btn btn-outline-primary btn-sm rounded-pill py-2 px-3 w-100 fw-semibold d-inline-flex align-items-center justify-content-center gap-1" data-bs-toggle="modal" data-bs-target="#modalFac_{{ $fac->id }}">
                            <i class="bi bi-zoom-in me-1"></i> Lihat Foto & Detail Full
                        </button>
                    </div>
                </div>
                @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 4rem 2rem; background: #f8fafc; border-radius: 16px; border: 2px dashed #cbd5e1;">
                    <i class="bi bi-box-seam text-muted" style="font-size: 3rem;"></i>
                    <h4 class="fw-bold mt-3 text-secondary">Belum Ada Fasilitas Terdaftar</h4>
                    <p class="text-muted">Data fasilitas belum ditambahkan oleh administrator.</p>
                </div>
                @endforelse
            </div>

            <!-- Modals Detail Foto Fasilitas -->
            @foreach($fasilitas as $fac)
            @php
                $fotoFac = $fac->foto ? (str_starts_with($fac->foto, 'http') ? $fac->foto : asset($fac->foto)) : 'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=600&q=80';
            @endphp
            <div class="modal fade text-start" id="modalFac_{{ $fac->id }}" tabindex="-1" aria-labelledby="modalFacLabel_{{ $fac->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg overflow-hidden rounded-4">
                        <div class="modal-header border-0 bg-primary text-white p-4 d-flex justify-content-between align-items-center">
                            <h5 class="modal-title fw-bold text-white d-flex align-items-center gap-2" id="modalFacLabel_{{ $fac->id }}">
                                <i class="bi bi-building"></i> {{ $fac->nama_fasilitas }}
                            </h5>
                            <button type="button" class="btn-close btn-close-white ms-auto shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-0 bg-white">
                            <img src="{{ $fotoFac }}" alt="{{ $fac->nama_fasilitas }}" style="width: 100%; max-height: 450px; object-fit: cover;">
                            <div class="p-4 text-start">
                                <h5 class="fw-bold text-dark mb-2">Deskripsi Fasilitas</h5>
                                <p class="text-secondary leading-relaxed mb-0" style="font-size: 1rem; line-height: 1.7;">
                                    {{ $fac->deskripsi ?? 'Fasilitas modern ini mendukung kenyamanan serta kelancaran proses pembelajaran siswa SMK Astika Dharma.' }}
                                </p>
                            </div>
                        </div>
                        <div class="modal-footer border-top bg-light p-3">
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
                Nikmati Pengalaman Belajar Terbaik di {{ $profil?->nama_sekolah ?? 'Sekolah Astika Dharma' }}
            </h3>
            <p style="font-size: 1.1rem; color: #cbd5e1; max-width: 650px; margin: 0 auto 2rem; line-height: 1.6;">
                Nikmati sarana dan prasarana terlengkap untuk mendukung keahlianmu. Bergabunglah bersama kami sekarang!
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
