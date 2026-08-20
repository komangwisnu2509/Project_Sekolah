@extends('layouts.landing')

@section('content')
<div class="py-5" style="background: #F8FAFC; min-height: 100vh; padding-top: 100px !important;">
    <div class="container py-4" style="max-width: 800px;">
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 p-4 d-flex align-items-center gap-3">
                <i data-lucide="check-circle" size="36" class="text-success flex-shrink-0"></i>
                <div>
                    <strong class="fs-5 d-block text-success">{{ session('success') }}</strong>
                    <span>Simpan nomor pendaftaran Anda atau cetak bukti pendaftaran ini sebagai bukti resmi.</span>
                </div>
            </div>
        @endif

        <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white" id="printableTicket">
            <!-- Header Card -->
            <div class="card-header bg-dark text-white p-4 border-0" style="background: linear-gradient(90deg, #0F172A 0%, #1E293B 100%);">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h3 class="fw-bold mb-1 text-white">{{ $profil?->nama_sekolah ?? 'SEKOLAH ASTIKA DHARMA' }}</h3>
                        <small class="text-white-50">BUKTI PENDAFTARAN SISWA BARU (PPDB ONLINE {{ date('Y') }})</small>
                    </div>
                    <span class="badge bg-warning text-dark font-monospace fs-5 px-3 py-2 fw-extrabold shadow-sm">
                        {{ $pendaftaran->no_pendaftaran }}
                    </span>
                </div>
            </div>

            <div class="card-body p-4 p-md-5">
                <!-- Banner Status Spesifik -->
                @if($pendaftaran->status === 'Pending')
                    <div class="alert alert-warning border-0 shadow-sm rounded-4 p-4 mb-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-warning text-dark p-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 54px; height: 54px;">
                                <i class="bi bi-clock-history fs-3"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-1">⏳ Status Pendaftaran: MENUNGGU VERIFIKASI SELEKSI</h5>
                                <p class="mb-0 text-dark small" style="line-height: 1.6;">
                                    Pendaftaran Anda atas nama <strong>{{ $pendaftaran->nama_lengkap }}</strong> saat ini sedang diperiksa & diverifikasi oleh Panitia PPDB Sekolah. 
                                    Silakan lakukan pengecekan halaman ini secara berkala menggunakan Nomor Registrasi atau Email Anda.
                                </p>
                            </div>
                        </div>
                    </div>
                @elseif($pendaftaran->status === 'Diterima')
                    <div class="alert alert-success border-0 shadow-sm rounded-4 p-4 mb-4" style="background: linear-gradient(135deg, #ECFDF5 0%, #D1FAE5 100%); border: 1px solid #10B981 !important;">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="rounded-circle bg-success text-white p-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 54px; height: 54px;">
                                <i class="bi bi-trophy-fill fs-3"></i>
                            </div>
                            <div>
                                <h4 class="fw-extrabold text-success mb-1">🎉 SELAMAT! ANDA NYATAKAN LOLOS SELEKSI & DITERIMA!</h4>
                                <span class="text-dark">Selamat bergabung di {{ $profil?->nama_sekolah ?? 'Sekolah Astika Dharma' }} pilihan jurusan <strong>{{ $pendaftaran->pilihan_jurusan }}</strong>.</span>
                            </div>
                        </div>

                        <!-- Kartu Petunjuk Daftar Ulang -->
                        <div class="p-3 bg-white rounded-3 border border-success border-opacity-50 mt-3">
                            <h6 class="fw-bold text-success mb-3"><i class="bi bi-calendar2-check-fill me-2"></i>Jadwal & Ketentuan Daftar Ulang Resmi:</h6>
                            <div class="row g-3 text-dark small">
                                <div class="col-md-6">
                                    <div class="p-2 bg-light rounded border">
                                        <strong class="text-muted d-block small">📅 Tanggal Daftar Ulang:</strong>
                                        <span class="fw-bold fs-6 text-dark">{{ $pendaftaran->tgl_daftar_ulang ?: 'Akan Diinfokan Panitia' }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-2 bg-light rounded border">
                                        <strong class="text-muted d-block small">⏰ Waktu / Jam Datang:</strong>
                                        <span class="fw-bold fs-6 text-dark">{{ $pendaftaran->waktu_daftar_ulang ?: '08:00 - 12:00 WITA' }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-2 bg-light rounded border">
                                        <strong class="text-muted d-block small">👔 Pakaian / Seragam:</strong>
                                        <span class="fw-bold text-dark">{{ $pendaftaran->seragam_daftar_ulang ?: 'Seragam SMP Asal / Rapi & Sopan' }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-2 bg-light rounded border">
                                        <strong class="text-muted d-block small">📍 Lokasi Tempat:</strong>
                                        <span class="fw-bold text-dark">{{ $pendaftaran->lokasi_daftar_ulang ?: 'Gedung Utama / Aula Sekolah' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($pendaftaran->email)
                            <div class="mt-3 pt-3 border-top border-success border-opacity-25 text-end">
                                <a href="{{ route('register') }}?email={{ urlencode($pendaftaran->email) }}" class="btn btn-success fw-bold px-4 py-2 rounded-pill shadow-sm">
                                    <i class="bi bi-key-fill me-1"></i> Aktivasi Akun Siswa Sekarang
                                </a>
                            </div>
                        @endif
                    </div>
                @elseif($pendaftaran->status === 'Ditolak')
                    <div class="alert alert-danger border-0 shadow-sm rounded-4 p-4 mb-4" style="background: linear-gradient(135deg, #FEF2F2 0%, #FEE2E2 100%); border: 1px solid #EF4444 !important;">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="rounded-circle bg-danger text-white p-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 54px; height: 54px;">
                                <i class="bi bi-x-circle-fill fs-3"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold text-danger mb-1">MOHON MAAF, PENDAFTARAN BELUM LOLOS SELEKSI</h4>
                                <span class="text-dark">Pendaftaran Anda belum dapat diterima pada periode PPDB Online ini.</span>
                            </div>
                        </div>

                        <div class="p-3 bg-white rounded-3 border border-danger border-opacity-50 text-dark">
                            <strong class="d-block text-danger mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i> Alasan Penolakan Dari Panitia PPDB:</strong>
                            <p class="mb-0 fs-6 fw-semibold text-dark">{{ $pendaftaran->alasan_ditolak ?: $pendaftaran->catatan_admin ?: 'Mohon maaf, kualifikasi belum memenuhi syarat atau kuota pilihan jurusan telah penuh.' }}</p>
                        </div>
                    </div>
                @endif

                <div class="row g-4 align-items-center mb-4 pb-4 border-bottom">
                    <div class="col-md-3 text-center">
                        @if($pendaftaran->foto)
                            <img src="{{ asset('storage/'.$pendaftaran->foto) }}" class="rounded-3 shadow-sm border object-fit-cover w-100" style="max-height: 180px;">
                        @else
                            <div class="bg-light text-muted rounded-3 p-4 border text-center">
                                <i data-lucide="user" size="64" class="text-secondary mx-auto mb-2"></i>
                                <small class="d-block">Foto Siswa</small>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-9">
                        <span class="badge {{ $pendaftaran->status === 'Diterima' ? 'bg-success' : ($pendaftaran->status === 'Ditolak' ? 'bg-danger' : 'bg-warning text-dark') }} px-3 py-1 fs-6 mb-2">
                            Status: {{ strtoupper($pendaftaran->status) }}
                        </span>
                        <h2 class="fw-bold text-dark mb-1">{{ $pendaftaran->nama_lengkap }}</h2>
                        <p class="text-muted mb-2">Asal Sekolah: <strong>{{ $pendaftaran->asal_sekolah }}</strong></p>
                        <div class="p-3 bg-light rounded-3 border">
                            <span class="text-muted d-block small">Pilihan Jurusan Utama:</span>
                            <span class="fw-extrabold fs-5 text-primary">{{ $pendaftaran->pilihan_jurusan }}</span>
                        </div>
                    </div>
                </div>

                <h5 class="fw-bold text-dark mb-3">Rincian Data Pendaftaran PPDB</h5>
                <div class="table-responsive mb-4">
                    <table class="table table-bordered align-middle">
                        <tbody>
                            <tr>
                                <th class="bg-light" style="width: 30%;">Nomor Pendaftaran</th>
                                <td class="fw-bold text-primary font-monospace">{{ $pendaftaran->no_pendaftaran }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">NISN</th>
                                <td>{{ $pendaftaran->nisn ?: '-' }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Jenis Kelamin</th>
                                <td>{{ $pendaftaran->jenis_kelamin }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Tempat, Tanggal Lahir</th>
                                <td>{{ $pendaftaran->tempat_lahir }}, {{ \Carbon\Carbon::parse($pendaftaran->tanggal_lahir)->translatedFormat('d F Y') }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Nama Orang Tua / Wali</th>
                                <td>{{ $pendaftaran->nama_orang_tua }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">No. WhatsApp / HP</th>
                                <td>{{ $pendaftaran->no_hp_wa }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Alamat Email</th>
                                <td class="fw-bold text-dark">{{ $pendaftaran->email ?: '-' }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Alamat Rumah</th>
                                <td>{{ $pendaftaran->alamat }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Tanggal Mendaftar</th>
                                <td>{{ $pendaftaran->created_at->translatedFormat('d F Y H:i') }} WITA</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                @if($pendaftaran->catatan_admin)
                    <div class="alert alert-info border-0 shadow-sm rounded-3 mb-4">
                        <strong class="d-block"><i data-lucide="info" class="me-1 d-inline"></i> Catatan Dari Panitia / Admin PPDB:</strong>
                        <span>{{ $pendaftaran->catatan_admin }}</span>
                    </div>
                @endif
            </div>

            <div class="card-footer bg-light p-3 d-flex justify-content-between align-items-center">
                <a href="{{ route('ppdb.index') }}" class="btn btn-outline-secondary fw-bold btn-sm">
                    <i data-lucide="arrow-left" class="me-1 d-inline"></i> Kembali ke Form PPDB
                </a>
                <button type="button" onclick="window.print()" class="btn btn-primary fw-bold btn-sm px-4">
                    <i data-lucide="printer" class="me-1 d-inline"></i> Cetak Bukti Pendaftaran
                </button>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    body * { visibility: hidden; }
    #printableTicket, #printableTicket * { visibility: visible; }
    #printableTicket { position: absolute; left: 0; top: 0; width: 100%; }
    .card-footer { display: none !important; }
}
</style>
@endsection
