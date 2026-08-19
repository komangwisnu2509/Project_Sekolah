@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">

    @if(Auth::user()->isSiswa() && Auth::user()->siswa && Auth::user()->siswa->status === 'Lulus')
        <!-- ========================================== -->
        <!-- DEDICATED ALUMNI GRADUATION DASHBOARD      -->
        <!-- ========================================== -->

        <!-- Confetti Animation Library -->
        <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Fire celebratory confetti on page load
                var count = 200;
                var defaults = {
                    origin: { y: 0.7 }
                };

                function fire(particleRatio, opts) {
                    confetti(Object.assign({}, defaults, opts, {
                        particleCount: Math.floor(count * particleRatio)
                    }));
                }

                fire(0.25, {
                    spread: 26,
                    startVelocity: 55,
                });
                fire(0.2, {
                    spread: 60,
                });
                fire(0.35, {
                    spread: 100,
                    decay: 0.91,
                    scalar: 0.8
                });
                fire(0.1, {
                    spread: 120,
                    startVelocity: 25,
                    decay: 0.92,
                    scalar: 1.2
                });
                fire(0.1, {
                    spread: 120,
                    startVelocity: 45,
                });
            });
        </script>

        <!-- Graduation Hero Banner -->
        <div class="card border-0 shadow-lg mb-4 rounded-4 overflow-hidden text-white position-relative" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #f12711 100%);">
            <div class="card-body p-4 p-lg-5 position-relative z-1">
                <div class="row align-items-center g-4">
                    <div class="col-lg-8">
                        <span class="badge bg-warning text-dark fw-bold px-3 py-2 fs-6 rounded-pill mb-3 text-uppercase shadow-sm">
                            🎓 SELAMAT & SUKSES ALUMNI TAHUN {{ $siswa->tahun_lulus ?? date('Y') }}
                        </span>
                        <h1 class="fw-extrabold text-white display-5 mb-2">
                            Selamat atas Kelulusan Anda, {{ $siswa->nama }}! 🎉
                        </h1>
                        <p class="fs-5 text-white-50 mb-4" style="line-height: 1.6;">
                            Selamat telah menyelesaikan masa studi di <strong>{{ $profilSekolah->nama_sekolah ?? 'Sekolah' }}</strong> dengan hasil yang membanggakan! 
                            Tetap semangat, pantang menyerah, dan capai cita-cita setinggi langit untuk masa depan Anda yang cerah! 🚀✨
                        </p>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge bg-white text-dark fw-bold px-3 py-2 shadow-sm">
                                <i class="bi bi-mortarboard-fill me-1 text-warning"></i> Status: LULUS RESMI
                            </span>
                            <span class="badge bg-white text-dark fw-bold px-3 py-2 shadow-sm">
                                <i class="bi bi-building me-1 text-primary"></i> Kelas Terakhir: {{ $siswa->kelas }}
                            </span>
                            <span class="badge bg-white text-dark fw-bold px-3 py-2 shadow-sm">
                                <i class="bi bi-journal-bookmark me-1 text-success"></i> Jurusan: {{ $siswa->jurusan }}
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-4 text-center">
                        <div class="position-relative d-inline-block">
                            @if($siswa->foto)
                                <img src="{{ asset('storage/'.$siswa->foto) }}" alt="{{ $siswa->nama }}" class="rounded-circle img-thumbnail shadow-lg object-fit-cover" style="width: 160px; height: 160px; border: 4px solid gold;">
                            @else
                                <div class="bg-warning text-dark rounded-circle d-inline-flex align-items-center justify-content-center fw-bold shadow-lg" style="width: 160px; height: 160px; font-size: 4rem; border: 4px solid gold;">
                                    🎓
                                </div>
                            @endif
                            <span class="position-absolute bottom-0 end-0 badge bg-danger text-white rounded-circle p-3 shadow">
                                <i class="bi bi-trophy-fill fs-5"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4 rounded-3 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4 rounded-3 shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Alumni Summary Cards (Total Nilai, Total Pelanggaran, Total Media Kenangan) -->
        <div class="row row-cols-1 row-cols-md-3 g-4 mb-4">
            <!-- Card 1: Total Nilai Kelulusan -->
            <div class="col">
                <div class="card border-0 shadow-sm h-100 rounded-3 border-start border-5 border-warning bg-white p-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <small class="text-muted fw-bold text-uppercase">Total Nilai Kelulusan</small>
                        <div class="bg-warning bg-opacity-10 text-warning p-2.5 rounded-circle">
                            <i class="bi bi-star-fill fs-4"></i>
                        </div>
                    </div>
                    <h2 class="fw-bold text-dark mb-1">{{ number_format($siswa->total_nilai ?? 85.00, 2) }}</h2>
                    <small class="text-success fw-bold"><i class="bi bi-check-all me-1"></i>Predikat Kelulusan Baik</small>
                </div>
            </div>

            <!-- Card 2: Total Poin Pelanggaran -->
            <div class="col">
                <div class="card border-0 shadow-sm h-100 rounded-3 border-start border-5 border-danger bg-white p-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <small class="text-muted fw-bold text-uppercase">Total Poin Pelanggaran</small>
                        <div class="bg-danger bg-opacity-10 text-danger p-2.5 rounded-circle">
                            <i class="bi bi-shield-exclamation fs-4"></i>
                        </div>
                    </div>
                    <h2 class="fw-bold {{ $totalPoints > 0 ? 'text-danger' : 'text-success' }} mb-1">
                        {{ $totalPoints }} <span class="fs-6 text-muted">Poin</span>
                    </h2>
                    @if($totalPoints == 0)
                        <small class="text-success fw-bold"><i class="bi bi-shield-check me-1"></i>Sempurna: 0 Pelanggaran</small>
                    @else
                        <small class="text-muted"><i class="bi bi-exclamation-circle me-1"></i>Tercatat {{ count($pelanggarans) }} Pelanggaran</small>
                    @endif
                </div>
            </div>

            <!-- Card 3: Total Media Kenangan -->
            <div class="col">
                <div class="card border-0 shadow-sm h-100 rounded-3 border-start border-5 border-primary bg-white p-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <small class="text-muted fw-bold text-uppercase">Album Media Kenangan</small>
                        <div class="bg-primary bg-opacity-10 text-primary p-2.5 rounded-circle">
                            <i class="bi bi-images fs-4"></i>
                        </div>
                    </div>
                    <h2 class="fw-bold text-primary mb-1">{{ count($siswaMedia) }} <span class="fs-6 text-muted">Berkas</span></h2>
                    <small class="text-secondary"><i class="bi bi-cloud-upload me-1"></i>Foto & Video Album Kelulusan</small>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <!-- Section 1: Detailed Discipline Record (Pelanggaran Selama Sekolah) -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100 rounded-3">
                    <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark">
                            <i class="bi bi-journal-x text-danger me-2"></i>Catatan Pelanggaran Selama Sekolah
                        </h5>
                        <span class="badge bg-danger px-3 py-1">{{ count($pelanggarans) }} Pelanggaran</span>
                    </div>
                    <div class="card-body p-0">
                        @if(count($pelanggarans) > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-4">Tanggal</th>
                                            <th>Jenis Pelanggaran</th>
                                            <th>Poin</th>
                                            <th class="pe-4">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pelanggarans as $p)
                                            <tr>
                                                <td class="ps-4 text-nowrap small fw-bold text-secondary">
                                                    {{ \Carbon\Carbon::parse($p->tanggal)->translatedFormat('d M Y') }}
                                                </td>
                                                <td class="fw-bold text-dark">{{ $p->nama_pelanggaran }}</td>
                                                <td><span class="badge bg-danger font-monospace">+{{ $p->point }}</span></td>
                                                <td class="pe-4 small text-muted">{{ $p->keterangan ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="p-5 text-center text-muted">
                                <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex p-4 mb-3">
                                    <i class="bi bi-shield-check fs-1"></i>
                                </div>
                                <h5 class="fw-bold text-dark mb-1">Catatan Disiplin 100% Bersih!</h5>
                                <p class="small text-secondary mb-0">
                                    Selamat! Anda tidak memiliki rekam jejak pelanggaran selama bersekolah di {{ $profilSekolah->nama_sekolah ?? 'Sekolah' }}.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Section 2: Upload Multiple Photos & Videos (>10 Files) -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100 rounded-3">
                    <div class="card-header bg-dark text-white py-3 border-0 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-camera-reels-fill text-warning me-2"></i>Unggah Foto & Video Kenangan
                        </h5>
                        <span class="badge bg-warning text-dark font-monospace">Multi-Upload (&gt;10 Berkas)</span>
                    </div>
                    <div class="card-body p-4 bg-light bg-opacity-50">
                        <form action="{{ route('siswa.upload-media-kenangan') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="files" class="form-label fw-bold">Pilih Foto & Video (Bisa Upload Banyak Sekaligus)</label>
                                <input type="file" name="files[]" id="files" class="form-control form-control-lg border-2" accept="image/*,video/*" multiple required>
                                <small class="text-muted d-block mt-1">
                                    <i class="bi bi-info-circle me-1"></i>Format foto (JPG, PNG, WebP) atau video (MP4, MOV, WebM). Anda bisa memilih lebih dari 10 berkas sekaligus!
                                </small>
                            </div>
                            <div class="mb-3">
                                <label for="caption" class="form-label fw-bold">Catatan / Caption Album (Opsional)</label>
                                <input type="text" name="caption" id="caption" class="form-control" placeholder="Contoh: Kenangan Momen Kelulusan Bersama Teman & Guru">
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary fw-bold py-2.5">
                                    <i class="bi bi-cloud-arrow-up-fill me-1 fs-5"></i> Unggah Album Foto & Video Kenangan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 3: Media Gallery (Grid Display for Photos & Videos) -->
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="bi bi-collection-play-fill text-primary me-2"></i>Galeri Media Kenangan Kelulusan Saya
                </h5>
                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary px-3 py-2 fs-6">
                    Total {{ count($siswaMedia) }} Berkas Tersimpan
                </span>
            </div>
            <div class="card-body p-4">
                @if(count($siswaMedia) > 0)
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">
                        @foreach($siswaMedia as $media)
                            <div class="col">
                                <div class="card border shadow-sm h-100 rounded-3 overflow-hidden position-relative group-hover">
                                    @if($media->file_type === 'video')
                                        <!-- Video Player -->
                                        <div class="ratio ratio-16x9 bg-black">
                                            <video controls preload="metadata" style="max-height: 200px; width: 100%;">
                                                <source src="{{ asset('storage/'.$media->file_path) }}">
                                                Browser Anda tidak mendukung pemutar video.
                                            </video>
                                        </div>
                                    @else
                                        <!-- Photo Thumbnail -->
                                        <a href="{{ asset('storage/'.$media->file_path) }}" target="_blank">
                                            <img src="{{ asset('storage/'.$media->file_path) }}" alt="Kenangan" class="card-img-top object-fit-cover" style="height: 180px;">
                                        </a>
                                    @endif

                                    <div class="card-body p-2 bg-light d-flex justify-content-between align-items-center">
                                        <div class="text-truncate me-2">
                                            @if($media->file_type === 'video')
                                                <span class="badge bg-danger me-1"><i class="bi bi-camera-video-fill me-1"></i>Video</span>
                                            @else
                                                <span class="badge bg-info text-dark me-1"><i class="bi bi-image me-1"></i>Foto</span>
                                            @endif
                                            <small class="text-dark fw-semibold text-truncate d-inline-block style='max-width: 120px;'">
                                                {{ $media->caption ?? 'Kenangan' }}
                                            </small>
                                        </div>
                                        <form action="{{ route('siswa.delete-media-kenangan', $media->id) }}" method="POST" onsubmit="return confirm('Hapus berkas kenangan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm p-1 px-2" title="Hapus Berkas">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-5 text-center text-muted border border-dashed rounded-3">
                        <i class="bi bi-images fs-1 d-block mb-2 text-secondary"></i>
                        Belum ada foto atau video kenangan yang diunggah. Silakan gunakan form unggah di atas untuk menambahkan kenangan Anda!
                    </div>
                @endif
            </div>
        </div>

    @else
        <!-- ========================================== -->
        <!-- REGULAR DASHBOARD FOR ADMIN, GURU & ACTIVE STUDENTS -->
        <!-- ========================================== -->

        <!-- Welcome Hero Banner -->
        <div class="card border-0 shadow-sm bg-primary bg-gradient text-white mb-4 rounded-3">
            <div class="card-body p-4 p-lg-5 d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <span class="badge bg-white text-primary fw-bold px-3 py-2 mb-2 text-uppercase tracking-wider">
                        <i class="bi bi-shield-check me-1"></i> 
                        @if(Auth::user()->isAdmin())
                            Panel Administrator
                        @elseif(Auth::user()->isGuru())
                            Portal Guru ({{ Auth::user()->guru->mata_pelajaran ?? 'Pengajar' }})
                        @else
                            Portal Siswa
                        @endif
                    </span>
                    <h2 class="fw-bold text-white mb-1">Selamat Datang, {{ Auth::user()->name }}! 👋</h2>
                    <p class="mb-0 text-white-50 fs-6">
                        Sistem Informasi Kelola Data Kelas, Guru, Tugas Piket, Jadwal Pelajaran, dan Tugas Sekolah.
                    </p>
                </div>
                <div class="text-lg-end bg-white bg-opacity-10 p-3 rounded-3 border border-white border-opacity-25">
                    <small class="text-white-50 d-block mb-1"><i class="bi bi-clock me-1"></i> Hari Ini</small>
                    <h5 class="fw-bold text-white mb-0">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</h5>
                </div>
            </div>
        </div>

        @php
            $dashboardNotifs = \App\Helpers\NotificationHelper::getNotifications();
        @endphp

        @if($dashboardNotifs->count() > 0)
            <div class="card border-0 shadow-sm mb-4 rounded-4 overflow-hidden border-start border-5 border-warning bg-white">
                <div class="card-header bg-dark text-white py-3 border-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h6 class="mb-0 fw-bold">
                        <i class="bi bi-bell-fill text-warning me-2 fs-5"></i>Notifikasi & Perhatian Penting Terbaru ({{ $dashboardNotifs->count() }})
                    </h6>
                    <span class="badge bg-warning text-dark font-monospace">Terbaru & Perlu Tindakan</span>
                </div>
                <div class="card-body p-3">
                    <div class="row g-3">
                        @foreach($dashboardNotifs as $dNotif)
                            <div class="col-md-6">
                                <a href="{{ $dNotif->url }}" class="card border border-opacity-25 shadow-sm p-3 rounded-3 text-decoration-none h-100 bg-light hover-bg-white transition-all">
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="p-2.5 rounded-circle bg-white border shadow-sm flex-shrink-0">
                                            <i class="{{ $dNotif->icon }} fs-4"></i>
                                        </div>
                                        <div class="w-100">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span class="badge {{ $dNotif->badge_class }} small">{{ $dNotif->badge }}</span>
                                                <small class="text-muted" style="font-size: 0.75rem;">{{ $dNotif->created_at }}</small>
                                            </div>
                                            <h6 class="fw-bold text-dark mb-1 small">{{ $dNotif->title }}</h6>
                                            <p class="small text-secondary mb-0" style="line-height: 1.35;">{{ $dNotif->message }}</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        @if(Auth::user()->isGuru() && $myPiketDashboard->count() > 0)
            <!-- Teacher Duty Schedule Notice -->
            <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center p-3 mb-4 rounded-3">
                <div class="bg-warning text-white rounded-circle p-2 me-3 fs-4">
                    <i class="bi bi-calendar-check-fill"></i>
                </div>
                <div>
                    <h6 class="fw-bold text-dark mb-1">Perhatian Jadwal Piket Guru Hari Ini / Minggu Ini</h6>
                    <p class="mb-0 small text-secondary">
                        Anda memiliki {{ $myPiketDashboard->count() }} tugas piket terdaftar. 
                        Hari piket: <strong>{{ $myPiketDashboard->pluck('hari')->implode(', ') }}</strong>. 
                        <a href="{{ route('piket.index') }}" class="fw-bold text-dark text-decoration-underline ms-1">Lihat Detail Jadwal Piket &rarr;</a>
                    </p>
                </div>
            </div>
        @endif

        @if(Auth::user()->isGuru() && isset($mySubstituteDuties) && $mySubstituteDuties->count() > 0)
            <!-- Substitute Teacher Duty Card (Mandat Guru Pengganti) -->
            <div class="card border-0 shadow-lg mb-4 bg-gradient bg-primary bg-opacity-10 border-start border-5 border-primary rounded-3">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="bi bi-person-badge-fill text-primary me-2 fs-4"></i>Tugas Guru Pengganti Hari Ini (Mandat Admin)
                        </h5>
                        <span class="badge bg-primary px-3 py-2 fs-6">
                            {{ $mySubstituteDuties->count() }} Penugasan Menggantikan
                        </span>
                    </div>

                    <div class="row g-3">
                        @foreach($mySubstituteDuties as $duty)
                            <div class="col-lg-6">
                                <div class="bg-white p-3 rounded-3 border shadow-sm h-100">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge bg-danger text-white fw-bold px-2.5 py-1">
                                            Menggantikan: {{ $duty->guru->nama ?? 'Guru' }} ({{ $duty->jenis }})
                                        </span>
                                        <span class="badge bg-secondary font-monospace">
                                            {{ date('d/m/Y', strtotime($duty->tanggal_mulai)) }} - {{ date('d/m/Y', strtotime($duty->tanggal_selesai)) }}
                                        </span>
                                    </div>
                                    <h5 class="fw-bold text-primary mb-1">
                                        <i class="bi bi-building me-1"></i>Kelas Target: {{ $duty->tugas->kelas ?? 'Seluruh Kelas' }}
                                    </h5>
                                    <p class="small text-muted mb-2">
                                        <strong>Mata Pelajaran:</strong> {{ $duty->guru->mata_pelajaran ?? '-' }} | 
                                        <strong>Alasan Izin Guru:</strong> "{{ $duty->alasan }}"
                                    </p>
                                    @if($duty->tugas)
                                        <div class="p-2 bg-light rounded border mb-2 small">
                                            <strong class="text-dark d-block"><i class="bi bi-journal-check text-primary me-1"></i>Tugas Siswa Terhubung:</strong>
                                            <span class="fw-bold text-dark">{{ $duty->tugas->judul }}</span>
                                            <span class="text-secondary d-block mt-1">Deadline: {{ date('d/m/Y H:i', strtotime($duty->tugas->deadline)) }}</span>
                                        </div>
                                    @elseif($duty->tugas_siswa)
                                        <div class="p-2 bg-light rounded border mb-2 small text-dark fst-italic">
                                            <strong>Instruksi/Tugas Guru:</strong> "{{ $duty->tugas_siswa }}"
                                        </div>
                                    @endif
                                    @if($duty->catatan_admin)
                                        <div class="small text-warning text-dark fw-semibold">
                                            <i class="bi bi-info-circle me-1"></i>Catatan Admin: {{ $duty->catatan_admin }}
                                        </div>
                                    @endif
                                    <div class="mt-3 text-end">
                                        <a href="{{ route('absensi.index', ['kelas' => $duty->tugas->kelas ?? '']) }}" class="btn btn-outline-primary btn-sm fw-bold">
                                            <i class="bi bi-clipboard-check me-1"></i> Absenkan Siswa Kelas Ini
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Main Statistics Cards -->
        @if(Auth::user()->isGuru())
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-3 mb-4">
                <!-- Jadwal Mengajar -->
                <div class="col">
                    <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-3">
                                    <i class="bi bi-calendar3 fs-3"></i>
                                </div>
                                <a href="{{ route('jadwal.index') }}" class="btn btn-sm btn-light text-warning rounded-circle p-2" title="Lihat Jadwal Mengajar">
                                    <i class="bi bi-arrow-right-short fs-5"></i>
                                </a>
                            </div>
                            <small class="text-muted fw-bold text-uppercase tracking-wider d-block mb-1">Jadwal Mengajar</small>
                            <h2 class="fw-bold text-dark mb-0">{{ $totalJadwal }}</h2>
                            <small class="text-secondary">Jam Pelajaran Terdaftar</small>
                        </div>
                        <div class="position-absolute bottom-0 start-0 w-100 bg-warning" style="height: 4px;"></div>
                    </div>
                </div>

                <!-- Tambah & Kelola Tugas -->
                <div class="col">
                    <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3">
                                    <i class="bi bi-file-earmark-plus-fill fs-3"></i>
                                </div>
                                <a href="{{ route('tugas.index') }}" class="btn btn-sm btn-light text-primary rounded-circle p-2" title="Buat & Kelola Tugas">
                                    <i class="bi bi-arrow-right-short fs-5"></i>
                                </a>
                            </div>
                            <small class="text-muted fw-bold text-uppercase tracking-wider d-block mb-1">Tugas Mapel Saya</small>
                            <h2 class="fw-bold text-dark mb-0">{{ $myTugasCount }}</h2>
                            <small class="text-secondary">Tugas Berhasil Dibuat</small>
                        </div>
                        <div class="position-absolute bottom-0 start-0 w-100 bg-primary" style="height: 4px;"></div>
                    </div>
                </div>

                <!-- Tugas Piket Saya -->
                <div class="col">
                    <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="bg-danger bg-opacity-10 text-danger p-3 rounded-3">
                                    <i class="bi bi-calendar-check-fill fs-3"></i>
                                </div>
                                <a href="{{ route('piket.index') }}" class="btn btn-sm btn-light text-danger rounded-circle p-2" title="Lihat Tugas Piket Saya">
                                    <i class="bi bi-arrow-right-short fs-5"></i>
                                </a>
                            </div>
                            <small class="text-muted fw-bold text-uppercase tracking-wider d-block mb-1">Jadwal Piket Saya</small>
                            <h2 class="fw-bold text-dark mb-0">{{ $myPiketCount }}</h2>
                            <small class="text-secondary">Tugas Piket Terdaftar</small>
                        </div>
                        <div class="position-absolute bottom-0 start-0 w-100 bg-danger" style="height: 4px;"></div>
                    </div>
                </div>
            </div>

        @elseif(Auth::user()->isSiswa())
            @if(isset($activeIzinGurusSiswa) && count($activeIzinGurusSiswa) > 0)
                <div class="card border-0 shadow-sm bg-warning bg-opacity-10 border-start border-5 border-warning mb-4 rounded-3">
                    <div class="card-body p-4">
                        <h5 class="fw-bold text-dark mb-3">
                            <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>Pemberitahuan Guru Tidak Hadir Hari Ini (Izin / Sakit)
                        </h5>
                        <div class="row g-3">
                            @foreach($activeIzinGurusSiswa as $iz)
                                <div class="col-md-6">
                                    <div class="p-3 bg-white border border-warning rounded-3 shadow-sm">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <span class="badge bg-warning text-dark fw-bold"><i class="bi bi-person-x me-1"></i>Guru {{ $iz->jenis }}</span>
                                            <small class="text-muted fw-semibold"><i class="bi bi-calendar-event me-1"></i>{{ \App\Helpers\WaktuHelper::formatShort($iz->tanggal_mulai) }} - {{ \App\Helpers\WaktuHelper::formatShort($iz->tanggal_selesai) }}</small>
                                        </div>
                                        <h6 class="fw-bold text-dark mb-1"><i class="bi bi-person-fill text-primary me-1"></i>{{ $iz->guru?->nama }}</h6>
                                        <p class="small text-muted mb-2">Mata Pelajaran: <strong>{{ $iz->guru?->mata_pelajaran ?? '-' }}</strong></p>
                                        
                                        @if($iz->guruPengganti)
                                            <div class="alert alert-success py-2 px-3 mb-2 small fw-bold">
                                                <i class="bi bi-person-check-fill me-1"></i>Guru Pengganti: {{ $iz->guruPengganti->nama }}
                                            </div>
                                        @else
                                            <div class="alert alert-secondary py-2 px-3 mb-2 small">
                                                <i class="bi bi-info-circle me-1"></i>Guru pengganti belum ditunjuk.
                                            </div>
                                        @endif

                                        @if($iz->tugas)
                                            <div class="mt-2">
                                                <small class="text-muted d-block mb-1">Tugas yang Wajib Dikerjakan:</small>
                                                <a href="{{ route('siswa.tugas') }}" class="btn btn-sm btn-primary w-100 fw-bold">
                                                    <i class="bi bi-file-earmark-check me-1"></i>Kerjakan: {{ $iz->tugas->judul }}
                                                </a>
                                            </div>
                                        @elseif($iz->tugas_siswa)
                                            <div class="mt-2 p-2 bg-light rounded small">
                                                <strong><i class="bi bi-journal-text me-1 text-primary"></i>Instruksi Tugas:</strong>
                                                <p class="mb-0 text-dark">{{ $iz->tugas_siswa }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-3 mb-4">
                <!-- Kelas Saya -->
                <div class="col">
                    <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3">
                                    <i class="bi bi-building fs-3"></i>
                                </div>
                            </div>
                            <small class="text-muted fw-bold text-uppercase tracking-wider d-block mb-1">Kelas Saya</small>
                            <h3 class="fw-bold text-dark mb-0">{{ Auth::user()->siswa->kelas ?? '-' }}</h3>
                            <small class="text-secondary">Jurusan: {{ Auth::user()->siswa->jurusan ?? '-' }}</small>
                        </div>
                        <div class="position-absolute bottom-0 start-0 w-100 bg-primary" style="height: 4px;"></div>
                    </div>
                </div>

                <!-- Jadwal Pelajaran -->
                <div class="col">
                    <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-3">
                                    <i class="bi bi-calendar3 fs-3"></i>
                                </div>
                                <a href="{{ route('jadwal.index') }}" class="btn btn-sm btn-light text-warning rounded-circle p-2" title="Lihat Jadwal Saya">
                                    <i class="bi bi-arrow-right-short fs-5"></i>
                                </a>
                            </div>
                            <small class="text-muted fw-bold text-uppercase tracking-wider d-block mb-1">Jadwal Kelas</small>
                            <h2 class="fw-bold text-dark mb-0">{{ $totalJadwal }}</h2>
                            <small class="text-secondary">Jam Pelajaran Terdaftar</small>
                        </div>
                        <div class="position-absolute bottom-0 start-0 w-100 bg-warning" style="height: 4px;"></div>
                    </div>
                </div>

                <!-- Tugas Sekolah -->
                <div class="col">
                    <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="bg-success bg-opacity-10 text-success p-3 rounded-3">
                                    <i class="bi bi-file-earmark-check fs-3"></i>
                                </div>
                                <a href="{{ route('tugas.index') }}" class="btn btn-sm btn-light text-success rounded-circle p-2" title="Lihat Tugas">
                                    <i class="bi bi-arrow-right-short fs-5"></i>
                                </a>
                            </div>
                            <small class="text-muted fw-bold text-uppercase tracking-wider d-block mb-1">Tugas Sekolah</small>
                            <h2 class="fw-bold text-dark mb-0">{{ count($recentTugas) }}</h2>
                            <small class="text-secondary">Tugas Aktif Kelas</small>
                        </div>
                        <div class="position-absolute bottom-0 start-0 w-100 bg-success" style="height: 4px;"></div>
                    </div>
                </div>
            </div>

        @else
            <!-- Admin View Stats -->
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3 mb-4">
                <div class="col">
                    <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3">
                                    <i class="bi bi-building fs-3"></i>
                                </div>
                                <a href="{{ route('kelas.index') }}" class="btn btn-sm btn-light text-primary rounded-circle p-2" title="Kelola Kelas">
                                    <i class="bi bi-arrow-right-short fs-5"></i>
                                </a>
                            </div>
                            <small class="text-muted fw-bold text-uppercase tracking-wider d-block mb-1">Total Kelas</small>
                            <h2 class="fw-bold text-dark mb-0">{{ $totalKelas }}</h2>
                            <small class="text-secondary">Terdaftar dalam Sistem</small>
                        </div>
                        <div class="position-absolute bottom-0 start-0 w-100 bg-primary" style="height: 4px;"></div>
                    </div>
                </div>

                <div class="col">
                    <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="bg-info bg-opacity-10 text-info p-3 rounded-3">
                                    <i class="bi bi-journal-bookmark fs-3"></i>
                                </div>
                                <a href="{{ route('jurusan.index') }}" class="btn btn-sm btn-light text-info rounded-circle p-2" title="Kelola Jurusan">
                                    <i class="bi bi-arrow-right-short fs-5"></i>
                                </a>
                            </div>
                            <small class="text-muted fw-bold text-uppercase tracking-wider d-block mb-1">Total Jurusan</small>
                            <h2 class="fw-bold text-dark mb-0">{{ $totalJurusan }}</h2>
                            <small class="text-secondary">Program Keahlian</small>
                        </div>
                        <div class="position-absolute bottom-0 start-0 w-100 bg-info" style="height: 4px;"></div>
                    </div>
                </div>

                <div class="col">
                    <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="bg-success bg-opacity-10 text-success p-3 rounded-3">
                                    <i class="bi bi-people fs-3"></i>
                                </div>
                                <a href="{{ route('siswa.index') }}" class="btn btn-sm btn-light text-success rounded-circle p-2" title="Kelola Siswa">
                                    <i class="bi bi-arrow-right-short fs-5"></i>
                                </a>
                            </div>
                            <small class="text-muted fw-bold text-uppercase tracking-wider d-block mb-1">Total Siswa</small>
                            <h2 class="fw-bold text-dark mb-0">{{ $totalSiswa }}</h2>
                            <small class="text-secondary">Siswa Aktif & Alumni</small>
                        </div>
                        <div class="position-absolute bottom-0 start-0 w-100 bg-success" style="height: 4px;"></div>
                    </div>
                </div>

                <div class="col">
                    <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-3">
                                    <i class="bi bi-person-badge fs-3"></i>
                                </div>
                                <a href="{{ route('guru.index') }}" class="btn btn-sm btn-light text-warning rounded-circle p-2" title="Kelola Guru">
                                    <i class="bi bi-arrow-right-short fs-5"></i>
                                </a>
                            </div>
                            <small class="text-muted fw-bold text-uppercase tracking-wider d-block mb-1">Total Guru</small>
                            <h2 class="fw-bold text-dark mb-0">{{ $totalGuru }}</h2>
                            <small class="text-secondary">Guru Pengajar Terdaftar</small>
                        </div>
                        <div class="position-absolute bottom-0 start-0 w-100 bg-warning" style="height: 4px;"></div>
                    </div>
                </div>
            </div>
        @endif

        @if(Auth::user()->isAdmin() || Auth::user()->isGuru())
            <!-- Daily Attendance Overview Widget -->
            <div class="card border-0 shadow-sm mb-4 rounded-3 overflow-hidden">
                <div class="card-header bg-dark text-white py-3 border-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-shield-check text-warning me-2"></i>Status Total Presensi Siswa Hari Ini ({{ \Carbon\Carbon::now()->translatedFormat('d F Y') }})
                    </h5>
                    <a href="{{ route('absensi.harian') }}" class="btn btn-warning text-dark btn-sm fw-bold px-3">
                        <i class="bi bi-eye-fill me-1"></i> Monitoring Presensi Seluruh Siswa &rarr;
                    </a>
                </div>
                <div class="card-body p-4 bg-light bg-opacity-50">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-5 g-3 text-center">
                        <div class="col">
                            <div class="bg-white p-3 rounded-3 shadow-sm border border-success border-2">
                                <small class="text-success fw-bold text-uppercase d-block mb-1">Hadir</small>
                                <h3 class="fw-bold text-success mb-0">{{ $todayHadirCount }}</h3>
                                <small class="text-muted">Siswa</small>
                            </div>
                        </div>
                        <div class="col">
                            <div class="bg-white p-3 rounded-3 shadow-sm border border-warning border-2">
                                <small class="text-warning fw-bold text-uppercase d-block mb-1">Izin</small>
                                <h3 class="fw-bold text-dark mb-0">{{ $todayIzinCount }}</h3>
                                <small class="text-muted">Dengan Alasan</small>
                            </div>
                        </div>
                        <div class="col">
                            <div class="bg-white p-3 rounded-3 shadow-sm border border-info border-2">
                                <small class="text-info fw-bold text-uppercase d-block mb-1">Sakit</small>
                                <h3 class="fw-bold text-dark mb-0">{{ $todaySakitCount }}</h3>
                                <small class="text-muted">Keterangan Sakit</small>
                            </div>
                        </div>
                        <div class="col">
                            <div class="bg-white p-3 rounded-3 shadow-sm border border-danger border-2">
                                <small class="text-danger fw-bold text-uppercase d-block mb-1">Alpa</small>
                                <h3 class="fw-bold text-danger mb-0">{{ $todayAlpaCount }}</h3>
                                <small class="text-muted">Tanpa Keterangan</small>
                            </div>
                        </div>
                        <div class="col">
                            <div class="bg-white p-3 rounded-3 shadow-sm border border-secondary border-2">
                                <small class="text-secondary fw-bold text-uppercase d-block mb-1">Belum Diabsen</small>
                                <h3 class="fw-bold text-secondary mb-0">{{ $todayBelumDiabsen }}</h3>
                                <small class="text-muted">Belum Diisi Guru</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Recent Schedules & Tasks Overview -->
        <div class="row g-4 mb-4">
            <!-- Recent Schedules -->
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-calendar3 text-primary me-2"></i>Jadwal Pelajaran</h5>
                        <a href="{{ route('jadwal.index') }}" class="btn btn-outline-primary btn-sm px-3">Lihat Semua</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Hari</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Guru Pengajar</th>
                                        <th>Kelas</th>
                                        <th class="pe-4 text-end">Waktu KBM</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentJadwal as $j)
                                        <tr>
                                            <td class="ps-4 fw-bold text-dark"><span class="badge bg-dark">{{ $j->hari }}</span></td>
                                            <td class="fw-bold text-primary">{{ $j->mata_pelajaran }}</td>
                                            <td><span class="badge bg-info text-dark small"><i class="bi bi-person-fill me-1"></i>{{ $j->guru->nama ?? '-' }}</span></td>
                                            <td><span class="badge bg-secondary">{{ $j->kelas }}</span></td>
                                            <td class="pe-4 text-end text-muted small">
                                                {{ date('H:i', strtotime($j->jam_mulai)) }} - {{ date('H:i', strtotime($j->jam_selesai)) }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted">Belum ada jadwal pelajaran.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Tasks -->
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-file-earmark-text text-danger me-2"></i>Tugas Sekolah Terbaru</h5>
                        <a href="{{ route('tugas.index') }}" class="btn btn-outline-danger btn-sm px-3">Lihat Semua</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Judul Tugas</th>
                                        <th>Kelas</th>
                                        <th class="pe-4 text-end">Deadline</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentTugas as $t)
                                        <tr>
                                            <td class="ps-4">
                                                <div class="fw-bold text-dark">{{ $t->judul }}</div>
                                                @if($t->mata_pelajaran)
                                                    <small class="text-primary">{{ $t->mata_pelajaran }}</small>
                                                @endif
                                            </td>
                                            <td><span class="badge bg-secondary">{{ $t->kelas }}</span></td>
                                            <td class="pe-4 text-end">
                                                @if(\Carbon\Carbon::parse($t->deadline)->isPast())
                                                    <span class="text-danger fw-bold small">{{ \App\Helpers\WaktuHelper::formatShort($t->deadline) }}</span>
                                                @else
                                                    <span class="text-dark small">{{ \App\Helpers\WaktuHelper::formatShort($t->deadline) }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center py-4 text-muted">Belum ada tugas sekolah.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- PRESTASI SISWA SHOWCASE SECTION -->
        <div class="card border-0 shadow-sm rounded-3 mb-4 overflow-hidden">
            <div class="card-header bg-gradient bg-warning bg-opacity-10 py-3 border-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h4 class="fw-bold text-dark mb-0">
                        <i class="bi bi-trophy-fill text-warning me-2 fs-3"></i>🏆 Hall of Fame & Siswa Berprestasi
                    </h4>
                    <small class="text-secondary">Pencapaian kebanggaan dan kejuaraan siswa di tingkat Kota, Provinsi, Nasional & Internasional</small>
                </div>
                @if(Auth::user()->isAdmin())
                    <button type="button" class="btn btn-warning text-dark fw-bold btn-sm px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahPrestasiDash">
                        <i class="bi bi-plus-circle-fill me-1"></i> Tambah Prestasi Baru
                    </button>
                @endif
            </div>
            <div class="card-body p-4 bg-light bg-opacity-25">
                <div class="row g-3">
                    @forelse($prestasiList as $p)
                        <div class="col-md-6 col-lg-4">
                            <div class="card border-0 shadow-sm rounded-3 h-100 bg-white position-relative">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-center gap-3 mb-3">
                                        @if($p->foto_bukti)
                                            <img src="{{ asset('storage/'.$p->foto_bukti) }}" class="rounded-circle object-fit-cover border border-2 border-warning shadow-sm" style="width: 55px; height: 55px;">
                                        @else
                                            <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center fw-bold fs-4 shadow-sm" style="width: 55px; height: 55px;">
                                                🏆
                                            </div>
                                        @endif
                                        <div class="flex-grow-1">
                                            <h6 class="fw-bold text-dark mb-0">{{ $p->nama_siswa }}</h6>
                                            <small class="text-muted d-block">{{ $p->kelas ? 'Kelas '.$p->kelas : 'Siswa Sekolah' }}</small>
                                            <span class="badge bg-warning text-dark fw-bold px-2 py-0.5 mt-1 small">
                                                <i class="bi bi-award-fill me-1"></i>{{ $p->peringkat }}
                                            </span>
                                        </div>
                                    </div>
                                    <h6 class="fw-bold text-primary mb-1">{{ $p->judul_prestasi }}</h6>
                                    <div class="d-flex justify-content-between align-items-center mt-2 small text-muted">
                                        <span><i class="bi bi-geo-alt me-1 text-danger"></i>Tingkat {{ $p->tingkat }}</span>
                                        <span class="font-monospace">Thn {{ $p->tahun }}</span>
                                    </div>

                                    <div class="d-flex gap-1 mt-3">
                                        <!-- Tombol Mata (View Detail Modal on Dashboard) -->
                                        <button type="button" class="btn btn-sm btn-info text-white fw-bold flex-grow-1" data-bs-toggle="modal" data-bs-target="#modalDashboardPrestasi{{ $p->id }}">
                                            <i class="bi bi-eye-fill me-1"></i> Detail
                                        </button>

                                        @if(Auth::user()->isAdmin())
                                            <!-- Tombol Edit Admin -->
                                            <button type="button" class="btn btn-sm btn-warning text-dark fw-bold px-2" data-bs-toggle="modal" data-bs-target="#modalEditDashPrestasi{{ $p->id }}" title="Edit Prestasi">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>

                                            <!-- Tombol Hapus Admin -->
                                            <form action="{{ route('admin.prestasi.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus prestasi ini?')" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger px-2" title="Hapus Prestasi">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Detail Prestasi Dashboard -->
                        <div class="modal fade" id="modalDashboardPrestasi{{ $p->id }}" tabindex="-1" aria-labelledby="labelDash{{ $p->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                                    <div class="modal-header bg-dark text-white border-0 py-3">
                                        <h5 class="modal-title fw-bold" id="labelDash{{ $p->id }}">
                                            <i class="bi bi-trophy-fill text-warning me-2"></i>Detail Prestasi & Deskripsi Lomba
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
                                                    <h6 class="fw-bold text-dark mb-1"><i class="bi bi-card-text me-1 text-primary"></i>Deskripsi / Rincian Lomba:</h6>
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
                            <!-- Modal Edit Prestasi Dashboard (ADMIN ONLY) -->
                            <div class="modal fade" id="modalEditDashPrestasi{{ $p->id }}" tabindex="-1" aria-labelledby="labelEditDash{{ $p->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content border-0 shadow-lg rounded-4">
                                        <div class="modal-header bg-warning text-dark border-0 py-3">
                                            <h5 class="modal-title fw-bold" id="labelEditDash{{ $p->id }}">
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
                                                        <label class="form-label fw-bold small">Pilih Siswa (Opsional)</label>
                                                        <select name="siswa_id" class="form-select form-select-sm">
                                                            <option value="">-- Pilih dari Data Siswa --</option>
                                                            @foreach($siswas as $s)
                                                                <option value="{{ $s->id }}" {{ $p->siswa_id == $s->id ? 'selected' : '' }}>{{ $s->nama }} (Kelas {{ $s->kelas }})</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-bold small">Nama Siswa (Manual)</label>
                                                        <input type="text" name="nama_siswa" class="form-control form-control-sm" value="{{ $p->nama_siswa }}">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="form-label fw-bold small">Judul / Nama Kejuaraan <span class="text-danger">*</span></label>
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
                                                        <textarea name="deskripsi" class="form-control form-control-sm" rows="3" placeholder="Tuliskan deskripsi singkat mengenai jalannya lomba...">{{ $p->deskripsi }}</textarea>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="form-label fw-bold small">Ganti Foto Bukti / Piala (Opsional)</label>
                                                        <input type="file" name="foto_bukti" class="form-control form-control-sm" accept="image/*">
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
                        <div class="col-12">
                            <div class="text-center py-4 text-muted bg-white rounded border border-dashed">
                                <i class="bi bi-trophy fs-1 d-block mb-2 text-warning opacity-50"></i>
                                Belum ada data prestasi siswa terdaftar.
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        @if(Auth::user()->isAdmin())
            <!-- Modal Tambah Prestasi Dashboard (ADMIN ONLY) -->
            <div class="modal fade" id="modalTambahPrestasiDash" tabindex="-1" aria-labelledby="labelTambahDash" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content border-0 shadow-lg rounded-4">
                        <div class="modal-header bg-dark text-white border-0 py-3">
                            <h5 class="modal-title fw-bold" id="labelTambahDash">
                                <i class="bi bi-plus-circle-fill text-warning me-2"></i>Tambah Data Prestasi Siswa Baru
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('admin.prestasi.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body p-4">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small">Pilih Siswa (Opsional)</label>
                                        <select name="siswa_id" class="form-select form-select-sm">
                                            <option value="">-- Pilih dari Data Siswa --</option>
                                            @foreach($siswas as $s)
                                                <option value="{{ $s->id }}">{{ $s->nama }} (Kelas {{ $s->kelas }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small">Nama Siswa (Manual)</label>
                                        <input type="text" name="nama_siswa" class="form-control form-control-sm" placeholder="Nama lengkap siswa berprestasi...">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold small">Judul / Nama Kejuaraan <span class="text-danger">*</span></label>
                                        <input type="text" name="judul_prestasi" class="form-control form-control-sm" placeholder="Contoh: Juara 1 Olimpiade Sains Nasional" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small">Kategori</label>
                                        <select name="kategori" class="form-select form-select-sm">
                                            <option value="Akademik">Akademik</option>
                                            <option value="Olahraga">Olahraga</option>
                                            <option value="Seni & Budaya">Seni & Budaya</option>
                                            <option value="Teknologi & IT">Teknologi & IT</option>
                                            <option value="Kepemimpinan">Kepemimpinan</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small">Tingkat</label>
                                        <select name="tingkat" class="form-select form-select-sm">
                                            <option value="Kota/Kabupaten">Kota / Kabupaten</option>
                                            <option value="Provinsi">Provinsi</option>
                                            <option value="Nasional" selected>Nasional</option>
                                            <option value="Internasional">Internasional</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold small">Peringkat / Medali</label>
                                        <input type="text" name="peringkat" class="form-control form-control-sm" value="Juara 1" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold small">Tahun</label>
                                        <input type="text" name="tahun" class="form-control form-control-sm" value="{{ date('Y') }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold small">Penyelenggara</label>
                                        <input type="text" name="penyelenggara" class="form-control form-control-sm" placeholder="Contoh: Kementerian Pendidikan">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold small">Deskripsi / Rincian Lomba</label>
                                        <textarea name="deskripsi" class="form-control form-control-sm" rows="3" placeholder="Tuliskan deskripsi singkat mengenai perlombaan..."></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold small">Foto Siswa / Penyerahan Piala</label>
                                        <input type="file" name="foto_bukti" class="form-control form-control-sm" accept="image/*">
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

        <!-- EKSTRAKURIKULER SEKOLAH SHOWCASE SECTION -->
        <div class="card border-0 shadow-sm rounded-3 mb-4 overflow-hidden">
            <div class="card-header bg-gradient bg-primary bg-opacity-10 py-3 border-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h4 class="fw-bold text-dark mb-0">
                        <i class="bi bi-palette-fill text-primary me-2 fs-3"></i>🎨 Ekstrakurikuler & Kegiatan Siswa
                    </h4>
                    <small class="text-secondary">Wadah minat, bakat, olahraga, seni, dan pengembangan karakter siswa</small>
                </div>
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.ekskul.index') }}" class="btn btn-primary fw-bold btn-sm px-3 shadow-sm">
                        <i class="bi bi-gear-fill me-1"></i> Kelola Ekskul (Admin)
                    </a>
                @endif
            </div>
            <div class="card-body p-4 bg-light bg-opacity-25">
                <div class="row g-3">
                    @forelse($ekskulList as $e)
                        <div class="col-md-6 col-lg-4">
                            <div class="card border-0 shadow-sm rounded-3 h-100 bg-white overflow-hidden">
                                @if($e->foto)
                                    <img src="{{ asset('storage/'.$e->foto) }}" class="card-img-top object-fit-cover" style="height: 120px;">
                                @else
                                    <div class="bg-primary text-white d-flex align-items-center justify-content-center p-3" style="height: 120px;">
                                        <i class="bi bi-palette fs-1"></i>
                                    </div>
                                @endif
                                <div class="card-body p-3">
                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary small mb-1">{{ $e->kategori }}</span>
                                    <h5 class="fw-bold text-dark mb-1">{{ $e->nama_ekskul }}</h5>
                                    <small class="text-muted d-block mb-2"><i class="bi bi-person-badge text-primary me-1"></i>Pembina: {{ $e->pembina ?? '-' }}</small>
                                    <div class="small text-secondary mb-1">
                                        <i class="bi bi-clock me-1 text-warning"></i>Jadwal: {{ $e->hari_latihan ?? '-' }} ({{ $e->jam_latihan ?? '-' }})
                                    </div>
                                    <div class="small text-secondary">
                                        <i class="bi bi-geo-alt me-1 text-danger"></i>Lokasi: {{ $e->lokasi ?? '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="text-center py-4 text-muted bg-white rounded border border-dashed">
                                <i class="bi bi-palette fs-1 d-block mb-2 text-primary opacity-50"></i>
                                Belum ada daftar ekstrakurikuler terdaftar di sekolah.
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- BERITA & EVENT SEKOLAH TERBARU SECTION -->
        <div class="row g-4 mb-4">
            <!-- Berita Terbaru Column -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-3 h-100 overflow-hidden">
                    <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-newspaper text-primary me-2"></i>Berita & Pengumuman Sekolah Terbaru</h5>
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.cms.index') }}" class="btn btn-outline-primary btn-sm fw-bold">Kelola Berita (Admin)</a>
                        @endif
                    </div>
                    <div class="card-body p-3 bg-light bg-opacity-50">
                        <div class="row g-3">
                            @forelse($beritaTerbaru as $b)
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm rounded-3 h-100 bg-white overflow-hidden">
                                        @if($b->foto)
                                            <img src="{{ $b->foto }}" class="card-img-top object-fit-cover" style="height: 130px;">
                                        @else
                                            <div class="bg-primary bg-opacity-10 text-primary p-4 text-center" style="height: 130px;">
                                                <i class="bi bi-newspaper fs-1"></i>
                                            </div>
                                        @endif
                                        <div class="card-body p-3 d-flex flex-column justify-content-between">
                                            <div>
                                                <span class="badge bg-info text-dark small mb-1">{{ $b->kategori ?: 'Umum' }}</span>
                                                <h6 class="fw-bold text-dark mb-1">{{ Str::limit($b->judul, 45) }}</h6>
                                                <small class="text-muted d-block mb-2"><i class="bi bi-calendar3 me-1"></i>{{ \Carbon\Carbon::parse($b->tanggal_publikasi)->translatedFormat('d F Y') }}</small>
                                            </div>
                                            <button type="button" class="btn btn-sm btn-outline-primary fw-bold w-100 mt-2" data-bs-toggle="modal" data-bs-target="#modalBacaBerita{{ $b->id }}">
                                                <i class="bi bi-book-half me-1"></i> Baca Selengkapnya
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Baca Berita Detail -->
                                <div class="modal fade" id="modalBacaBerita{{ $b->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content border-0 shadow-lg rounded-4">
                                            <div class="modal-header bg-dark text-white border-0 py-3">
                                                <h5 class="modal-title fw-bold"><i class="bi bi-newspaper text-warning me-2"></i>{{ $b->judul }}</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                @if($b->foto)
                                                    <img src="{{ $b->foto }}" class="img-fluid rounded-3 shadow-sm border mb-3 w-100 object-fit-cover" style="max-height: 320px;">
                                                @endif
                                                <div class="d-flex justify-content-between align-items-center mb-3 text-muted small">
                                                    <span><i class="bi bi-calendar-event me-1 text-primary"></i>Dipublikasikan: {{ \Carbon\Carbon::parse($b->tanggal_publikasi)->translatedFormat('d F Y') }}</span>
                                                    <span class="badge bg-info text-dark">{{ $b->kategori ?: 'Berita Sekolah' }}</span>
                                                </div>
                                                <div class="p-3 bg-light rounded-3 text-dark" style="line-height: 1.8; text-align: justify; white-space: pre-line;">
                                                    {!! nl2br(e($b->konten)) !!}
                                                </div>
                                            </div>
                                            <div class="modal-footer bg-light border-0">
                                                <button type="button" class="btn btn-secondary btn-sm px-4" data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center py-4 text-muted bg-white rounded border border-dashed">
                                    <i class="bi bi-newspaper fs-1 d-block mb-2 opacity-50"></i>
                                    Belum ada berita atau pengumuman sekolah terbaru.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Event / Agenda Mendatang Column -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-3 h-100 overflow-hidden">
                    <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-calendar-event text-warning me-2"></i>Agenda & Event Acara</h5>
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.cms.index') }}" class="btn btn-outline-warning text-dark btn-sm fw-bold">Kelola Event</a>
                        @endif
                    </div>
                    <div class="card-body p-3 bg-light bg-opacity-50">
                        @forelse($agendaMendatang as $ag)
                            <div class="bg-white p-3 rounded-3 shadow-sm mb-3 border border-start border-4 border-warning">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="badge bg-warning text-dark fw-bold">{{ $ag->kategori ?: 'Acara Sekolah' }}</span>
                                    <span class="small text-muted font-monospace"><i class="bi bi-clock me-1 text-primary"></i>{{ date('H:i', strtotime($ag->waktu_mulai ?? '08:00')) }} WITA</span>
                                </div>
                                <h6 class="fw-bold text-dark mb-1">{{ $ag->judul }}</h6>
                                <p class="small text-muted mb-2">{{ $ag->deskripsi }}</p>
                                <div class="d-flex justify-content-between align-items-center small text-secondary border-top pt-2">
                                    <span><i class="bi bi-calendar-check text-primary me-1"></i>{{ \Carbon\Carbon::parse($ag->tanggal)->translatedFormat('d F Y') }}</span>
                                    <span><i class="bi bi-geo-alt text-danger me-1"></i>{{ $ag->lokasi ?: 'Sekolah' }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4 text-muted bg-white rounded border border-dashed">
                                <i class="bi bi-calendar-x fs-1 d-block mb-2 text-warning opacity-50"></i>
                                Belum ada agenda acara mendatang.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    @endif

</div>
@endsection
