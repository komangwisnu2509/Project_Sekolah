@extends('layouts.landing')

@section('content')

    <div style="position: relative; height: 400px; display: flex; align-items: center; justify-content: center; text-align: center; color: white;">
        <div style="position: absolute; inset: 0; background-image: url('https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=2070&auto=format&fit=crop'); background-size: cover; background-position: center; z-index: 1;"></div>
        <div style="position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(15,23,42,0.8), rgba(15,23,42,0.9)); z-index: 2;"></div>
        <div style="position: relative; z-index: 3; max-width: 800px; padding: 0 5%; margin-top: 50px;">
            <h1 style="font-size: 3.5rem; font-weight: 800; margin-bottom: 1rem; color: white; font-family: var(--font-heading);">Papan Pengumuman</h1>
            <div style="display: flex; gap: 0.5rem; justify-content: center; font-size: 1rem; opacity: 0.8; font-weight: 500;">
                <a href="{{ route('landing_page') }}">Beranda</a>
                <span>/</span>
                <span>Papan Pengumuman</span>
            </div>
        </div>
    </div>
    
        <div class="container" style="padding: 5rem 5%; margin-top: -3rem;">
            <div style="max-width: 900px; margin: 0 auto; background: var(--white); border-radius: var(--radius-lg); box-shadow: 0 20px 40px rgba(0,0,0,0.08); padding: 3rem; position: relative; z-index: 10;">
                
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 2px solid var(--border);">
                    <h2 style="color: var(--primary); font-size: 1.8rem; margin: 0;">Pengumuman & Berita Resmi</h2>
                    <span style="background: rgba(37,99,235,0.1); color: var(--accent); padding: 5px 15px; border-radius: 50px; font-weight: 600; font-size: 0.9rem;">{{ count($beritas) }} Terbitan</span>
                </div>
                
                @forelse($beritas as $item)
                @php
                    $kategori = $item->kategori ?: 'Pengumuman';
                    $badgeColor = match(strtolower($kategori)) {
                        'akademik' => 'rgba(16, 185, 129, 0.1); color: #10B981',
                        'wajib' => 'rgba(239, 68, 68, 0.1); color: #EF4444',
                        default => 'rgba(37, 99, 235, 0.1); color: var(--accent)'
                    };
                @endphp
                <div class="announcement-item" style="padding: 2rem; background: var(--bg-light); border-radius: var(--radius-md); margin-bottom: 1.5rem; border-left: 4px solid var(--accent); transition: var(--transition);">
                    <div style="display: flex; gap: 0.5rem; align-items: center; margin-bottom: 0.75rem;">
                        <i data-lucide="calendar" size="16" style="color: var(--text-muted);"></i>
                        <span style="color: var(--text-muted); font-size: 0.9rem; font-weight: 500;">{{ \Carbon\Carbon::parse($item->tanggal_publikasi)->translatedFormat('d F Y') }}</span>
                        <span style="margin: 0 0.5rem; color: var(--border);">|</span>
                        <span style="background: {{ $badgeColor }}; padding: 2px 10px; border-radius: 4px; font-size: 0.8rem; font-weight: 600;">{{ $kategori }}</span>
                    </div>
                    <h3 style="margin: 0 0 1rem 0; color: var(--primary); font-size: 1.4rem;">{{ $item->judul }}</h3>
                    <p style="color: var(--text-main); margin-bottom: 1.5rem; line-height: 1.6;">{!! nl2br(e($item->konten)) !!}</p>
                </div>
                @empty
                <div class="text-center py-5 text-muted">Belum ada pengumuman resmi dipublikasikan oleh admin.</div>
                @endforelse
            </div>
            <style>
                .announcement-item:hover { transform: translateX(5px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
            </style>
        </div>
@endsection
