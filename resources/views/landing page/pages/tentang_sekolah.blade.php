@extends('layouts.landing')

@section('content')
    <!-- Banner Header -->
    <div style="position: relative; height: 420px; display: flex; align-items: center; justify-content: center; text-align: center; color: white;">
        @php
            $headerBg = $profil?->hero_banner ? (str_starts_with($profil->hero_banner, 'http') ? $profil->hero_banner : asset('storage/'.$profil->hero_banner)) : 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=2070&auto=format&fit=crop';
        @endphp
        <div style="position: absolute; inset: 0; background-image: url('{{ $headerBg }}'); background-size: cover; background-position: center; z-index: 1;"></div>
        <div style="position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(15,23,42,0.85), rgba(15,23,42,0.95)); z-index: 2;"></div>
        <div style="position: relative; z-index: 3; max-width: 850px; padding: 0 5%; margin-top: 50px;">
            <div style="display: inline-block; padding: 6px 18px; background: rgba(37,99,235,0.25); border: 1px solid rgba(59,130,246,0.4); border-radius: 50px; color: #93c5fd; font-size: 0.88rem; font-weight: 600; text-uppercase; letter-spacing: 1px; margin-bottom: 1rem;">
                Profil Utama Sekolah
            </div>
            <h1 style="font-size: 3.2rem; font-weight: 800; margin-bottom: 1rem; color: white; line-height: 1.2;">
                Mengenal Lebih Dekat {{ $profil?->nama_sekolah ?? 'Astika Dharma' }}
            </h1>
            <div style="display: flex; gap: 0.5rem; justify-content: center; font-size: 0.98rem; opacity: 0.9;">
                <a href="{{ route('landing_page') }}" style="color: #93c5fd;">Beranda</a>
                <span style="color: #64748b;">/</span>
                <span style="color: #cbd5e1;">Profil</span>
                <span style="color: #64748b;">/</span>
                <span style="color: #ffffff; font-weight: 600;">Mengenal Lebih Dekat</span>
            </div>
        </div>
    </div>
    
    <!-- Main Content Section -->
    <div class="container" style="padding: 4rem 5% 6rem; margin-top: -3rem; position: relative; z-index: 10;">
        
        <!-- Card Detail Utama -->
        <div style="background: var(--white); padding: 3.5rem 3rem; border-radius: var(--radius-lg); box-shadow: 0 20px 40px rgba(0,0,0,0.08); margin-bottom: 3.5rem;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3.5rem; align-items: center;">
                <div data-aos="fade-right">
                    @php
                        $fotoTentang = $profil?->foto_tentang ? (str_starts_with($profil->foto_tentang, 'http') ? $profil->foto_tentang : asset('storage/'.$profil->foto_tentang)) : 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?q=80&w=2022&auto=format&fit=crop';
                    @endphp
                    <div style="position: relative; border-radius: var(--radius-md); overflow: hidden; box-shadow: 0 15px 30px rgba(0,0,0,0.12);">
                        <img src="{{ $fotoTentang }}" alt="Tentang {{ $profil?->nama_sekolah ?? 'Astika Dharma' }}" style="width: 100%; height: 420px; object-fit: cover; display: block;">
                        <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(to top, rgba(15,23,42,0.9), transparent); padding: 1.5rem; color: white;">
                            <div style="font-weight: 700; font-size: 1.1rem;">{{ $profil?->nama_sekolah ?? 'Sekolah Astika Dharma' }}</div>
                            <div style="font-size: 0.88rem; opacity: 0.85;"><i class="bi bi-geo-alt-fill text-warning me-1"></i>{{ $profil?->alamat ?? 'Jl. Pendidikan No. 45' }}</div>
                        </div>
                    </div>
                </div>
                
                <div data-aos="fade-left">
                    <div style="display: inline-block; padding: 4px 14px; background: rgba(37,99,235,0.1); border-radius: 20px; color: var(--accent); font-weight: 700; font-size: 0.85rem; margin-bottom: 1rem;">
                        TENTANG KAMI
                    </div>
                    <h2 class="section-title" style="font-size: 2.2rem; margin-bottom: 1.5rem; color: var(--primary);">
                        Mengenal Lebih Dekat {{ $profil?->nama_sekolah ?? 'Sekolah Astika Dharma' }}
                    </h2>
                    
                    @if($profil?->tentang_lengkap)
                        <div style="font-size: 1.05rem; line-height: 1.85; color: var(--text-main); text-align: justify; white-space: pre-line;">
                            {{ $profil->tentang_lengkap }}
                        </div>
                    @else
                        <p style="font-size: 1.05rem; line-height: 1.85; color: var(--text-main); text-align: justify; margin-bottom: 1.25rem;">
                            {{ $profil?->deskripsi_tentang ?? 'Sekolah Astika Dharma adalah lembaga pendidikan terkemuka yang berdedikasi untuk menciptakan lingkungan belajar yang inspiratif, inklusif, dan berpusat pada pengembangan holistik siswa.' }}
                        </p>
                        <p style="font-size: 1.05rem; line-height: 1.85; color: var(--text-main); text-align: justify; margin-bottom: 1.25rem;">
                            Dengan fasilitas modern berstandar industri dan tenaga pengajar profesional yang berdedikasi tinggi, kami menyeimbangkan pencapaian prestasi akademik unggulan dengan pembentukan karakter mulia dan keterampilan abad ke-21.
                        </p>
                        <p style="font-size: 1.05rem; line-height: 1.85; color: var(--text-main); text-align: justify;">
                            Kami berkomitmen mempersiapkan setiap peserta didik menjadi lulusan yang siap kerja, berjiwa kewirausahaan, serta mampu bersaing di era digital dan global.
                        </p>
                    @endif

                    <div style="display: flex; gap: 1rem; margin-top: 2rem; flex-wrap: wrap;">
                        <a href="{{ route('ppdb.index') }}" class="btn btn-primary" style="padding: 0.75rem 1.75rem; border-radius: 50px;">
                            <i class="bi bi-file-earmark-person-fill me-1"></i> Daftar PPDB Sekarang
                        </a>
                        <a href="{{ route('sambutan') }}" class="btn btn-outline-primary" style="padding: 0.75rem 1.5rem; border-radius: 50px;">
                            <i class="bi bi-person-video3 me-1"></i> Sambutan Kepala Sekolah
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Highlight Key Statistics & Info Badges -->
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 3.5rem;">
            <div style="background: var(--white); padding: 2rem 1.5rem; border-radius: var(--radius-md); box-shadow: 0 10px 25px rgba(0,0,0,0.05); text-align: center; border-bottom: 4px solid var(--accent);" data-aos="fade-up" data-aos-delay="100">
                <div style="width: 56px; height: 56px; background: rgba(37,99,235,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: var(--accent);">
                    <i data-lucide="award" size="28"></i>
                </div>
                <h4 style="font-size: 1.8rem; font-weight: 800; color: var(--primary); margin-bottom: 0.25rem;">Akreditasi {{ $profil?->akreditasi ?? 'A' }}</h4>
                <p style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 0;">Status Kualitas Terjamin</p>
            </div>
            
            <div style="background: var(--white); padding: 2rem 1.5rem; border-radius: var(--radius-md); box-shadow: 0 10px 25px rgba(0,0,0,0.05); text-align: center; border-bottom: 4px solid #10b981;" data-aos="fade-up" data-aos-delay="200">
                <div style="width: 56px; height: 56px; background: rgba(16,185,129,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: #10b981;">
                    <i data-lucide="users" size="28"></i>
                </div>
                <h4 style="font-size: 1.8rem; font-weight: 800; color: var(--primary); margin-bottom: 0.25rem;">{{ $siswaCount }}+ Siswa</h4>
                <p style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 0;">Peserta Didik Aktif</p>
            </div>

            <div style="background: var(--white); padding: 2rem 1.5rem; border-radius: var(--radius-md); box-shadow: 0 10px 25px rgba(0,0,0,0.05); text-align: center; border-bottom: 4px solid #f59e0b;" data-aos="fade-up" data-aos-delay="300">
                <div style="width: 56px; height: 56px; background: rgba(245,158,11,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: #f59e0b;">
                    <i data-lucide="briefcase" size="28"></i>
                </div>
                <h4 style="font-size: 1.8rem; font-weight: 800; color: var(--primary); margin-bottom: 0.25rem;">{{ $guruCount }}+ Pengajar</h4>
                <p style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 0;">Guru & Staf Kompeten</p>
            </div>

            <div style="background: var(--white); padding: 2rem 1.5rem; border-radius: var(--radius-md); box-shadow: 0 10px 25px rgba(0,0,0,0.05); text-align: center; border-bottom: 4px solid #8b5cf6;" data-aos="fade-up" data-aos-delay="400">
                <div style="width: 56px; height: 56px; background: rgba(139,92,246,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: #8b5cf6;">
                    <i data-lucide="clock" size="28"></i>
                </div>
                <h4 style="font-size: 1.8rem; font-weight: 800; color: var(--primary); margin-bottom: 0.25rem;">{{ $tahunDedikasi }}+ Tahun</h4>
                <p style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 0;">Pengalaman Dedikasi</p>
            </div>
        </div>

        <!-- Section Visi & Misi Ringkas -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 3.5rem;">
            <div style="background: var(--white); padding: 3rem; border-radius: var(--radius-lg); box-shadow: 0 15px 30px rgba(0,0,0,0.06); border-top: 4px solid var(--accent);" data-aos="fade-up">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
                    <div style="width: 50px; height: 50px; background: rgba(37,99,235,0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--accent);">
                        <i data-lucide="eye" size="28"></i>
                    </div>
                    <h3 style="font-size: 1.6rem; color: var(--primary); margin: 0;">Visi Sekolah</h3>
                </div>
                <p style="font-size: 1.1rem; line-height: 1.8; color: var(--text-main); font-weight: 500;">
                    "{{ $profil?->visi ?? 'Mewujudkan generasi unggul, berakhlak mulia, dan berwawasan global berbasis teknologi terdepan.' }}"
                </p>
            </div>

            <div style="background: var(--white); padding: 3rem; border-radius: var(--radius-lg); box-shadow: 0 15px 30px rgba(0,0,0,0.06); border-top: 4px solid #10b981;" data-aos="fade-up" data-aos-delay="100">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
                    <div style="width: 50px; height: 50px; background: rgba(16,185,129,0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #10b981;">
                        <i data-lucide="target" size="28"></i>
                    </div>
                    <h3 style="font-size: 1.6rem; color: var(--primary); margin: 0;">Misi Utama</h3>
                </div>
                @php
                    $misiList = explode("\n", $profil?->misi ?? "- Menyelenggarakan pembelajaran yang aktif, inovatif, dan relevan dengan industri.\n- Mengembangkan potensi peserta didik secara optimal.\n- Menanamkan nilai-nilai karakter bangsa dan budi pekerti luhur.");
                @endphp
                <ul style="list-style: none; padding: 0; margin: 0;">
                    @foreach(array_slice($misiList, 0, 3) as $misiItem)
                        @if(trim($misiItem) != "")
                        <li style="display: flex; gap: 0.75rem; margin-bottom: 0.75rem; align-items: flex-start; font-size: 1rem; color: var(--text-main);">
                            <i data-lucide="check-circle" size="20" style="color: #10b981; flex-shrink: 0; margin-top: 3px;"></i>
                            <span>{{ ltrim(trim($misiItem), "-1234567890. ") }}</span>
                        </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Call to Action Footer -->
        <div style="background: linear-gradient(135deg, var(--primary) 0%, #1e293b 100%); padding: 3.5rem 3rem; border-radius: var(--radius-lg); text-align: center; color: white; box-shadow: 0 20px 40px rgba(15,23,42,0.25);" data-aos="fade-up">
            <h3 style="font-size: 2rem; font-weight: 800; color: white; margin-bottom: 1rem;">
                Ingin Menjadi Bagian Dari {{ $profil?->nama_sekolah ?? 'Sekolah Astika Dharma' }}?
            </h3>
            <p style="font-size: 1.1rem; color: #cbd5e1; max-width: 650px; margin: 0 auto 2rem; line-height: 1.6;">
                Pendaftaran peserta didik baru (PPDB) telah dibuka! Daftarkan diri Anda secara online atau kunjungi kampus kami untuk informasi selengkapnya.
            </p>
            <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                <a href="{{ route('ppdb.index') }}" class="btn btn-primary" style="padding: 0.85rem 2rem; border-radius: 50px; font-weight: 700;">
                    <i class="bi bi-pencil-square me-1"></i> Daftar PPDB Online
                </a>
                <a href="{{ route('landing_page') }}#profil" class="btn btn-outline" style="padding: 0.85rem 2rem; border-radius: 50px; font-weight: 700; border-color: rgba(255,255,255,0.4); color: white;">
                    <i class="bi bi-house me-1"></i> Kembali ke Beranda
                </a>
            </div>
        </div>

    </div>
@endsection
