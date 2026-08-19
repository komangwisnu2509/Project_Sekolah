@extends('layouts.app')

@section('content')
<div class="container-fluid px-0" style="max-width: 1200px; margin: 0 auto;">
    <!-- Title Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1">
                <i class="bi bi-trophy-fill text-warning me-2"></i>Prestasi & Kejuaraan Siswa
            </h2>
            <p class="text-muted mb-0">Daftar pencapaian, penghargaan, dan kejuaraan siswa kebanggaan sekolah.</p>
        </div>
        @if(Auth::user()->isAdmin())
            <button type="button" class="btn btn-warning text-dark fw-bold px-3 py-2" data-bs-toggle="modal" data-bs-target="#modalTambahPrestasi">
                <i class="bi bi-plus-circle-fill me-1"></i> Tambah Prestasi Baru
            </button>
        @endif
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Filter Bar -->
    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-body p-3 bg-light rounded-3">
            <form action="{{ route('prestasi.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-4">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="q" class="form-control border-start-0" placeholder="Cari nama siswa, judul lomba, deskripsi..." value="{{ request('q') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="kategori" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">-- Semua Kategori --</option>
                        @foreach(['Akademik', 'Olahraga', 'Seni & Budaya', 'Teknologi & IT', 'Kepemimpinan'] as $kat)
                            <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="tingkat" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">-- Semua Tingkat --</option>
                        @foreach(['Kota/Kabupaten', 'Provinsi', 'Nasional', 'Internasional'] as $tingk)
                            <option value="{{ $tingk }}" {{ request('tingkat') == $tingk ? 'selected' : '' }}>Tingkat {{ $tingk }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-sm btn-primary w-100 fw-bold"><i class="bi bi-filter me-1"></i> Filter</button>
                    @if(request()->hasAny(['q', 'kategori', 'tingkat']))
                        <a href="{{ route('prestasi.index') }}" class="btn btn-sm btn-outline-secondary" title="Reset Filter"><i class="bi bi-x-lg"></i></a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Achievements Grid / Table -->
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="mb-0 fw-bold text-dark">
                <i class="bi bi-award-fill text-warning me-2"></i>Daftar Prestasi Siswa ({{ count($prestasis) }})
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="width: 50px;">#</th>
                            <th>Siswa</th>
                            <th>Judul Kejuaraan / Prestasi</th>
                            <th>Peringkat & Tingkat</th>
                            <th>Penyelenggara / Tahun</th>
                            @if(Auth::user()->isAdmin())
                                <th class="text-center">Status Beranda</th>
                            @endif
                            <th class="pe-4 text-center" style="min-width: 140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($prestasis as $index => $p)
                            <tr class="{{ !$p->tampilkan_di_beranda && Auth::user()->isAdmin() ? 'table-secondary bg-opacity-25' : '' }}">
                                <td class="ps-4 text-muted small fw-bold">{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        @if($p->foto_bukti)
                                            <img src="{{ asset('storage/'.$p->foto_bukti) }}" class="rounded-circle object-fit-cover border shadow-sm" style="width: 42px; height: 42px;">
                                        @else
                                            <div class="bg-warning bg-opacity-25 text-dark rounded-circle d-flex align-items-center justify-content-center fw-bold border" style="width: 42px; height: 42px;">
                                                <i class="bi bi-trophy-fill text-warning fs-5"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-bold text-dark mb-0">{{ $p->nama_siswa }}</div>
                                            <small class="text-muted">{{ $p->kelas ? 'Kelas '.$p->kelas : 'Siswa Sekolah' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold text-primary small mb-0">{{ $p->judul_prestasi }}</div>
                                    <small class="badge bg-secondary font-monospace">{{ $p->kategori }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-warning text-dark fw-bold mb-1 d-inline-block">{{ $p->peringkat }}</span>
                                    <div class="small text-secondary fw-semibold">{{ $p->tingkat }}</div>
                                </td>
                                <td>
                                    <div class="small text-dark fw-semibold mb-0">{{ $p->penyelenggara ?? '-' }}</div>
                                    <small class="text-muted">Tahun {{ $p->tahun }}</small>
                                </td>
                                @if(Auth::user()->isAdmin())
                                    <td class="text-center">
                                        <form action="{{ route('admin.prestasi.toggle-homepage', $p->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm {{ $p->tampilkan_di_beranda ? 'btn-success' : 'btn-outline-secondary' }} px-3 py-1" title="Klik untuk {{ $p->tampilkan_di_beranda ? 'Non-aktifkan' : 'Aktifkan' }}">
                                                <i class="bi {{ $p->tampilkan_di_beranda ? 'bi-check-circle-fill me-1' : 'bi-eye-slash-fill me-1' }}"></i>
                                                {{ $p->tampilkan_di_beranda ? 'Aktif (Tampil)' : 'Non-Aktif' }}
                                            </button>
                                        </form>
                                    </td>
                                @endif
                                <td class="pe-4 text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <!-- Tombol Mata (View Detail Modal) - ALL ROLES -->
                                        <button type="button" class="btn btn-sm btn-info text-white fw-bold px-2 py-1" data-bs-toggle="modal" data-bs-target="#modalDetailPrestasi{{ $p->id }}" title="Lihat Detail & Deskripsi Lomba">
                                            <i class="bi bi-eye-fill"></i> Detail
                                        </button>

                                        @if(Auth::user()->isAdmin())
                                            <!-- Tombol Edit (ADMIN ONLY) -->
                                            <button type="button" class="btn btn-sm btn-warning text-dark fw-bold px-2 py-1" data-bs-toggle="modal" data-bs-target="#modalEditPrestasi{{ $p->id }}" title="Edit Data Prestasi">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>

                                            <!-- Tombol Hapus (ADMIN ONLY) -->
                                            <form action="{{ route('admin.prestasi.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus prestasi {{ $p->judul_prestasi }} ini?')" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger px-2 py-1" title="Hapus Prestasi">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            <!-- MODAL DETAIL PRESTASI (TOMBOL MATA) -->
                            <div class="modal fade" id="modalDetailPrestasi{{ $p->id }}" tabindex="-1" aria-labelledby="labelDetail{{ $p->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                                        <div class="modal-header bg-dark text-white border-0 py-3">
                                            <h5 class="modal-title fw-bold" id="labelDetail{{ $p->id }}">
                                                <i class="bi bi-trophy-fill text-warning me-2"></i>Detail Prestasi & Lomba
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div class="row g-4 align-items-center">
                                                <div class="col-md-5 text-center">
                                                    @if($p->foto_bukti)
                                                        <img src="{{ asset('storage/'.$p->foto_bukti) }}" alt="{{ $p->judul_prestasi }}" class="img-fluid rounded-3 shadow border object-fit-cover w-100" style="max-height: 280px;">
                                                    @else
                                                        <div class="bg-warning bg-opacity-10 text-dark rounded-3 p-5 border text-center">
                                                            <i class="bi bi-trophy-fill text-warning display-1"></i>
                                                            <p class="small text-muted mt-2 mb-0">Foto Dokumentasi Tidak Tersedia</p>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-md-7">
                                                    <span class="badge bg-warning text-dark fw-bold px-3 py-1 mb-2">{{ $p->peringkat }} - Tingkat {{ $p->tingkat }}</span>
                                                    <h4 class="fw-extrabold text-primary mb-2">{{ $p->judul_prestasi }}</h4>
                                                    
                                                    <div class="p-3 bg-light rounded-3 mb-3 border">
                                                        <div class="row g-2 small">
                                                            <div class="col-6">
                                                                <strong class="text-muted d-block"><i class="bi bi-person-fill text-primary me-1"></i>Nama Siswa:</strong>
                                                                <span class="fw-bold text-dark fs-6">{{ $p->nama_siswa }}</span>
                                                            </div>
                                                            <div class="col-6">
                                                                <strong class="text-muted d-block"><i class="bi bi-building me-1 text-primary"></i>Kelas:</strong>
                                                                <span class="fw-bold text-dark fs-6">{{ $p->kelas ? 'Kelas '.$p->kelas : '-' }}</span>
                                                            </div>
                                                            <div class="col-6">
                                                                <strong class="text-muted d-block"><i class="bi bi-tag-fill me-1 text-primary"></i>Kategori:</strong>
                                                                <span class="fw-semibold text-dark">{{ $p->kategori }}</span>
                                                            </div>
                                                            <div class="col-6">
                                                                <strong class="text-muted d-block"><i class="bi bi-calendar-event me-1 text-primary"></i>Tahun:</strong>
                                                                <span class="fw-semibold text-dark">{{ $p->tahun }}</span>
                                                            </div>
                                                            <div class="col-12">
                                                                <strong class="text-muted d-block"><i class="bi bi-diagram-3-fill me-1 text-primary"></i>Penyelenggara:</strong>
                                                                <span class="fw-semibold text-dark">{{ $p->penyelenggara ?? 'Penyelenggara Resmi' }}</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mb-0">
                                                        <h6 class="fw-bold text-dark mb-1"><i class="bi bi-card-text me-1 text-primary"></i>Deskripsi Rincian Lomba:</h6>
                                                        <div class="p-3 bg-white border rounded-3 text-secondary small" style="line-height: 1.6; max-height: 160px; overflow-y: auto;">
                                                            {{ $p->deskripsi ?: 'Tidak ada deskripsi singkat tambahan untuk kejuaraan ini.' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-light border-0 py-2">
                                            <button type="button" class="btn btn-secondary btn-sm px-4" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if(Auth::user()->isAdmin())
                                <!-- MODAL EDIT PRESTASI (ADMIN ONLY) -->
                                <div class="modal fade" id="modalEditPrestasi{{ $p->id }}" tabindex="-1" aria-labelledby="labelEdit{{ $p->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content border-0 shadow-lg rounded-4">
                                            <div class="modal-header bg-warning text-dark border-0 py-3">
                                                <h5 class="modal-title fw-bold" id="labelEdit{{ $p->id }}">
                                                    <i class="bi bi-pencil-square me-2"></i>Edit Data Prestasi Siswa
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('admin.prestasi.update', $p->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body p-4">
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold small">Pilih Siswa</label>
                                                            <select name="siswa_id" class="form-select form-select-sm">
                                                                <option value="">-- Pilih dari Data Siswa --</option>
                                                                @foreach($siswas as $s)
                                                                    <option value="{{ $s->id }}" {{ $p->siswa_id == $s->id ? 'selected' : '' }}>{{ $s->nama }} (Kelas {{ $s->kelas }})</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="form-label fw-bold small"> Nama Kejuaraan Yang Diikuti <span class="text-danger">*</span></label>
                                                            <input type="text" name="judul_prestasi" class="form-control form-control-sm" value="{{ $p->judul_prestasi }}" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold small">Kategori</label>
                                                            <select name="kategori" class="form-select form-select-sm">
                                                                @foreach(['Akademik', 'Olahraga', 'Seni & Budaya', 'Teknologi & IT', 'Kepemimpinan'] as $kat)
                                                                    <option value="{{ $kat }}" {{ $p->kategori == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold small">Tingkat</label>
                                                            <select name="tingkat" class="form-select form-select-sm">
                                                                @foreach(['Kota/Kabupaten', 'Provinsi', 'Nasional', 'Internasional'] as $tingk)
                                                                    <option value="{{ $tingk }}" {{ $p->tingkat == $tingk ? 'selected' : '' }}>{{ $tingk }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold small">Peringkat / Medali</label>
                                                            <input type="text" name="peringkat" class="form-control form-control-sm" value="{{ $p->peringkat }}" required>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold small">Tahun</label>
                                                            <input type="text" name="tahun" class="form-control form-control-sm" value="{{ $p->tahun }}" required>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold small">Penyelenggara</label>
                                                            <input type="text" name="penyelenggara" class="form-control form-control-sm" value="{{ $p->penyelenggara }}">
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="form-label fw-bold small">Deskripsi / Rincian Lomba</label>
                                                            <textarea name="deskripsi" class="form-control form-control-sm" rows="3" placeholder="Tuliskan deskripsi singkat mengenai jalannya lomba, lokasi, atau tantangan kejuaraan...">{{ $p->deskripsi }}</textarea>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="form-label fw-bold small">Ganti Foto Bukti / Piala</label>
                                                            <input type="file" name="foto_bukti" class="form-control form-control-sm" accept="image/*">
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="tampilkan_di_beranda" id="editBeranda{{ $p->id }}" value="1" {{ $p->tampilkan_di_beranda ? 'checked' : '' }}>
                                                                <label class="form-check-label small fw-semibold text-dark" for="editBeranda{{ $p->id }}">
                                                                    Aktifkan & Tampilkan di Halaman Utama Sekolah (Beranda)
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer bg-light border-0 py-3">
                                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-warning text-dark fw-bold btn-sm"><i class="bi bi-save me-1"></i> Simpan Perubahan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <tr>
                                <td colspan="{{ Auth::user()->isAdmin() ? '7' : '6' }}" class="text-center py-5 text-muted">
                                    <i class="bi bi-trophy d-block fs-2 mb-2 text-secondary opacity-50"></i>
                                    Belum ada data prestasi siswa terdaftar yang sesuai filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@if(Auth::user()->isAdmin())
    <!-- MODAL TAMBAH PRESTASI BARU (ADMIN ONLY) -->
    <div class="modal fade" id="modalTambahPrestasi" tabindex="-1" aria-labelledby="labelTambah" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-dark text-white border-0 py-3">
                    <h5 class="modal-title fw-bold" id="labelTambah">
                        <i class="bi bi-plus-circle-fill text-warning me-2"></i>Tambah Data Prestasi Siswa Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.prestasi.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="siswa_id" class="form-label fw-bold small">Pilih Siswa</label>
                                <select name="siswa_id" id="siswa_id" class="form-select form-select-sm">
                                    <option value="">-- Pilih dari Data Siswa --</option>
                                    @foreach($siswas as $s)
                                        <option value="{{ $s->id }}">{{ $s->nama }} (Kelas {{ $s->kelas }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="judul_prestasi" class="form-label fw-bold small"> Nama Kejuaraan Yang Diikuti <span class="text-danger">*</span></label>
                                <input type="text" name="judul_prestasi" id="judul_prestasi" class="form-control form-control-sm" placeholder="Contoh: Juara 1 Olimpiade Sains Nasional" required>
                            </div>
                            <div class="col-md-6">
                                <label for="kategori" class="form-label fw-bold small">Kategori</label>
                                <select name="kategori" id="kategori" class="form-select form-select-sm">
                                    <option value="Akademik">Akademik</option>
                                    <option value="Olahraga">Olahraga</option>
                                    <option value="Seni & Budaya">Seni & Budaya</option>
                                    <option value="Teknologi & IT">Teknologi & IT</option>
                                    <option value="Kepemimpinan">Kepemimpinan</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="tingkat" class="form-label fw-bold small">Tingkat</label>
                                <select name="tingkat" id="tingkat" class="form-select form-select-sm">
                                    <option value="Kota/Kabupaten">Kota / Kabupaten</option>
                                    <option value="Provinsi">Provinsi</option>
                                    <option value="Nasional" selected>Nasional</option>
                                    <option value="Internasional">Internasional</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="peringkat" class="form-label fw-bold small">Peringkat / Medali</label>
                                <input type="text" name="peringkat" id="peringkat" class="form-control form-control-sm" value="Juara 1" required>
                            </div>
                            <div class="col-md-4">
                                <label for="tahun" class="form-label fw-bold small">Tahun</label>
                                <input type="text" name="tahun" id="tahun" class="form-control form-control-sm" value="{{ date('Y') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="penyelenggara" class="form-label fw-bold small">Penyelenggara</label>
                                <input type="text" name="penyelenggara" id="penyelenggara" class="form-control form-control-sm" placeholder="Contoh: Kementerian Pendidikan">
                            </div>
                            <div class="col-md-12">
                                <label for="deskripsi" class="form-label fw-bold small">Deskripsi / Rincian Lomba</label>
                                <textarea name="deskripsi" id="deskripsi" class="form-control form-control-sm" rows="3" placeholder="Tuliskan deskripsi singkat mengenai perlombaan, babak penyisihan, lokasi, atau tantangan..."></textarea>
                            </div>
                            <div class="col-md-12">
                                <label for="foto_bukti" class="form-label fw-bold small">Foto Siswa / Penyerahan Piala</label>
                                <input type="file" name="foto_bukti" id="foto_bukti" class="form-control form-control-sm" accept="image/*">
                            </div>
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="tampilkan_di_beranda" id="tampilkan_di_beranda" value="1" checked>
                                    <label class="form-check-label small fw-semibold text-dark" for="tampilkan_di_beranda">
                                        Tampilkan & Aktifkan di Halaman Utama Sekolah (Beranda)
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-0 py-3">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning text-dark fw-bold btn-sm"><i class="bi bi-save me-1"></i> Simpan Prestasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
@endsection
