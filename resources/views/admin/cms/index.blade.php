@extends('layouts.app')

@section('content')
<style>
    /* Premium CMS Tab Pills Styling */
    #cmsTabs .nav-link {
        color: #475569;
        border-radius: 10px;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        font-size: 0.92rem;
    }
    #cmsTabs .nav-link:hover {
        background-color: #f1f5f9;
        color: #0f172a;
    }
    #cmsTabs .nav-link.active {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    }
    .badge-show {
        background-color: #10b981 !important;
        color: #ffffff !important;
        box-shadow: 0 2px 6px rgba(16, 185, 129, 0.2);
    }
    .badge-hide {
        background-color: #64748b !important;
        color: #ffffff !important;
    }
    .hover-card {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .hover-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.08) !important;
    }
</style>

<div class="container-fluid px-0" style="max-width: 1300px; margin: 0 auto;">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                <i class="bi bi-globe text-primary"></i> Pengaturan & CMS Web Sekolah
            </h2>
            <p class="text-muted mb-0">
                Kelola profil sekolah, ekstrakurikuler, berita, event, foto fasilitas, galeri, testimoni, FAQ, serta direktori Guru & Staff yang tampil di Beranda Utama.
            </p>
        </div>
        <a href="{{ route('landing_page') }}" class="btn btn-outline-primary fw-bold shadow-sm px-3 py-2 rounded-3" target="_blank">
            <i class="bi bi-globe me-1.5"></i> Buka Website Beranda Utama &rarr;
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

    <!-- CMS Tabbed Navigation -->
    <ul class="nav nav-pills nav-fill mb-4 bg-white p-2 rounded-3 shadow-sm border" id="cmsTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-bold py-2.5" id="tab-profil-tab" data-bs-toggle="tab" data-bs-target="#tab-profil" type="button" role="tab">
                <i class="bi bi-building me-1.5"></i> Profil Sekolah
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold py-2.5" id="tab-ekskul-tab" data-bs-toggle="tab" data-bs-target="#tab-ekskul" type="button" role="tab">
                <i class="bi bi-palette me-1.5"></i> Ekstrakurikuler
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold py-2.5" id="tab-berita-tab" data-bs-toggle="tab" data-bs-target="#tab-berita" type="button" role="tab">
                <i class="bi bi-newspaper me-1.5"></i> Berita Sekolah
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold py-2.5" id="tab-agenda-tab" data-bs-toggle="tab" data-bs-target="#tab-agenda" type="button" role="tab">
                <i class="bi bi-calendar-event me-1.5"></i> Event / Agenda
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold py-2.5" id="tab-fasilitas-tab" data-bs-toggle="tab" data-bs-target="#tab-fasilitas" type="button" role="tab">
                <i class="bi bi-box-seam me-1.5"></i> Fasilitas
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold py-2.5" id="tab-galeri-tab" data-bs-toggle="tab" data-bs-target="#tab-galeri" type="button" role="tab">
                <i class="bi bi-images me-1.5"></i> Galeri Foto
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold py-2.5" id="tab-testimoni-tab" data-bs-toggle="tab" data-bs-target="#tab-testimoni" type="button" role="tab">
                <i class="bi bi-chat-quote me-1.5"></i> Testimoni & FAQ
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold py-2.5" id="tab-guru-tab" data-bs-toggle="tab" data-bs-target="#tab-guru" type="button" role="tab">
                <i class="bi bi-person-workspace me-1.5"></i> Guru & Staff
            </button>
        </li>
    </ul>

    <!-- Tab Contents -->
    <div class="tab-content" id="cmsTabsContent">
        <!-- TAB 1: PROFIL SEKOLAH -->
        <div class="tab-pane fade show active" id="tab-profil" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-pencil-square text-primary me-2"></i>Edit Informasi Profil & Kontak Sekolah</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.cms.profil.update') }}#tab-profil" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-dark">Nama Sekolah</label>
                                <input type="text" name="nama_sekolah" class="form-control" value="{{ old('nama_sekolah', $profil->nama_sekolah ?? 'Sekolah Astika Dharma') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-dark">Slogan / Tagline Sekolah</label>
                                <input type="text" name="slogan" class="form-control" value="{{ old('slogan', $profil->slogan) }}" placeholder="Membentuk Generasi Unggul Untuk Masa Depan...">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-dark">Nama Kepala Sekolah</label>
                                <input type="text" name="nama_kepala_sekolah" class="form-control" value="{{ old('nama_kepala_sekolah', $profil->nama_kepala_sekolah) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-dark">Foto Kepala Sekolah</label>
                                <input type="file" name="foto_kepala_sekolah" class="form-control" accept="image/*">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold small text-dark">Sambutan Kepala Sekolah</label>
                                <textarea name="sambutan_kepala_sekolah" class="form-control" rows="4">{{ old('sambutan_kepala_sekolah', $profil->sambutan_kepala_sekolah) }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-dark">Visi Sekolah</label>
                                <textarea name="visi" class="form-control" rows="3">{{ old('visi', $profil->visi) }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-dark">Misi Sekolah</label>
                                <textarea name="misi" class="form-control" rows="3">{{ old('misi', $profil->misi) }}</textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold small text-dark">Sejarah Singkat Sekolah</label>
                                <textarea name="sejarah" class="form-control" rows="3">{{ old('sejarah', $profil->sejarah) }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-dark">Alamat Lengkap</label>
                                <input type="text" name="alamat" class="form-control" value="{{ old('alamat', $profil->alamat) }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small text-dark">Telepon</label>
                                <input type="text" name="telepon" class="form-control" value="{{ old('telepon', $profil->telepon) }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small text-dark">Email Resmi</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $profil->email) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-dark">Instagram</label>
                                <input type="text" name="instagram" class="form-control" value="{{ old('instagram', $profil->instagram) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-dark">YouTube Channel</label>
                                <input type="text" name="youtube" class="form-control" value="{{ old('youtube', $profil->youtube) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-dark">Facebook</label>
                                <input type="text" name="facebook" class="form-control" value="{{ old('facebook', $profil->facebook) }}">
                            </div>
                            <div class="col-12 text-end pt-3">
                                <button type="submit" class="btn btn-primary fw-bold px-4 py-2 rounded-3">
                                    <i class="bi bi-save me-1"></i> Simpan Perubahan Profil
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- TAB 2: EKSTRAKURIKULER -->
        <div class="tab-pane fade" id="tab-ekskul" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-3 mb-4 overflow-hidden">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-palette me-2 text-primary"></i>Kelola Ekstrakurikuler Sekolah</h5>
                    <button type="button" class="btn btn-primary btn-sm fw-bold rounded-3" data-bs-toggle="modal" data-bs-target="#modalTambahEkskul">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Ekskul Baru
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4" style="width: 250px;">Nama Ekstrakurikuler</th>
                                    <th>Kategori</th>
                                    <th>Pembina</th>
                                    <th>Jadwal Latihan</th>
                                    <th>Lokasi</th>
                                    <th style="width: 140px;">Status Landing</th>
                                    <th class="pe-4 text-end" style="width: 100px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ekstrakurikulers as $ek)
                                    <tr class="{{ $ek->status !== 'Aktif' ? 'table-secondary bg-opacity-25' : '' }}">
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center gap-2.5">
                                                @if($ek->foto)
                                                    <img src="{{ asset('storage/'.$ek->foto) }}" class="rounded-3 object-fit-cover border" style="width: 48px; height: 48px;">
                                                @else
                                                    <div class="bg-primary bg-opacity-10 text-primary rounded-3 d-flex align-items-center justify-content-center fw-bold" style="width: 48px; height: 48px;">
                                                        <i class="bi bi-palette fs-5"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="fw-bold text-dark fs-6">{{ $ek->nama_ekskul }}</div>
                                                    <small class="text-muted d-block text-truncate" style="max-width: 180px;">{{ $ek->deskripsi ?: '-' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-warning text-dark px-2.5 py-1">{{ $ek->kategori }}</span></td>
                                        <td class="small text-secondary">{{ $ek->pembina ?: '-' }}</td>
                                        <td class="small text-secondary">{{ $ek->hari_latihan ?: '-' }} {{ $ek->jam_latihan ? "($ek->jam_latihan)" : '' }}</td>
                                        <td class="small text-secondary">{{ $ek->lokasi ?: '-' }}</td>
                                        <td>
                                            <form action="{{ route('admin.cms.ekskul.toggle', $ek->id) }}#tab-ekskul" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm {{ $ek->status === 'Aktif' ? 'badge-show' : 'badge-hide' }} px-3 py-1.5 rounded-pill fw-bold" style="font-size: 0.8rem;" title="Klik untuk {{ $ek->status === 'Aktif' ? 'Sembunyikan (Hide)' : 'Tampilkan (Show)' }}">
                                                    <i class="bi {{ $ek->status === 'Aktif' ? 'bi-eye-fill me-1' : 'bi-eye-slash-fill me-1' }}"></i>
                                                    {{ $ek->status === 'Aktif' ? 'Show (Tampil)' : 'Hide (Sembunyi)' }}
                                                </button>
                                            </form>
                                        </td>
                                        <td class="pe-4 text-end">
                                            <form action="{{ route('admin.cms.ekskul.destroy', $ek->id) }}#tab-ekskul" method="POST" onsubmit="return confirm('Hapus ekstrakurikuler ini?')" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-3" title="Hapus">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada data ekstrakurikuler terdaftar.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 3: BERITA SEKOLAH -->
        <div class="tab-pane fade" id="tab-berita" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-3 mb-4 overflow-hidden">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-newspaper me-2 text-primary"></i>Kelola Publikasi Berita Sekolah</h5>
                    <button type="button" class="btn btn-primary btn-sm fw-bold rounded-3" data-bs-toggle="modal" data-bs-target="#modalTambahBerita">
                        <i class="bi bi-plus-circle me-1"></i> Terbitkan Berita Baru
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Judul Berita</th>
                                    <th>Kategori</th>
                                    <th>Tanggal Publikasi</th>
                                    <th>Highlight</th>
                                    <th style="width: 140px;">Status Landing</th>
                                    <th class="pe-4 text-end" style="width: 100px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($beritas as $b)
                                    <tr class="{{ !$b->is_active ? 'table-secondary bg-opacity-25' : '' }}">
                                        <td class="ps-4">
                                            <div class="fw-bold text-dark fs-6">{{ $b->judul }}</div>
                                            <small class="text-muted text-truncate d-block" style="max-width: 320px;">{{ Str::limit($b->ringkasan ?: $b->konten, 70) }}</small>
                                        </td>
                                        <td><span class="badge bg-info text-dark px-2.5 py-1">{{ $b->kategori ?: 'Umum' }}</span></td>
                                        <td class="small text-secondary">{{ \Carbon\Carbon::parse($b->tanggal_publikasi)->translatedFormat('d F Y') }}</td>
                                        <td>
                                            @if($b->is_highlight)
                                                <span class="badge bg-warning text-dark px-2 py-1"><i class="bi bi-star-fill me-1"></i>Utama</span>
                                            @else
                                                <span class="badge bg-light text-muted border px-2 py-1">Biasa</span>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.cms.berita.toggle', $b->id) }}#tab-berita" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm {{ $b->is_active ? 'badge-show' : 'badge-hide' }} px-3 py-1.5 rounded-pill fw-bold" style="font-size: 0.8rem;" title="Klik untuk {{ $b->is_active ? 'Sembunyikan (Hide)' : 'Tampilkan (Show)' }}">
                                                    <i class="bi {{ $b->is_active ? 'bi-eye-fill me-1' : 'bi-eye-slash-fill me-1' }}"></i>
                                                    {{ $b->is_active ? 'Show (Tampil)' : 'Hide (Sembunyi)' }}
                                                </button>
                                            </form>
                                        </td>
                                        <td class="pe-4 text-end">
                                            <form action="{{ route('admin.cms.berita.destroy', $b->id) }}#tab-berita" method="POST" onsubmit="return confirm('Hapus berita ini?')" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-3" title="Hapus Berita">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada berita terbit.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 4: AGENDA / EVENT -->
        <div class="tab-pane fade" id="tab-agenda" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-3 mb-4 overflow-hidden">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-calendar-event me-2 text-primary"></i>Kelola Event & Agenda Acara Sekolah</h5>
                    <button type="button" class="btn btn-primary btn-sm fw-bold rounded-3" data-bs-toggle="modal" data-bs-target="#modalTambahAgenda">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Event Baru
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Nama Event / Acara</th>
                                    <th>Tanggal & Waktu</th>
                                    <th>Lokasi</th>
                                    <th>Kategori</th>
                                    <th style="width: 140px;">Status Landing</th>
                                    <th class="pe-4 text-end" style="width: 100px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($agendas as $ag)
                                    <tr class="{{ !$ag->is_active ? 'table-secondary bg-opacity-25' : '' }}">
                                        <td class="ps-4">
                                            <div class="fw-bold text-dark fs-6">{{ $ag->judul }}</div>
                                            <small class="text-muted">{{ $ag->deskripsi ?: '-' }}</small>
                                        </td>
                                        <td class="small text-secondary">
                                            <i class="bi bi-calendar3 me-1 text-primary"></i>{{ \Carbon\Carbon::parse($ag->tanggal)->translatedFormat('d F Y') }}
                                            @if($ag->waktu_mulai)<br><small class="text-muted">{{ date('H:i', strtotime($ag->waktu_mulai)) }} WITA</small>@endif
                                        </td>
                                        <td class="small text-secondary">{{ $ag->lokasi ?: 'Sekolah' }}</td>
                                        <td><span class="badge bg-secondary px-2.5 py-1">{{ $ag->kategori }}</span></td>
                                        <td>
                                            <form action="{{ route('admin.cms.agenda.toggle', $ag->id) }}#tab-agenda" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm {{ $ag->is_active ? 'badge-show' : 'badge-hide' }} px-3 py-1.5 rounded-pill fw-bold" style="font-size: 0.8rem;" title="Klik untuk {{ $ag->is_active ? 'Sembunyikan (Hide)' : 'Tampilkan (Show)' }}">
                                                    <i class="bi {{ $ag->is_active ? 'bi-eye-fill me-1' : 'bi-eye-slash-fill me-1' }}"></i>
                                                    {{ $ag->is_active ? 'Show (Tampil)' : 'Hide (Sembunyi)' }}
                                                </button>
                                            </form>
                                        </td>
                                        <td class="pe-4 text-end">
                                            <form action="{{ route('admin.cms.agenda.destroy', $ag->id) }}#tab-agenda" method="POST" onsubmit="return confirm('Hapus agenda ini?')" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-3">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada agenda acara.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 5: FASILITAS -->
        <div class="tab-pane fade" id="tab-fasilitas" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-3 mb-4 overflow-hidden">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-box-seam me-2 text-primary"></i>Kelola Data &amp; Foto Fasilitas Sekolah</h5>
                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ route('landing_page') }}#fasilitas" target="_blank" class="btn btn-outline-info btn-sm fw-bold rounded-3">
                            <i class="bi bi-globe me-1"></i> Tampil di Landing Page &rarr;
                        </a>
                        <button type="button" class="btn btn-primary btn-sm fw-bold rounded-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahFasilitas">
                            <i class="bi bi-plus-circle me-1"></i> Tambah Fasilitas Baru
                        </button>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        @forelse($fasilitas as $fac)
                            <div class="col-md-4">
                                <div class="card border-0 shadow-sm h-100 rounded-3 overflow-hidden hover-card border border-light-subtle {{ !$fac->is_active ? 'bg-secondary bg-opacity-10' : '' }}">
                                    <div class="position-relative">
                                        <img src="{{ $fac->foto }}" class="card-img-top object-fit-cover" style="height: 180px;" alt="{{ $fac->nama_fasilitas }}">
                                        @if($fac->is_large)
                                            <span class="position-absolute top-0 end-0 badge bg-warning text-dark m-2 shadow-sm">
                                                <i class="bi bi-star-fill me-1"></i> Highlight Ukuran Besar
                                            </span>
                                        @endif
                                    </div>
                                    <div class="card-body p-3 d-flex flex-column justify-content-between">
                                        <div>
                                            <h6 class="fw-bold text-dark mb-1">{{ $fac->nama_fasilitas }}</h6>
                                            <p class="small text-muted mb-2">{{ $fac->deskripsi ?: 'Tidak ada deskripsi singkat.' }}</p>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center pt-2 border-top mt-2">
                                            <form action="{{ route('admin.cms.fasilitas.toggle', $fac->id) }}#tab-fasilitas" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm {{ $fac->is_active ? 'badge-show' : 'badge-hide' }} px-3 py-1 rounded-pill fw-bold" style="font-size: 0.8rem;" title="Klik untuk {{ $fac->is_active ? 'Sembunyikan (Hide)' : 'Tampilkan (Show)' }}">
                                                    <i class="bi {{ $fac->is_active ? 'bi-eye-fill me-1' : 'bi-eye-slash-fill me-1' }}"></i>
                                                    {{ $fac->is_active ? 'Show (Tampil)' : 'Hide (Sembunyi)' }}
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.cms.fasilitas.destroy', $fac->id) }}#tab-fasilitas" method="POST" onsubmit="return confirm('Hapus data fasilitas ini?')" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger px-2 rounded-3">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-4 text-muted">Belum ada foto fasilitas terdaftar.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 6: GALERI FOTO -->
        <div class="tab-pane fade" id="tab-galeri" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-3 mb-4 overflow-hidden">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-images me-2 text-primary"></i>Kelola Galeri Foto Sekolah</h5>
                    <button type="button" class="btn btn-primary btn-sm fw-bold rounded-3" data-bs-toggle="modal" data-bs-target="#modalTambahGaleri">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Foto Galeri
                    </button>
                </div>
                <div class="card-body p-3 bg-light">
                    <div class="row g-3">
                        @forelse($galeris as $g)
                            <div class="col-6 col-md-3">
                                <div class="card border-0 shadow-sm rounded-3 overflow-hidden position-relative hover-card {{ !$g->is_active ? 'opacity-75 border border-secondary' : '' }}">
                                    <img src="{{ $g->foto }}" class="card-img-top object-fit-cover" style="height: 160px;">
                                    <div class="p-2.5 bg-white d-flex justify-content-between align-items-center border-top">
                                        <form action="{{ route('admin.cms.galeri.toggle', $g->id) }}#tab-galeri" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-xs {{ $g->is_active ? 'badge-show' : 'badge-hide' }} px-2.5 py-1 rounded-pill fw-bold" style="font-size: 0.75rem;">
                                                <i class="bi {{ $g->is_active ? 'bi-eye-fill me-1' : 'bi-eye-slash-fill me-1' }}"></i> {{ $g->is_active ? 'Show' : 'Hide' }}
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.cms.galeri.destroy', $g->id) }}#tab-galeri" method="POST" onsubmit="return confirm('Hapus foto ini?')" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm p-0 px-2 rounded-3" title="Hapus Foto">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-4 text-muted">Belum ada foto di galeri sekolah.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 7: TESTIMONI & FAQ -->
        <div class="tab-pane fade" id="tab-testimoni" role="tabpanel">
            <div class="row g-4">
                <!-- Testimoni Column -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm rounded-3 mb-4 overflow-hidden">
                        <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-chat-quote me-2 text-primary"></i>Testimoni Alumni / Orang Tua</h5>
                            <button type="button" class="btn btn-primary btn-sm fw-bold rounded-3" data-bs-toggle="modal" data-bs-target="#modalTambahTestimoni">
                                <i class="bi bi-plus-circle me-1"></i> Tambah
                            </button>
                        </div>
                        <div class="card-body p-3 bg-light">
                            @forelse($testimonis as $t)
                                <div class="bg-white p-3 rounded-3 shadow-sm mb-2.5 border hover-card {{ !$t->is_active ? 'bg-secondary bg-opacity-10' : '' }}">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="fw-bold text-dark mb-0 fs-6">{{ $t->nama }}</h6>
                                            <small class="text-primary fw-semibold">{{ $t->peran ?: 'Alumni / Wali Siswa' }}</small>
                                        </div>
                                        <div class="d-flex align-items-center gap-1.5">
                                            <form action="{{ route('admin.cms.testimoni.toggle', $t->id) }}#tab-testimoni" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm {{ $t->is_active ? 'badge-show' : 'badge-hide' }} px-2.5 py-1 rounded-pill fw-bold" style="font-size: 0.75rem;">
                                                    <i class="bi {{ $t->is_active ? 'bi-eye-fill me-1' : 'bi-eye-slash-fill me-1' }}"></i> {{ $t->is_active ? 'Show' : 'Hide' }}
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.cms.testimoni.destroy', $t->id) }}#tab-testimoni" method="POST" onsubmit="return confirm('Hapus testimoni ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger py-0.5 px-2 rounded-3"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                    <small class="text-muted fst-italic d-block">"{{ $t->konten }}"</small>
                                </div>
                            @empty
                                <div class="text-center py-3 text-muted">Belum ada testimoni.</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- FAQ Column -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm rounded-3 mb-4 overflow-hidden">
                        <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-question-circle me-2 text-primary"></i>FAQ (Pertanyaan Umum)</h5>
                            <button type="button" class="btn btn-primary btn-sm fw-bold rounded-3" data-bs-toggle="modal" data-bs-target="#modalTambahFaq">
                                <i class="bi bi-plus-circle me-1"></i> Tambah FAQ
                            </button>
                        </div>
                        <div class="card-body p-3 bg-light">
                            @forelse($faqs as $fq)
                                <div class="bg-white p-3 rounded-3 shadow-sm mb-2.5 border hover-card {{ !$fq->is_active ? 'bg-secondary bg-opacity-10' : '' }}">
                                    <div class="d-flex justify-content-between align-items-start mb-1.5">
                                        <h6 class="fw-bold text-dark mb-0 fs-6">{{ $fq->pertanyaan }}</h6>
                                        <div class="d-flex align-items-center gap-1.5">
                                            <form action="{{ route('admin.cms.faq.toggle', $fq->id) }}#tab-testimoni" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm {{ $fq->is_active ? 'badge-show' : 'badge-hide' }} px-2.5 py-1 rounded-pill fw-bold" style="font-size: 0.75rem;">
                                                    <i class="bi {{ $fq->is_active ? 'bi-eye-fill me-1' : 'bi-eye-slash-fill me-1' }}"></i> {{ $fq->is_active ? 'Show' : 'Hide' }}
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.cms.faq.destroy', $fq->id) }}#tab-testimoni" method="POST" onsubmit="return confirm('Hapus FAQ ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger py-0.5 px-2 rounded-3"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                    <small class="text-muted d-block" style="line-height: 1.5;">{{ $fq->jawaban }}</small>
                                </div>
                            @empty
                                <div class="text-center py-3 text-muted">Belum ada data FAQ.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 8: GURU & STAFF SEKOLAH -->
        <div class="tab-pane fade" id="tab-guru" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-3 mb-4 overflow-hidden">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-person-workspace text-primary me-2"></i>Pengaturan Tampilan Direktori Guru & Staff di Landing Page
                    </h5>
                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ route('guru_staff') }}" target="_blank" class="btn btn-outline-primary btn-sm fw-bold rounded-3">
                            <i class="bi bi-globe me-1"></i> Buka Tampilan Landing Page &rarr;
                        </a>
                        <a href="{{ route('guru.index') }}" class="btn btn-primary btn-sm fw-bold rounded-3">
                            <i class="bi bi-gear-fill me-1"></i> Kelola Data Guru (Tambah / Edit)
                        </a>
                    </div>
                </div>
                <div class="card-body p-4">
                    <!-- Guru Section -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold text-dark mb-0"><i class="bi bi-person-badge text-primary me-1"></i> Daftar Guru Sekolah (Total {{ count($gurus) }})</h6>
                    </div>

                    <div class="row g-3 mb-4">
                        @forelse($gurus as $g)
                        <div class="col-md-6 col-lg-4">
                            <div class="card border border-light-subtle shadow-sm rounded-3 h-100 hover-card {{ !$g->is_active ? 'bg-secondary bg-opacity-10' : '' }}">
                                <div class="card-body p-3 d-flex align-items-center justify-content-between gap-2">
                                    <div class="d-flex align-items-center gap-3">
                                        @if($g->foto)
                                            <img src="{{ asset('storage/'.$g->foto) }}" alt="{{ $g->nama }}" class="rounded-circle object-fit-cover border shadow-sm" style="width: 50px; height: 50px;">
                                        @else
                                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 50px; height: 50px; font-size: 1.2rem;">
                                                {{ strtoupper(substr($g->nama, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <h6 class="fw-bold text-dark mb-1 fs-6">{{ $g->nama }}</h6>
                                            <span class="badge bg-primary bg-opacity-10 text-primary fw-bold small">{{ $g->mata_pelajaran }}</span>
                                        </div>
                                    </div>
                                    <form action="{{ route('admin.cms.guru.toggle', $g->id) }}#tab-guru" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm {{ $g->is_active ? 'badge-show' : 'badge-hide' }} px-3 py-1.5 rounded-pill fw-bold" style="font-size: 0.8rem;" title="Klik untuk {{ $g->is_active ? 'Sembunyikan (Hide)' : 'Tampilkan (Show)' }}">
                                            <i class="bi {{ $g->is_active ? 'bi-eye-fill me-1' : 'bi-eye-slash-fill me-1' }}"></i>
                                            {{ $g->is_active ? 'Show (Tampil)' : 'Hide (Sembunyi)' }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-center py-4 text-muted">Belum ada data guru terdaftar.</div>
                        @endforelse
                    </div>

                    <!-- Staff Section -->
                    @if(isset($staffs))
                    <div class="d-flex justify-content-between align-items-center mb-3 pt-3 border-top">
                        <h6 class="fw-bold text-dark mb-0"><i class="bi bi-person-lines-fill text-info me-1"></i> Daftar Staff Sekolah (Total {{ count($staffs) }})</h6>
                    </div>

                    <div class="row g-3">
                        @forelse($staffs as $s)
                        <div class="col-md-6 col-lg-4">
                            <div class="card border border-light-subtle shadow-sm rounded-3 h-100 hover-card {{ !$s->is_active ? 'bg-secondary bg-opacity-10' : '' }}">
                                <div class="card-body p-3 d-flex align-items-center justify-content-between gap-2">
                                    <div class="d-flex align-items-center gap-3">
                                        @if($s->foto)
                                            <img src="{{ asset('storage/'.$s->foto) }}" alt="{{ $s->nama }}" class="rounded-circle object-fit-cover border shadow-sm" style="width: 50px; height: 50px;">
                                        @else
                                            <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 50px; height: 50px; font-size: 1.2rem;">
                                                {{ strtoupper(substr($s->nama, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <h6 class="fw-bold text-dark mb-1 fs-6">{{ $s->nama }}</h6>
                                            <span class="badge bg-info bg-opacity-10 text-info fw-bold small">{{ $s->jabatan }}</span>
                                        </div>
                                    </div>
                                    <form action="{{ route('admin.cms.staff.toggle', $s->id) }}#tab-guru" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm {{ $s->is_active ? 'badge-show' : 'badge-hide' }} px-3 py-1.5 rounded-pill fw-bold" style="font-size: 0.8rem;" title="Klik untuk {{ $s->is_active ? 'Sembunyikan (Hide)' : 'Tampilkan (Show)' }}">
                                            <i class="bi {{ $s->is_active ? 'bi-eye-fill me-1' : 'bi-eye-slash-fill me-1' }}"></i>
                                            {{ $s->is_active ? 'Show (Tampil)' : 'Hide (Sembunyi)' }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-center py-4 text-muted">Belum ada data staff terdaftar.</div>
                        @endforelse
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODALS FOR ADDING CMS ITEMS -->
<!-- Modal Tambah Ekstrakurikuler -->
<div class="modal fade" id="modalTambahEkskul" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-dark text-white border-0 py-3">
                <h5 class="modal-title fw-bold"><i class="bi bi-palette me-2 text-warning"></i>Tambah Ekstrakurikuler Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.cms.ekskul.store') }}#tab-ekskul" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-dark">Nama Ekstrakurikuler <span class="text-danger">*</span></label>
                            <input type="text" name="nama_ekskul" class="form-control" required placeholder="Contoh: Basket / Pramuka / DJ...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-dark">Kategori <span class="text-danger">*</span></label>
                            <select name="kategori" class="form-select" required>
                                <option value="Olahraga">Olahraga</option>
                                <option value="Seni & Budaya">Seni & Budaya</option>
                                <option value="Keagamaan">Keagamaan</option>
                                <option value="Sains & Teknologi">Sains & Teknologi</option>
                                <option value="Organisasi & Kepemimpinan">Organisasi & Kepemimpinan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-dark">Nama Pembina</label>
                            <input type="text" name="pembina" class="form-control" placeholder="Nama guru / pembina ekskul...">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small text-dark">Hari Latihan</label>
                            <input type="text" name="hari_latihan" class="form-control" placeholder="Contoh: Sabtu">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small text-dark">Jam Latihan</label>
                            <input type="text" name="jam_latihan" class="form-control" placeholder="15.00 - 17.00">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-dark">Lokasi Latihan</label>
                            <input type="text" name="lokasi" class="form-control" placeholder="Lapangan / Aula Sekolah...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-dark">Foto Ekskul</label>
                            <input type="file" name="foto" class="form-control" accept="image/*">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small text-dark">Deskripsi Ekskul</label>
                            <textarea name="deskripsi" class="form-control" rows="3" placeholder="Penjelasan singkat ekskul..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary btn-sm rounded-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold btn-sm px-4 rounded-3">Simpan Ekstrakurikuler</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah Berita -->
<div class="modal fade" id="modalTambahBerita" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-dark text-white border-0 py-3">
                <h5 class="modal-title fw-bold"><i class="bi bi-newspaper me-2 text-warning"></i>Terbitkan Berita Sekolah Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.cms.berita.store') }}#tab-berita" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold small text-dark">Judul Berita <span class="text-danger">*</span></label>
                            <input type="text" name="judul" class="form-control" required placeholder="Judul berita sekolah...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-dark">Kategori</label>
                            <input type="text" name="kategori" class="form-control" placeholder="Pengumuman / Prestasi / Akademik...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-dark">Tanggal Publikasi <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_publikasi" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small text-dark">Ringkasan Berita Singkat</label>
                            <input type="text" name="ringkasan" class="form-control" placeholder="Ringkasan 1-2 kalimat...">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small text-dark">Isi Konten Berita Lengkap <span class="text-danger">*</span></label>
                            <textarea name="konten" class="form-control" rows="5" required placeholder="Tuliskan isi berita sekolah..."></textarea>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-bold small text-dark">Foto Berita</label>
                            <input type="file" name="foto" class="form-control" accept="image/*">
                        </div>
                        <div class="col-md-4 pt-4">
                            <div class="form-check form-switch pt-2">
                                <input class="form-check-input" type="checkbox" name="is_highlight" id="highlightCheck" value="1">
                                <label class="form-check-label fw-bold small text-dark" for="highlightCheck">Set Berita Utama (Highlight)</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary btn-sm rounded-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold btn-sm px-4 rounded-3">Terbitkan Berita</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah Agenda -->
<div class="modal fade" id="modalTambahAgenda" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-dark text-white border-0 py-3">
                <h5 class="modal-title fw-bold"><i class="bi bi-calendar-event me-2 text-warning"></i>Tambah Agenda Acara Sekolah</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.cms.agenda.store') }}#tab-agenda" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold small text-dark">Nama Event / Acara <span class="text-danger">*</span></label>
                            <input type="text" name="judul" class="form-control" required placeholder="Contoh: Upacara Hari Kemerdekaan...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-dark">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small text-dark">Waktu Mulai</label>
                            <input type="time" name="waktu_mulai" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small text-dark">Selesai</label>
                            <input type="time" name="waktu_selesai" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-dark">Lokasi Acara</label>
                            <input type="text" name="lokasi" class="form-control" placeholder="Lapangan Utama / Aula...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-dark">Kategori</label>
                            <input type="text" name="kategori" class="form-control" placeholder="Umum / Ujian / Upacara...">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small text-dark">Deskripsi Singkat</label>
                            <textarea name="deskripsi" class="form-control" rows="2" placeholder="Keterangan singkat acara..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary btn-sm rounded-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold btn-sm px-4 rounded-3">Simpan Agenda</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah Fasilitas -->
<div class="modal fade" id="modalTambahFasilitas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-dark text-white border-0 py-3">
                <h5 class="modal-title fw-bold"><i class="bi bi-box-seam me-2 text-warning"></i>Tambah Fasilitas Sekolah</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.cms.fasilitas.store') }}#tab-fasilitas" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold small text-dark">Nama Fasilitas <span class="text-danger">*</span></label>
                            <input type="text" name="nama_fasilitas" class="form-control" required placeholder="Contoh: Laboratorium Komputer RPL...">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small text-dark">Foto Fasilitas <span class="text-danger">*</span></label>
                            <input type="file" name="foto" class="form-control" accept="image/*" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small text-dark">Deskripsi Fasilitas</label>
                            <textarea name="deskripsi" class="form-control" rows="2" placeholder="Keterangan fasilitas..."></textarea>
                        </div>
                        <div class="col-12">
                            <div class="form-check form-switch pt-1">
                                <input class="form-check-input" type="checkbox" name="is_large" id="largeCheck" value="1">
                                <label class="form-check-label fw-bold small text-dark" for="largeCheck">Tampilkan Sebagai Card Ukuran Besar (Highlight)</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary btn-sm rounded-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold btn-sm px-4 rounded-3">Simpan Fasilitas</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah Galeri -->
<div class="modal fade" id="modalTambahGaleri" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-dark text-white border-0 py-3">
                <h5 class="modal-title fw-bold"><i class="bi bi-images me-2 text-warning"></i>Upload Foto Galeri</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.cms.galeri.store') }}#tab-galeri" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold small text-dark">Pilih Foto <span class="text-danger">*</span></label>
                            <input type="file" name="foto" class="form-control" accept="image/*" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-dark">Judul / Caption Foto</label>
                            <input type="text" name="judul" class="form-control" placeholder="Caption singkat...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-dark">Kategori</label>
                            <input type="text" name="kategori" class="form-control" placeholder="Kegiatan / Prestasi...">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary btn-sm rounded-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold btn-sm px-4 rounded-3">Upload Foto</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah Testimoni -->
<div class="modal fade" id="modalTambahTestimoni" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-dark text-white border-0 py-3">
                <h5 class="modal-title fw-bold"><i class="bi bi-chat-quote me-2 text-warning"></i>Tambah Testimoni Alumni / Ortu</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.cms.testimoni.store') }}#tab-testimoni" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-dark">Nama <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control" required placeholder="Nama pemberi testimoni...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-dark">Peran / Profesi</label>
                            <input type="text" name="peran" class="form-control" placeholder="Alumni 2024 / Orang Tua Siswa...">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small text-dark">Isi Testimoni <span class="text-danger">*</span></label>
                            <textarea name="konten" class="form-control" rows="3" required placeholder="Tuliskan testimoni tentang sekolah..."></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small text-dark">Foto Profil</label>
                            <input type="file" name="foto" class="form-control" accept="image/*">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary btn-sm rounded-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold btn-sm px-4 rounded-3">Simpan Testimoni</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah FAQ -->
<div class="modal fade" id="modalTambahFaq" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-dark text-white border-0 py-3">
                <h5 class="modal-title fw-bold"><i class="bi bi-question-circle me-2 text-warning"></i>Tambah Pertanyaan FAQ</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.cms.faq.store') }}#tab-testimoni" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold small text-dark">Pertanyaan <span class="text-danger">*</span></label>
                            <input type="text" name="pertanyaan" class="form-control" required placeholder="Contoh: Bagaimana cara mendaftar PPDB online?">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small text-dark">Jawaban <span class="text-danger">*</span></label>
                            <textarea name="jawaban" class="form-control" rows="3" required placeholder="Tuliskan jawaban lengkap..."></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-dark">Urutan Tampil</label>
                            <input type="number" name="urutan" class="form-control" value="0">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary btn-sm rounded-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold btn-sm px-4 rounded-3">Simpan FAQ</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Tab Persistence & Smart Hash Switching Script -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Function to active tab by ID
        function activateTab(tabId) {
            if (!tabId) return;
            const targetId = tabId.replace('#', '');
            const tabButton = document.querySelector(`#${targetId}-tab`) || 
                              document.querySelector(`button[data-bs-target="#${targetId}"]`);
            if (tabButton && typeof bootstrap !== 'undefined') {
                const bsTab = bootstrap.Tab.getOrCreateInstance(tabButton);
                bsTab.show();
            }
        }

        // 1. Check URL Hash or localStorage on load
        let currentHash = window.location.hash;
        let storedTab = localStorage.getItem("cmsActiveTab");
        let tabToActivate = currentHash || (storedTab ? '#' + storedTab : null);

        if (tabToActivate) {
            activateTab(tabToActivate);
        }

        // 2. Save active tab when user clicks any tab
        const tabList = document.querySelectorAll('#cmsTabs button[data-bs-toggle="tab"]');
        tabList.forEach(button => {
            button.addEventListener('shown.bs.tab', function(e) {
                const targetHash = e.target.getAttribute('data-bs-target');
                const targetId = targetHash.replace('#', '');
                localStorage.setItem("cmsActiveTab", targetId);
                if (history.replaceState) {
                    history.replaceState(null, null, targetHash);
                } else {
                    location.hash = targetHash;
                }
            });
        });
    });
</script>
@endsection
