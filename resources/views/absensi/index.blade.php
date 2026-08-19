@extends('layouts.app')

@section('content')
<div class="container-fluid px-0" style="max-width: 1200px; margin: 0 auto;">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1">
                <i class="bi bi-clipboard-check-fill text-primary me-2"></i>Input Absensi Siswa
            </h2>
            <p class="text-muted mb-0">
                Pencatatan kehadiran siswa per kelas (Hadir, Izin, Sakit, Alpa) dan keterangan alasan secara langsung.
                @if(Auth::user()->isGuru())
                    <span class="text-primary fw-semibold"><i class="bi bi-shield-check me-1"></i>(Menampilkan khusus kelas yang Anda ampu & tugaskan)</span>
                @endif
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('absensi.harian') }}" class="btn btn-outline-secondary fw-bold shadow-sm">
                <i class="bi bi-shield-check me-1"></i> Monitoring Presensi Harian
            </a>
            <a href="{{ route('absensi.rekap', ['kelas' => $selectedKelas]) }}" class="btn btn-outline-primary fw-bold shadow-sm">
                <i class="bi bi-file-earmark-bar-graph me-1"></i> Rekap & Cetak PDF
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="bi bi-shield-x me-2 fs-5"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- All Classes Attendance Completed Banner -->
    @if(isset($isAllClassesDone) && $isAllClassesDone)
        <div class="alert alert-success border-start border-4 border-success shadow-sm mb-4 rounded-3 d-flex align-items-center gap-3">
            <div class="bg-success text-white p-2.5 rounded-circle fs-4 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                <i class="bi bi-check-all"></i>
            </div>
            <div>
                <strong class="d-block text-success fs-6">🎉 Seluruh Kelas di Sekolah Sudah Memiliki Data Absensi Hari Ini!</strong>
                <span class="small text-dark">Seluruh data presensi siswa tanggal <strong>{{ date('d/m/Y', strtotime($tanggal)) }}</strong> telah lengkap di-absen.</span>
            </div>
        </div>
    @elseif(isset($isMyClassesDone) && $isMyClassesDone)
        <div class="alert alert-success border-start border-4 border-success shadow-sm mb-4 rounded-3 d-flex align-items-center gap-3">
            <div class="bg-success text-white p-2.5 rounded-circle fs-4 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <div>
                <strong class="d-block text-success fs-6">✅ Seluruh Kelas Mengajar & Tugas Mendampingi Anda Sudah Selesai Di-absen Hari Ini!</strong>
                <span class="small text-dark">Presensi kelas Anda pada hari ini telah lengkap. Notifikasi absensi telah dibersihkan secara otomatis.</span>
            </div>
        </div>
    @endif

    <!-- Time-Aware Auto Active Class Schedule Banner for Guru -->
    @if(isset($activeJadwalInfo) && $activeJadwalInfo)
        <div class="alert alert-primary alert-dismissible fade show border-start border-4 border-primary shadow-sm mb-4 rounded-3" role="alert">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-primary text-white p-2.5 rounded-circle fs-4 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                    <i class="bi bi-clock-history"></i>
                </div>
                <div>
                    <strong class="d-block text-primary fs-6">⚡ Otomatis Terpilih Sesuai Jam Pelajaran Guru Hari Ini:</strong>
                    <span>Kelas <strong>{{ $selectedKelas }}</strong> (Jadwal: <strong>{{ date('H:i', strtotime($activeJadwalInfo->jam_mulai)) }} - {{ date('H:i', strtotime($activeJadwalInfo->jam_selesai)) }}</strong> | Mapel: <strong>{{ $activeJadwalInfo->mata_pelajaran }}</strong>). Anda tidak perlu repot berpindah kelas lagi!</span>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Class & Date Selector Card -->
    <div class="card border-0 shadow-sm mb-4 rounded-3">
        <div class="card-body p-3">
            <form action="{{ route('absensi.index') }}" method="GET" class="row g-3 align-items-center">
                <div class="col-md-5">
                    <label for="kelas_select" class="form-label fw-bold small text-muted mb-1"><i class="bi bi-building me-1 text-primary"></i>Pilih Kelas Siswa</label>
                    <select name="kelas" id="kelas_select" class="form-select fw-bold" onchange="this.form.submit()">
                        @if(count($kelas) == 0)
                            <option value="">-- Anda Belum Memiliki Jadwal Kelas --</option>
                        @endif
                        @if(count($kelasX) > 0)
                            <optgroup label="🏫 Tingkat X (Kelas 10)">
                                @foreach($kelasX as $k)
                                    <option value="{{ $k->nama_kelas }}" {{ $selectedKelas == $k->nama_kelas ? 'selected' : '' }}>
                                        Kelas: {{ $k->nama_kelas }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endif
                        @if(count($kelasXI) > 0)
                            <optgroup label="🏫 Tingkat XI (Kelas 11)">
                                @foreach($kelasXI as $k)
                                    <option value="{{ $k->nama_kelas }}" {{ $selectedKelas == $k->nama_kelas ? 'selected' : '' }}>
                                        Kelas: {{ $k->nama_kelas }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endif
                        @if(count($kelasXII) > 0)
                            <optgroup label="🏫 Tingkat XII (Kelas 12)">
                                @foreach($kelasXII as $k)
                                    <option value="{{ $k->nama_kelas }}" {{ $selectedKelas == $k->nama_kelas ? 'selected' : '' }}>
                                        Kelas: {{ $k->nama_kelas }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endif
                        @if(count($kelasOther) > 0)
                            <optgroup label="🏫 Kelas Lainnya">
                                @foreach($kelasOther as $k)
                                    <option value="{{ $k->nama_kelas }}" {{ $selectedKelas == $k->nama_kelas ? 'selected' : '' }}>
                                        Kelas: {{ $k->nama_kelas }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endif
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="tanggal_select" class="form-label fw-bold small text-muted mb-1"><i class="bi bi-calendar-event me-1 text-warning"></i>Tanggal Absensi Hari Ini</label>
                    <input type="date" name="tanggal" id="tanggal_select" class="form-control fw-bold" value="{{ $tanggal }}" onchange="this.form.submit()">
                </div>
                <div class="col-md-3 text-md-end pt-md-4">
                    <button type="button" class="btn btn-outline-success fw-bold w-100 py-2 shadow-sm" onclick="setSemuaHadir()">
                        <i class="bi bi-check-all me-1 fs-5"></i> Set Semua HADIR
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Attendance Entry Form & Table -->
    @if(count($siswas) > 0)
        @php
            $ts = strtotime($tanggal);
            $daysMap = ['Monday'=>'Senin','Tuesday'=>'Selasa','Wednesday'=>'Rabu','Thursday'=>'Kamis','Friday'=>'Jumat','Saturday'=>'Sabtu','Sunday'=>'Minggu'];
            $monthsMap = ['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];
            $formattedIndoDate = ($daysMap[date('l', $ts)] ?? date('l', $ts)) . ', ' . date('d', $ts) . ' ' . ($monthsMap[date('m', $ts)] ?? date('F', $ts)) . ' ' . date('Y', $ts);
        @endphp

        <form action="{{ route('absensi.store') }}" method="POST">
            @csrf
            <input type="hidden" name="kelas" value="{{ $selectedKelas }}">
            <input type="hidden" name="tanggal" value="{{ $tanggal }}">

            <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4">
                <div class="card-header bg-dark text-white py-3 border-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h5 class="mb-1 fw-bold text-white">
                            <i class="bi bi-people-fill text-warning me-2"></i>Form Presensi Siswa Kelas {{ $selectedKelas }}
                        </h5>
                        <small class="text-white-50">
                            <i class="bi bi-calendar-event me-1"></i>Tanggal: {{ $formattedIndoDate }}
                        </small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        @if($existingAbsensi->count() == 0)
                            <span class="badge bg-success px-3 py-2 fs-6 shadow-sm">
                                <i class="bi bi-stars me-1"></i>Presensi Baru Hari Ini (Mengulang dari 0)
                            </span>
                        @else
                            <span class="badge bg-info text-dark px-3 py-2 fs-6 shadow-sm">
                                <i class="bi bi-check-circle-fill me-1"></i>Telah Diisi Hari Ini ({{ $existingAbsensi->count() }} Siswa)
                            </span>
                        @endif
                        <span class="badge bg-warning text-dark fw-bold px-3 py-2 fs-6 shadow-sm">
                            Total {{ count($siswas) }} Siswa
                        </span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4" style="width: 100px;" title="Nomor Absen berdasarkan urutan NIS Terkecil di kelas ini">No. Absen</th>
                                    <th style="width: 260px;">Nama Siswa & NIS</th>
                                    <th class="text-center" style="width: 380px;">Status Kehadiran Hari Ini</th>
                                    <th class="pe-4">Alasan / Keterangan Izin/Sakit/Alpa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($siswas as $idx => $s)
                                    @php
                                        $ex = $existingAbsensi->get($s->id);
                                        $currentStatus = $ex ? $ex->status : 'Hadir';
                                        $currentAlasan = $ex ? $ex->alasan : '';
                                    @endphp
                                    <tr>
                                        <td class="ps-4">
                                            <span class="badge bg-primary px-3 py-1.5 fs-6 shadow-sm" title="Absen #{{ $idx + 1 }} (NIS {{ $s->nis }})">
                                                #{{ $idx + 1 }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                @if($s->foto)
                                                    <img src="{{ asset('storage/'.$s->foto) }}" alt="{{ $s->nama }}" class="rounded-circle object-fit-cover shadow-sm border" style="width: 40px; height: 40px;">
                                                @else
                                                    <div class="bg-primary bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 40px; height: 40px;">
                                                        {{ strtoupper(substr($s->nama, 0, 1)) }}
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="fw-bold text-dark mb-0 fs-6">{{ $s->nama }}</div>
                                                    <small class="text-muted font-monospace">NIS: {{ $s->nis }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-group w-100" role="group" aria-label="Status Absensi {{ $s->id }}">
                                                <!-- Hadir -->
                                                <input type="radio" class="btn-check radio-status-hadir" name="absensi[{{ $s->id }}][status]" id="hadir_{{ $s->id }}" value="Hadir" {{ $currentStatus === 'Hadir' ? 'checked' : '' }} autocomplete="off">
                                                <label class="btn btn-outline-success fw-bold py-2" for="hadir_{{ $s->id }}">
                                                    <i class="bi bi-check-circle me-1"></i> Hadir
                                                </label>

                                                <!-- Izin -->
                                                <input type="radio" class="btn-check" name="absensi[{{ $s->id }}][status]" id="izin_{{ $s->id }}" value="Izin" {{ $currentStatus === 'Izin' ? 'checked' : '' }} autocomplete="off">
                                                <label class="btn btn-outline-warning fw-bold text-dark py-2" for="izin_{{ $s->id }}">
                                                    <i class="bi bi-envelope me-1"></i> Izin
                                                </label>

                                                <!-- Sakit -->
                                                <input type="radio" class="btn-check" name="absensi[{{ $s->id }}][status]" id="sakit_{{ $s->id }}" value="Sakit" {{ $currentStatus === 'Sakit' ? 'checked' : '' }} autocomplete="off">
                                                <label class="btn btn-outline-info fw-bold text-dark py-2" for="sakit_{{ $s->id }}">
                                                    <i class="bi bi-hospital me-1"></i> Sakit
                                                </label>

                                                <!-- Alpa -->
                                                <input type="radio" class="btn-check" name="absensi[{{ $s->id }}][status]" id="alpa_{{ $s->id }}" value="Alpa" {{ $currentStatus === 'Alpa' ? 'checked' : '' }} autocomplete="off">
                                                <label class="btn btn-outline-danger fw-bold py-2" for="alpa_{{ $s->id }}">
                                                    <i class="bi bi-x-circle me-1"></i> Alpa
                                                </label>
                                            </div>
                                        </td>
                                        <td class="pe-4">
                                            <input type="text" name="absensi[{{ $s->id }}][alasan]" class="form-control form-control-sm input-alasan" value="{{ $currentAlasan }}" placeholder="Tulis alasan jika Izin / Sakit / Alpa...">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-light p-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <small class="text-muted"><i class="bi bi-info-circle me-1"></i>Tekan tombol simpan untuk memperbarui presensi kehadiran siswa kelas ini.</small>
                    <button type="submit" class="btn btn-primary fw-bold px-4 py-2 shadow-sm">
                        <i class="bi bi-save-fill me-1"></i> Simpan Presensi Absensi
                    </button>
                </div>
            </div>
        </form>
    @else
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body py-5 text-center text-muted">
                <i class="bi bi-people fs-1 text-secondary opacity-50 d-block mb-2"></i>
                <h5 class="fw-bold text-dark mb-1">Belum Ada Siswa di Kelas Ini</h5>
                <p class="small text-secondary mb-0">Silakan pilih kelas lain atau tambahkan data siswa terlebih dahulu.</p>
            </div>
        </div>
    @endif
</div>

<script>
    function setSemuaHadir() {
        const hadirRadios = document.querySelectorAll('.radio-status-hadir');
        hadirRadios.forEach(radio => {
            radio.checked = true;
        });
    }
</script>
@endsection
