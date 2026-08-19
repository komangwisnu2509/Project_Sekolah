@extends('layouts.landing')

@section('content')
<div class="py-5" style="background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%); min-height: 100vh; padding-top: 100px !important;">
    <div class="container py-4">
        <!-- Header Banner -->
        <div class="text-center text-white mb-5" data-aos="fade-down">
            <span class="badge px-3 py-2 fs-6 mb-3" style="background: rgba(37, 99, 235, 0.2); border: 1px solid #2563EB; color: #60A5FA;">
                ✨ PENERIMAAN SISWA BARU (PPDB / SMBP {{ date('Y') }})
            </span>
            <h1 class="fw-extrabold display-4 mb-3 text-white" style="font-family: var(--font-heading);">Formulir Pendaftaran Siswa Baru Online</h1>
            <p class="lead text-white-50 mx-auto" style="max-width: 700px;">
                Bergabunglah bersama keluarga besar {{ $profil?->nama_sekolah ?? 'Sekolah Astika Dharma' }}. Isilah data calon peserta didik baru secara lengkap dan benar di bawah ini.
            </p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-9">
                <!-- Registration Form Card -->
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden" style="background: rgba(255, 255, 255, 0.98); backdrop-filter: blur(20px);" data-aos="fade-up">
                    <div class="card-header text-white p-4 border-0" style="background: linear-gradient(90deg, #1E293B 0%, #2563EB 100%);">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div>
                                <h4 class="fw-bold mb-0 text-white"><i data-lucide="user-plus" class="me-2 d-inline"></i> Formulir Data Calon Siswa</h4>
                                <small style="color: rgba(255,255,255,0.8);">Proses pendaftaran cepat, aman, dan tanpa biaya registrasi awal</small>
                            </div>
                            <span class="badge bg-white text-dark font-monospace px-3 py-2 fs-6 shadow-sm">
                                TAHUN AJARAN {{ date('Y') }}/{{ date('Y')+1 }}
                            </span>
                        </div>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        @if ($errors->any())
                            <div class="alert alert-danger mb-4 rounded-3 border-0 shadow-sm">
                                <strong class="d-block mb-1"><i data-lucide="alert-triangle" class="me-1 d-inline"></i> Mohon periksa kembali isian Anda:</strong>
                                <ul class="mb-0 ps-3 small">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('smbp.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Section 1: Data Calon Siswa -->
                            <h5 class="fw-bold mb-3 text-primary d-flex align-items-center border-bottom pb-2">
                                <i data-lucide="user" class="me-2"></i> 1. Data Pribadi Calon Siswa
                            </h5>

                            <div class="row g-3 mb-4">
                                <div class="col-md-8">
                                    <label class="form-label fw-bold small text-dark">Nama Lengkap Siswa <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_lengkap" class="form-control form-control-lg fs-6" placeholder="Sesuai ijazah SMP/MTs..." value="{{ old('nama_lengkap') }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold small text-dark">NISN (Nomor Induk Siswa Nasional)</label>
                                    <input type="text" name="nisn" class="form-control form-control-lg fs-6" placeholder="10 digit NISN..." value="{{ old('nisn') }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold small text-dark">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select name="jenis_kelamin" class="form-select form-select-lg fs-6" required>
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold small text-dark">Tempat Lahir <span class="text-danger">*</span></label>
                                    <input type="text" name="tempat_lahir" class="form-control form-control-lg fs-6" placeholder="Kota/Kabupaten..." value="{{ old('tempat_lahir') }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold small text-dark">Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_lahir" class="form-control form-control-lg fs-6" value="{{ old('tanggal_lahir') }}" required>
                                </div>
                            </div>

                            <!-- Section 2: Pilihan Jurusan & Asal Sekolah -->
                            <h5 class="fw-bold mb-3 text-primary d-flex align-items-center border-bottom pb-2 pt-3">
                                <i data-lucide="graduation-cap" class="me-2"></i> 2. Asal Sekolah & Pilihan Jurusan
                            </h5>

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-dark">Asal Sekolah SMP/MTs <span class="text-danger">*</span></label>
                                    <input type="text" name="asal_sekolah" class="form-control form-control-lg fs-6" placeholder="Nama SMP / MTs asal..." value="{{ old('asal_sekolah') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-dark">Pilihan Jurusan / Program Keahlian <span class="text-danger">*</span></label>
                                    <select name="pilihan_jurusan" class="form-select form-select-lg fs-6" required>
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
                            <h5 class="fw-bold mb-3 text-primary d-flex align-items-center border-bottom pb-2 pt-3">
                                <i data-lucide="phone-call" class="me-2"></i> 3. Kontak & Data Orang Tua/Wali
                            </h5>

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-dark">Nama Orang Tua / Wali <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_orang_tua" class="form-control form-control-lg fs-6" placeholder="Nama Ayah/Ibu/Wali..." value="{{ old('nama_orang_tua') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-dark">Nomor HP / WhatsApp Aktif <span class="text-danger">*</span></label>
                                    <input type="text" name="no_hp_wa" class="form-control form-control-lg fs-6" placeholder="Contoh: 081234567890..." value="{{ old('no_hp_wa') }}" required>
                                    <small class="text-muted">Notifikasi hasil seleksi akan dikirim via WhatsApp.</small>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold small text-dark">Alamat Lengkap Rumah <span class="text-danger">*</span></label>
                                    <textarea name="alamat" class="form-control fs-6" rows="3" placeholder="Alamat lengkap (Jalan, RT/RW, Desa/Kelurahan, Kecamatan, Kabupaten)..." required>{{ old('alamat') }}</textarea>
                                </div>
                            </div>

                            <!-- Section 4: Unggah Berkas -->
                            <h5 class="fw-bold mb-3 text-primary d-flex align-items-center border-bottom pb-2 pt-3">
                                <i data-lucide="upload-cloud" class="me-2"></i> 4. Upload Pasfoto & Berkas Dokumen (Opsional)
                            </h5>

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-dark">Pasfoto Siswa (3x4)</label>
                                    <input type="file" name="foto" class="form-control" accept="image/*">
                                    <small class="text-muted">Format: JPG, PNG, WEBP (Maksimal 4MB)</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-dark">Scan Ijazah / Surat Keterangan Lulus (SKL)</label>
                                    <input type="file" name="berkas_ijazah" class="form-control" accept=".pdf,image/*">
                                    <small class="text-muted">Format: PDF, JPG, PNG (Maksimal 5MB)</small>
                                </div>
                            </div>

                            <!-- Submit Action Button -->
                            <div class="pt-3 border-top text-end">
                                <button type="submit" class="btn btn-primary btn-lg px-5 py-3 fw-bold rounded-3 shadow-lg" style="background: #2563EB; border: none;">
                                    <i data-lucide="send" class="me-2 d-inline"></i> Kirim Pendaftaran Siswa Baru
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
