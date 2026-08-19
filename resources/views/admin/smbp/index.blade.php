@extends('layouts.app')

@section('content')
<div class="container-fluid px-0" style="max-width: 1300px; margin: 0 auto;">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1">
                <i class="bi bi-user-plus-fill text-primary me-2"></i>Portal SMBP / PPDB Siswa Baru
            </h2>
            <p class="text-muted mb-0">
                Kelola pendaftaran calon siswa baru online, verifikasi berkas, dan konversi status penerimaan ke akun siswa resmi.
            </p>
        </div>
        <a href="{{ route('smbp.index') }}" class="btn btn-primary fw-bold shadow-sm" target="_blank">
            <i class="bi bi-globe me-1"></i> Buka Form Pendaftaran Publik &rarr;
        </a>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
        <div class="alert alert-success border-start border-4 border-success shadow-sm mb-4 rounded-3 d-flex align-items-center justify-content-between">
            <div>
                <i class="bi bi-check-circle-fill me-2 fs-5 text-success"></i>
                <strong>{{ session('success') }}</strong>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Statistics Overview Cards -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3 mb-4">
        <div class="col">
            <div class="card border-0 shadow-sm p-3 border-start border-4 border-primary bg-white h-100">
                <small class="text-muted fw-bold text-uppercase d-block mb-1" style="font-size: 0.72rem;">Total Pendaftar</small>
                <h3 class="fw-bold text-dark mb-0">{{ $totalPendaftar }}</h3>
                <small class="text-secondary">Pendaftar Masuk</small>
            </div>
        </div>
        <div class="col">
            <div class="card border-0 shadow-sm p-3 border-start border-4 border-warning bg-white h-100">
                <small class="text-warning fw-bold text-uppercase d-block mb-1" style="font-size: 0.72rem;">Menunggu Verifikasi</small>
                <h3 class="fw-bold text-dark mb-0">{{ $totalPending }}</h3>
                <small class="text-muted">Status Pending</small>
            </div>
        </div>
        <div class="col">
            <div class="card border-0 shadow-sm p-3 border-start border-4 border-success bg-white h-100">
                <small class="text-success fw-bold text-uppercase d-block mb-1" style="font-size: 0.72rem;">Siswa Diterima</small>
                <h3 class="fw-bold text-success mb-0">{{ $totalDiterima }}</h3>
                <small class="text-muted">Lolos Seleksi</small>
            </div>
        </div>
        <div class="col">
            <div class="card border-0 shadow-sm p-3 border-start border-4 border-danger bg-white h-100">
                <small class="text-danger fw-bold text-uppercase d-block mb-1" style="font-size: 0.72rem;">Tidak Diterima</small>
                <h3 class="fw-bold text-danger mb-0">{{ $totalDitolak }}</h3>
                <small class="text-muted">Status Ditolak</small>
            </div>
        </div>
    </div>

    <!-- Filter Bar Card -->
    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('admin.smbp.index') }}" method="GET" class="row g-3 align-items-center">
                <div class="col-md-4">
                    <label class="form-label fw-bold small text-muted mb-1">Filter Status Pendaftaran</label>
                    <select name="status" class="form-select fw-bold" onchange="this.form.submit()">
                        <option value="">-- Semua Status Pendaftaran --</option>
                        <option value="Pending" {{ $status == 'Pending' ? 'selected' : '' }}>Pending (Menunggu Verifikasi)</option>
                        <option value="Diterima" {{ $status == 'Diterima' ? 'selected' : '' }}>Diterima (Lolos Seleksi)</option>
                        <option value="Ditolak" {{ $status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold small text-muted mb-1">Cari Nama / No Pendaftaran / Asal Sekolah</label>
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Kata kunci pencarian..." value="{{ $q }}">
                        <button type="submit" class="btn btn-primary fw-bold"><i class="bi bi-search me-1"></i> Cari</button>
                    </div>
                </div>
                <div class="col-md-2 text-end pt-3">
                    <a href="{{ route('admin.smbp.index') }}" class="btn btn-outline-secondary w-100 fw-bold">Reset Filter</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Applicants Table Card -->
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-list-ul me-2 text-primary"></i>Daftar Calon Siswa Baru</h5>
            <span class="badge bg-secondary px-3 py-1 fs-6">Total: {{ $pendaftarans->total() }} Data</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">No. Reg</th>
                            <th>Calon Siswa</th>
                            <th>Pilihan Jurusan</th>
                            <th>Asal Sekolah</th>
                            <th>Kontak Ortu / WA</th>
                            <th>Status</th>
                            <th class="pe-4 text-end">Aksi / Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendaftarans as $p)
                            <tr>
                                <td class="ps-4 font-monospace fw-bold text-primary">{{ $p->no_pendaftaran }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        @if($p->foto)
                                            <img src="{{ asset('storage/'.$p->foto) }}" class="rounded-circle object-fit-cover border" style="width: 40px; height: 40px;">
                                        @else
                                            <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">
                                                <i class="bi bi-person-fill"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-bold text-dark">{{ $p->nama_lengkap }}</div>
                                            <small class="text-muted">{{ $p->jenis_kelamin }} | NISN: {{ $p->nisn ?: '-' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-primary text-wrap" style="max-width: 160px;">{{ $p->pilihan_jurusan }}</span>
                                </td>
                                <td class="fw-semibold text-dark">{{ $p->asal_sekolah }}</td>
                                <td>
                                    <div class="small fw-bold text-dark"><i class="bi bi-whatsapp text-success me-1"></i>{{ $p->no_hp_wa }}</div>
                                    <small class="text-muted">Ortu: {{ $p->nama_orang_tua }}</small>
                                </td>
                                <td>
                                    <span class="badge {{ $p->status === 'Diterima' ? 'bg-success' : ($p->status === 'Ditolak' ? 'bg-danger' : 'bg-warning text-dark') }} px-3 py-1.5 fs-6">
                                        {{ $p->status }}
                                    </span>
                                </td>
                                <td class="pe-4 text-end">
                                    <div class="btn-group">
                                        <!-- Tombol Detail / Verifikasi -->
                                        <button type="button" class="btn btn-sm btn-primary fw-bold px-3" data-bs-toggle="modal" data-bs-target="#modalSmbpDetail{{ $p->id }}">
                                            <i class="bi bi-eye-fill me-1"></i> Detail
                                        </button>
                                        <!-- Cetak Bukti -->
                                        <a href="{{ route('smbp.bukti', $p->no_pendaftaran) }}" class="btn btn-sm btn-outline-secondary" target="_blank" title="Cetak Bukti">
                                            <i class="bi bi-printer-fill"></i>
                                        </a>
                                        <!-- Hapus -->
                                        <form action="{{ route('admin.smbp.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus data pendaftaran ini?')" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal Detail & Verifikasi Status Admin -->
                            <div class="modal fade" id="modalSmbpDetail{{ $p->id }}" tabindex="-1" aria-labelledby="labelSmbp{{ $p->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content border-0 shadow-lg rounded-4">
                                        <div class="modal-header bg-dark text-white border-0 py-3">
                                            <h5 class="modal-title fw-bold" id="labelSmbp{{ $p->id }}">
                                                <i class="bi bi-person-badge-fill text-warning me-2"></i>Verifikasi Data Pendaftar: {{ $p->no_pendaftaran }}
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('admin.smbp.status.update', $p->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body p-4">
                                                <div class="row g-4 mb-3">
                                                    <div class="col-md-4 text-center">
                                                        @if($p->foto)
                                                            <img src="{{ asset('storage/'.$p->foto) }}" class="rounded-3 img-fluid shadow border mb-3 object-fit-cover" style="max-height: 200px;">
                                                        @else
                                                            <div class="bg-light p-4 rounded-3 border text-center mb-3">
                                                                <i class="bi bi-person fs-1 text-muted d-block"></i>
                                                                <small class="text-muted">Tidak Ada Pasfoto</small>
                                                            </div>
                                                        @endif

                                                        @if($p->berkas_ijazah)
                                                            <a href="{{ asset('storage/'.$p->berkas_ijazah) }}" class="btn btn-outline-primary btn-sm w-100 fw-bold" target="_blank">
                                                                <i class="bi bi-file-earmark-pdf me-1"></i> Lihat Berkas Ijazah/SKL
                                                            </a>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-8">
                                                        <h4 class="fw-bold text-primary mb-1">{{ $p->nama_lengkap }}</h4>
                                                        <p class="text-muted mb-2">NISN: {{ $p->nisn ?: '-' }} | {{ $p->jenis_kelamin }}</p>
                                                        
                                                        <div class="bg-light p-3 rounded-3 mb-3 border">
                                                            <div class="row g-2 small">
                                                                <div class="col-6"><strong>Asal Sekolah:</strong> <br>{{ $p->asal_sekolah }}</div>
                                                                <div class="col-6"><strong>Jurusan Minat:</strong> <br><span class="badge bg-primary">{{ $p->pilihan_jurusan }}</span></div>
                                                                <div class="col-6 mt-2"><strong>Ortu / Wali:</strong> <br>{{ $p->nama_orang_tua }}</div>
                                                                <div class="col-6 mt-2"><strong>Kontak WA:</strong> <br>{{ $p->no_hp_wa }}</div>
                                                                <div class="col-12 mt-2"><strong>Alamat Lengkap:</strong> <br>{{ $p->alamat }}</div>
                                                            </div>
                                                        </div>

                                                        <!-- Update Status Form Controls -->
                                                        <div class="border-top pt-3">
                                                            <h6 class="fw-bold text-dark mb-2"><i class="bi bi-sliders me-1 text-warning"></i>Ubah Status & Verifikasi</h6>
                                                            
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold small">Status Penerimaan Siswa <span class="text-danger">*</span></label>
                                                                <select name="status" class="form-select fw-bold">
                                                                    <option value="Pending" {{ $p->status == 'Pending' ? 'selected' : '' }}>Pending (Menunggu Verifikasi)</option>
                                                                    <option value="Diterima" {{ $p->status == 'Diterima' ? 'selected' : '' }}>Diterima (Lolos Seleksi)</option>
                                                                    <option value="Ditolak" {{ $p->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                                                </select>
                                                            </div>

                                                            <div class="form-check form-switch mb-3 p-3 bg-white border rounded-3 ms-0">
                                                                <input class="form-check-input ms-0 me-2" type="checkbox" name="buat_akun_siswa" id="buatAkun{{ $p->id }}" value="1">
                                                                <label class="form-check-label fw-bold text-dark small" for="buatAkun{{ $p->id }}">
                                                                    ✨ Buatkan Akun Siswa Resmi Otomatis (Jika Diterima)
                                                                </label>
                                                                <small class="text-muted d-block ms-4 fs-7">Otomatis generate NIS dan buat akun login siswa untuk masuk ke Portal Siswa SAT Project.</small>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold small">Catatan Admin / Pesan Untuk Pendaftar</label>
                                                                <textarea name="catatan_admin" class="form-control form-control-sm" rows="2" placeholder="Catatan perbaikan atau instruksi daftar ulang...">{{ $p->catatan_admin }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer bg-light border-0 py-3">
                                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-primary fw-bold btn-sm px-4"><i class="bi bi-save me-1"></i> Simpan Status Verifikasi</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-user-x fs-1 d-block mb-2 opacity-50"></i>
                                    Belum ada data pendaftar SMBP/PPDB yang sesuai.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($pendaftarans->hasPages())
            <div class="card-footer bg-white py-3 border-0">
                {{ $pendaftarans->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
