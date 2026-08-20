<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemberitahuan Status PPDB</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f9; margin: 0; padding: 20px; color: #333; }
        .email-card { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.08); }
        .email-header { background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%); color: #ffffff; padding: 30px 25px; text-align: center; }
        .email-header h2 { margin: 0 0 5px 0; font-size: 22px; font-weight: 800; color: #ffffff; }
        .email-header p { margin: 0; opacity: 0.8; font-size: 13px; letter-spacing: 0.5px; text-transform: uppercase; }
        .email-body { padding: 30px 25px; }
        .badge-status { display: inline-block; padding: 8px 18px; border-radius: 50px; font-weight: 700; font-size: 14px; margin-bottom: 20px; }
        .badge-diterima { background-color: #D1FAE5; color: #065F46; border: 1px solid #10B981; }
        .badge-ditolak { background-color: #FEE2E2; color: #991B1B; border: 1px solid #EF4444; }
        .info-box { background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px; padding: 20px; margin: 20px 0; }
        .info-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .info-table td { padding: 8px 0; border-bottom: 1px border-dashed #E2E8F0; font-size: 14px; }
        .info-table td.label { color: #64748B; font-weight: 600; width: 40%; }
        .info-table td.value { color: #0F172A; font-weight: 700; }
        .btn-action { display: inline-block; background: #2563EB; color: #ffffff !important; font-weight: 700; text-decoration: none; padding: 12px 28px; border-radius: 50px; margin-top: 15px; text-align: center; }
        .email-footer { background: #F1F5F9; padding: 20px; text-align: center; font-size: 12px; color: #64748B; }
    </style>
</head>
<body>
    <div class="email-card">
        <div class="email-header">
            <h2>{{ $profil?->nama_sekolah ?? 'SEKOLAH ASTIKA DHARMA' }}</h2>
            <p>PEMBERITAHUAN HASIL SELEKSI PPDB ONLINE {{ date('Y') }}</p>
        </div>

        <div class="email-body">
            <p style="font-size: 16px;">Halo <strong>{{ $pendaftaran->nama_lengkap }}</strong>,</p>

            @if($pendaftaran->status === 'Diterima')
                <div class="badge-status badge-diterima">
                    🎉 STATUS SELEKSI: DITERIMA (LOLOS SELEKSI)
                </div>

                <p style="line-height: 1.6; color: #334155;">
                    Selamat! Pendaftaran Anda dengan Nomor Registrasi <strong>{{ $pendaftaran->no_pendaftaran }}</strong> pada pilihan jurusan <strong>{{ $pendaftaran->pilihan_jurusan }}</strong> telah dinyatakan <strong>LOLOS SELEKSI & DITERIMA</strong> di {{ $profil?->nama_sekolah ?? 'Sekolah Astika Dharma' }}.
                </p>

                <div class="info-box">
                    <h4 style="margin: 0 0 12px 0; color: #0F172A; font-size: 15px;">📋 JADWAL & KETENTUAN DAFTAR ULANG RESMI:</h4>
                    <table class="info-table">
                        <tr>
                            <td class="label">📅 Tanggal Daftar Ulang</td>
                            <td class="value">{{ $pendaftaran->tgl_daftar_ulang ?: '25 Agustus 2026' }}</td>
                        </tr>
                        <tr>
                            <td class="label">⏰ Waktu / Jam Datang</td>
                            <td class="value">{{ $pendaftaran->waktu_daftar_ulang ?: '08:00 - 12:00 WITA' }}</td>
                        </tr>
                        <tr>
                            <td class="label">👔 Seragam / Pakaian</td>
                            <td class="value">{{ $pendaftaran->seragam_daftar_ulang ?: 'Seragam SMP Asal / Rapi & Sopan' }}</td>
                        </tr>
                        <tr>
                            <td class="label">📍 Lokasi Tempat</td>
                            <td class="value">{{ $pendaftaran->lokasi_daftar_ulang ?: 'Aula Utama Sekolah' }}</td>
                        </tr>
                    </table>
                </div>

                <div style="text-align: center; margin-top: 25px;">
                    <p style="font-size: 14px; color: #475569; margin-bottom: 10px;">Lakukan aktivasi akun siswa Anda sekarang untuk membuat password login portal siswa:</p>
                    <a href="{{ url('/register') }}?email={{ urlencode($pendaftaran->email) }}" class="btn-action">
                        ✨ Aktivasi Akun Siswa Sekarang
                    </a>
                </div>

            @elseif($pendaftaran->status === 'Ditolak')
                <div class="badge-status badge-ditolak">
                    ❌ STATUS SELEKSI: BELUM LOLOS SELEKSI (DITOLAK)
                </div>

                <p style="line-height: 1.6; color: #334155;">
                    Terima kasih telah mendaftar di {{ $profil?->nama_sekolah ?? 'Sekolah Astika Dharma' }}. Berdasarkan hasil verifikasi berkala dengan Nomor Registrasi <strong>{{ $pendaftaran->no_pendaftaran }}</strong>, kami memberitahukan bahwa pendaftaran Anda belum dapat diterima pada periode ini.
                </p>

                <div class="info-box" style="border-color: #FECDD3; background: #FFF1F2;">
                    <h4 style="margin: 0 0 8px 0; color: #991B1B; font-size: 15px;">⚠️ Alasan Penolakan dari Sekolah:</h4>
                    <p style="margin: 0; color: #881337; font-weight: 600; font-size: 14px; line-height: 1.5;">
                        {{ $pendaftaran->alasan_ditolak ?: $pendaftaran->catatan_admin ?: 'Mohon maaf, kualifikasi belum memenuhi syarat atau kuota pilihan jurusan telah penuh.' }}
                    </p>
                </div>
            @endif

            <p style="margin-top: 30px; font-size: 13px; color: #64748B; border-top: 1px solid #E2E8F0; padding-top: 15px;">
                Jika ada pertanyaan mengenai proses pendaftaran atau verifikasi, silakan hubungi Panitia PPDB sekolah di <strong>{{ $pendaftaran->no_hp_wa ?: 'WhatsApp Resmi Sekolah' }}</strong>.
            </p>
        </div>

        <div class="email-footer">
            Email otomatis dikirim oleh Sistem Informasi PPDB {{ $profil?->nama_sekolah ?? 'Sekolah Astika Dharma' }}.<br>
            Mohon tidak membalas email otomatis ini.
        </div>
    </div>
</body>
</html>
