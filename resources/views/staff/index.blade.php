@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <div>
            <h2 class="fw-bold text-dark mb-1"><i class="bi bi-person-badge text-primary me-2"></i>Kelola Data Staff & Tenaga Kependidikan</h2>
            <p class="text-muted mb-0">Manajemen data staf TU, administrasi, pustakawan, teknisi IT, kebersihan, dan staf sekolah lainnya.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('guru_staff') }}" target="_blank" class="btn btn-outline-info fw-bold shadow-sm" title="Pratinjau Tampilan Direktori Staff di Landing Page">
                <i class="bi bi-globe me-1"></i> Tampil di Landing Page &rarr;
            </a>
            <button type="button" class="btn btn-success fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#tambahStaffModal">
                <i class="bi bi-person-plus-fill me-1"></i> Tambah Data Staff Baru
            </button>
        </div>
    </div>

    <!-- Info Sync Banner -->
    <div class="alert alert-info border-start border-4 border-info shadow-sm mb-4 rounded-3 d-flex align-items-center justify-content-between">
        <div>
            <i class="bi bi-info-circle-fill me-2 fs-5 text-info"></i>
            <strong>Integrasi Landing Page:</strong> Setiap data Staff yang Anda tambahkan atau edit di sini akan secara otomatis tampil dan diperbarui pada <strong>Direktori Staff Website Sekolah</strong>.
        </div>
        <a href="{{ route('guru_staff') }}" target="_blank" class="btn btn-sm btn-info text-white fw-bold ms-3">Lihat Tampilan &rarr;</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <h6 class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i>Gagal Menambahkan / Memperbarui Data Staff:</h6>
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Search & Summary Bar -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 fs-6">
                        <i class="bi bi-people-fill me-1"></i> Total {{ count($staffs) }} Staff Terdaftar
                    </span>
                </div>

                <form action="{{ route('staff.index') }}" method="GET" class="d-flex" style="min-width: 280px;">
                    <input type="text" name="q" class="form-control form-control-sm me-2" placeholder="Cari NIP/NIK, Nama, Jabatan..." value="{{ $q ?? '' }}">
                    <button type="submit" class="btn btn-success btn-sm px-3"><i class="bi bi-search"></i></button>
                    @if(isset($q) && $q !== '')
                        <a href="{{ route('staff.index') }}" class="btn btn-outline-secondary btn-sm ms-2">Reset</a>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <!-- Staff Table Card -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4" style="width: 70px;">Foto</th>
                            <th>NIP / NIK</th>
                            <th>Nama Staff</th>
                            <th>Jabatan / Posisi</th>
                            <th>No. Telepon / WA</th>
                            <th>Email</th>
                            <th class="pe-4 text-end" style="width: 180px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($staffs as $st)
                            <tr>
                                <td class="ps-4">
                                    @if($st->foto)
                                        <img src="{{ asset('storage/'.$st->foto) }}" alt="{{ $st->nama }}" class="rounded-circle object-fit-cover border shadow-sm" style="width: 45px; height: 45px;">
                                    @else
                                        <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 45px; height: 45px; font-size: 1.1rem;">
                                            {{ strtoupper(substr($st->nama, 0, 1)) }}
                                        </div>
                                    @endif
                                </td>
                                <td><span class="badge bg-light text-dark border font-monospace">{{ $st->nip_nik ?? '-' }}</span></td>
                                <td class="fw-bold text-dark">{{ $st->nama }}</td>
                                <td><span class="badge bg-white text-dark border border-secondary border-opacity-25 shadow-sm px-3 py-1.5 fs-6 fw-bold"><i class="bi bi-briefcase-fill text-success me-1"></i>{{ $st->jabatan }}</span></td>
                                <td>
                                    @if($st->no_hp)
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $st->no_hp) }}" target="_blank" class="text-success fw-semibold text-decoration-none small">
                                            <i class="bi bi-whatsapp me-1"></i>{{ $st->no_hp }}
                                        </a>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td class="small">{{ $st->email ?? '-' }}</td>
                                <td class="pe-4 text-end">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editStaffModal_{{ $st->id }}" title="Edit Data Staff">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <form action="{{ route('staff.destroy', $st->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data staff {{ $st->nama }}?')" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Hapus Staff">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Modal Edit Staff -->
                                    <div class="modal fade text-start" id="editStaffModal_{{ $st->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 shadow">
                                                <div class="modal-header bg-warning text-dark py-3">
                                                    <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i>Edit Data Staff: {{ $st->nama }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('staff.update', $st->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body p-4">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Nama Lengkap & Gelar <span class="text-danger">*</span></label>
                                                            <input type="text" name="nama" class="form-control" value="{{ old('nama', $st->nama) }}" required>
                                                        </div>
                                                        <div class="row g-3 mb-3">
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold">NIP / NIK (Opsional)</label>
                                                                <input type="text" name="nip_nik" class="form-control" value="{{ old('nip_nik', $st->nip_nik) }}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold">Jabatan / Posisi <span class="text-danger">*</span></label>
                                                                <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', $st->jabatan) }}" placeholder="Contoh: Kepala TU / Staf IT" required>
                                                            </div>
                                                        </div>
                                                        <div class="row g-3 mb-3">
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold">No. Telepon / WA</label>
                                                                <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $st->no_hp) }}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold">Status Keaktifan Staff</label>
                                                                <select name="status" class="form-select fw-bold">
                                                                    <option value="Aktif" {{ old('status', $st->status ?? 'Aktif') == 'Aktif' ? 'selected' : '' }}>✅ Aktif Bekerja</option>
                                                                    <option value="Pensiun" {{ old('status', $st->status ?? '') == 'Pensiun' ? 'selected' : '' }}>🏆 Pensiun (Purna Bhakti)</option>
                                                                    <option value="Pindah" {{ old('status', $st->status ?? '') == 'Pindah' ? 'selected' : '' }}>🎖️ Purna (Pindah Instansi/Sekolah)</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row g-3 mb-3 p-2 bg-light rounded border">
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold small">Tahun Purna / Pensiun</label>
                                                                <input type="text" name="tahun_purna" class="form-control form-control-sm" placeholder="Contoh: 2026" value="{{ old('tahun_purna', $st->tahun_purna) }}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold small">Pesan Apresiasi</label>
                                                                <input type="text" name="pesan_purna" class="form-control form-control-sm" placeholder="Catatan pengabdian..." value="{{ old('pesan_purna', $st->pesan_purna) }}">
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Email (Opsional)</label>
                                                            <input type="email" name="email" class="form-control" value="{{ old('email', $st->email) }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Foto Staff</label>
                                                            <input type="file" name="foto" class="form-control" accept="image/*">
                                                            @if($st->foto)
                                                                <small class="text-muted d-block mt-1">Foto saat ini: {{ basename($st->foto) }}</small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer bg-light">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-warning fw-bold"><i class="bi bi-save me-1"></i> Simpan Perubahan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-people fs-1 d-block mb-2 text-secondary"></i>
                                    Belum ada data staff terdaftar. Klik tombol <strong>Tambah Data Staff Baru</strong> di atas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Staff -->
<div class="modal fade" id="tambahStaffModal" tabindex="-1" aria-labelledby="tambahStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white py-3">
                <h5 class="modal-title fw-bold" id="tambahStaffModalLabel"><i class="bi bi-person-plus-fill me-2"></i>Tambah Data Staff Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('staff.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="nama_staff" class="form-label fw-bold">Nama Lengkap & Gelar <span class="text-danger">*</span></label>
                        <input type="text" name="nama" id="nama_staff" class="form-control" placeholder="Contoh: Rina Wijaya, S.Kom." value="{{ old('nama') }}" required>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="nip_nik_staff" class="form-label fw-bold">NIP / NIK (Opsional)</label>
                            <input type="text" name="nip_nik" id="nip_nik_staff" class="form-control" placeholder="1987..." value="{{ old('nip_nik') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="jabatan_staff" class="form-label fw-bold">Jabatan / Posisi <span class="text-danger">*</span></label>
                            <input type="text" name="jabatan" id="jabatan_staff" class="form-control" placeholder="Contoh: Staff TU / IT Support" value="{{ old('jabatan') }}" required>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="no_hp_staff" class="form-label fw-bold">No. Telepon / WA</label>
                            <input type="text" name="no_hp" id="no_hp_staff" class="form-control" placeholder="08123456789" value="{{ old('no_hp') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="email_staff" class="form-label fw-bold">Email (Opsional)</label>
                            <input type="email" name="email" id="email_staff" class="form-control" placeholder="staff@smk.sch.id" value="{{ old('email') }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="foto_staff" class="form-label fw-bold">Foto Staff (Opsional)</label>
                        <input type="file" name="foto" id="foto_staff" class="form-control" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success fw-bold"><i class="bi bi-save me-1"></i> Simpan Data Staff</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
