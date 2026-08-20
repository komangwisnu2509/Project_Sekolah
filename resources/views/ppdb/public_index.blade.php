@extends('layouts.landing')

@section('content')
<div style="background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%); min-height: 100vh; padding-top: 140px; padding-bottom: 80px;">
    <div class="container">
        <!-- Header Banner Section -->
        <div class="text-center text-white mb-5" data-aos="fade-down">
            <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill mb-3" style="background: rgba(37, 99, 235, 0.25); border: 1px solid #3B82F6;">
                <i class="bi bi-stars text-warning fs-5"></i>
                <span class="fw-bold text-white fs-6">PENERIMAAN PESERTA DIDIK BARU (PPDB ONLINE {{ date('Y') }})</span>
            </div>
            <h1 class="fw-extrabold display-4 mb-3 text-white" style="font-family: var(--font-heading); text-shadow: 0 4px 12px rgba(0,0,0,0.3);">
                Formulir Pendaftaran Siswa Baru Online
            </h1>
            <p class="lead text-white-50 mx-auto" style="max-width: 720px; font-size: 1.15rem;">
                Bergabunglah bersama keluarga besar <strong class="text-white">{{ $profil?->nama_sekolah ?? 'Sekolah Astika Dharma' }}</strong>. Isilah data calon peserta didik baru secara lengkap dan benar di bawah ini.
            </p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-9">
                <!-- Card Cek Status Pendaftaran Mandiri -->
                <div class="card border-0 shadow-lg rounded-4 mb-4 overflow-hidden" style="background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);">
                    <div class="card-body p-4 text-white">
                        <div class="row align-items-center g-3">
                            <div class="col-md-7">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle bg-warning bg-opacity-20 text-warning d-flex align-items-center justify-content-center flex-shrink-0" style="width: 50px; height: 50px;">
                                        <i class="bi bi-search fs-4"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold text-white mb-1">Sudah Mendaftar? Cek Status Pendaftaran Anda</h5>
                                        <p class="text-white-50 small mb-0">Masukkan Nomor Reg (PPDB-...), Email, atau NISN Anda untuk mengecek status verifikasi secara privat.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <form action="{{ route('ppdb.cek-status') }}" method="POST">
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" name="search_key" class="form-control form-control-lg fs-6 rounded-start-3 border-0" placeholder="No Reg / Email / NISN..." required value="{{ old('search_key') }}">
                                        <button type="submit" class="btn btn-warning fw-bold px-4 rounded-end-3">
                                            <i class="bi bi-arrow-right-circle me-1"></i> Cek Status
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                @if(session('error'))
                    <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4 p-3 d-flex align-items-center gap-3">
                        <i class="bi bi-exclamation-triangle-fill fs-4 text-danger"></i>
                        <div class="fw-semibold text-danger">{{ session('error') }}</div>
                    </div>
                @endif

                <!-- Registration Form Card -->
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden" style="background: #FFFFFF;" data-aos="fade-up">
                    <div class="card-header text-white p-4 border-0" style="background: linear-gradient(90deg, #0F172A 0%, #2563EB 100%);">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div>
                                <h4 class="fw-bold mb-1 text-white"><i class="bi bi-person-plus-fill me-2 text-warning"></i>Formulir Data Calon Siswa PPDB</h4>
                                <small class="text-white-50">Proses pendaftaran cepat, transparan, dan tanpa biaya registrasi awal</small>
                            </div>
                            <span class="badge bg-warning text-dark font-monospace px-3 py-2 fs-6 fw-bold shadow-sm">
                                TAHUN AJARAN {{ date('Y') }}/{{ date('Y')+1 }}
                            </span>
                        </div>
                    </div>

                    <div class="card-body p-4 p-md-5 bg-white">
                        @if ($errors->any())
                            <div class="alert alert-danger mb-4 rounded-3 border-0 shadow-sm">
                                <strong class="d-block mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i> Mohon periksa kembali isian Anda:</strong>
                                <ul class="mb-0 ps-3 small">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('ppdb.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Section 1: Data Calon Siswa -->
                            <div class="bg-light p-3 rounded-3 mb-4 border border-start border-4 border-primary">
                                <h5 class="fw-bold mb-0 text-primary d-flex align-items-center">
                                    <i class="bi bi-person-badge me-2 fs-4"></i> 1. Data Pribadi Calon Siswa
                                </h5>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-8">
                                    <label class="form-label fw-bold small text-dark">Nama Lengkap Siswa <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_lengkap" class="form-control form-control-lg fs-6 rounded-3 border-secondary-subtle" placeholder="Sesuai ijazah SMP/MTs..." value="{{ old('nama_lengkap') }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold small text-dark">NISN (Nomor Induk Siswa Nasional)</label>
                                    <input type="text" name="nisn" class="form-control form-control-lg fs-6 rounded-3 border-secondary-subtle" placeholder="10 digit NISN..." value="{{ old('nisn') }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold small text-dark">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select name="jenis_kelamin" class="form-select form-select-lg fs-6 rounded-3 border-secondary-subtle" required>
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold small text-dark">Tempat Lahir <span class="text-danger">*</span></label>
                                    <input type="text" name="tempat_lahir" class="form-control form-control-lg fs-6 rounded-3 border-secondary-subtle" placeholder="Kota/Kabupaten..." value="{{ old('tempat_lahir') }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold small text-dark">Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_lahir" class="form-control form-control-lg fs-6 rounded-3 border-secondary-subtle" value="{{ old('tanggal_lahir') }}" required>
                                </div>
                            </div>

                            <!-- Section 2: Pilihan Jurusan & Asal Sekolah -->
                            <div class="bg-light p-3 rounded-3 mb-4 border border-start border-4 border-primary mt-4">
                                <h5 class="fw-bold mb-0 text-primary d-flex align-items-center">
                                    <i class="bi bi-mortarboard-fill me-2 fs-4"></i> 2. Asal Sekolah & Pilihan Jurusan
                                </h5>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-dark">Asal Sekolah SMP/MTs <span class="text-danger">*</span></label>
                                    <input type="text" name="asal_sekolah" class="form-control form-control-lg fs-6 rounded-3 border-secondary-subtle" placeholder="Nama SMP / MTs asal..." value="{{ old('asal_sekolah') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-dark">Pilihan Jurusan / Program Keahlian <span class="text-danger">*</span></label>
                                    <select name="pilihan_jurusan" class="form-select form-select-lg fs-6 rounded-3 border-secondary-subtle" required>
                                        <option value="">-- Pilih Jurusan Yang Diminati --</option>
                                        @foreach($jurusans as $j)
                                            <option value="{{ $j->nama_jurusan }}" {{ old('pilihan_jurusan') == $j->nama_jurusan ? 'selected' : '' }}>
                                                {{ $j->nama_jurusan }} ({{ $j->kode_jurusan ?? '-' }})
                                            </option>
                                        @endforeach
                                        @if(count($jurusans) == 0)
                                            <option value="Desain Komunikasi Visual (DKV)">Desain Komunikasi Visual (DKV)</option>
                                            <option value="Rekayasa Perangkat Lunak (RPL)">Rekayasa Perangkat Lunak (RPL)</option>
                                            <option value="Teknik Komputer & Jaringan (TKJ)">Teknik Komputer & Jaringan (TKJ)</option>
                                            <option value="Akuntansi & Keuangan (AKL)">Akuntansi & Keuangan (AKL)</option>
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <!-- Section 3: Data Kontak & Orang Tua -->
                            <div class="bg-light p-3 rounded-3 mb-4 border border-start border-4 border-primary mt-4">
                                <h5 class="fw-bold mb-0 text-primary d-flex align-items-center">
                                    <i class="bi bi-telephone-fill me-2 fs-4"></i> 3. Kontak & Data Orang Tua/Wali
                                </h5>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-dark">Alamat Email Aktif (Siswa/Orang Tua) <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control form-control-lg fs-6 rounded-3 border-secondary-subtle" placeholder="Contoh: siswa@gmail.com..." value="{{ old('email') }}" required>
                                    <small class="text-muted"><i class="bi bi-info-circle me-1 text-primary"></i>Email ini penting untuk registrasi & aktivasi akun siswa baru.</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-dark">Nomor HP / WhatsApp Aktif <span class="text-danger">*</span></label>
                                    <input type="text" name="no_hp_wa" class="form-control form-control-lg fs-6 rounded-3 border-secondary-subtle" placeholder="Contoh: 081234567890..." value="{{ old('no_hp_wa') }}" required>
                                    <small class="text-muted">Notifikasi hasil seleksi akan dikirim via WhatsApp.</small>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small text-dark">Nama Orang Tua / Wali <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_orang_tua" class="form-control form-control-lg fs-6 rounded-3 border-secondary-subtle" placeholder="Nama Ayah/Ibu/Wali..." value="{{ old('nama_orang_tua') }}" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold small text-dark">Alamat Lengkap Rumah <span class="text-danger">*</span></label>
                                    <textarea name="alamat" class="form-control fs-6 rounded-3 border-secondary-subtle" rows="3" placeholder="Alamat lengkap (Jalan, RT/RW, Desa/Kelurahan, Kecamatan, Kabupaten)..." required>{{ old('alamat') }}</textarea>
                                </div>
                            </div>

                            <!-- Section 4: Unggah Berkas -->
                            <div class="bg-light p-3 rounded-3 mb-4 border border-start border-4 border-primary mt-4">
                                <h5 class="fw-bold mb-0 text-primary d-flex align-items-center">
                                    <i class="bi bi-cloud-upload-fill me-2 fs-4"></i> 4. Upload Pasfoto & Berkas Dokumen (Opsional)
                                </h5>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-dark">Pasfoto Siswa (3x4)</label>
                                    <input type="file" name="foto" class="form-control form-control-lg fs-6 rounded-3 border-secondary-subtle" accept="image/*">
                                    <small class="text-muted">Format: JPG, PNG, WEBP (Maksimal 4MB)</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-dark">Scan Ijazah / Surat Keterangan Lulus (SKL)</label>
                                    <input type="file" name="berkas_ijazah" class="form-control form-control-lg fs-6 rounded-3 border-secondary-subtle" accept=".pdf,image/*">
                                    <small class="text-muted">Format: PDF, JPG, PNG (Maksimal 5MB)</small>
                                </div>
                            </div>

                            <!-- Submit Action Button -->
                            <div class="pt-4 border-top text-end mt-4">
                                <button type="submit" class="btn btn-primary btn-lg px-5 py-3 fw-bold rounded-3 shadow-lg" style="background: linear-gradient(90deg, #2563EB 0%, #1D4ED8 100%); border: none; font-size: 1.1rem;">
                                    <i class="bi bi-send-fill me-2"></i> Kirim Pendaftaran PPDB Online
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
