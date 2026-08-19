@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    <!-- Success or Error Alerts -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4 shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Hero Header Banner -->
    <div class="card border-0 shadow-sm bg-gradient bg-primary text-white mb-4 rounded-3">
        <div class="card-body p-4 p-lg-5 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <span class="badge bg-white text-primary fw-bold px-3 py-1 mb-2">PORTAL TUGAS SISWA</span>
                <h2 class="fw-bold text-white mb-1">
                    <i class="bi bi-file-earmark-text-fill me-2"></i>Tugas Sekolah Kelas {{ $siswa->kelas }}
                </h2>
                <p class="mb-0 text-white-50">
                    Daftar tugas sekolah untuk kelas Anda. Selesaikan &amp; kumpulkan jawaban tepat waktu sebelum deadline.
                </p>
            </div>
            <div class="text-end bg-white bg-opacity-10 p-3 rounded-3 border border-white border-opacity-25">
                <small class="text-white-50 d-block mb-1"><i class="bi bi-person-circle me-1"></i> Siswa Aktif</small>
                <h5 class="fw-bold text-white mb-0">{{ $siswa->nama }}</h5>
                <small class="text-white-50">NIS: {{ $siswa->nis }} | Kelas: {{ $siswa->kelas }}</small>
            </div>
        </div>
    </div>

    @php
        $completedTasks = $tugas->filter(function($t) use ($submissions) {
            $sub = $submissions->get($t->id) ?? $submissions->firstWhere('tugas_id', $t->id);
            return $sub && ($sub->file_path !== null || $sub->catatan !== null);
        });
        $pendingTasks = $tugas->reject(function($t) use ($submissions) {
            $sub = $submissions->get($t->id) ?? $submissions->firstWhere('tugas_id', $t->id);
            return $sub && ($sub->file_path !== null || $sub->catatan !== null);
        });

        $totalTugasSiswa = $tugas->count();
        $completedCount = $completedTasks->count();
        $pendingCount = $pendingTasks->count();
        $overdueCount = $pendingTasks->filter(fn($t) => \Carbon\Carbon::parse($t->deadline)->isPast())->count();
        $urgentCount = $pendingTasks->filter(function($t) {
            $d = \Carbon\Carbon::parse($t->deadline);
            return !$d->isPast() && $d->diffInHours(now()) <= 24;
        })->count();

        $pastTasksCount = isset($tugasKelasLalu) ? $tugasKelasLalu->count() : 0;
    @endphp

    <!-- NOTIFICATION ALERTS BANNER FOR STUDENT -->
    @if($pendingCount > 0 || $overdueCount > 0)
        <div class="row g-3 mb-4">
            @if($pendingCount > 0)
                <div class="col-md-{{ $overdueCount > 0 || $urgentCount > 0 ? '6' : '12' }}">
                    <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center mb-0 p-3 rounded-3 border-start border-5 border-warning">
                        <div class="bg-warning text-dark p-3 rounded-circle me-3">
                            <i class="bi bi-bell-fill fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-1">🔔 Notifikasi Tugas Belum Dikumpulkan ({{ $pendingCount }} Tugas)</h6>
                            <p class="mb-0 small text-secondary">
                                Anda memiliki <strong>{{ $pendingCount }} tugas</strong> di Kelas {{ $siswa->kelas }} yang belum dikumpulkan. Cek tab di bawah dan segera selesaikan.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            @if($overdueCount > 0 || $urgentCount > 0)
                <div class="col-md-{{ $pendingCount > 0 ? '6' : '12' }}">
                    <div class="alert alert-danger border-0 shadow-sm d-flex align-items-center mb-0 p-3 rounded-3 border-start border-5 border-danger">
                        <div class="bg-danger text-white p-3 rounded-circle me-3">
                            <i class="bi bi-alarm-fill fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-1">⏰ Peringatan Batas Waktu Deadline!</h6>
                            <p class="mb-0 small text-secondary">
                                @if($overdueCount > 0)
                                    Ada <strong class="text-danger">{{ $overdueCount }} tugas lewat deadline</strong>.
                                @endif
                                @if($urgentCount > 0)
                                    Ada <strong class="text-warning">{{ $urgentCount }} tugas mendekati deadline (&lt; 24 Jam)</strong>.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endif

    <!-- Task Statistics Summary Cards -->
    <div class="col-12 mb-4">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3">
            <div class="col">
                <div class="card border-0 shadow-sm p-3 border-start border-4 border-primary">
                    <small class="text-muted fw-bold text-uppercase d-block mb-1">Tugas Kelas {{ $siswa->kelas }}</small>
                    <h3 class="fw-bold text-dark mb-0">{{ $totalTugasSiswa }}</h3>
                </div>
            </div>
            <div class="col">
                <div class="card border-0 shadow-sm p-3 border-start border-4 border-warning">
                    <small class="text-muted fw-bold text-uppercase d-block mb-1">Belum Dikumpulkan</small>
                    <h3 class="fw-bold text-warning mb-0">{{ $pendingCount }}</h3>
                </div>
            </div>
            <div class="col">
                <div class="card border-0 shadow-sm p-3 border-start border-4 border-success">
                    <small class="text-muted fw-bold text-uppercase d-block mb-1">Sudah Dikumpulkan</small>
                    <h3 class="fw-bold text-success mb-0">{{ $completedCount }}</h3>
                </div>
            </div>
            <div class="col">
                <div class="card border-0 shadow-sm p-3 border-start border-4 border-info">
                    <small class="text-muted fw-bold text-uppercase d-block mb-1">Arsip Kelas Sebelumnya</small>
                    <h3 class="fw-bold text-info mb-0">{{ $pastTasksCount }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Nav Buttons (Simple, Robust, Guaranteed No Blank Space) -->
    <div class="col-12 mb-4">
        <div class="bg-white p-2 rounded-3 shadow-sm border d-flex gap-2 flex-wrap" id="tugasTabNav">
            <button type="button" class="btn btn-primary fw-bold px-4 py-2 rounded-3 tugas-tab-btn active" data-target="all-tasks">
                <i class="bi bi-collection-fill me-1"></i> Semua Tugas ({{ $totalTugasSiswa }})
            </button>
            <button type="button" class="btn btn-outline-warning text-dark fw-bold px-4 py-2 rounded-3 tugas-tab-btn" data-target="pending-tasks">
                <i class="bi bi-clock-history me-1"></i> Belum Dikumpulkan ({{ $pendingCount }})
            </button>
            <button type="button" class="btn btn-outline-success fw-bold px-4 py-2 rounded-3 tugas-tab-btn" data-target="completed-tasks">
                <i class="bi bi-check-circle-fill me-1"></i> Sudah Dikumpulkan ({{ $completedCount }})
            </button>
            <button type="button" class="btn btn-outline-secondary fw-bold px-4 py-2 rounded-3 tugas-tab-btn" data-target="past-tasks">
                <i class="bi bi-journal-bookmark-fill me-1 text-primary"></i> Tugas Kelas Sebelumnya ({{ $pastTasksCount }})
            </button>
        </div>
    </div>

    <!-- Tab Contents Containers -->
    <div class="col-12">
        
        <!-- Tab 1: Semua Tugas -->
        <div class="tugas-tab-pane" id="all-tasks">
            <div class="row row-cols-1 row-cols-md-2 g-4">
                @forelse($tugas as $item)
                    @php 
                        $sub = $submissions->get($item->id) ?? $submissions->firstWhere('tugas_id', $item->id);
                        $hasSubmittedWork = $sub && ($sub->file_path !== null || $sub->catatan !== null);
                        $isPastDeadline = \Carbon\Carbon::parse($item->deadline)->isPast();
                        $lateStatus = $sub?->status_izin_terlambat;
                    @endphp
                    <div class="col">
                        <div class="card border-0 shadow-sm border-start border-4 {{ $hasSubmittedWork ? 'border-success' : ($isPastDeadline ? 'border-danger' : 'border-primary') }}">
                            <div class="card-body p-4 d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <span class="badge bg-primary mb-2 fs-6">{{ $item->mata_pelajaran ?? 'Mata Pelajaran' }}</span>
                                        <h4 class="fw-bold text-dark mb-1">{{ $item->judul }}</h4>
                                    </div>
                                    @if($hasSubmittedWork)
                                        <span class="badge bg-success px-3 py-2 fs-6"><i class="bi bi-check-circle-fill me-1"></i>Selesai</span>
                                    @elseif($lateStatus === 'Pending')
                                        <span class="badge bg-warning text-dark px-3 py-2 fs-6"><i class="bi bi-clock-history me-1"></i>Menunggu ACC Guru</span>
                                    @elseif($lateStatus === 'Disetujui')
                                        <span class="badge bg-info text-dark px-3 py-2 fs-6"><i class="bi bi-check2-circle me-1"></i>Izin Terlambat ACC</span>
                                    @elseif($isPastDeadline)
                                        <span class="badge bg-danger px-3 py-2 fs-6"><i class="bi bi-exclamation-circle-fill me-1"></i>Lewat Deadline</span>
                                    @else
                                        <span class="badge bg-primary px-3 py-2 fs-6"><i class="bi bi-clock me-1"></i>Aktif</span>
                                    @endif
                                </div>

                                <p class="text-secondary small mb-3">{{ $item->deskripsi }}</p>

                                @if($item->foto)
                                    <div class="mb-3">
                                        <small class="text-muted d-block fw-bold mb-1"><i class="bi bi-image me-1"></i>Lampiran Gambar Tugas:</small>
                                        <a href="{{ asset('storage/'.$item->foto) }}" target="_blank">
                                            <img src="{{ asset('storage/'.$item->foto) }}" alt="Lampiran {{ $item->judul }}" class="img-thumbnail rounded" style="max-height: 160px; object-fit: cover;">
                                        </a>
                                    </div>
                                @endif

                                @if($item->guru)
                                    <div class="small text-muted mb-3">
                                        <i class="bi bi-person-fill text-primary me-1"></i>Guru Pengajar: <strong>{{ $item->guru->nama }}</strong>
                                    </div>
                                @endif

                                <!-- Submitted Answer & Grade Section -->
                                @if($hasSubmittedWork)
                                    <div class="bg-light p-3 rounded mb-3 border">
                                        <small class="text-muted d-block fw-bold mb-1"><i class="bi bi-chat-left-text-fill me-1 text-success"></i>Jawaban Anda:</small>
                                        <p class="mb-2 text-dark small">{{ $sub->catatan ?? '-' }}</p>
                                        @if($sub->file_path)
                                            <a href="{{ asset('storage/'.$sub->file_path) }}" class="btn btn-outline-primary btn-sm px-3 mb-2" target="_blank">
                                                <i class="bi bi-download me-1"></i> Unduh Berkas Jawaban
                                            </a>
                                        @endif
                                        <div class="text-muted small mb-2">
                                            Dikumpulkan pada: {{ \App\Helpers\WaktuHelper::format($sub->dikumpulkan_pada) }}
                                        </div>

                                        <!-- DISPLAY GRADE & TEACHER RESPONSE FOR STUDENT -->
                                        @if($sub->nilai !== null)
                                            <div class="alert alert-success border border-success border-opacity-25 shadow-sm rounded-3 mt-2 p-3 mb-0">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span class="fw-bold text-success"><i class="bi bi-star-fill me-1 text-warning"></i> Nilai Tugas Guru:</span>
                                                    <span class="badge bg-success fs-5 px-3 py-1">⭐ {{ $sub->nilai }} / 100</span>
                                                </div>
                                                @if($sub->respon_guru)
                                                    <div class="pt-2 border-top border-success border-opacity-25">
                                                        <small class="fw-bold text-dark d-block mb-1"><i class="bi bi-chat-left-quote-fill me-1 text-primary"></i> Respon &amp; Catatan Guru:</small>
                                                        <p class="mb-0 text-dark small fst-italic">"{{ $sub->respon_guru }}"</p>
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                            <div class="alert alert-warning border-0 shadow-sm mt-2 p-2 text-center mb-0">
                                                <small class="fw-bold text-dark"><i class="bi bi-clock-history me-1"></i> Tugas telah dikumpulkan &amp; menunggu penilaian guru</small>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                <!-- Late Permission Status Notifications -->
                                @if(!$hasSubmittedWork && $isPastDeadline)
                                    @if($lateStatus === 'Pending')
                                        <div class="p-3 bg-warning bg-opacity-10 border border-warning rounded-3 mb-3">
                                            <small class="fw-bold text-warning-emphasis d-block mb-1"><i class="bi bi-hourglass-split me-1"></i>Permohonan Izin Terlambat Terkirim</small>
                                            <p class="small text-secondary mb-1">Alasan: "{{ $sub->alasan_terlambat }}"</p>
                                            <span class="badge bg-warning text-dark small">Menunggu Persetujuan Guru</span>
                                        </div>
                                    @elseif($lateStatus === 'Disetujui')
                                        <div class="p-3 bg-success bg-opacity-10 border border-success rounded-3 mb-3">
                                            <small class="fw-bold text-success d-block mb-1"><i class="bi bi-check-circle-fill me-1"></i>Izin Terlambat Disetujui Guru!</small>
                                            <p class="small text-secondary mb-0">Guru telah memberikan persetujuan. Anda kini dapat mengumpulkan tugas di bawah ini.</p>
                                        </div>
                                    @elseif($lateStatus === 'Ditolak')
                                        <div class="p-3 bg-danger bg-opacity-10 border border-danger rounded-3 mb-3">
                                            <small class="fw-bold text-danger d-block mb-1"><i class="bi bi-x-circle-fill me-1"></i>Permohonan Terlambat Ditolak Guru</small>
                                            <p class="small text-secondary mb-0">Maaf, guru pengajar menolak permohonan izin kumpul terlambat untuk tugas ini.</p>
                                        </div>
                                    @endif
                                @endif

                                <div class="mt-3">
                                    <div class="border-top pt-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                                        <span class="{{ $isPastDeadline && !$hasSubmittedWork ? 'text-danger' : 'text-primary' }} small fw-bold">
                                            <i class="bi bi-calendar-event me-1"></i>Deadline: {{ \App\Helpers\WaktuHelper::format($item->deadline) }}
                                        </span>

                                        @if(!$hasSubmittedWork)
                                            @if(!$isPastDeadline || $lateStatus === 'Disetujui')
                                                <button class="btn btn-primary btn-sm px-4 fw-bold shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#submitFormSiswaAll_{{ $item->id }}" aria-expanded="false" aria-controls="submitFormSiswaAll_{{ $item->id }}">
                                                    <i class="bi bi-send-fill me-1"></i> Kumpulkan Tugas
                                                </button>
                                            @elseif($isPastDeadline && !$lateStatus)
                                                <button class="btn btn-warning text-dark btn-sm px-3 fw-bold shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#requestLateFormSiswaAll_{{ $item->id }}" aria-expanded="false" aria-controls="requestLateFormSiswaAll_{{ $item->id }}">
                                                    <i class="bi bi-hand-index-thumb me-1"></i> Minta Izin Terlambat
                                                </button>
                                            @endif
                                        @endif
                                    </div>

                                    <!-- Form 1: Normal / Approved Submission -->
                                    @if(!$hasSubmittedWork && (!$isPastDeadline || $lateStatus === 'Disetujui'))
                                        <div class="collapse mt-3" id="submitFormSiswaAll_{{ $item->id }}">
                                            <form action="{{ route('siswa.tugas.submit', $item->id) }}" method="POST" enctype="multipart/form-data" class="p-3 bg-light rounded border">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="catatan_sa_{{ $item->id }}" class="form-label fw-bold small">Catatan Jawaban (Teks)</label>
                                                    <textarea name="catatan" id="catatan_sa_{{ $item->id }}" class="form-control form-control-sm" rows="3" placeholder="Tulis catatan atau jawaban tugas Anda..."></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="file_sa_{{ $item->id }}" class="form-label fw-bold small">Unggah Berkas (PDF, DOC, ZIP, Foto - Max 5MB)</label>
                                                    <input type="file" name="file" id="file_sa_{{ $item->id }}" class="form-control form-control-sm">
                                                </div>
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-success btn-sm fw-bold"><i class="bi bi-check-circle-fill me-1"></i> Kirim Tugas Sekarang</button>
                                                </div>
                                            </form>
                                        </div>
                                    @endif

                                    <!-- Form 2: Late Permission Request -->
                                    @if(!$hasSubmittedWork && $isPastDeadline && !$lateStatus)
                                        <div class="collapse mt-3" id="requestLateFormSiswaAll_{{ $item->id }}">
                                            <form action="{{ route('siswa.tugas.request-late', $item->id) }}" method="POST" class="p-3 bg-warning bg-opacity-10 border border-warning rounded">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="alasan_sa_{{ $item->id }}" class="form-label fw-bold small text-dark"><i class="bi bi-chat-left-dots-fill text-warning me-1"></i>Alasan Pengumpulkan Terlambat</label>
                                                    <textarea name="alasan_terlambat" id="alasan_sa_{{ $item->id }}" class="form-control form-control-sm" rows="2" placeholder="Jelaskan alasan kendala Anda kenapa terlambat mengumpulkan..." required></textarea>
                                                </div>
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-warning text-dark btn-sm fw-bold"><i class="bi bi-paperplane-fill me-1"></i> Kirim Permohonan Izin ke Guru</button>
                                                </div>
                                            </form>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="card border-0 shadow-sm p-5 text-center text-muted">
                            <i class="bi bi-clipboard-x fs-1 text-secondary mb-2 d-block"></i>
                            Belum ada tugas sekolah yang diberikan untuk Kelas {{ $siswa->kelas }}.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Tab 2: Belum Dikumpulkan -->
        <div class="tugas-tab-pane d-none" id="pending-tasks">
            <div class="row row-cols-1 row-cols-md-2 g-4">
                @forelse($pendingTasks as $item)
                    @php 
                        $sub = $submissions->get($item->id) ?? $submissions->firstWhere('tugas_id', $item->id);
                        $isPastDeadline = \Carbon\Carbon::parse($item->deadline)->isPast();
                        $lateStatus = $sub?->status_izin_terlambat;
                    @endphp
                    <div class="col">
                        <div class="card border-0 shadow-sm border-start border-4 border-warning">
                            <div class="card-body p-4 d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <span class="badge bg-primary mb-2 fs-6">{{ $item->mata_pelajaran ?? 'Mata Pelajaran' }}</span>
                                        <h4 class="fw-bold text-dark mb-1">{{ $item->judul }}</h4>
                                    </div>
                                    <span class="badge bg-warning text-dark px-3 py-2 fs-6"><i class="bi bi-clock-history me-1"></i>Belum Dikumpulkan</span>
                                </div>
                                <p class="text-secondary small mb-3">{{ $item->deskripsi }}</p>

                                @if($item->foto)
                                    <div class="mb-3">
                                        <a href="{{ asset('storage/'.$item->foto) }}" target="_blank">
                                            <img src="{{ asset('storage/'.$item->foto) }}" alt="Lampiran" class="img-thumbnail rounded" style="max-height: 150px;">
                                        </a>
                                    </div>
                                @endif

                                @if($item->guru)
                                    <div class="small text-muted mb-3">
                                        <i class="bi bi-person-fill text-primary me-1"></i>Guru Pengajar: <strong>{{ $item->guru->nama }}</strong>
                                    </div>
                                @endif

                                @if($isPastDeadline)
                                    @if($lateStatus === 'Pending')
                                        <div class="p-3 bg-warning bg-opacity-10 border border-warning rounded-3 mb-3">
                                            <small class="fw-bold text-warning-emphasis d-block mb-1"><i class="bi bi-hourglass-split me-1"></i>Permohonan Terlambat Terkirim</small>
                                            <p class="small text-secondary mb-0">Alasan: "{{ $sub->alasan_terlambat }}" (Menunggu ACC Guru)</p>
                                        </div>
                                    @elseif($lateStatus === 'Disetujui')
                                        <div class="p-3 bg-success bg-opacity-10 border border-success rounded-3 mb-3">
                                            <small class="fw-bold text-success d-block mb-0"><i class="bi bi-check-circle-fill me-1"></i>Izin Terlambat Disetujui Guru! Anda dapat mengumpulkan sekarang.</small>
                                        </div>
                                    @elseif($lateStatus === 'Ditolak')
                                        <div class="p-3 bg-danger bg-opacity-10 border border-danger rounded-3 mb-3">
                                            <small class="fw-bold text-danger d-block mb-0"><i class="bi bi-x-circle-fill me-1"></i>Permohonan Izin Terlambat Ditolak Guru.</small>
                                        </div>
                                    @endif
                                @endif

                                <div class="mt-3">
                                    <div class="border-top pt-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                                        <span class="text-danger small fw-bold">
                                            <i class="bi bi-calendar-event me-1"></i>Deadline: {{ \App\Helpers\WaktuHelper::format($item->deadline) }}
                                        </span>

                                        @if(!$isPastDeadline || $lateStatus === 'Disetujui')
                                            <button class="btn btn-primary btn-sm px-4 fw-bold shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#submitFormSiswaPending_{{ $item->id }}" aria-expanded="false" aria-controls="submitFormSiswaPending_{{ $item->id }}">
                                                <i class="bi bi-send-fill me-1"></i> Kumpulkan
                                            </button>
                                        @elseif($isPastDeadline && !$lateStatus)
                                            <button class="btn btn-warning text-dark btn-sm px-3 fw-bold shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#requestLateFormSiswaPending_{{ $item->id }}" aria-expanded="false" aria-controls="requestLateFormSiswaPending_{{ $item->id }}">
                                                <i class="bi bi-hand-index-thumb me-1"></i> Minta Izin Terlambat
                                            </button>
                                        @endif
                                    </div>

                                    @if(!$isPastDeadline || $lateStatus === 'Disetujui')
                                        <div class="collapse mt-3" id="submitFormSiswaPending_{{ $item->id }}">
                                            <form action="{{ route('siswa.tugas.submit', $item->id) }}" method="POST" enctype="multipart/form-data" class="p-3 bg-light rounded border">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="catatan_sp_{{ $item->id }}" class="form-label fw-bold small">Catatan Jawaban</label>
                                                    <textarea name="catatan" id="catatan_sp_{{ $item->id }}" class="form-control form-control-sm" rows="2" placeholder="Catatan jawaban..."></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="file_sp_{{ $item->id }}" class="form-label fw-bold small">Unggah Berkas (Max 5MB)</label>
                                                    <input type="file" name="file" id="file_sp_{{ $item->id }}" class="form-control form-control-sm">
                                                </div>
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-success btn-sm fw-bold"><i class="bi bi-check-circle-fill me-1"></i> Kirim Jawaban</button>
                                                </div>
                                            </form>
                                        </div>
                                    @endif

                                    @if($isPastDeadline && !$lateStatus)
                                        <div class="collapse mt-3" id="requestLateFormSiswaPending_{{ $item->id }}">
                                            <form action="{{ route('siswa.tugas.request-late', $item->id) }}" method="POST" class="p-3 bg-warning bg-opacity-10 border border-warning rounded">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="alasan_sp_{{ $item->id }}" class="form-label fw-bold small text-dark">Alasan Terlambat Mengumpulkan</label>
                                                    <textarea name="alasan_terlambat" id="alasan_sp_{{ $item->id }}" class="form-control form-control-sm" rows="2" placeholder="Jelaskan alasan kendala Anda..." required></textarea>
                                                </div>
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-warning text-dark btn-sm fw-bold"><i class="bi bi-paperplane-fill me-1"></i> Kirim Permohonan Izin</button>
                                                </div>
                                            </form>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="card border-0 shadow-sm p-5 text-center text-muted">
                            <i class="bi bi-emoji-smile fs-1 text-success mb-2 d-block"></i>
                            🎉 Hore! Semua tugas sekolah untuk Kelas {{ $siswa->kelas }} telah selesai dikumpulkan!
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Tab 3: Sudah Dikumpulkan -->
        <div class="tugas-tab-pane d-none" id="completed-tasks">
            <div class="row row-cols-1 row-cols-md-2 g-4">
                @forelse($completedTasks as $item)
                    @php $sub = $submissions->get($item->id) ?? $submissions->firstWhere('tugas_id', $item->id); @endphp
                    <div class="col">
                        <div class="card border-0 shadow-sm border-start border-4 border-success">
                            <div class="card-body p-4 d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <span class="badge bg-primary mb-2 fs-6">{{ $item->mata_pelajaran ?? 'Mata Pelajaran' }}</span>
                                        <h4 class="fw-bold text-dark mb-1">{{ $item->judul }}</h4>
                                    </div>
                                    <span class="badge bg-success px-3 py-2 fs-6"><i class="bi bi-check-circle-fill me-1"></i>Selesai</span>
                                </div>
                                <p class="text-secondary small mb-3">{{ $item->deskripsi }}</p>

                                @if($item->guru)
                                    <div class="small text-muted mb-3">
                                        <i class="bi bi-person-fill text-primary me-1"></i>Guru Pengajar: <strong>{{ $item->guru->nama }}</strong>
                                    </div>
                                @endif

                                <div class="bg-light p-3 rounded mb-3 border">
                                    <small class="text-muted d-block fw-bold mb-1"><i class="bi bi-chat-left-text-fill me-1 text-success"></i>Jawaban Anda:</small>
                                    <p class="mb-2 text-dark small">{{ $sub->catatan ?? '-' }}</p>
                                    @if($sub && $sub->file_path)
                                        <a href="{{ asset('storage/'.$sub->file_path) }}" class="btn btn-outline-primary btn-sm px-3 mb-2" target="_blank">
                                            <i class="bi bi-download me-1"></i> Unduh Berkas Jawaban
                                        </a>
                                    @endif
                                    @if($sub)
                                        <div class="text-muted small mb-2">
                                            Dikumpulkan pada: {{ \App\Helpers\WaktuHelper::format($sub->dikumpulkan_pada) }}
                                        </div>
                                    @endif

                                    <!-- Teacher Grade & Response -->
                                    @if($sub && $sub->nilai !== null)
                                        <div class="alert alert-success border border-success border-opacity-25 shadow-sm rounded-3 mt-2 p-3 mb-0">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span class="fw-bold text-success"><i class="bi bi-star-fill me-1 text-warning"></i> Nilai Tugas Guru:</span>
                                                <span class="badge bg-success fs-5 px-3 py-1">⭐ {{ $sub->nilai }} / 100</span>
                                            </div>
                                            @if($sub->respon_guru)
                                                <div class="pt-2 border-top border-success border-opacity-25">
                                                    <small class="fw-bold text-dark d-block mb-1"><i class="bi bi-chat-left-quote-fill me-1 text-primary"></i> Respon &amp; Catatan Guru:</small>
                                                    <p class="mb-0 text-dark small fst-italic">"{{ $sub->respon_guru }}"</p>
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <div class="alert alert-warning border-0 shadow-sm mt-2 p-2 text-center mb-0">
                                            <small class="fw-bold text-dark"><i class="bi bi-clock-history me-1"></i> Tugas telah dikumpulkan &amp; menunggu penilaian guru</small>
                                        </div>
                                    @endif
                                </div>

                                <div class="mt-3 border-top pt-3">
                                    <span class="text-primary small fw-bold">
                                        <i class="bi bi-calendar-event me-1"></i>Deadline: {{ \App\Helpers\WaktuHelper::format($item->deadline) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="card border-0 shadow-sm p-5 text-center text-muted">
                            <i class="bi bi-card-text fs-1 text-secondary mb-2 d-block"></i>
                            Belum ada tugas yang selesai dikumpulkan.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Tab 4: Tugas Kelas Sebelumnya (Riwayat Tugas Kelas Lalu) -->
        <div class="tugas-tab-pane d-none" id="past-tasks">
            <div class="row row-cols-1 row-cols-md-2 g-4">
                @if(isset($tugasKelasLalu) && count($tugasKelasLalu) > 0)
                    @foreach($tugasKelasLalu as $item)
                        @php $sub = $submissions->get($item->id) ?? $submissions->firstWhere('tugas_id', $item->id); @endphp
                        <div class="col">
                            <div class="card border-0 shadow-sm border-start border-4 border-info bg-light bg-opacity-25">
                                <div class="card-body p-4 d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <span class="badge bg-secondary mb-2 fs-6">Arsip Kelas {{ $item->kelas }}</span>
                                            <span class="badge bg-primary mb-2 fs-6">{{ $item->mata_pelajaran ?? 'Mata Pelajaran' }}</span>
                                            <h4 class="fw-bold text-dark mb-1">{{ $item->judul }}</h4>
                                        </div>
                                        <span class="badge bg-info text-dark px-3 py-2"><i class="bi bi-journal-bookmark-fill me-1"></i>Kelas Lalu</span>
                                    </div>
                                    <p class="text-secondary small mb-3">{{ $item->deskripsi }}</p>

                                    @if($sub)
                                        <div class="bg-white p-3 rounded mb-2 border">
                                            <small class="text-muted d-block fw-bold mb-1"><i class="bi bi-check-all text-success me-1"></i>Hasil Pekerjaan Anda:</small>
                                            <p class="mb-2 text-dark small">{{ $sub->catatan ?? '-' }}</p>
                                            @if($sub->file_path)
                                                <a href="{{ asset('storage/'.$sub->file_path) }}" class="btn btn-outline-primary btn-sm px-3 mb-2" target="_blank">
                                                    <i class="bi bi-download me-1"></i> Unduh Berkas
                                                </a>
                                            @endif
                                            @if($sub->nilai !== null)
                                                <div class="mt-2 pt-2 border-top">
                                                    <span class="badge bg-success fs-6"><i class="bi bi-star-fill me-1"></i> Nilai Guru: {{ $sub->nilai }} / 100</span>
                                                </div>
                                            @endif
                                        </div>
                                    @endif

                                    <div class="mt-3 border-top pt-3">
                                        <span class="text-secondary small fw-bold">
                                            <i class="bi bi-calendar-event me-1"></i>Deadline: {{ \App\Helpers\WaktuHelper::format($item->deadline) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12">
                        <div class="card border-0 shadow-sm p-5 text-center text-muted">
                            <i class="bi bi-journal-x fs-1 text-secondary mb-2 d-block"></i>
                            Belum ada riwayat tugas dari kelas sebelumnya. Saat Anda naik kelas, tugas-tugas dari kelas sebelumnya akan tersimpan di sini secara otomatis.
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>

<!-- Pure Vanilla JS Tab Switcher Script (100% Fail-Safe, Guaranteed Active Display) -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.tugas-tab-btn');
    const panes = document.querySelectorAll('.tugas-tab-pane');

    buttons.forEach(function(btn) {
        btn.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');

            // Reset all buttons to outline state
            buttons.forEach(b => {
                b.classList.remove('active', 'btn-primary', 'btn-warning', 'btn-success', 'btn-secondary', 'text-white');
                const t = b.getAttribute('data-target');
                if (t === 'all-tasks') {
                    b.className = 'btn btn-outline-primary fw-bold px-4 py-2 rounded-3 tugas-tab-btn';
                } else if (t === 'pending-tasks') {
                    b.className = 'btn btn-outline-warning text-dark fw-bold px-4 py-2 rounded-3 tugas-tab-btn';
                } else if (t === 'completed-tasks') {
                    b.className = 'btn btn-outline-success fw-bold px-4 py-2 rounded-3 tugas-tab-btn';
                } else if (t === 'past-tasks') {
                    b.className = 'btn btn-outline-secondary fw-bold px-4 py-2 rounded-3 tugas-tab-btn';
                }
            });

            // Set clicked button to filled active state
            if (targetId === 'all-tasks') {
                this.className = 'btn btn-primary fw-bold px-4 py-2 rounded-3 tugas-tab-btn active';
            } else if (targetId === 'pending-tasks') {
                this.className = 'btn btn-warning text-dark fw-bold px-4 py-2 rounded-3 tugas-tab-btn active';
            } else if (targetId === 'completed-tasks') {
                this.className = 'btn btn-success fw-bold px-4 py-2 rounded-3 tugas-tab-btn active';
            } else if (targetId === 'past-tasks') {
                this.className = 'btn btn-secondary fw-bold px-4 py-2 rounded-3 tugas-tab-btn active';
            }

            // Hide all tab panes, show selected pane
            panes.forEach(function(pane) {
                if (pane.id === targetId) {
                    pane.classList.remove('d-none');
                } else {
                    pane.classList.add('d-none');
                }
            });
        });
    });
});
</script>
@endsection
