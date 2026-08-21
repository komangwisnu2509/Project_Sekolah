@extends('layouts.landing')

@section('content')

    <div style="position: relative; height: 400px; display: flex; align-items: center; justify-content: center; text-align: center; color: white;">
        <div style="position: absolute; inset: 0; background-image: url('https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=2070&auto=format&fit=crop'); background-size: cover; background-position: center; z-index: 1;"></div>
        <div style="position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(15,23,42,0.8), rgba(15,23,42,0.9)); z-index: 2;"></div>
        <div style="position: relative; z-index: 3; max-width: 800px; padding: 0 5%; margin-top: 50px;">
            <h1 style="font-size: 3.5rem; font-weight: 800; margin-bottom: 1rem; color: white;">Direktori Guru & Staff</h1>
            <div style="display: flex; gap: 0.5rem; justify-content: center; font-size: 1rem; opacity: 0.8;">
                <a href="{{ route('landing_page') }}">Beranda</a>
                <span>/</span>
                <span>Profil</span>
                <span>/</span>
                <span>Direktori Guru & Staff</span>
            </div>
        </div>
    </div>
    
        <div class="container" style="padding: 4rem 5%;">
            @php
                $gurusAktif = $gurus->reject(fn($g) => in_array($g->status, ['Pensiun', 'Pindah']));
                $staffsAktif = $staffs->reject(fn($s) => in_array($s->status, ['Pensiun', 'Pindah']));
                
                $gurusPurna = $gurus->filter(fn($g) => in_array($g->status, ['Pensiun', 'Pindah']));
                $staffsPurna = $staffs->filter(fn($s) => in_array($s->status, ['Pensiun', 'Pindah']));
            @endphp

            <!-- Seksi 1: Guru Pengajar Aktif -->
            <div style="text-align: center; margin-bottom: 3rem;">
                <span style="color: var(--accent); font-weight: 700; text-transform: uppercase; letter-spacing: 1px; font-size: 0.9rem;">👨‍🏫 Tim Pengajar Aktif</span>
                <h2 style="font-size: 2.2rem; font-weight: 800; margin-top: 0.5rem; margin-bottom: 0.5rem;">Guru Pengajar Sekolah</h2>
                <p class="section-subtitle mx-auto">Para tenaga pendidik profesional yang membimbing dan mengajar peserta didik saat ini.</p>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 2rem; margin-bottom: 5rem;">
                @forelse($gurusAktif as $guru)
                <div style="background: var(--white); border-radius: var(--radius-lg); overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.06); transition: var(--transition);" class="guru-card">
                    <div style="height: 250px; background: var(--bg-light); display: flex; align-items: center; justify-content: center; overflow: hidden;">
                        @if($guru->foto)
                            <img src="{{ asset('storage/'.$guru->foto) }}" alt="{{ $guru->nama }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s;">
                        @else
                            <i data-lucide="user" size="64" style="color: var(--border);"></i>
                        @endif
                    </div>
                    <div style="padding: 1.5rem; text-align: center;">
                        <h4 style="font-size: 1.15rem; font-weight: 700; margin-bottom: 0.4rem;">{{ $guru->nama }}</h4>
                        <p style="color: var(--accent); font-size: 0.85rem; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase; margin-bottom: 0.2rem;">{{ $guru->mata_pelajaran }}</p>
                        @if($guru->nip)
                            <small style="color: #64748b; font-size: 0.75rem; font-family: monospace;">NIP: {{ $guru->nip }}</small>
                        @endif
                    </div>
                </div>
                @empty
                <div style="grid-column: 1 / -1; text-align: center; color: #64748b; padding: 2rem;">Belum ada data guru aktif terdaftar.</div>
                @endforelse
            </div>

            <!-- Seksi 2: Staff & Tenaga Kependidikan Aktif -->
            <div style="text-align: center; margin-bottom: 3rem; border-top: 2px dashed #e2e8f0; padding-top: 4rem;">
                <span style="color: #10b981; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; font-size: 0.9rem;">💼 Tenaga Kependidikan</span>
                <h2 style="font-size: 2.2rem; font-weight: 800; margin-top: 0.5rem; margin-bottom: 0.5rem;">Staff & Operational Sekolah</h2>
                <p class="section-subtitle mx-auto">Tim administrasi, IT, perpustakaan, dan operasional pendukung kegiatan sekolah.</p>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 2rem; margin-bottom: 5rem;">
                @forelse($staffsAktif as $staff)
                <div style="background: var(--white); border-radius: var(--radius-lg); overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.06); transition: var(--transition);" class="guru-card">
                    <div style="height: 250px; background: var(--bg-light); display: flex; align-items: center; justify-content: center; overflow: hidden;">
                        @if($staff->foto)
                            <img src="{{ asset('storage/'.$staff->foto) }}" alt="{{ $staff->nama }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s;">
                        @else
                            <i data-lucide="user-check" size="64" style="color: #10b981;"></i>
                        @endif
                    </div>
                    <div style="padding: 1.5rem; text-align: center;">
                        <h4 style="font-size: 1.15rem; font-weight: 700; margin-bottom: 0.4rem;">{{ $staff->nama }}</h4>
                        <p style="color: #10b981; font-size: 0.85rem; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase; margin-bottom: 0.2rem;">{{ $staff->jabatan }}</p>
                        @if($staff->nip_nik)
                            <small style="color: #64748b; font-size: 0.75rem; font-family: monospace;">NIP/NIK: {{ $staff->nip_nik }}</small>
                        @endif
                    </div>
                </div>
                @empty
                <div style="grid-column: 1 / -1; text-align: center; color: #64748b; padding: 2rem;">Belum ada data staff aktif terdaftar.</div>
                @endforelse
            </div>

            <!-- Seksi 3: Honor Roll / Alumni Guru & Staff (Purna Bhakti & Pensiun) -->
            @if($gurusPurna->count() > 0 || $staffsPurna->count() > 0)
            <div style="text-align: center; margin-bottom: 3rem; border-top: 2px solid #f59e0b; padding-top: 4rem;">
                <span style="color: #d97706; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; font-size: 0.9rem;">🏆 Honor Roll & Apresiasi Pengabdian</span>
                <h2 style="font-size: 2.2rem; font-weight: 800; margin-top: 0.5rem; margin-bottom: 0.5rem;">Alumni Guru & Staff (Purna Bhakti & Pensiun)</h2>
                <p class="section-subtitle mx-auto">Penghargaan setinggi-tingginya kepada para pendidik dan staff yang telah menyelesaikan masa tugas pengabdian di sekolah.</p>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 2.5rem;">
                @foreach($gurusPurna as $gp)
                <div style="background: linear-gradient(135deg, #ffffff 0%, #fffbe6 100%); border: 2px solid #f59e0b; border-radius: var(--radius-lg); overflow: hidden; box-shadow: 0 10px 30px rgba(245,158,11,0.15); transition: var(--transition);" class="guru-card">
                    <div style="height: 250px; background: #1e293b; display: flex; align-items: center; justify-content: center; overflow: hidden; position: relative;">
                        @if($gp->foto)
                            <img src="{{ asset('storage/'.$gp->foto) }}" alt="{{ $gp->nama }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <i data-lucide="award" size="64" style="color: #f59e0b;"></i>
                        @endif
                        <span style="position: absolute; top: 12px; right: 12px; background: #f59e0b; color: #000; font-weight: 800; font-size: 0.75rem; padding: 4px 12px; border-radius: 50px; text-transform: uppercase; box-shadow: 0 4px 10px rgba(0,0,0,0.2);">
                            {{ $gp->status === 'Pensiun' ? '🏆 Pensiun' : '🎖️ Purna' }}
                        </span>
                    </div>
                    <div style="padding: 1.5rem; text-align: center;">
                        <h4 style="font-size: 1.2rem; font-weight: 800; color: #1e293b; margin-bottom: 0.3rem;">{{ $gp->nama }}</h4>
                        <p style="color: #d97706; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; margin-bottom: 0.5rem;">Guru {{ $gp->mata_pelajaran }}</p>
                        @if($gp->tahun_purna)
                            <span style="display: inline-block; background: #fef3c7; color: #92400e; font-size: 0.75rem; font-weight: 700; padding: 2px 10px; border-radius: 12px; margin-bottom: 0.5rem;">Tahun Purna: {{ $gp->tahun_purna }}</span>
                        @endif
                        @if($gp->pesan_purna)
                            <p style="font-size: 0.8rem; color: #475569; font-style: italic; margin-top: 0.5rem; border-top: 1px solid #fde68a; padding-top: 0.5rem;">
                                "{{ $gp->pesan_purna }}"
                            </p>
                        @endif
                    </div>
                </div>
                @endforeach

                @foreach($staffsPurna as $sp)
                <div style="background: linear-gradient(135deg, #ffffff 0%, #f0fdf4 100%); border: 2px solid #10b981; border-radius: var(--radius-lg); overflow: hidden; box-shadow: 0 10px 30px rgba(16,185,129,0.15); transition: var(--transition);" class="guru-card">
                    <div style="height: 250px; background: #0f172a; display: flex; align-items: center; justify-content: center; overflow: hidden; position: relative;">
                        @if($sp->foto)
                            <img src="{{ asset('storage/'.$sp->foto) }}" alt="{{ $sp->nama }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <i data-lucide="shield-check" size="64" style="color: #10b981;"></i>
                        @endif
                        <span style="position: absolute; top: 12px; right: 12px; background: #10b981; color: #fff; font-weight: 800; font-size: 0.75rem; padding: 4px 12px; border-radius: 50px; text-transform: uppercase; box-shadow: 0 4px 10px rgba(0,0,0,0.2);">
                            {{ $sp->status === 'Pensiun' ? '🏆 Pensiun' : '🎖️ Purna' }}
                        </span>
                    </div>
                    <div style="padding: 1.5rem; text-align: center;">
                        <h4 style="font-size: 1.2rem; font-weight: 800; color: #1e293b; margin-bottom: 0.3rem;">{{ $sp->nama }}</h4>
                        <p style="color: #059669; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; margin-bottom: 0.5rem;">{{ $sp->jabatan }}</p>
                        @if($sp->tahun_purna)
                            <span style="display: inline-block; background: #d1fae5; color: #065f46; font-size: 0.75rem; font-weight: 700; padding: 2px 10px; border-radius: 12px; margin-bottom: 0.5rem;">Tahun Purna: {{ $sp->tahun_purna }}</span>
                        @endif
                        @if($sp->pesan_purna)
                            <p style="font-size: 0.8rem; color: #475569; font-style: italic; margin-top: 0.5rem; border-top: 1px solid #a7f3d0; padding-top: 0.5rem;">
                                "{{ $sp->pesan_purna }}"
                            </p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            <style>
                .guru-card:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
                .guru-card:hover img { transform: scale(1.05); }
            </style>
        </div>
@endsection
