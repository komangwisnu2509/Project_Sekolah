@extends('layouts.app')

@section('content')
<div class="container-fluid px-0" style="max-width: 1250px; margin: 0 auto;">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1">
                <i class="bi bi-shield-check text-primary me-2"></i>Monitoring Presensi & Total Kehadiran Siswa
            </h2>
            <p class="text-muted mb-0">
                Pantau statistik kehadiran harian seluruh siswa terkelompok per kelas, jadwal mengajar guru hari ini, serta detail siswa yang hadir, izin, sakit, dan belum diabsen.
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('absensi.index') }}" class="btn btn-primary fw-bold shadow-sm">
                <i class="bi bi-pencil-square me-1"></i> Input Absensi Kelas
            </a>
            <a href="{{ route('absensi.harian.pdf', ['tanggal' => $tanggal, 'kelas' => $selectedKelas]) }}" class="btn btn-danger fw-bold shadow-sm" target="_blank">
                <i class="bi bi-file-pdf-fill me-1"></i> Cetak PDF Laporan
            </a>
        </div>
    </div>

    <!-- BANNER JADWAL MENGAJAR & PRESENSI GURU HARI INI (OTOMATIS SESUAI HARI & JAM PELAJARAN) -->
    @if(Auth::user()->isGuru() && Auth::user()->guru)
        <div class="card border-0 shadow-sm mb-4 bg-gradient bg-primary text-white rounded-3 border-start border-5 border-warning">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                    <div>
                        <span class="badge bg-warning text-dark fw-bold px-3 py-1.5 mb-1 fs-6">
                            <i class="bi bi-calendar-check-fill me-1"></i> JADWAL MENGAJAR GURU HARI INI
                        </span>
                        <h4 class="fw-bold text-white mb-0">
                            {{ $formattedIndoDate }}
                        </h4>
                    </div>
                    <span class="badge bg-white text-primary px-3 py-2 fw-bold font-monospace fs-6 shadow-sm">
                        <i class="bi bi-clock me-1"></i> {{ count($myTodayJadwals) }} Jam Pelajaran Terdaftar
                    </span>
                </div>

                @if(count($myTodayJadwals) > 0)
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                        @foreach($myTodayJadwals as $j)
                            @php
                                $classSummary = $summaryPerKelas->get($j->kelas);
                                $belumCount = $classSummary ? $classSummary['belum'] : 0;
                                $isComplete = $classSummary && $belumCount === 0 && $classSummary['total'] > 0;
                                $nowTime = date('H:i:s');
                                $isActiveNow = ($nowTime >= $j->jam_mulai && $nowTime <= $j->jam_selesai);
                            @endphp
                            <div class="col">
                                <div class="bg-white text-dark p-3 rounded-3 shadow-sm h-100 border {{ $isActiveNow ? 'border-primary border-3' : 'border-light' }}">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h5 class="fw-bold text-primary mb-0"><i class="bi bi-building me-1"></i>Kelas {{ $j->kelas }}</h5>
                                        @if($isActiveNow)
                                            <span class="badge bg-danger animate__animated animate__flash animate__infinite px-2.5 py-1">⚡ JAM SEKARANG</span>
                                        @else
                                            <span class="badge bg-light text-dark font-monospace border"><i class="bi bi-clock me-1 text-primary"></i>{{ date('H:i', strtotime($j->jam_mulai)) }} - {{ date('H:i', strtotime($j->jam_selesai)) }}</span>
                                        @endif
                                    </div>
                                    <small class="text-muted d-block mb-2">Mapel: <strong>{{ $j->mata_pelajaran }}</strong> (Sesi {{ $j->sesi ?? '-' }})</small>

                                    <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                        @if($isComplete)
                                            <span class="badge bg-success px-2.5 py-1.5 small"><i class="bi bi-check-circle-fill me-1"></i>Presensi Lengkap</span>
                                        @else
                                            <span class="badge bg-warning text-dark px-2.5 py-1.5 small"><i class="bi bi-exclamation-triangle-fill me-1"></i>{{ $belumCount }} Belum Diabsen</span>
                                        @endif

                                        <a href="{{ route('absensi.index', ['kelas' => $j->kelas, 'tanggal' => $tanggal]) }}" class="btn btn-primary btn-sm fw-bold">
                                            <i class="bi bi-pencil-square me-1"></i> Absen Sekarang
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-3 bg-white bg-opacity-10 rounded-3 text-white-50 border border-white border-opacity-25 small text-center">
                        <i class="bi bi-calendar-x me-1 fs-5"></i> Anda tidak memiliki jadwal mengajar aktif untuk hari <strong>{{ $hariIndo }}</strong>.
                    </div>
                @endif
            </div>
        </div>
    @endif

    <!-- Filter Control Card -->
    <div class="card border-0 shadow-sm mb-4 rounded-3">
        <div class="card-body p-3">
            <form action="{{ route('absensi.harian') }}" method="GET" class="row g-3 align-items-center">
                <div class="col-md-3">
                    <label for="tanggal" class="form-label fw-bold small text-muted mb-1"><i class="bi bi-calendar-event me-1 text-warning"></i>Pilih Tanggal Presensi</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control fw-bold" value="{{ $tanggal }}" onchange="this.form.submit()">
                </div>
                <div class="col-md-3">
                    <label for="kelas" class="form-label fw-bold small text-muted mb-1"><i class="bi bi-building me-1 text-primary"></i>Filter Kelas</label>
                    <select name="kelas" id="kelas" class="form-select fw-bold" onchange="this.form.submit()">
                        <option value="">-- Semua Kelas --</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->nama_kelas }}" {{ $selectedKelas == $k->nama_kelas ? 'selected' : '' }}>Kelas {{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label fw-bold small text-muted mb-1"><i class="bi bi-funnel me-1 text-info"></i>Filter Status Kehadiran</label>
                    <select name="status" id="status" class="form-select fw-bold" onchange="this.form.submit()">
                        <option value="">-- Semua Status --</option>
                        <option value="Hadir" {{ $statusFilter == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                        <option value="Izin" {{ $statusFilter == 'Izin' ? 'selected' : '' }}>Izin</option>
                        <option value="Sakit" {{ $statusFilter == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                        <option value="Alpa" {{ $statusFilter == 'Alpa' ? 'selected' : '' }}>Alpa</option>
                        <option value="Non-Hadir" {{ $statusFilter == 'Non-Hadir' ? 'selected' : '' }}>Khusus Non-Hadir (Izin/Sakit/Alpa)</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="q" class="form-label fw-bold small text-muted mb-1"><i class="bi bi-search me-1 text-secondary"></i>Cari Nama / NIS</label>
                    <div class="input-group">
                        <input type="text" name="q" id="q" class="form-control" placeholder="Cari nama..." value="{{ $search }}">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Daily Statistics Overview Cards -->
    <!-- All Classes Attendance Completed Banner -->
    @if(isset($totalBelum) && $totalBelum == 0 && $totalSiswa > 0)
        <div class="alert alert-success border-start border-4 border-success shadow-sm mb-4 rounded-3 d-flex align-items-center gap-3">
            <div class="bg-success text-white p-2.5 rounded-circle fs-4 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                <i class="bi bi-check-all"></i>
            </div>
            <div>
                <strong class="d-block text-success fs-6">🎉 Seluruh Kelas Sudah Selesai & Lengkap Di-absen Hari Ini!</strong>
                <span class="small text-dark">Seluruh {{ $totalSiswa }} siswa aktif di sekolah telah memiliki data absensi untuk tanggal {{ $formattedIndoDate }}.</span>
            </div>
        </div>
    @endif

    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-6 g-3 mb-4">
        <!-- Total Active Students -->
        <div class="col">
            <div class="card border-0 shadow-sm h-100 p-3 border-start border-4 border-dark bg-white">
                <small class="text-muted fw-bold text-uppercase d-block mb-1" style="font-size: 0.72rem;">Total Siswa</small>
                <h3 class="fw-bold text-dark mb-0">{{ $totalSiswa }}</h3>
                <small class="text-secondary" style="font-size: 0.72rem;">Siswa Aktif</small>
            </div>
        </div>

        <!-- Hadir -->
        <div class="col">
            <div class="card border-0 shadow-sm h-100 p-3 border-start border-4 border-success bg-white">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <small class="text-success fw-bold text-uppercase" style="font-size: 0.72rem;">Hadir</small>
                    <span class="badge bg-success" style="font-size: 0.7rem;">
                        {{ $totalSiswa > 0 ? round(($totalHadir / $totalSiswa) * 100) : 0 }}%
                    </span>
                </div>
                <h3 class="fw-bold text-success mb-0">{{ $totalHadir }}</h3>
                <small class="text-muted" style="font-size: 0.72rem;">Siswa Hadir</small>
            </div>
        </div>

        <!-- Izin -->
        <div class="col">
            <div class="card border-0 shadow-sm h-100 p-3 border-start border-4 border-warning bg-white">
                <small class="text-warning fw-bold text-uppercase d-block mb-1" style="font-size: 0.72rem;">Izin</small>
                <h3 class="fw-bold text-dark mb-0">{{ $totalIzin }}</h3>
                <small class="text-muted" style="font-size: 0.72rem;">Dengan Alasan</small>
            </div>
        </div>

        <!-- Sakit -->
        <div class="col">
            <div class="card border-0 shadow-sm h-100 p-3 border-start border-4 border-info bg-white">
                <small class="text-info fw-bold text-uppercase d-block mb-1" style="font-size: 0.72rem;">Sakit</small>
                <h3 class="fw-bold text-dark mb-0">{{ $totalSakit }}</h3>
                <small class="text-muted" style="font-size: 0.72rem;">Surat / Keterangan</small>
            </div>
        </div>

        <!-- Alpa -->
        <div class="col">
            <div class="card border-0 shadow-sm h-100 p-3 border-start border-4 border-danger bg-white">
                <small class="text-danger fw-bold text-uppercase d-block mb-1" style="font-size: 0.72rem;">Alpa</small>
                <h3 class="fw-bold text-danger mb-0">{{ $totalAlpa }}</h3>
                <small class="text-muted" style="font-size: 0.72rem;">Tanpa Keterangan</small>
            </div>
        </div>

        <!-- Belum Diabsen -->
        <div class="col">
            <div class="card border-0 shadow-sm h-100 p-3 border-start border-4 border-secondary bg-white">
                <small class="text-secondary fw-bold text-uppercase d-block mb-1" style="font-size: 0.72rem;">Belum Diabsen</small>
                <h3 class="fw-bold text-secondary mb-0">{{ $totalBelum }}</h3>
                <small class="text-muted" style="font-size: 0.72rem;">Belum Diisi Guru</small>
            </div>
        </div>
    </div>

    <!-- Per Class Attendance Summary & Interactive Detail Modals -->
    @if(count($summaryPerKelas) > 0 && !$selectedKelas)
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="bi bi-pie-chart-fill text-primary me-2"></i>Status Ringkasan Kehadiran Kelas ({{ $formattedIndoDate }})
                </h5>
                <span class="badge bg-secondary px-3 py-1 fs-6">Klik card kelas untuk melihat detail rincian siswa Hadir, Izin, Sakit & Belum Diabsen</span>
            </div>
            <div class="card-body p-3 bg-light bg-opacity-50">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">
                    @foreach($summaryPerKelas as $className => $cData)
                        @php
                            $hadirPct = $cData['total'] > 0 ? round(($cData['hadir'] / $cData['total']) * 100) : 0;
                            $belumCount = $cData['belum'];
                            $isAllowed = $cData['isAllowedForGuru'];
                            $modalId = 'modalDetailClass_' . Str::slug($className);
                        @endphp
                        <div class="col">
                            <div class="bg-white p-3 rounded-3 border shadow-sm h-100 {{ $belumCount > 0 ? 'border-warning border-2' : '' }}">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="fw-bold text-dark"><i class="bi bi-building me-1 text-primary"></i>Kelas {{ $className }}</span>
                                    @if($belumCount > 0)
                                        <span class="badge bg-warning text-dark font-semibold fs-6"><i class="bi bi-exclamation-triangle-fill me-1"></i>Belum Diabsen</span>
                                    @else
                                        <span class="badge bg-success fs-6"><i class="bi bi-check-circle-fill me-1"></i>Lengkap</span>
                                    @endif
                                </div>
                                <div class="progress mb-2" style="height: 8px;">
                                    <div class="progress-bar bg-success" style="width: {{ $hadirPct }}%"></div>
                                </div>
                                <div class="d-flex justify-content-between text-muted small mb-2" style="font-size: 0.75rem;">
                                    <span>Hadir: <strong class="text-success">{{ $cData['hadir'] }}</strong></span>
                                    <span>Izin/Sakit: <strong class="text-warning">{{ $cData['izin'] + $cData['sakit'] }}</strong></span>
                                    <span>Alpa: <strong class="text-danger">{{ $cData['alpa'] }}</strong></span>
                                </div>

                                <div class="border-top pt-2 mt-1 d-flex flex-column gap-1">
                                    <button type="button" class="btn btn-outline-primary btn-sm fw-bold w-100 py-1" data-bs-toggle="modal" data-bs-target="#{{ $modalId }}">
                                        <i class="bi bi-eye-fill me-1"></i> Lihat Detail Siswa Kelas
                                    </button>
                                    @if($isAllowed)
                                        <a href="{{ route('absensi.index', ['kelas' => $className, 'tanggal' => $tanggal]) }}" class="btn btn-primary btn-sm fw-bold w-100 py-1">
                                            <i class="bi bi-pencil-square me-1"></i> Absen Kelas Ini
                                        </a>
                                    @else
                                        <span class="badge bg-light text-muted border text-center py-1.5" title="Hanya Guru pengampu atau Guru Pengganti yang dapat mengabsen kelas ini">
                                            <i class="bi bi-lock-fill me-1"></i> Khusus Guru Pengampu
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- MODAL KLIK DETAIL KELAS FULL (HADIR, IZIN, SAKIT, ALPA, BELUM DIABSEN) -->
                        <div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content border-0 shadow">
                                    <div class="modal-header bg-primary text-white py-3">
                                        <h5 class="modal-title fw-bold">
                                            <i class="bi bi-building-fill me-2"></i>Rincian Kehadiran Siswa Kelas {{ $className }}
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom flex-wrap gap-2">
                                            <span class="text-dark fw-bold">Tanggal: {{ $formattedIndoDate }}</span>
                                            <div class="d-flex gap-2">
                                                <span class="badge bg-success">Hadir: {{ $cData['hadir'] }}</span>
                                                <span class="badge bg-warning text-dark">Izin/Sakit: {{ $cData['izin'] + $cData['sakit'] }}</span>
                                                <span class="badge bg-danger">Alpa: {{ $cData['alpa'] }}</span>
                                                <span class="badge bg-secondary">Belum: {{ $cData['belum'] }}</span>
                                            </div>
                                        </div>

                                        <!-- Nav Tabs Inside Modal -->
                                        <ul class="nav nav-tabs mb-3" id="tabClass_{{ Str::slug($className) }}" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active fw-bold small" id="tabHadir_{{ Str::slug($className) }}" data-bs-toggle="tab" data-bs-target="#contentHadir_{{ Str::slug($className) }}" type="button" role="tab">
                                                    <i class="bi bi-check-circle-fill text-success me-1"></i> Hadir ({{ count($cData['hadirStudents']) }})
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link fw-bold small" id="tabIzin_{{ Str::slug($className) }}" data-bs-toggle="tab" data-bs-target="#contentIzin_{{ Str::slug($className) }}" type="button" role="tab">
                                                    <i class="bi bi-clock-history text-warning me-1"></i> Izin / Sakit ({{ count($cData['izinStudents']) }})
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link fw-bold small" id="tabAlpa_{{ Str::slug($className) }}" data-bs-toggle="tab" data-bs-target="#contentAlpa_{{ Str::slug($className) }}" type="button" role="tab">
                                                    <i class="bi bi-x-circle-fill text-danger me-1"></i> Alpa ({{ count($cData['alpaStudents']) }})
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link fw-bold small" id="tabBelum_{{ Str::slug($className) }}" data-bs-toggle="tab" data-bs-target="#contentBelum_{{ Str::slug($className) }}" type="button" role="tab">
                                                    <i class="bi bi-question-circle-fill text-secondary me-1"></i> Belum Diabsen ({{ count($cData['unmarkedStudents']) }})
                                                </button>
                                            </li>
                                        </ul>

                                        <div class="tab-content" id="tabContent_{{ Str::slug($className) }}">
                                            <!-- TAB 1: HADIR -->
                                            <div class="tab-pane fade show active" id="contentHadir_{{ Str::slug($className) }}" role="tabpanel">
                                                <div class="table-responsive" style="max-height: 300px;">
                                                    <table class="table table-hover align-middle mb-0">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th style="width: 50px;">No</th>
                                                                <th>Nama Siswa & NIS</th>
                                                                <th class="text-end">Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($cData['hadirStudents'] as $hIdx => $hSiswa)
                                                                <tr>
                                                                    <td class="fw-bold text-muted">{{ $hIdx + 1 }}</td>
                                                                    <td>
                                                                        <div class="d-flex align-items-center gap-2">
                                                                            @if($hSiswa->foto)
                                                                                <img src="{{ asset('storage/'.$hSiswa->foto) }}" alt="Foto" class="rounded-circle object-fit-cover" style="width: 35px; height: 35px;">
                                                                            @else
                                                                                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 35px; height: 35px;">
                                                                                    {{ strtoupper(substr($hSiswa->nama, 0, 1)) }}
                                                                                </div>
                                                                            @endif
                                                                            <div>
                                                                                <div class="fw-bold text-dark">{{ $hSiswa->nama }}</div>
                                                                                <small class="text-muted font-monospace">NIS: {{ $hSiswa->nis }}</small>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-end"><span class="badge bg-success"><i class="bi bi-check-circle-fill me-1"></i>Hadir</span></td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="3" class="text-center py-4 text-muted">Belum ada siswa yang hadir.</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <!-- TAB 2: IZIN & SAKIT -->
                                            <div class="tab-pane fade" id="contentIzin_{{ Str::slug($className) }}" role="tabpanel">
                                                <div class="table-responsive" style="max-height: 300px;">
                                                    <table class="table table-hover align-middle mb-0">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th style="width: 50px;">No</th>
                                                                <th>Nama Siswa & NIS</th>
                                                                <th>Status & Alasan</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($cData['izinStudents'] as $iIdx => $iSiswa)
                                                                @php
                                                                    $rec = $absensiRecords->get($iSiswa->id);
                                                                @endphp
                                                                <tr>
                                                                    <td class="fw-bold text-muted">{{ $iIdx + 1 }}</td>
                                                                    <td>
                                                                        <div class="d-flex align-items-center gap-2">
                                                                            @if($iSiswa->foto)
                                                                                <img src="{{ asset('storage/'.$iSiswa->foto) }}" alt="Foto" class="rounded-circle object-fit-cover" style="width: 35px; height: 35px;">
                                                                            @else
                                                                                <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 35px; height: 35px;">
                                                                                    {{ strtoupper(substr($iSiswa->nama, 0, 1)) }}
                                                                                </div>
                                                                            @endif
                                                                            <div>
                                                                                <div class="fw-bold text-dark">{{ $iSiswa->nama }}</div>
                                                                                <small class="text-muted font-monospace">NIS: {{ $iSiswa->nis }}</small>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        @if($rec && $rec->status === 'Izin')
                                                                            <span class="badge bg-warning text-dark me-1">Izin</span>
                                                                        @else
                                                                            <span class="badge bg-info text-dark me-1">Sakit</span>
                                                                        @endif
                                                                        <small class="text-dark fst-italic">"{{ $rec->alasan ?? 'Tidak ada alasan' }}"</small>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="3" class="text-center py-4 text-muted">Tidak ada siswa yang Izin/Sakit.</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <!-- TAB 3: ALPA -->
                                            <div class="tab-pane fade" id="contentAlpa_{{ Str::slug($className) }}" role="tabpanel">
                                                <div class="table-responsive" style="max-height: 300px;">
                                                    <table class="table table-hover align-middle mb-0">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th style="width: 50px;">No</th>
                                                                <th>Nama Siswa & NIS</th>
                                                                <th class="text-end">Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($cData['alpaStudents'] as $aIdx => $aSiswa)
                                                                <tr>
                                                                    <td class="fw-bold text-muted">{{ $aIdx + 1 }}</td>
                                                                    <td>
                                                                        <div class="d-flex align-items-center gap-2">
                                                                            @if($aSiswa->foto)
                                                                                <img src="{{ asset('storage/'.$aSiswa->foto) }}" alt="Foto" class="rounded-circle object-fit-cover" style="width: 35px; height: 35px;">
                                                                            @else
                                                                                <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 35px; height: 35px;">
                                                                                    {{ strtoupper(substr($aSiswa->nama, 0, 1)) }}
                                                                                </div>
                                                                            @endif
                                                                            <div>
                                                                                <div class="fw-bold text-dark">{{ $aSiswa->nama }}</div>
                                                                                <small class="text-muted font-monospace">NIS: {{ $aSiswa->nis }}</small>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-end"><span class="badge bg-danger"><i class="bi bi-x-circle-fill me-1"></i>Alpa</span></td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="3" class="text-center py-4 text-muted">Tidak ada siswa yang Alpa.</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <!-- TAB 4: BELUM DIABSEN -->
                                            <div class="tab-pane fade" id="contentBelum_{{ Str::slug($className) }}" role="tabpanel">
                                                <div class="table-responsive" style="max-height: 300px;">
                                                    <table class="table table-hover align-middle mb-0">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th style="width: 50px;">No</th>
                                                                <th>Nama Siswa & NIS</th>
                                                                <th class="text-end">Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($cData['unmarkedStudents'] as $uIdx => $uSiswa)
                                                                <tr>
                                                                    <td class="fw-bold text-muted">{{ $uIdx + 1 }}</td>
                                                                    <td>
                                                                        <div class="d-flex align-items-center gap-2">
                                                                            @if($uSiswa->foto)
                                                                                <img src="{{ asset('storage/'.$uSiswa->foto) }}" alt="Foto" class="rounded-circle object-fit-cover" style="width: 35px; height: 35px;">
                                                                            @else
                                                                                <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 35px; height: 35px;">
                                                                                    {{ strtoupper(substr($uSiswa->nama, 0, 1)) }}
                                                                                </div>
                                                                            @endif
                                                                            <div>
                                                                                <div class="fw-bold text-dark">{{ $uSiswa->nama }}</div>
                                                                                <small class="text-muted font-monospace">NIS: {{ $uSiswa->nis }}</small>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-end">
                                                                        @if($isAllowed)
                                                                            <a href="{{ route('absensi.index', ['kelas' => $className, 'tanggal' => $tanggal]) }}" class="btn btn-primary btn-sm fw-bold">
                                                                                <i class="bi bi-pencil-square me-1"></i> Absen
                                                                            </a>
                                                                        @else
                                                                            <span class="badge bg-secondary">Terkunci</span>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="3" class="text-center py-4 text-success fw-bold">
                                                                        <i class="bi bi-check-circle-fill me-1 fs-4 d-block mb-1"></i>
                                                                        Seluruh siswa kelas {{ $className }} sudah selesai diabsen!
                                                                    </td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer bg-light">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        @if($isAllowed)
                                            <a href="{{ route('absensi.index', ['kelas' => $className, 'tanggal' => $tanggal]) }}" class="btn btn-primary fw-bold">
                                                <i class="bi bi-pencil-square me-1"></i> Buka Form Absensi Kelas {{ $className }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- STUDENT DAILY ATTENDANCE TABLES (STRICTLY GROUPED BY CLASS) -->
    @forelse($siswasGroupedByKelas as $className => $classStudents)
        @php
            $isClassAllowed = $summaryPerKelas->get($className)['isAllowedForGuru'] ?? true;
        @endphp
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4">
            <div class="card-header bg-dark text-white py-3 border-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h5 class="mb-1 fw-bold text-white">
                        <i class="bi bi-building-fill text-warning me-2"></i>Daftar Presensi Kelas {{ $className }}
                    </h5>
                    <small class="text-white-50"><i class="bi bi-calendar-event me-1"></i>Tanggal: {{ $formattedIndoDate }}</small>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-warning text-dark font-monospace px-3 py-2 fs-6 shadow-sm">
                        Total {{ count($classStudents) }} Siswa
                    </span>
                    @if($isClassAllowed)
                        <a href="{{ route('absensi.index', ['kelas' => $className, 'tanggal' => $tanggal]) }}" class="btn btn-sm btn-outline-light fw-bold">
                            <i class="bi bi-pencil-square me-1"></i> Input/Edit Absensi
                        </a>
                    @else
                        <span class="badge bg-secondary text-white px-3 py-2 fs-6">
                            <i class="bi bi-lock-fill me-1"></i> Khusus Guru Pengampu
                        </span>
                    @endif
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4" style="width: 100px;" title="Nomor Absen berdasarkan NIS Terkecil di kelas ini">No. Absen</th>
                                <th>Nama Siswa & NIS</th>
                                <th style="width: 140px;">Kelas</th>
                                <th class="text-center" style="width: 160px;">Status Kehadiran</th>
                                <th>Alasan / Keterangan Izin/Sakit/Alpa</th>
                                <th class="pe-4 text-end" style="width: 170px;">Diabsen Oleh</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($classStudents as $cIndex => $item)
                                @php
                                    $absensi = $absensiRecords->get($item->id);
                                    $status = $absensi ? $absensi->status : 'Belum Diabsen';
                                @endphp
                                <tr>
                                    <td class="ps-4">
                                        <span class="badge bg-primary px-3 py-1.5 fs-6 shadow-sm" title="Absen #{{ $cIndex + 1 }} (NIS {{ $item->nis }})">
                                            #{{ $cIndex + 1 }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            @if($item->foto)
                                                <img src="{{ asset('storage/'.$item->foto) }}" alt="{{ $item->nama }}" class="rounded-circle object-fit-cover shadow-sm border" style="width: 38px; height: 38px;">
                                            @else
                                                <div class="bg-primary bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 38px; height: 38px;">
                                                    {{ strtoupper(substr($item->nama, 0, 1)) }}
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-bold text-dark fs-6">{{ $item->nama }}</div>
                                                <small class="text-muted font-monospace">NIS: {{ $item->nis }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2.5 py-1.5 fs-6">
                                            Kelas {{ $item->kelas }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if($status === 'Hadir')
                                            <span class="badge bg-success px-3 py-1.5 fs-6"><i class="bi bi-check-circle-fill me-1"></i>Hadir</span>
                                        @elseif($status === 'Izin')
                                            <span class="badge bg-warning text-dark px-3 py-1.5 fs-6"><i class="bi bi-clock-history me-1"></i>Izin</span>
                                        @elseif($status === 'Sakit')
                                            <span class="badge bg-info text-dark px-3 py-1.5 fs-6"><i class="bi bi-hospital-fill me-1"></i>Sakit</span>
                                        @elseif($status === 'Alpa')
                                            <span class="badge bg-danger px-3 py-1.5 fs-6"><i class="bi bi-x-circle-fill me-1"></i>Alpa</span>
                                        @else
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 px-3 py-1.5 fs-6"><i class="bi bi-question-circle me-1"></i>Belum Diabsen</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($absensi && $absensi->alasan)
                                            <span class="text-dark small fst-italic"><i class="bi bi-chat-left-quote-fill me-1 text-primary"></i>"{{ $absensi->alasan }}"</span>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td class="pe-4 text-end">
                                        @if($absensi && $absensi->guru)
                                            <small class="text-dark fw-semibold d-block"><i class="bi bi-person-fill text-primary me-1"></i>{{ $absensi->guru->nama }}</small>
                                        @else
                                            <small class="text-muted">-</small>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @empty
        <div class="card border-0 shadow-sm rounded-3 p-5 text-center text-muted mb-4">
            <i class="bi bi-search fs-1 d-block mb-2 text-secondary opacity-50"></i>
            Tidak ada data presensi siswa yang cocok dengan filter.
        </div>
    @endforelse

</div>
@endsection
