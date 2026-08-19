@extends('layouts.app')

@section('content')
<div class="container-fluid px-0" style="max-width: 1200px; margin: 0 auto;">
    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('kelas.index') }}" class="btn btn-outline-secondary px-3 py-2 rounded-3 fw-bold shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <div>
                <h2 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                    <i class="bi bi-building-fill text-primary"></i> Detail Kelas: {{ $kelas->nama_kelas }}
                </h2>
                <p class="text-muted mb-0 small">Daftar seluruh siswa aktif di kelas {{ $kelas->nama_kelas }} (Nomor absen diurutkan berdasarkan NIS terkecil).</p>
            </div>
        </div>

        @if(Auth::user()->isAdmin())
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('kelas.edit', $kelas->id) }}" class="btn btn-warning text-dark fw-bold px-3 py-2 rounded-3 shadow-sm">
                    <i class="bi bi-pencil-square me-1"></i> Edit Nama Kelas
                </a>
                <a href="{{ route('siswa.create') }}" class="btn btn-primary fw-bold px-3 py-2 rounded-3 shadow-sm">
                    <i class="bi bi-person-plus-fill me-1"></i> Tambah Siswa Baru
                </a>
            </div>
        @endif
    </div>

    <!-- Overview Stat Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-gradient bg-primary text-white h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="badge bg-white text-primary fw-bold px-2.5 py-1 mb-2">INFORMASI KELAS</span>
                        <h3 class="fw-bold mb-0">Kelas {{ $kelas->nama_kelas }}</h3>
                        <small class="text-white-50">Tingkat & Keahlian</small>
                    </div>
                    <i class="bi bi-building fs-1 opacity-50"></i>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-gradient bg-success text-white h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="badge bg-white text-success fw-bold px-2.5 py-1 mb-2">TOTAL SISWA</span>
                        <h2 class="fw-bold mb-0">{{ $totalSiswa }} <span class="fs-6 text-white-50">Siswa Aktif</span></h2>
                        <small class="text-white-50">Terdaftar di kelas ini</small>
                    </div>
                    <i class="bi bi-people fs-1 opacity-50"></i>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-lg-4">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-gradient bg-info text-white h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="badge bg-white text-info fw-bold px-2.5 py-1 mb-2">PENOMORAN ABSEN</span>
                        <h5 class="fw-bold mb-1">Urutan NIS Terkecil</h5>
                        <small class="text-white-50">Siswa NIS terkecil otomatis No. Absen 1</small>
                    </div>
                    <i class="bi bi-sort-numeric-down fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Student List Table -->
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4">
        <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="bi bi-people-fill text-primary me-2"></i>Daftar Nama Siswa Kelas {{ $kelas->nama_kelas }} ({{ $totalSiswa }})
                </h5>
            </div>
            @if(Auth::user()->isAdmin())
                <a href="{{ route('siswa.create') }}" class="btn btn-outline-primary btn-sm fw-bold">
                    <i class="bi bi-person-plus-fill me-1"></i> Tambah Siswa
                </a>
            @endif
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="width: 110px;" title="Nomor Absen berdasarkan NIS Terkecil">No. Absen</th>
                            <th style="width: 75px;">Foto</th>
                            <th style="width: 130px;">NIS</th>
                            <th>Nama Siswa</th>
                            <th>Jurusan / Keahlian</th>
                            <th>Status</th>
                            @if(Auth::user()->isAdmin())
                                <th class="pe-4 text-end" style="width: 140px;">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswaList as $index => $s)
                            <tr>
                                <td class="ps-4">
                                    <span class="badge bg-primary px-3 py-1.5 fs-6 shadow-sm" title="Absen #{{ $index + 1 }} (NIS {{ $s->nis }})">
                                        #{{ $index + 1 }}
                                    </span>
                                </td>
                                <td>
                                    @if($s->foto)
                                        <img src="{{ asset('storage/'.$s->foto) }}" alt="{{ $s->nama }}" class="rounded-circle object-fit-cover border shadow-sm" style="width: 42px; height: 42px;">
                                    @else
                                        <div class="bg-primary bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 42px; height: 42px; font-size: 1.1rem;">
                                            {{ strtoupper(substr($s->nama, 0, 1)) }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark font-monospace border px-2.5 py-1.5 fs-6">{{ $s->nis }}</span>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark fs-6">{{ $s->nama }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 px-2.5 py-1.5 fs-6">{{ $s->jurusan }}</span>
                                </td>
                                <td>
                                    @if($s->status === 'Pelajar' || $s->status === 'Aktif')
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success px-3 py-1">Aktif</span>
                                    @else
                                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger px-3 py-1">{{ $s->status }}</span>
                                    @endif
                                </td>
                                @if(Auth::user()->isAdmin())
                                    <td class="pe-4 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            <a href="{{ route('siswa.edit', $s->id) }}" class="btn btn-sm btn-outline-warning fw-bold" title="Edit Data Siswa">
                                                <i class="bi bi-pencil-square me-1"></i> Edit
                                            </a>
                                            <a href="{{ route('siswa.pelanggaran.index', $s->id) }}" class="btn btn-sm btn-outline-danger" title="Catatan Pelanggaran">
                                                <i class="bi bi-exclamation-triangle"></i>
                                            </a>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ Auth::user()->isAdmin() ? '7' : '6' }}" class="text-center py-5 text-muted">
                                    <i class="bi bi-people fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                    Belum ada siswa yang terdaftar di kelas <strong>{{ $kelas->nama_kelas }}</strong>.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
