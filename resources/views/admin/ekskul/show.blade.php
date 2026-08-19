@extends('layouts.app')

@section('content')
<div class="container-fluid px-0" style="max-width: 1200px; margin: 0 auto;">
    <!-- Navigation / Breadcrumb -->
    <div class="mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <a href="{{ route('admin.ekskul.index') }}" class="btn btn-outline-secondary btn-sm mb-2">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Kelola Ekskul
            </a>
            <h2 class="fw-bold text-dark mb-1">
                <i class="bi bi-info-circle-fill text-primary me-2"></i>Detail Ekstrakurikuler: {{ $ekskul->nama_ekskul }}
            </h2>
            <p class="text-muted mb-0">Informasi status kegiatan, jadwal latihan, serta daftar anggota siswa yang terdaftar.</p>
        </div>
        <div>
            <button type="button" class="btn btn-primary fw-bold" data-bs-toggle="modal" data-bs-target="#modalEditEkskulDetail">
                <i class="bi bi-pencil-square me-1"></i> Edit Informai Ekskul
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

    <!-- EKSTRAKURIKULER HERO BANNER / CARD -->
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4">
        <div class="row g-0">
            <div class="col-md-4 bg-light d-flex align-items-center justify-content-center p-3" style="min-height: 200px;">
                @if($ekskul->foto)
                    <img src="{{ asset('storage/'.$ekskul->foto) }}" class="img-fluid rounded shadow-sm object-fit-cover w-100 h-100" style="max-height: 220px;">
                @else
                    <div class="text-center text-primary py-4">
                        <i class="bi bi-palette display-1 mb-2"></i>
                        <div class="fw-bold fs-5">{{ $ekskul->nama_ekskul }}</div>
                    </div>
                @endif
            </div>
            <div class="col-md-8 p-4">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-2">
                    <div>
                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary me-2">{{ $ekskul->kategori }}</span>
                        @if(($ekskul->status ?? 'Aktif') === 'Aktif')
                            <span class="badge bg-success px-3 py-1 fs-6"><i class="bi bi-play-circle-fill me-1"></i>Kegiatan Berjalan (Aktif)</span>
                        @else
                            <span class="badge bg-danger px-3 py-1 fs-6"><i class="bi bi-pause-circle-fill me-1"></i>Tidak Berjalan (Non-Aktif / Libur)</span>
                        @endif
                    </div>
                </div>

                <h3 class="fw-bold text-dark mb-2">{{ $ekskul->nama_ekskul }}</h3>
                <p class="text-secondary mb-3">{{ $ekskul->deskripsi ?? 'Belum ada deskripsi untuk ekstrakurikuler ini.' }}</p>

                <div class="row g-3 text-dark small bg-light p-3 rounded-3 border">
                    <div class="col-sm-6 col-md-4">
                        <div class="text-muted small">Guru Pembina / Pelatih</div>
                        <div class="fw-bold text-dark"><i class="bi bi-person-badge text-primary me-1"></i>{{ $ekskul->pembina ?? '-' }}</div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="text-muted small">Jadwal & Waktu Latihan</div>
                        <div class="fw-bold text-dark"><i class="bi bi-clock text-warning me-1"></i>{{ $ekskul->hari_latihan ?? '-' }} ({{ $ekskul->jam_latihan ?? '-' }})</div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="text-muted small">Lokasi Latihan</div>
                        <div class="fw-bold text-dark"><i class="bi bi-geo-alt text-danger me-1"></i>{{ $ekskul->lokasi ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- STATS CARDS -->
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-success border-4">
                <div class="text-muted small fw-bold">Total Anggota Active (ACC)</div>
                <div class="fs-2 fw-bold text-success">{{ count($approvedMembers) }} <small class="fs-6 text-muted font-normal">Siswa</small></div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-warning border-4">
                <div class="text-muted small fw-bold">Pendaftaran Pending</div>
                <div class="fs-2 fw-bold text-warning">{{ count($pendingMembers) }} <small class="fs-6 text-muted font-normal">Menunggu ACC</small></div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-danger border-4">
                <div class="text-muted small fw-bold">Pendaftaran Ditolak</div>
                <div class="fs-2 fw-bold text-danger">{{ count($rejectedMembers) }} <small class="fs-6 text-muted font-normal">Siswa</small></div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-primary border-4">
                <div class="text-muted small fw-bold">Status Ekstra</div>
                <div class="fs-5 fw-bold {{ ($ekskul->status ?? 'Aktif') === 'Aktif' ? 'text-success' : 'text-danger' }} mt-2">
                    @if(($ekskul->status ?? 'Aktif') === 'Aktif')
                        <i class="bi bi-check-circle-fill me-1"></i>Berjalan
                    @else
                        <i class="bi bi-x-circle-fill me-1"></i>Tidak Berjalan
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- TAB / TABLE MEMBERS -->
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-5">
        <div class="card-header bg-dark text-white py-3 border-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="mb-0 fw-bold"><i class="bi bi-people-fill text-warning me-2"></i>Daftar Anggota Siswa ({{ count($approvedMembers) }})</h5>
            <ul class="nav nav-pills card-header-pills" id="ekskulTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active btn-sm text-white fw-bold" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approved-tab-pane" type="button" role="tab">
                        Anggota Disetujui ({{ count($approvedMembers) }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link btn-sm text-white fw-bold position-relative" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending-tab-pane" type="button" role="tab">
                        Pending ({{ count($pendingMembers) }})
                        @if(count($pendingMembers) > 0)
                            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                        @endif
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link btn-sm text-white fw-bold" id="rejected-tab" data-bs-toggle="tab" data-bs-target="#rejected-tab-pane" type="button" role="tab">
                        Ditolak ({{ count($rejectedMembers) }})
                    </button>
                </li>
            </ul>
        </div>
        <div class="card-body p-0">
            <div class="tab-content" id="ekskulTabContent">
                <!-- TAB 1: APPROVED MEMBERS -->
                <div class="tab-pane fade show active" id="approved-tab-pane" role="tabpanel" tabindex="0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">No</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>NIS</th>
                                    <th>Alasan Bergabung</th>
                                    <th>Tanggal Pendaftaran</th>
                                    <th class="pe-4 text-end">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($approvedMembers as $idx => $m)
                                    <tr>
                                        <td class="ps-4 fw-bold text-muted">{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="fw-bold text-dark">{{ $m->siswa->nama ?? 'Siswa' }}</div>
                                            <small class="text-muted">{{ $m->siswa->jenis_kelamin ?? '-' }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary">{{ $m->siswa->kelas ?? '-' }}</span>
                                        </td>
                                        <td><code class="text-dark">{{ $m->siswa->nis ?? '-' }}</code></td>
                                        <td>
                                            <small class="text-dark fst-italic">"{{ Str::limit($m->alasan_bergabung ?? 'Ingin mengasah kemampuan', 70) }}"</small>
                                        </td>
                                        <td><small class="text-muted">{{ $m->created_at->format('d M Y, H:i') }}</small></td>
                                        <td class="pe-4 text-end">
                                            <span class="badge bg-success px-3 py-1 fs-6"><i class="bi bi-check-circle-fill me-1"></i>Disetujui (ACC)</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">
                                            Belum ada siswa yang menjadi anggota ekskul ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- TAB 2: PENDING REGISTRATIONS -->
                <div class="tab-pane fade" id="pending-tab-pane" role="tabpanel" tabindex="0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Siswa Pendaftar</th>
                                    <th>Kelas & NIS</th>
                                    <th>Alasan Pendaftaran</th>
                                    <th>Tanggal Daftar</th>
                                    <th class="pe-4 text-end">Aksi Admin</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendingMembers as $p)
                                    <tr class="table-warning">
                                        <td class="ps-4">
                                            <div class="fw-bold text-dark">{{ $p->siswa->nama ?? 'Siswa' }}</div>
                                        </td>
                                        <td>
                                            <span class="badge bg-dark">{{ $p->siswa->kelas ?? '-' }}</span>
                                            <small class="text-muted d-block">NIS: {{ $p->siswa->nis ?? '-' }}</small>
                                        </td>
                                        <td>
                                            <small class="text-dark fw-semibold">"{{ $p->alasan_bergabung ?? 'Ingin bergabung' }}"</small>
                                        </td>
                                        <td><small class="text-muted">{{ $p->created_at->format('d M Y, H:i') }}</small></td>
                                        <td class="pe-4 text-end">
                                            <div class="d-flex justify-content-end gap-1">
                                                <form action="{{ route('admin.ekskul.approve', $p->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm fw-bold">
                                                        <i class="bi bi-check-lg"></i> ACC
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.ekskul.reject', $p->id) }}" method="POST" onsubmit="return confirm('Tolak pendaftaran siswa ini?')">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-danger btn-sm fw-bold">
                                                        <i class="bi bi-x-lg"></i> Tolak
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">
                                            Tidak ada pendaftaran pending untuk ekstrakurikuler ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- TAB 3: REJECTED REGISTRATIONS -->
                <div class="tab-pane fade" id="rejected-tab-pane" role="tabpanel" tabindex="0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Siswa Pendaftar</th>
                                    <th>Kelas & NIS</th>
                                    <th>Alasan Pendaftaran</th>
                                    <th>Catatan Penolakan</th>
                                    <th class="pe-4 text-end">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rejectedMembers as $r)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold text-dark">{{ $r->siswa->nama ?? 'Siswa' }}</div>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $r->siswa->kelas ?? '-' }}</span>
                                        </td>
                                        <td><small class="text-muted">"{{ $r->alasan_bergabung }}"</small></td>
                                        <td><small class="text-danger fw-semibold">{{ $r->catatan_admin ?? '-' }}</small></td>
                                        <td class="pe-4 text-end">
                                            <span class="badge bg-danger px-3 py-1 fs-6"><i class="bi bi-x-circle-fill me-1"></i>Ditolak</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">
                                            Tidak ada data pendaftaran yang ditolak.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL EDIT EKSKUL DETAIL -->
<div class="modal fade" id="modalEditEkskulDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fw-bold text-white mb-0">
                    <i class="bi bi-pencil-square me-2 text-warning"></i>Edit Informasi {{ $ekskul->nama_ekskul }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.ekskul.update', $ekskul->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Nama Ekstrakurikuler</label>
                        <input type="text" name="nama_ekskul" class="form-control" value="{{ $ekskul->nama_ekskul }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Kategori</label>
                        <select name="kategori" class="form-select">
                            <option value="Olahraga" {{ $ekskul->kategori === 'Olahraga' ? 'selected' : '' }}>Olahraga & Kebugaran</option>
                            <option value="Seni & Budaya" {{ $ekskul->kategori === 'Seni & Budaya' ? 'selected' : '' }}>Seni, Musik & Budaya</option>
                            <option value="Sains & Teknologi" {{ $ekskul->kategori === 'Sains & Teknologi' ? 'selected' : '' }}>Sains & Teknologi / IT</option>
                            <option value="Kepanduan" {{ $ekskul->kategori === 'Kepanduan' ? 'selected' : '' }}>Kepanduan & Belanegara</option>
                            <option value="Keagamaan" {{ $ekskul->kategori === 'Keagamaan' ? 'selected' : '' }}>Keagamaan & Kerohanian</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Status Kegiatan Ekstra</label>
                        <select name="status" class="form-select border-primary fw-bold">
                            <option value="Aktif" {{ ($ekskul->status ?? 'Aktif') === 'Aktif' ? 'selected' : '' }}>🟢 Aktif (Kegiatan Berjalan)</option>
                            <option value="Non-Aktif" {{ ($ekskul->status ?? 'Aktif') === 'Non-Aktif' ? 'selected' : '' }}>🔴 Non-Aktif (Kegiatan Tidak Berjalan / Libur)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Guru Pembina / Pelatih</label>
                        <input type="text" name="pembina" class="form-control" value="{{ $ekskul->pembina }}">
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold small">Hari Latihan</label>
                            <input type="text" name="hari_latihan" class="form-control" value="{{ $ekskul->hari_latihan }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold small">Jam Latihan</label>
                            <input type="text" name="jam_latihan" class="form-control" value="{{ $ekskul->jam_latihan }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Lokasi Latihan</label>
                        <input type="text" name="lokasi" class="form-control" value="{{ $ekskul->lokasi }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3">{{ $ekskul->deskripsi }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Ganti Foto Logo/Banner (Opsional)</label>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
