@extends('layouts.landing')

@section('content')

    <div style="position: relative; height: 400px; display: flex; align-items: center; justify-content: center; text-align: center; color: white;">
        <div style="position: absolute; inset: 0; background-image: url('https://images.unsplash.com/photo-1506784951206-a9f7acaef9a8?q=80&w=2074&auto=format&fit=crop'); background-size: cover; background-position: center; z-index: 1;"></div>
        <div style="position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(15,23,42,0.8), rgba(15,23,42,0.9)); z-index: 2;"></div>
        <div style="position: relative; z-index: 3; max-width: 800px; padding: 0 5%; margin-top: 50px;">
            <h1 style="font-size: 3.5rem; font-weight: 800; margin-bottom: 1rem; color: white; font-family: var(--font-heading);">Agenda Kegiatan</h1>
            <div style="display: flex; gap: 0.5rem; justify-content: center; font-size: 1rem; opacity: 0.8; font-weight: 500;">
                <a href="{{ route('landing_page') }}">Beranda</a>
                <span>/</span>
                <span>Agenda Kegiatan</span>
            </div>
        </div>
    </div>
    
        <div class="container" style="padding: 5rem 5%; margin-top: -3rem;">
            <div style="max-width: 900px; margin: 0 auto; position: relative; z-index: 10;">
                @forelse($agendas as $agenda)
                <div style="display: flex; background: var(--white); border-radius: var(--radius-lg); overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.08); margin-bottom: 2rem; transition: var(--transition);" class="agenda-card">
                    <div style="background: linear-gradient(135deg, var(--primary), var(--accent)); color: var(--white); padding: 2.5rem 2rem; display: flex; flex-direction: column; justify-content: center; align-items: center; min-width: 180px; text-align: center;">
                        <span style="text-transform: uppercase; letter-spacing: 2px; font-size: 0.9rem; font-weight: 600; opacity: 0.8;">{{ \Carbon\Carbon::parse($agenda->tanggal)->translatedFormat('M') }}</span>
                        <h2 style="color: var(--white); font-size: 3.5rem; margin: 0.25rem 0; line-height: 1; font-family: var(--font-heading);">{{ \Carbon\Carbon::parse($agenda->tanggal)->format('d') }}</h2>
                        <span style="font-size: 1.1rem; font-weight: 500;">{{ \Carbon\Carbon::parse($agenda->tanggal)->format('Y') }}</span>
                    </div>
                    <div style="padding: 2.5rem; flex: 1;">
                        <span style="background: rgba(37, 99, 235, 0.1); color: var(--accent); padding: 4px 12px; border-radius: 50px; font-size: 0.8rem; font-weight: 600; margin-bottom: 1rem; display: inline-block;">{{ $agenda->kategori ?: 'Agenda Sekolah' }}</span>
                        <h3 style="margin: 0 0 1rem 0; font-size: 1.6rem; color: var(--primary);">{{ $agenda->judul }}</h3>
                        <div style="display: flex; gap: 1.5rem; margin-bottom: 1.5rem; flex-wrap: wrap;">
                            <span style="display: flex; align-items: center; gap: 0.5rem; color: var(--text-muted); font-size: 0.95rem;">
                                <i data-lucide="clock" size="18"></i> {{ $agenda->waktu_mulai ? substr($agenda->waktu_mulai,0,5) : '08:00' }} WITA - Selesai
                            </span>
                            <span style="display: flex; align-items: center; gap: 0.5rem; color: var(--text-muted); font-size: 0.95rem;">
                                <i data-lucide="map-pin" size="18"></i> {{ $agenda->lokasi ?: 'Aula Utama' }}
                            </span>
                        </div>
                        <p style="color: var(--text-main); margin: 0; line-height: 1.6;">{{ $agenda->deskripsi ?: 'Kegiatan sekolah.' }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-5 bg-white rounded-4 shadow-sm text-muted">Belum ada agenda kegiatan terdaftar di sistem.</div>
                @endforelse
            </div>
            <style>
                .agenda-card:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(0,0,0,0.12) !important; }
            </style>
        </div>
@endsection
