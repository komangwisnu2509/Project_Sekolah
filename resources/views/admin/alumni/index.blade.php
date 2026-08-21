@extends('layouts.app')

@section('content')
<div class="container-fluid px-0" style="max-width: 1300px; margin: 0 auto;">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h2 class="fw-bold text-dark mb-1">
                <i class="bi bi-mortarboard-fill text-primary me-2"></i>Data Tracer Alumni & Daftar Siswa Lulus
            </h2>
            <p class="text-muted mb-0">Penelusuran nama siswa lulus, status pasca lulus (kuliah/bekerja), foto alumni, kesan & pesan, serta persetujuan (ACC) Admin.</p>
        </div>
        <div>
            <button type="button" class="btn btn-primary fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahAlumni">
                <i class="bi bi-plus-circle-fill me-1"></i> Tambah Data Alumni
            </button>
        </div>
    </div>

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

    <!-- Summary Stats -->
    <div class="row g-3 mb-4">
        <div class="col-md-20 col-sm-6" style="flex: 1;">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-gradient bg-primary text-white h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-white-50 fw-bold d-block">TOTAL SISWA LULUS</small>
                        <h3 class="fw-bold mb-0">{{ $totalAlumni }}</h3>
                    </div>
                    <i class="bi bi-mortarboard fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-20 col-sm-6" style="flex: 1;">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-gradient bg-warning text-dark h-100 border-start border-4 border-warning">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-dark-50 fw-bold d-block">PENDING ACC ADMIN</small>
                        <h3 class="fw-bold mb-0 text-dark">{{ $totalPending }}</h3>
                    </div>
                    <i class="bi bi-clock-history fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-20 col-sm-6" style="flex: 1;">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-gradient bg-success text-white h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-white-50 fw-bold d-block">SUDAH ISI TRACER</small>
                        <h3 class="fw-bold mb-0">{{ $totalSudahTracer }} <span class="fs-6 opacity-75">/ {{ $totalBelumTracer }} Belum</span></h3>
                    </div>
                    <i class="bi bi-file-earmark-check fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-20 col-sm-6" style="flex: 1;">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-gradient bg-info text-white h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-white-50 fw-bold d-block">KULIAH / PERGURUAN TINGGI</small>
                        <h3 class="fw-bold mb-0">{{ $totalKuliah }}</h3>
                    </div>
                    <i class="bi bi-bank fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-20 col-sm-6" style="flex: 1;">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-gradient bg-secondary text-white h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-white-50 fw-bold d-block">BEKERJA / WIRAUSAHA</small>
                        <h3 class="fw-bold mb-0">{{ $totalBekerja + $totalWirausaha }}</h3>
                    </div>
                    <i class="bi bi-briefcase fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-20 col-sm-6" style="flex: 1;">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white text-dark h-100 border-start border-4 border-warning">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted fw-bold d-block">GURU PURNA</small>
                        <h3 class="fw-bold mb-0 text-warning text-darken-2">{{ $totalGuruPurna }}</h3>
                    </div>
                    <i class="bi bi-award fs-1 text-warning"></i>
                </div>
            </div>
        </div>
        <div class="col-md-20 col-sm-6" style="flex: 1;">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white text-dark h-100 border-start border-4 border-success">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted fw-bold d-block">STAFF PURNA</small>
                        <h3 class="fw-bold mb-0 text-success">{{ $totalStaffPurna }}</h3>
                    </div>
                    <i class="bi bi-person-badge fs-1 text-success"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Form Card -->
    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('admin.alumni.index') }}" method="GET">
                <div class="row g-2 align-items-center">
                    <!-- Search Input for Student Name, Class, NIS, Instansi -->
                    <div class="col-lg-4 col-md-6">
                        <label class="form-label small text-muted fw-bold mb-1"><i class="bi bi-search me-1 text-primary"></i>Pencarian (Nama Siswa, NIS, Kelas, Instansi)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white text-primary border-end-0"><i class="bi bi-search"></i></span>
                            <input type="text" name="q" class="form-control border-start-0 ps-0" placeholder="Cari Nama Siswa, Kelas (misal: XII IPA 1), Instansi..." value="{{ $q }}">
                        </div>
                    </div>

                    <!-- Filter Kelas -->
                    <div class="col-lg-2 col-md-3">
                        <label class="form-label small text-muted fw-bold mb-1">Filter Kelas</label>
                        <select name="kelas" class="form-select fw-semibold" onchange="this.form.submit()">
                            <option value="">-- Semua Kelas --</option>
                            @foreach($kelasOptions as $k)
                                <option value="{{ $k }}" {{ $kelasFilter === $k ? 'selected' : '' }}>Kelas {{ $k }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter Status Pasca Lulus -->
                    <div class="col-lg-2 col-md-3">
                        <label class="form-label small text-muted fw-bold mb-1">Status Alumni</label>
                        <select name="status" class="form-select fw-semibold" onchange="this.form.submit()">
                            <option value="">-- Semua Status --</option>
                            <option value="Kuliah" {{ $statusFilter === 'Kuliah' ? 'selected' : '' }}>🎓 Kuliah</option>
                            <option value="Bekerja" {{ $statusFilter === 'Bekerja' ? 'selected' : '' }}>💼 Bekerja</option>
                            <option value="Kuliah & Bekerja" {{ $statusFilter === 'Kuliah & Bekerja' ? 'selected' : '' }}>🌟 Kuliah & Bekerja</option>
                            <option value="Wirausaha" {{ $statusFilter === 'Wirausaha' ? 'selected' : '' }}>🏪 Wirausaha</option>
                            <option value="Mencari Kerja" {{ $statusFilter === 'Mencari Kerja' ? 'selected' : '' }}>🔍 Mencari Kerja</option>
                            <option value="Belum Isi" {{ $statusFilter === 'Belum Isi' ? 'selected' : '' }}>⚠️ Belum Mengisi Tracer</option>
                        </select>
                    </div>

                    <!-- Filter Status ACC -->
                    <div class="col-lg-2 col-md-3">
                        <label class="form-label small text-muted fw-bold mb-1">Status Persetujuan (ACC)</label>
                        <select name="status_acc" class="form-select fw-semibold" onchange="this.form.submit()">
                            <option value="">-- Semua ACC --</option>
                            <option value="Pending" {{ $accFilter === 'Pending' ? 'selected' : '' }}>⏳ Pending ACC</option>
                            <option value="Disetujui" {{ $accFilter === 'Disetujui' ? 'selected' : '' }}>✅ Disetujui (ACC)</option>
                            <option value="Ditolak" {{ $accFilter === 'Ditolak' ? 'selected' : '' }}>❌ Ditolak</option>
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="col-lg-2 col-md-3 text-end align-self-end">
                        <button type="submit" class="btn btn-primary fw-bold w-100 mb-1">
                            <i class="bi bi-filter me-1"></i> Terapkan Filter
                        </button>
                        @if($q || $statusFilter || $accFilter || $tahunFilter || $kelasFilter)
                            <a href="{{ route('admin.alumni.index') }}" class="btn btn-outline-secondary btn-sm w-100">
                                <i class="bi bi-x-circle me-1"></i> Reset Search
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- CATEGORY SEPARATION NAV TABS -->
    <ul class="nav nav-pills nav-fill bg-white p-2 rounded-3 shadow-sm mb-4 border" id="alumniCategoryTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-bold py-2.5 fs-6" id="siswa-tab" data-bs-toggle="pill" data-bs-target="#tab-siswa-alumni" type="button" role="tab" aria-controls="tab-siswa-alumni" aria-selected="true">
                <i class="bi bi-mortarboard-fill me-2 text-primary"></i>1. Alumni Siswa Lulus 
                <span class="badge bg-primary ms-2 rounded-pill">{{ count($alumniSiswaList) }}</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold py-2.5 fs-6" id="guru-tab" data-bs-toggle="pill" data-bs-target="#tab-guru-alumni" type="button" role="tab" aria-controls="tab-guru-alumni" aria-selected="false">
                <i class="bi bi-person-workspace me-2 text-warning"></i>2. Alumni Guru (Purna Bhakti) 
                <span class="badge bg-warning text-dark ms-2 rounded-pill">{{ count($alumniGuruList) }}</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold py-2.5 fs-6" id="staff-tab" data-bs-toggle="pill" data-bs-target="#tab-staff-alumni" type="button" role="tab" aria-controls="tab-staff-alumni" aria-selected="false">
                <i class="bi bi-person-badge me-2 text-success"></i>3. Alumni Staff (Purna Bhakti) 
                <span class="badge bg-success ms-2 rounded-pill">{{ count($alumniStaffList) }}</span>
            </button>
        </li>
    </ul>

    <div class="tab-content" id="alumniCategoryTabContent">
        <!-- TAB 1: ALUMNI SISWA LULUS -->
        <div class="tab-pane fade show active" id="tab-siswa-alumni" role="tabpanel" aria-labelledby="siswa-tab">
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-people-fill text-primary me-2"></i>Daftar Siswa Alumni Lulus ({{ count($alumniSiswaList) }} Siswa Ditemukan)
                    </h5>
                    @if($q)
                        <span class="badge bg-info text-dark">Pencarian: "{{ $q }}"</span>
                    @endif
                </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="width: 50px;">No</th>
                            <th>Nama Siswa Alumni & Kelas</th>
                            <th>Status Pasca Lulus & Instansi</th>
                            <th>Foto Alumni & Kesan Pesan</th>
                            <th>Status ACC Admin</th>
                            <th class="pe-4 text-end" style="width: 220px;">Aksi Admin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($alumniSiswaList as $idx => $s)
                            @php
                                $t = $s->alumniTracer->first(); // Latest tracer entry if available
                            @endphp
                            <tr>
                                <td class="ps-4 fw-bold text-muted">{{ $idx + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        @if($s->foto)
                                            <img src="{{ asset('storage/'.$s->foto) }}" alt="Foto {{ $s->nama }}" class="rounded-circle object-fit-cover border shadow-sm" style="width: 45px; height: 45px;">
                                        @else
                                            <div class="bg-primary bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 45px; height: 45px; font-size: 1.1rem;">
                                                {{ strtoupper(substr($s->nama, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-bold text-dark fs-6">{{ $s->nama }}</div>
                                            <div class="d-flex align-items-center gap-1 mt-0.5">
                                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2 py-0.5" style="font-size: 0.75rem;">Kelas {{ $s->kelas }}</span>
                                                <small class="text-muted font-monospace" style="font-size: 0.75rem;">NIS: {{ $s->nis }} | Lulus {{ $s->tahun_lulus ?? '-' }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($t)
                                        <div class="mb-1">
                                            @if(str_contains($t->status_alumni, 'Kuliah'))
                                                <span class="badge bg-success"><i class="bi bi-bank me-1"></i>{{ $t->status_alumni }}</span>
                                            @elseif($t->status_alumni === 'Bekerja')
                                                <span class="badge bg-info text-dark"><i class="bi bi-briefcase me-1"></i>Bekerja</span>
                                            @elseif($t->status_alumni === 'Wirausaha')
                                                <span class="badge bg-warning text-dark"><i class="bi bi-shop me-1"></i>Wirausaha</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $t->status_alumni }}</span>
                                            @endif
                                        </div>
                                        <div class="fw-bold text-primary mb-0">{{ $t->nama_instansi }}</div>
                                        @if($t->jurusan_atau_jabatan)
                                            <small class="text-dark d-block">Posisi/Jurusan: <strong>{{ $t->jurusan_atau_jabatan }}</strong></small>
                                        @endif
                                        @if($t->lokasi)
                                            <small class="text-muted d-block"><i class="bi bi-geo-alt me-1 text-danger"></i>{{ $t->lokasi }} (Masuk {{ $t->tahun_masuk ?? '-' }})</small>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 px-3 py-1">
                                            <i class="bi bi-dash-circle me-1"></i>Belum Mengisi Tracer
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($t)
                                        <div class="d-flex align-items-center gap-2">
                                            @if($t->foto)
                                                <a href="{{ asset('storage/'.$t->foto) }}" target="_blank" title="Lihat Foto Kenangan/Alumni">
                                                    <img src="{{ asset('storage/'.$t->foto) }}" alt="Foto Alumni" class="img-thumbnail rounded shadow-sm" style="width: 55px; height: 55px; object-fit: cover;">
                                                </a>
                                            @else
                                                <span class="badge bg-light text-muted border">Tanpa Foto</span>
                                            @endif
                                            <div style="max-width: 200px;">
                                                @if($t->kesan_pesan)
                                                    <small class="text-dark fw-semibold d-block text-truncate" title="{{ $t->kesan_pesan }}">
                                                        <i class="bi bi-chat-quote-fill me-1 text-warning"></i>"{{ $t->kesan_pesan }}"
                                                    </small>
                                                @else
                                                    <small class="text-muted fst-italic">Belum ada kesan pesan</small>
                                                @endif
                                                @if($t->catatan)
                                                    <small class="text-secondary d-block text-truncate" title="{{ $t->catatan }}">Catatan: {{ $t->catatan }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <small class="text-muted fst-italic">Belum ada data</small>
                                    @endif
                                </td>
                                <td>
                                    @if($t)
                                        @if($t->status_acc === 'Pending')
                                            <span class="badge bg-warning text-dark px-3 py-2 fs-6">
                                                <i class="bi bi-clock-history me-1"></i>Pending ACC
                                            </span>
                                        @elseif($t->status_acc === 'Disetujui')
                                            <span class="badge bg-success px-3 py-2 fs-6">
                                                <i class="bi bi-check-circle-fill me-1"></i>Disetujui (ACC)
                                            </span>
                                        @elseif($t->status_acc === 'Ditolak')
                                            <span class="badge bg-danger px-3 py-2 fs-6" title="{{ $t->catatan_admin }}">
                                                <i class="bi bi-x-circle-fill me-1"></i>Ditolak
                                            </span>
                                            @if($t->catatan_admin)
                                                <small class="text-danger d-block mt-1 font-italic">{{ Str::limit($t->catatan_admin, 25) }}</small>
                                            @endif
                                        @endif
                                    @else
                                        <span class="badge bg-light text-muted border">Belum Isi</span>
                                    @endif
                                </td>
                                <td class="pe-4 text-end">
                                    <div class="d-flex justify-content-end gap-1 flex-wrap">
                                        @if($t)
                                            @if($t->status_acc !== 'Disetujui')
                                                <form action="{{ route('admin.alumni.approve', $t->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm fw-bold" title="Setujui / ACC Data Alumni">
                                                        <i class="bi bi-check-lg"></i> ACC
                                                    </button>
                                                </form>
                                            @endif

                                            @if($t->status_acc !== 'Ditolak')
                                                <button type="button" class="btn btn-warning btn-sm fw-bold text-dark" data-bs-toggle="modal" data-bs-target="#modalTolak_{{ $t->id }}" title="Tolak Pengajuan">
                                                    <i class="bi bi-x-lg"></i> Tolak
                                                </button>
                                            @endif

                                            <!-- Edit Button -->
                                            <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit_{{ $t->id }}" title="Edit Data Alumni">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </button>

                                            <!-- Delete Button -->
                                            <form action="{{ route('admin.alumni.destroy', $t->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data tracer alumni ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus Data">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <!-- Button for Admin to create tracer for student who hasn't filled yet -->
                                            <button type="button" class="btn btn-primary btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#modalIsiTracer_{{ $s->id }}">
                                                <i class="bi bi-plus-circle me-1"></i> Isi Tracer
                                            </button>
                                        @endif
                                    </div>

                                    @if($t)
                                        <!-- MODAL TOLAK (REJECT) -->
                                        <div class="modal fade text-start" id="modalTolak_{{ $t->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('admin.alumni.reject', $t->id) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-header bg-warning text-dark">
                                                            <h5 class="modal-title fw-bold"><i class="bi bi-x-circle-fill me-1"></i> Tolak Pengajuan Alumni</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="mb-2">Tolak pengajuan data alumni dari <strong>{{ $s->nama }}</strong>?</p>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold small">Catatan Alasan Penolakan (Opsional)</label>
                                                                <textarea name="catatan_admin" class="form-control" rows="3" placeholder="Contoh: Foto tidak sopan, atau nama instansi tidak jelas."></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-danger fw-bold">Ya, Tolak Pengajuan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- MODAL EDIT ADMIN -->
                                        <div class="modal fade text-start" id="modalEdit_{{ $t->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <form action="{{ route('admin.alumni.update', $t->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-header bg-primary text-white">
                                                            <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-1"></i> Edit Data Alumni - {{ $s->nama }}</h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row g-3">
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-bold small">Status Alumni Pasca Lulus <span class="text-danger">*</span></label>
                                                                    <select name="status_alumni" class="form-select fw-semibold" required>
                                                                        <option value="Kuliah" {{ $t->status_alumni === 'Kuliah' ? 'selected' : '' }}>🎓 Kuliah / Perguruan Tinggi</option>
                                                                        <option value="Bekerja" {{ $t->status_alumni === 'Bekerja' ? 'selected' : '' }}>💼 Bekerja / Berkarir</option>
                                                                        <option value="Kuliah & Bekerja" {{ $t->status_alumni === 'Kuliah & Bekerja' ? 'selected' : '' }}>🌟 Kuliah & Bekerja</option>
                                                                        <option value="Wirausaha" {{ $t->status_alumni === 'Wirausaha' ? 'selected' : '' }}>🏪 Wirausaha / Bisnis</option>
                                                                        <option value="Mencari Kerja" {{ $t->status_alumni === 'Mencari Kerja' ? 'selected' : '' }}>🔍 Mencari Kerja</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-bold small">Nama Universitas / Perusahaan <span class="text-danger">*</span></label>
                                                                    <input type="text" name="nama_instansi" class="form-control" value="{{ $t->nama_instansi }}" required>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-bold small">Jurusan / Posisi Pekerjaan</label>
                                                                    <input type="text" name="jurusan_atau_jabatan" class="form-control" value="{{ $t->jurusan_atau_jabatan }}">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label fw-bold small">Tahun Masuk</label>
                                                                    <input type="text" name="tahun_masuk" class="form-control" value="{{ $t->tahun_masuk }}">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label fw-bold small">Lokasi</label>
                                                                    <input type="text" name="lokasi" class="form-control" value="{{ $t->lokasi }}">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-bold small">Status Persetujuan (ACC Admin) <span class="text-danger">*</span></label>
                                                                    <select name="status_acc" class="form-select fw-semibold" required>
                                                                        <option value="Pending" {{ $t->status_acc === 'Pending' ? 'selected' : '' }}>⏳ Pending (Menunggu ACC)</option>
                                                                        <option value="Disetujui" {{ $t->status_acc === 'Disetujui' ? 'selected' : '' }}>✅ Disetujui (ACC)</option>
                                                                        <option value="Ditolak" {{ $t->status_acc === 'Ditolak' ? 'selected' : '' }}>❌ Ditolak</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-bold small">Upload / Ganti Foto Alumni</label>
                                                                    <input type="file" name="foto" class="form-control" accept="image/*">
                                                                    @if($t->foto)
                                                                        <small class="text-success mt-1 d-block"><i class="bi bi-image me-1"></i>Foto saat ini terdaftar</small>
                                                                    @endif
                                                                </div>
                                                                <div class="col-12">
                                                                    <label class="form-label fw-bold small">Kesan & Pesan Alumni</label>
                                                                    <textarea name="kesan_pesan" class="form-control" rows="3">{{ $t->kesan_pesan }}</textarea>
                                                                </div>
                                                                <div class="col-12">
                                                                    <label class="form-label fw-bold small">Catatan Tambahan</label>
                                                                    <textarea name="catatan" class="form-control" rows="2">{{ $t->catatan }}</textarea>
                                                                </div>
                                                                <div class="col-12">
                                                                    <label class="form-label fw-bold small text-danger">Catatan Alasan Admin (Jika Ditolak)</label>
                                                                    <input type="text" name="catatan_admin" class="form-control" value="{{ $t->catatan_admin }}" placeholder="Alasan bila ditolak">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary fw-bold"><i class="bi bi-save me-1"></i> Simpan Perubahan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <!-- MODAL ISI TRACER UNTUK SISWA YN BELUM ISI -->
                                        <div class="modal fade text-start" id="modalIsiTracer_{{ $s->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <form action="{{ route('admin.alumni.store') }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="siswa_id" value="{{ $s->id }}">
                                                        <div class="modal-header bg-primary text-white">
                                                            <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle-fill me-1"></i> Isi Data Tracer untuk {{ $s->nama }} (Kelas {{ $s->kelas }})</h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row g-3">
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-bold small">Status Pasca Lulus <span class="text-danger">*</span></label>
                                                                    <select name="status_alumni" class="form-select fw-semibold" required>
                                                                        <option value="Kuliah">🎓 Melanjutkan Kuliah / Perguruan Tinggi</option>
                                                                        <option value="Bekerja">💼 Bekerja / Berkarir</option>
                                                                        <option value="Kuliah & Bekerja">🌟 Kuliah & Bekerja</option>
                                                                        <option value="Wirausaha">🏪 Wirausaha / Bisnis</option>
                                                                        <option value="Mencari Kerja">🔍 Mencari Kerja</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-bold small">Nama Universitas / Perusahaan <span class="text-danger">*</span></label>
                                                                    <input type="text" name="nama_instansi" class="form-control" placeholder="Contoh: Universitas Gadjah Mada / PT Telkom" required>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-bold small">Jurusan / Posisi Pekerjaan</label>
                                                                    <input type="text" name="jurusan_atau_jabatan" class="form-control" placeholder="Contoh: Teknik Informatika / Software Engineer">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label fw-bold small">Tahun Masuk</label>
                                                                    <input type="text" name="tahun_masuk" class="form-control" value="{{ date('Y') }}">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label fw-bold small">Lokasi</label>
                                                                    <input type="text" name="lokasi" class="form-control" placeholder="Contoh: Jakarta">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-bold small">Status Persetujuan (ACC Admin) <span class="text-danger">*</span></label>
                                                                    <select name="status_acc" class="form-select fw-semibold" required>
                                                                        <option value="Disetujui" selected>✅ Langsung Disetujui (ACC)</option>
                                                                        <option value="Pending">⏳ Pending (Menunggu ACC)</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-bold small">Foto Alumni (Opsional)</label>
                                                                    <input type="file" name="foto" class="form-control" accept="image/*">
                                                                </div>
                                                                <div class="col-12">
                                                                    <label class="form-label fw-bold small">Kesan & Pesan Alumni</label>
                                                                    <textarea name="kesan_pesan" class="form-control" rows="3" placeholder="Tulis kesan dan pesan alumni..."></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary fw-bold"><i class="bi bi-save me-1"></i> Simpan Tracer Alumni</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-person-x fs-1 d-block mb-2 text-secondary"></i>
                                    Tidak ada data siswa lulus atau tracer alumni yang cocok dengan pencarian <strong>"{{ $q }}"</strong>.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
            </div>
        </div>
    </div>
    <!-- END TAB 1: ALUMNI SISWA LULUS -->

    <!-- TAB 2: ALUMNI GURU PURNA BHAKTI & PENSIUN -->
    <div class="tab-pane fade" id="tab-guru-alumni" role="tabpanel" aria-labelledby="guru-tab">
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4 border-top border-4 border-warning">
            <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-award-fill text-warning me-2"></i>Daftar Alumni Guru Purna Bhakti &amp; Pensiun ({{ count($alumniGuruList) }} Guru Ditemukan)
                </h5>
                <a href="{{ route('guru.index') }}" class="btn btn-outline-warning btn-sm fw-bold">
                    <i class="bi bi-gear-fill me-1"></i> Kelola Data Guru (Ubah Status Keaktifan) &rarr;
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th class="ps-4" style="width: 50px;">No</th>
                                <th style="width: 70px;">Foto</th>
                                <th>NIP &amp; Nama Guru</th>
                                <th>Mata Pelajaran</th>
                                <th>Status Purna</th>
                                <th>Tahun Purna</th>
                                <th>Pesan &amp; Kesan Pengabdian</th>
                                <th class="pe-4 text-end" style="width: 130px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($alumniGuruList as $idx => $ag)
                                <tr>
                                    <td class="ps-4 fw-bold text-muted">{{ $idx + 1 }}</td>
                                    <td>
                                        @if($ag->foto)
                                            <img src="{{ asset('storage/'.$ag->foto) }}" alt="{{ $ag->nama }}" class="rounded-circle object-fit-cover border shadow-sm" style="width: 45px; height: 45px;">
                                        @else
                                            <div class="bg-warning bg-opacity-20 text-dark rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 45px; height: 45px;">
                                                {{ strtoupper(substr($ag->nama, 0, 1)) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark fs-6">{{ $ag->nama }}</div>
                                        <small class="text-muted font-monospace">NIP: {{ $ag->nip ?? '-' }}</small>
                                    </td>
                                    <td><span class="badge bg-info text-dark">{{ $ag->mata_pelajaran }}</span></td>
                                    <td>
                                        @if($ag->status === 'Pensiun')
                                            <span class="badge bg-warning text-dark border border-warning px-2.5 py-1 fw-bold"><i class="bi bi-trophy-fill me-1"></i> Pensiun</span>
                                        @else
                                            <span class="badge bg-secondary text-white border px-2.5 py-1 fw-bold"><i class="bi bi-arrow-right-circle me-1"></i> Purna (Pindah)</span>
                                        @endif
                                    </td>
                                    <td class="fw-bold text-dark">{{ $ag->tahun_purna ?? '-' }}</td>
                                    <td class="small text-muted fst-italic">{{ $ag->pesan_purna ?? 'Terima kasih atas segala pengabdian dan ilmu yang diberikan.' }}</td>
                                    <td class="pe-4 text-end">
                                        <a href="{{ route('guru.edit', $ag->id) }}" class="btn btn-outline-warning btn-sm fw-bold">
                                            <i class="bi bi-pencil-square me-1"></i> Edit
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        <i class="bi bi-person-badge fs-1 d-block mb-2 text-warning opacity-50"></i>
                                        Belum ada data guru berstatus Pensiun atau Purna (Pindah). Ubah status guru di menu <strong>Data Guru</strong>.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- END TAB 2: ALUMNI GURU -->

    <!-- TAB 3: ALUMNI STAFF PURNA BHAKTI & PENSIUN -->
    <div class="tab-pane fade" id="tab-staff-alumni" role="tabpanel" aria-labelledby="staff-tab">
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4 border-top border-4 border-success">
            <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-shield-check text-success me-2"></i>Daftar Alumni Staff Purna Bhakti &amp; Pensiun ({{ count($alumniStaffList) }} Staff Ditemukan)
                </h5>
                <a href="{{ route('staff.index') }}" class="btn btn-outline-success btn-sm fw-bold">
                    <i class="bi bi-gear-fill me-1"></i> Kelola Data Staff (Ubah Status Keaktifan) &rarr;
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th class="ps-4" style="width: 50px;">No</th>
                                <th style="width: 70px;">Foto</th>
                                <th>NIP/NIK &amp; Nama Staff</th>
                                <th>Jabatan / Posisi</th>
                                <th>Status Purna</th>
                                <th>Tahun Purna</th>
                                <th>Pesan &amp; Kesan Pengabdian</th>
                                <th class="pe-4 text-end" style="width: 130px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($alumniStaffList as $idx => $as)
                                <tr>
                                    <td class="ps-4 fw-bold text-muted">{{ $idx + 1 }}</td>
                                    <td>
                                        @if($as->foto)
                                            <img src="{{ asset('storage/'.$as->foto) }}" alt="{{ $as->nama }}" class="rounded-circle object-fit-cover border shadow-sm" style="width: 45px; height: 45px;">
                                        @else
                                            <div class="bg-success bg-opacity-20 text-success rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 45px; height: 45px;">
                                                {{ strtoupper(substr($as->nama, 0, 1)) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark fs-6">{{ $as->nama }}</div>
                                        <small class="text-muted font-monospace">NIP/NIK: {{ $as->nip_nik ?? '-' }}</small>
                                    </td>
                                    <td><span class="badge bg-white text-dark border shadow-sm fw-bold">{{ $as->jabatan }}</span></td>
                                    <td>
                                        @if($as->status === 'Pensiun')
                                            <span class="badge bg-warning text-dark border border-warning px-2.5 py-1 fw-bold"><i class="bi bi-trophy-fill me-1"></i> Pensiun</span>
                                        @else
                                            <span class="badge bg-secondary text-white border px-2.5 py-1 fw-bold"><i class="bi bi-arrow-right-circle me-1"></i> Purna (Pindah)</span>
                                        @endif
                                    </td>
                                    <td class="fw-bold text-dark">{{ $as->tahun_purna ?? '-' }}</td>
                                    <td class="small text-muted fst-italic">{{ $as->pesan_purna ?? 'Terima kasih atas segala pengabdian dan operasional yang diberikan.' }}</td>
                                    <td class="pe-4 text-end">
                                        <a href="{{ route('staff.index') }}" class="btn btn-outline-success btn-sm fw-bold">
                                            <i class="bi bi-gear-fill me-1"></i> Kelola
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        <i class="bi bi-people fs-1 d-block mb-2 text-success opacity-50"></i>
                                        Belum ada data staff berstatus Pensiun atau Purna (Pindah). Ubah status staff di menu <strong>Data Staff</strong>.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- END TAB 3: ALUMNI STAFF -->
</div>
<!-- END TAB CONTENT CONTAINER -->

<!-- MODAL TAMBAH DATA ALUMNI DIRECTLY BY ADMIN -->
<div class="modal fade" id="modalTambahAlumni" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.alumni.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle-fill me-1"></i> Tambah Data Alumni Pasca Lulus</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Pilih Siswa Lulus <span class="text-danger">*</span></label>
                            <select name="siswa_id" class="form-select fw-semibold" required>
                                <option value="">-- Pilih Siswa Berstatus Lulus --</option>
                                @foreach($allGraduatedSiswa as $s)
                                    <option value="{{ $s->id }}">{{ $s->nama }} (NIS: {{ $s->nis }} - Kelas {{ $s->kelas }} - Lulus {{ $s->tahun_lulus }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Status Pasca Lulus <span class="text-danger">*</span></label>
                            <select name="status_alumni" class="form-select fw-semibold" required>
                                <option value="Kuliah">🎓 Melanjutkan Kuliah / Perguruan Tinggi</option>
                                <option value="Bekerja">💼 Bekerja / Berkarir</option>
                                <option value="Kuliah & Bekerja">🌟 Kuliah & Bekerja</option>
                                <option value="Wirausaha">🏪 Wirausaha / Bisnis</option>
                                <option value="Mencari Kerja">🔍 Mencari Kerja</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Nama Universitas / Perusahaan <span class="text-danger">*</span></label>
                            <input type="text" name="nama_instansi" class="form-control" placeholder="Contoh: Universitas Indonesia / PT Astra" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Jurusan / Posisi Pekerjaan</label>
                            <input type="text" name="jurusan_atau_jabatan" class="form-control" placeholder="Contoh: Manajemen / Staff Admin">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small">Tahun Masuk</label>
                            <input type="text" name="tahun_masuk" class="form-control" value="{{ date('Y') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small">Lokasi</label>
                            <input type="text" name="lokasi" class="form-control" placeholder="Contoh: Jakarta">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Status Persetujuan (ACC Admin) <span class="text-danger">*</span></label>
                            <select name="status_acc" class="form-select fw-semibold" required>
                                <option value="Disetujui" selected>✅ Langsung Disetujui (ACC)</option>
                                <option value="Pending">⏳ Pending (Menunggu ACC)</option>
                                <option value="Ditolak">❌ Ditolak</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Foto Alumni</label>
                            <input type="file" name="foto" class="form-control" accept="image/*">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small">Kesan & Pesan Alumni</label>
                            <textarea name="kesan_pesan" class="form-control" rows="3" placeholder="Tulis kesan dan pesan alumni..."></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small">Catatan Tambahan</label>
                            <textarea name="catatan" class="form-control" rows="2" placeholder="Catatan tambahan..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold"><i class="bi bi-save me-1"></i> Simpan Data Alumni</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
