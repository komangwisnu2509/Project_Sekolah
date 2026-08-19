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
                        <small class="text-white-50">BUKTI PENDAFTARAN SISWA BARU (SMBP / PPDB {{ date('Y') }})</small>
                    </div>
                    <span class="badge bg-warning text-dark font-monospace fs-5 px-3 py-2 fw-extrabold shadow-sm">
                        {{ $pendaftaran->no_pendaftaran }}
                    </span>
                </div>
            </div>

            <div class="card-body p-4 p-md-5">
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

                <h5 class="fw-bold text-dark mb-3">Rincian Data Pendaftaran</h5>
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
                        <strong class="d-block"><i data-lucide="info" class="me-1 d-inline"></i> Catatan Dari Panitia / Admin:</strong>
                        <span>{{ $pendaftaran->catatan_admin }}</span>
                    </div>
                @endif
            </div>

            <div class="card-footer bg-light p-3 d-flex justify-content-between align-items-center">
                <a href="{{ route('smbp.index') }}" class="btn btn-outline-secondary fw-bold btn-sm">
                    <i data-lucide="arrow-left" class="me-1 d-inline"></i> Kembali ke Form SMBP
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
