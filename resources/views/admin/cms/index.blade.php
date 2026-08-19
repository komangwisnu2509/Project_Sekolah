@extends('layouts.app')

@section('content')
<div class="container-fluid px-0" style="max-width: 1300px; margin: 0 auto;">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1">
                <i class="bi bi-window-stack text-primary me-2"></i>Kelola Beranda Utama Sekolah (CMS)
            </h2>
            <p class="text-muted mb-0">
                Edit profil sekolah, publikasikan berita & agenda acara, kelola foto fasilitas, galeri, testimoni, dan FAQ yang tampil di Beranda Utama.
            </p>
        </div>
        <a href="{{ route('landing_page') }}" class="btn btn-outline-primary fw-bold shadow-sm" target="_blank">
            <i class="bi bi-globe me-1"></i> Buka Website Beranda Utama &rarr;
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
                <i class="bi bi-building me-1"></i> Profil Sekolah
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold py-2.5" id="tab-berita-tab" data-bs-toggle="tab" data-bs-target="#tab-berita" type="button" role="tab">
                <i class="bi bi-newspaper me-1"></i> Berita Sekolah
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold py-2.5" id="tab-agenda-tab" data-bs-toggle="tab" data-bs-target="#tab-agenda" type="button" role="tab">
                <i class="bi bi-calendar-event me-1"></i> Event / Agenda
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold py-2.5" id="tab-fasilitas-tab" data-bs-toggle="tab" data-bs-target="#tab-fasilitas" type="button" role="tab">
                <i class="bi bi-box-seam me-1"></i> Fasilitas
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold py-2.5" id="tab-galeri-tab" data-bs-toggle="tab" data-bs-target="#tab-galeri" type="button" role="tab">
                <i class="bi bi-images me-1"></i> Galeri Foto
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold py-2.5" id="tab-testimoni-tab" data-bs-toggle="tab" data-bs-target="#tab-testimoni" type="button" role="tab">
                <i class="bi bi-chat-quote me-1"></i> Testimoni & FAQ
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
                    <form action="{{ route('admin.cms.profil.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Nama Sekolah</label>
                                <input type="text" name="nama_sekolah" class="form-control" value="{{ old('nama_sekolah', $profil->nama_sekolah ?? 'Sekolah Astika Dharma') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Slogan / Tagline Sekolah</label>
                                <input type="text" name="slogan" class="form-control" value="{{ old('slogan', $profil->slogan) }}" placeholder="Membentuk Generasi Unggul Untuk Masa Depan...">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Nama Kepala Sekolah</label>
                                <input type="text" name="nama_kepala_sekolah" class="form-control" value="{{ old('nama_kepala_sekolah', $profil->nama_kepala_sekolah) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Foto Kepala Sekolah</label>
                                <input type="file" name="foto_kepala_sekolah" class="form-control" accept="image/*">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold small">Sambutan Kepala Sekolah</label>
                                <textarea name="sambutan_kepala_sekolah" class="form-control" rows="4">{{ old('sambutan_kepala_sekolah', $profil->sambutan_kepala_sekolah) }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Visi Sekolah</label>
                                <textarea name="visi" class="form-control" rows="3">{{ old('visi', $profil->visi) }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Misi Sekolah</label>
                                <textarea name="misi" class="form-control" rows="3">{{ old('misi', $profil->misi) }}</textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">Nomor Telepon / WA</label>
                                <input type="text" name="telepon" class="form-control" value="{{ old('telepon', $profil->telepon) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">Email Resmi Sekolah</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $profil->email) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">Username Instagram</label>
                                <input type="text" name="instagram" class="form-control" value="{{ old('instagram', $profil->instagram) }}" placeholder="@astikadharma">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold small">Alamat Lengkap Sekolah</label>
                                <textarea name="alamat" class="form-control" rows="2">{{ old('alamat', $profil->alamat) }}</textarea>
                            </div>
                        </div>
                        <div class="text-end mt-4 pt-3 border-top">
                            <button type="submit" class="btn btn-primary fw-bold px-4"><i class="bi bi-save me-1"></i> Simpan Profil Sekolah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- TAB 2: BERITA SEKOLAH -->
        <div class="tab-pane fade" id="tab-berita" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-newspaper me-2 text-primary"></i>Kelola Publikasi Berita Sekolah</h5>
                    <button type="button" class="btn btn-primary btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambahBerita">
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
                                    <th>Highlight Beranda</th>
                                    <th class="pe-4 text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($beritas as $b)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold text-dark">{{ $b->judul }}</div>
                                            <small class="text-muted">{{ Str::limit($b->ringkasan ?: $b->konten, 70) }}</small>
                                        </td>
                                        <td><span class="badge bg-info text-dark">{{ $b->kategori ?: 'Umum' }}</span></td>
                                        <td class="small">{{ \Carbon\Carbon::parse($b->tanggal_publikasi)->translatedFormat('d F Y') }}</td>
                                        <td>
                                            @if($b->is_highlight)
                                                <span class="badge bg-warning text-dark"><i class="bi bi-star-fill me-1"></i>Utama (Highlight)</span>
                                            @else
                                                <span class="badge bg-light text-dark border">Biasa</span>
                                            @endif
                                        </td>
                                        <td class="pe-4 text-end">
                                            <form action="{{ route('admin.cms.berita.destroy', $b->id) }}" method="POST" onsubmit="return confirm('Hapus berita ini?')" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Berita">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada berita terbit.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 3: AGENDA / EVENT -->
        <div class="tab-pane fade" id="tab-agenda" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-calendar-event me-2 text-primary"></i>Kelola Event & Agenda Acara Sekolah</h5>
                    <button type="button" class="btn btn-primary btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambahAgenda">
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
                                    <th class="pe-4 text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($agendas as $ag)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold text-dark">{{ $ag->judul }}</div>
                                            <small class="text-muted">{{ $ag->deskripsi }}</small>
                                        </td>
                                        <td class="small">
                                            <i class="bi bi-calendar3 me-1 text-primary"></i>{{ \Carbon\Carbon::parse($ag->tanggal)->translatedFormat('d F Y') }}
                                            @if($ag->waktu_mulai)<br><small class="text-muted">{{ date('H:i', strtotime($ag->waktu_mulai)) }} WITA</small>@endif
                                        </td>
                                        <td class="small">{{ $ag->lokasi ?: 'Sekolah' }}</td>
                                        <td><span class="badge bg-secondary">{{ $ag->kategori }}</span></td>
                                        <td class="pe-4 text-end">
                                            <form action="{{ route('admin.cms.agenda.destroy', $ag->id) }}" method="POST" onsubmit="return confirm('Hapus agenda ini?')" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada agenda acara.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 4: FASILITAS -->
        <div class="tab-pane fade" id="tab-fasilitas" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-box-seam me-2 text-primary"></i>Kelola Foto Fasilitas Sekolah</h5>
                    <button type="button" class="btn btn-primary btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambahFasilitas">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Fasilitas Baru
                    </button>
                </div>
                <div class="card-body p-3 bg-light">
                    <div class="row g-3">
                        @forelse($fasilitas as $fac)
                            <div class="col-md-4">
                                <div class="card border-0 shadow-sm h-100 rounded-3 overflow-hidden">
                                    <img src="{{ $fac->foto }}" class="card-img-top object-fit-cover" style="height: 180px;">
                                    <div class="card-body p-3">
                                        <h6 class="fw-bold text-dark mb-1">{{ $fac->nama_fasilitas }}</h6>
                                        <p class="small text-muted mb-2">{{ $fac->deskripsi }}</p>
                                        <div class="text-end">
                                            <form action="{{ route('admin.cms.fasilitas.destroy', $fac->id) }}" method="POST" onsubmit="return confirm('Hapus fasilitas ini?')" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger px-3">
                                                    <i class="bi bi-trash me-1"></i> Hapus
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

        <!-- TAB 5: GALERI FOTO -->
        <div class="tab-pane fade" id="tab-galeri" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-images me-2 text-primary"></i>Kelola Galeri Foto Sekolah</h5>
                    <button type="button" class="btn btn-primary btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambahGaleri">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Foto Galeri
                    </button>
                </div>
                <div class="card-body p-3 bg-light">
                    <div class="row g-3">
                        @forelse($galeris as $g)
                            <div class="col-6 col-md-3">
                                <div class="card border-0 shadow-sm rounded-3 overflow-hidden position-relative">
                                    <img src="{{ $g->foto }}" class="card-img-top object-fit-cover" style="height: 150px;">
                                    <form action="{{ route('admin.cms.galeri.destroy', $g->id) }}" method="POST" onsubmit="return confirm('Hapus foto ini?')" class="position-absolute top-0 end-0 m-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm rounded-circle p-1" style="width: 32px; height: 32px;" title="Hapus Foto">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-4 text-muted">Belum ada foto di galeri sekolah.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 6: TESTIMONI & FAQ -->
        <div class="tab-pane fade" id="tab-testimoni" role="tabpanel">
            <div class="row g-4">
                <!-- Testimoni Column -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm rounded-3 mb-4">
                        <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-chat-quote me-2 text-primary"></i>Testimoni Alumni / Orang Tua</h5>
                            <button type="button" class="btn btn-primary btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambahTestimoni">
                                <i class="bi bi-plus-circle me-1"></i> Tambah
                            </button>
                        </div>
                        <div class="card-body p-3 bg-light">
                            @forelse($testimonis as $t)
                                <div class="bg-white p-3 rounded-3 shadow-sm mb-2 border">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="fw-bold text-dark mb-0">{{ $t->nama }}</h6>
                                            <small class="text-primary">{{ $t->peran }}</small>
                                        </div>
                                        <form action="{{ route('admin.cms.testimoni.destroy', $t->id) }}" method="POST" onsubmit="return confirm('Hapus testimoni ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-2"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                    <small class="text-muted fst-italic">"{{ $t->konten }}"</small>
                                </div>
                            @empty
                                <div class="text-center py-3 text-muted">Belum ada testimoni.</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- FAQ Column -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm rounded-3 mb-4">
                        <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-question-circle me-2 text-primary"></i>FAQ (Pertanyaan Umum)</h5>
                            <button type="button" class="btn btn-primary btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambahFaq">
                                <i class="bi bi-plus-circle me-1"></i> Tambah FAQ
                            </button>
                        </div>
                        <div class="card-body p-3 bg-light">
                            @forelse($faqs as $fq)
                                <div class="bg-white p-3 rounded-3 shadow-sm mb-2 border">
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <h6 class="fw-bold text-dark mb-0">{{ $fq->pertanyaan }}</h6>
                                        <form action="{{ route('admin.cms.faq.destroy', $fq->id) }}" method="POST" onsubmit="return confirm('Hapus FAQ ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-2"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                    <small class="text-muted d-block">{{ $fq->jawaban }}</small>
                                </div>
                            @empty
                                <div class="text-center py-3 text-muted">Belum ada data FAQ.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODALS FOR ADDING CMS ITEMS -->
<!-- Modal Tambah Berita -->
<div class="modal fade" id="modalTambahBerita" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-dark text-white border-0 py-3">
                <h5 class="modal-title fw-bold"><i class="bi bi-newspaper me-2 text-warning"></i>Terbitkan Berita Sekolah Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.cms.berita.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold small">Judul Berita <span class="text-danger">*</span></label>
                            <input type="text" name="judul" class="form-control" required placeholder="Judul berita sekolah...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Kategori</label>
                            <input type="text" name="kategori" class="form-control" placeholder="Pengumuman / Prestasi / Akademik...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Tanggal Publikasi <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_publikasi" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small">Ringkasan Berita Singkat</label>
                            <input type="text" name="ringkasan" class="form-control" placeholder="Ringkasan 1-2 kalimat...">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small">Isi Konten Berita Lengkap <span class="text-danger">*</span></label>
                            <textarea name="konten" class="form-control" rows="5" required placeholder="Tuliskan isi berita sekolah..."></textarea>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-bold small">Foto Berita</label>
                            <input type="file" name="foto" class="form-control" accept="image/*">
                        </div>
                        <div class="col-md-4 pt-4">
                            <div class="form-check form-switch pt-2">
                                <input class="form-check-input" type="checkbox" name="is_highlight" id="highlightCheck" value="1">
                                <label class="form-check-label fw-bold small" for="highlightCheck">Set Berita Utama (Highlight)</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold btn-sm px-4">Terbitkan Berita</button>
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
            <form action="{{ route('admin.cms.agenda.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold small">Nama Event / Acara <span class="text-danger">*</span></label>
                            <input type="text" name="judul" class="form-control" required placeholder="Contoh: Ujian Tengah Semester Genap...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Lokasi</label>
                            <input type="text" name="lokasi" class="form-control" placeholder="Aula / Lapangan...">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small">Deskripsi Acara</label>
                            <textarea name="deskripsi" class="form-control" rows="3" placeholder="Rincian singkat acara..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold btn-sm px-4">Simpan Event</button>
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
            <form action="{{ route('admin.cms.fasilitas.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold small">Nama Fasilitas <span class="text-danger">*</span></label>
                            <input type="text" name="nama_fasilitas" class="form-control" required placeholder="Contoh: Lab Komputer i7...">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small">Deskripsi Singkat</label>
                            <textarea name="deskripsi" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small">Foto Fasilitas <span class="text-danger">*</span></label>
                            <input type="file" name="foto" class="form-control" accept="image/*" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold btn-sm px-4">Simpan Fasilitas</button>
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
                <h5 class="modal-title fw-bold"><i class="bi bi-images me-2 text-warning"></i>Tambah Foto Galeri</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.cms.galeri.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold small">Judul / Keterangan Foto</label>
                            <input type="text" name="judul" class="form-control" placeholder="Contoh: Upacara Bendera...">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small">Pilih File Foto <span class="text-danger">*</span></label>
                            <input type="file" name="foto" class="form-control" accept="image/*" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold btn-sm px-4">Upload Foto</button>
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
                <h5 class="modal-title fw-bold"><i class="bi bi-chat-quote me-2 text-warning"></i>Tambah Testimoni</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.cms.testimoni.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold small">Nama Pemberi Testimoni <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control" required placeholder="Nama alumni / orang tua...">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small">Peran / Status</label>
                            <input type="text" name="peran" class="form-control" placeholder="Contoh: Alumni DKV 2023 / Orang Tua Siswa...">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small">Isi Testimoni <span class="text-danger">*</span></label>
                            <textarea name="konten" class="form-control" rows="3" required placeholder="Ulasan pengalaman belajar..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold btn-sm px-4">Simpan Testimoni</button>
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
                <h5 class="modal-title fw-bold"><i class="bi bi-question-circle me-2 text-warning"></i>Tambah FAQ Pertanyaan Umum</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.cms.faq.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold small">Pertanyaan <span class="text-danger">*</span></label>
                            <input type="text" name="pertanyaan" class="form-control" required placeholder="Pertanyaan yang sering ditanyakan...">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small">Jawaban Lengkap <span class="text-danger">*</span></label>
                            <textarea name="jawaban" class="form-control" rows="3" required placeholder="Jawaban resmi..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold btn-sm px-4">Simpan FAQ</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
