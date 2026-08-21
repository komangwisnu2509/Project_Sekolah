@extends('layouts.app')

@section('content')
<div class="row" style="max-width: 1150px; margin: 0 auto;">
    <div class="col-md-12 mb-4">
        <h2 class="fw-bold"><i class="bi bi-journal-text me-2"></i>Kelola Jurusan / Program Keahlian</h2>
        <p class="text-muted">Kelola data jurusan, status tampilan (Show/Hide), deskripsi singkat, foto, dan informasi lengkap yang tampil pada Landing Page Sekolah.</p>
    </div>

    @if(session('success'))
        <div class="col-md-12 mb-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <!-- Form Tambah Jurusan -->
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
            <div class="card-header bg-dark text-white py-3">
                <h5 class="mb-0 fw-bold"><i class="bi bi-plus-circle me-1"></i> Tambah Jurusan</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('jurusan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_jurusan" class="form-label fw-bold small text-dark">Nama Jurusan <span class="text-danger">*</span></label>
                        <input type="text" name="nama_jurusan" id="nama_jurusan" class="form-control @error('nama_jurusan') is-invalid @enderror" placeholder="Contoh: Rekayasa Perangkat Lunak (RPL)" required>
                        @error('nama_jurusan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="is_active" class="form-label fw-bold small text-dark">Status Tampilan Landing Page</label>
                        <select name="is_active" id="is_active" class="form-select fw-semibold text-dark">
                            <option value="1" selected>👁️ Show (Tampilkan di Landing Page)</option>
                            <option value="0">🙈 Hide (Sembunyikan dari Landing Page)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="icon" class="form-label fw-bold small text-dark">Ikon Jurusan</label>
                        <select name="icon" id="icon" class="form-select">
                            <option value="monitor">🖥️ Laptop / Monitor (Teknologi / RPL / TKJ)</option>
                            <option value="code">💻 Pemrograman / Code</option>
                            <option value="camera">📷 Kamera (DKV / Multimedia / Seni)</option>
                            <option value="briefcase">💼 Bisnis & Manajemen / Akuntansi</option>
                            <option value="cpu">⚡ Elektronika / Otomasi / Mesin</option>
                            <option value="tools">🔧 Otomotif / Konstruksi</option>
                            <option value="book">📚 Umum / Bahasa / Pendidikan</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label fw-bold small text-dark">Deskripsi Singkat</label>
                        <textarea name="deskripsi" id="deskripsi" rows="2" class="form-control" placeholder="Ringkasan singkat yang tampil di kartu Landing Page..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="detail_informasi" class="form-label fw-bold small text-dark">Detail Informasi & Prospek Kerja</label>
                        <textarea name="detail_informasi" id="detail_informasi" rows="3" class="form-control" placeholder="Jelaskan keunggulan, materi yang dipelajari, dan prospek karir jurusan..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="foto" class="form-label fw-bold small text-dark">Foto / Gambar Jurusan</label>
                        <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
                        <small class="text-muted d-block mt-1">Format: JPG, PNG, WEBP (Maks 3MB).</small>
                    </div>

                    <div class="d-grid pt-2">
                        <button type="submit" class="btn btn-primary fw-bold py-2"><i class="bi bi-save me-1"></i> Simpan Jurusan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Tabel Daftar Jurusan -->
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
            <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-list-stars me-2 text-primary"></i>Daftar Jurusan Sekolah</h5>
                <span class="badge bg-primary rounded-pill px-3">{{ count($jurusans) }} Jurusan</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3" style="width: 50px;">No</th>
                                <th style="width: 90px;">Foto</th>
                                <th>Nama & Deskripsi Jurusan</th>
                                <th style="width: 140px;">Status Landing</th>
                                <th class="pe-3 text-end" style="width: 170px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jurusans as $index => $item)
                            @php
                                $imgUrl = $item->foto ? asset('storage/'.$item->foto) : 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?auto=format&fit=crop&w=400&q=80';
                            @endphp
                            <tr class="{{ !$item->is_active ? 'table-secondary bg-opacity-25' : '' }}">
                                <td class="ps-3 fw-bold text-secondary">{{ $index + 1 }}</td>
                                <td>
                                    <img src="{{ $imgUrl }}" alt="{{ $item->nama_jurusan }}" class="rounded-3 border object-fit-cover" style="width: 65px; height: 48px;">
                                </td>
                                <td>
                                    <div class="fw-bold text-dark fs-6">{{ $item->nama_jurusan }}</div>
                                    @if($item->deskripsi)
                                        <small class="text-muted d-block text-truncate" style="max-width: 280px;">{{ $item->deskripsi }}</small>
                                    @else
                                        <small class="text-muted fst-italic">Belum ada deskripsi singkat</small>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('jurusan.toggle-status', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm {{ $item->is_active ? 'btn-success' : 'btn-outline-secondary' }} px-2 py-1 small rounded-pill fw-bold" title="Klik untuk {{ $item->is_active ? 'Sembunyikan (Hide)' : 'Tampilkan (Show)' }}">
                                            <i class="bi {{ $item->is_active ? 'bi-eye-fill me-1' : 'bi-eye-slash-fill me-1' }}"></i>
                                            {{ $item->is_active ? 'Show (Tampil)' : 'Hide (Sembunyi)' }}
                                        </button>
                                    </form>
                                </td>
                                <td class="pe-3 text-end">
                                    <div class="d-inline-flex gap-1">
                                        <button type="button" class="btn btn-warning btn-sm text-dark fw-bold" data-bs-toggle="modal" data-bs-target="#editJurusanModal_{{ $item->id }}" title="Edit Jurusan">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </button>
                                        <form action="{{ route('jurusan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jurusan ini?')" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus Jurusan">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Modal Edit Jurusan -->
                                    <div class="modal fade text-start" id="editJurusanModal_{{ $item->id }}" tabindex="-1" aria-labelledby="editJurusanModalLabel_{{ $item->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content border-0 shadow-lg rounded-3">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-header-title fw-bold mb-0" id="editJurusanModalLabel_{{ $item->id }}">
                                                        <i class="bi bi-pencil-square me-2"></i>Edit Program Keahlian ({{ $item->nama_jurusan }})
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('jurusan.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body p-4">
                                                        <div class="row g-3">
                                                            <div class="col-md-6">
                                                                <label for="nama_jurusan_{{ $item->id }}" class="form-label fw-bold">Nama Jurusan <span class="text-danger">*</span></label>
                                                                <input type="text" name="nama_jurusan" id="nama_jurusan_{{ $item->id }}" class="form-control" value="{{ $item->nama_jurusan }}" required>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label for="is_active_{{ $item->id }}" class="form-label fw-bold">Status Tampilan</label>
                                                                <select name="is_active" id="is_active_{{ $item->id }}" class="form-select fw-semibold">
                                                                    <option value="1" {{ $item->is_active ? 'selected' : '' }}>👁️ Show (Tampil)</option>
                                                                    <option value="0" {{ !$item->is_active ? 'selected' : '' }}>🙈 Hide (Sembunyi)</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label for="icon_{{ $item->id }}" class="form-label fw-bold">Ikon Jurusan</label>
                                                                <select name="icon" id="icon_{{ $item->id }}" class="form-select">
                                                                    <option value="monitor" {{ $item->icon == 'monitor' ? 'selected' : '' }}>🖥️ Laptop / Monitor</option>
                                                                    <option value="code" {{ $item->icon == 'code' ? 'selected' : '' }}>💻 Pemrograman</option>
                                                                    <option value="camera" {{ $item->icon == 'camera' ? 'selected' : '' }}>📷 Kamera (DKV)</option>
                                                                    <option value="briefcase" {{ $item->icon == 'briefcase' ? 'selected' : '' }}>💼 Bisnis / AKL</option>
                                                                    <option value="cpu" {{ $item->icon == 'cpu' ? 'selected' : '' }}>⚡ Elektronika</option>
                                                                    <option value="tools" {{ $item->icon == 'tools' ? 'selected' : '' }}>🔧 Otomotif</option>
                                                                    <option value="book" {{ $item->icon == 'book' ? 'selected' : '' }}>📚 Pendidikan</option>
                                                                </select>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <label for="deskripsi_{{ $item->id }}" class="form-label fw-bold">Deskripsi Singkat (Landing Page Card)</label>
                                                                <textarea name="deskripsi" id="deskripsi_{{ $item->id }}" rows="2" class="form-control" placeholder="Deskripsi singkat yang langsung tampil di kartu depan landing page...">{{ $item->deskripsi }}</textarea>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <label for="detail_informasi_{{ $item->id }}" class="form-label fw-bold">Detail Informasi Lengkap & Prospek Karir (Popup Modal)</label>
                                                                <textarea name="detail_informasi" id="detail_informasi_{{ $item->id }}" rows="4" class="form-control" placeholder="Informasi lengkap mengenai kompetensi keahlian, materi pembelajaran, fasilitas laboratorium, dan prospek kerja lulusan...">{{ $item->detail_informasi }}</textarea>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <label for="foto_{{ $item->id }}" class="form-label fw-bold">Foto / Gambar Jurusan</label>
                                                                @if($item->foto)
                                                                    <div class="mb-2">
                                                                        <img src="{{ asset('storage/'.$item->foto) }}" alt="Foto Jurusan" class="rounded border" style="max-height: 120px; object-fit: cover;">
                                                                        <div class="small text-muted mt-1">Foto saat ini terpasang</div>
                                                                    </div>
                                                                @endif
                                                                <input type="file" name="foto" id="foto_{{ $item->id }}" class="form-control" accept="image/*">
                                                                <small class="text-muted">Pilih file baru jika ingin mengganti gambar (Format JPG/PNG/WEBP, Max 3MB).</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer bg-light">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary fw-bold"><i class="bi bi-save me-1"></i> Simpan Perubahan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    Belum ada data jurusan. Silakan tambahkan terlebih dahulu melalui form di sebelah kiri.
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
@endsection
