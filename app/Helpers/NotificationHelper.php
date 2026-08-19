<?php

namespace App\Helpers;

use App\Models\Absensi;
use App\Models\AlumniTracer;
use App\Models\Ekstrakurikuler;
use App\Models\IzinGuru;
use App\Models\PendaftaranEkskul;
use App\Models\Siswa;
use App\Models\Tugas;
use App\Models\TugasSubmission;
use Illuminate\Support\Facades\Auth;

class NotificationHelper
{
    /**
     * Get active/latest notifications for currently logged in user.
     * STRICT RULE: Only show items that are NEW (last 48h) or PENDING ACTION.
     */
    public static function getNotifications()
    {
        $user = Auth::user();
        if (!$user) {
            return collect();
        }

        $notifications = collect();
        $recentCutoff = now()->subHours(48); // Only items from last 48 hours for completed events

        // ==========================================
        // 1. NOTIFIKASI UNTUK SISWA
        // ==========================================
        if ($user->isSiswa() && $user->siswa) {
            $siswa = $user->siswa;
            $siswaKelas = $siswa->kelas;
            $siswaId = $siswa->id;

            if ($siswa->status !== 'Lulus') {
                // A. Tugas Belum Dikumpulkan (Hanya yang belum lewat deadline lebih dari 3 hari ATAU dibuat dalam 7 hari terakhir)
                $allTugas = Tugas::where('kelas', $siswaKelas)
                    ->where(function($q) {
                        $q->whereNull('deadline')
                          ->orWhere('deadline', '>=', now()->subDays(3));
                    })
                    ->orderBy('created_at', 'desc')
                    ->get();

                $submittedTugasMap = TugasSubmission::where('siswa_id', $siswaId)
                    ->get()
                    ->keyBy('tugas_id');

                foreach ($allTugas as $tugas) {
                    $submission = $submittedTugasMap->get($tugas->id);

                    if (!$submission) {
                        // Tugas Belum Dikumpulkan!
                        $deadlineText = $tugas->deadline ? WaktuHelper::formatShort($tugas->deadline) : 'Segera';
                        $isDeadlineNear = $tugas->deadline && strtotime($tugas->deadline) < (time() + 86400 * 2);

                        $notifications->push((object)[
                            'id' => 'tugas_pending_' . $tugas->id,
                            'title' => 'Tugas Belum Dikumpulkan!',
                            'message' => "Tugas '{$tugas->judul}' ({$tugas->mata_pelajaran}) belum Anda kumpulkan. Deadline: {$deadlineText}.",
                            'icon' => 'bi-file-earmark-arrow-up-fill text-warning',
                            'badge' => $isDeadlineNear ? 'Segera Kumpulkan' : 'Tugas Baru',
                            'badge_class' => $isDeadlineNear ? 'bg-danger text-white' : 'bg-warning text-dark',
                            'url' => route('siswa.tugas'),
                            'created_at' => $tugas->created_at ? $tugas->created_at->diffForHumans() : 'Baru saja',
                            'type' => 'tugas',
                        ]);
                    } elseif ($submission->nilai !== null && $submission->updated_at >= $recentCutoff) {
                        // Tugas Baru Saja Dinilai Guru (dalam 48 jam terakhir)!
                        $notifications->push((object)[
                            'id' => 'tugas_graded_' . $submission->id,
                            'title' => 'Nilai Tugas Baru 🎉',
                            'message' => "Tugas '{$tugas->judul}' telah dinilai guru dengan Nilai: {$submission->nilai}/100.",
                            'icon' => 'bi-award-fill text-success',
                            'badge' => 'Baru Dinilai',
                            'badge_class' => 'bg-success text-white',
                            'url' => route('siswa.tugas'),
                            'created_at' => $submission->updated_at ? $submission->updated_at->diffForHumans() : 'Terbaru',
                            'type' => 'tugas',
                        ]);
                    }
                }
            }

            // B. Status Pendaftaran Ekskul Siswa (Hanya Pending ATAU ACC/Ditolak dalam 48 jam terakhir)
            $myRegistrations = PendaftaranEkskul::with('ekstrakurikuler')
                ->where('siswa_id', $siswaId)
                ->orderBy('updated_at', 'desc')
                ->get();

            foreach ($myRegistrations as $reg) {
                $ekskulNama = $reg->ekstrakurikuler ? $reg->ekstrakurikuler->nama_ekskul : 'Ekskul';

                if ($reg->status === 'Pending') {
                    $notifications->push((object)[
                        'id' => 'ekskul_pending_' . $reg->id,
                        'title' => 'Pendaftaran Ekskul Menunggu ACC',
                        'message' => "Pendaftaran ekskul '{$ekskulNama}' Anda sedang diproses oleh Admin.",
                        'icon' => 'bi-clock-history text-warning',
                        'badge' => 'Menunggu ACC',
                        'badge_class' => 'bg-warning text-dark',
                        'url' => route('siswa.ekskul'),
                        'created_at' => $reg->created_at ? $reg->created_at->diffForHumans() : 'Pending',
                        'type' => 'ekskul',
                    ]);
                } elseif ($reg->status === 'Disetujui' && $reg->updated_at >= $recentCutoff) {
                    $notifications->push((object)[
                        'id' => 'ekskul_acc_' . $reg->id,
                        'title' => 'Pendaftaran Ekskul Disetujui! (ACC)',
                        'message' => "Selamat! Pendaftaran ekskul '{$ekskulNama}' Anda telah disetujui Admin.",
                        'icon' => 'bi-check-circle-fill text-success',
                        'badge' => 'Baru Disetujui',
                        'badge_class' => 'bg-success text-white',
                        'url' => route('siswa.ekskul'),
                        'created_at' => $reg->updated_at ? $reg->updated_at->diffForHumans() : 'Terbaru',
                        'type' => 'ekskul',
                    ]);
                } elseif ($reg->status === 'Ditolak' && $reg->updated_at >= $recentCutoff) {
                    $notifications->push((object)[
                        'id' => 'ekskul_rejected_' . $reg->id,
                        'title' => 'Pendaftaran Ekskul Ditolak',
                        'message' => "Pendaftaran ekskul '{$ekskulNama}' ditolak: \"{$reg->catatan_admin}\". Anda dapat mendaftar ekskul lain.",
                        'icon' => 'bi-x-circle-fill text-danger',
                        'badge' => 'Ditolak',
                        'badge_class' => 'bg-danger text-white',
                        'url' => route('siswa.ekskul'),
                        'created_at' => $reg->updated_at ? $reg->updated_at->diffForHumans() : 'Terbaru',
                        'type' => 'ekskul',
                    ]);
                }
            }

            // C. Guru Izin Hari Ini (Hanya HARI INI)
            $todayLeaves = IzinGuru::with('guru')
                ->where('status', 'Disetujui')
                ->where('tanggal_mulai', '<=', date('Y-m-d'))
                ->where('tanggal_selesai', '>=', date('Y-m-d'))
                ->get();

            foreach ($todayLeaves as $izin) {
                $guruNama = $izin->guru ? $izin->guru->nama : 'Guru';
                $mapel = $izin->guru ? $izin->guru->mata_pelajaran : 'Mapel';
                $notifications->push((object)[
                    'id' => 'guru_izin_' . $izin->id,
                    'title' => 'Guru Izin Hari Ini',
                    'message' => "Guru {$guruNama} ({$mapel}) sedang izin hari ini ({$izin->alasan_izin}). Cek jadwal piket/pengganti.",
                    'icon' => 'bi-person-exclamation text-info',
                    'badge' => 'Guru Izin Hari Ini',
                    'badge_class' => 'bg-info text-dark',
                    'url' => route('siswa.jadwal'),
                    'created_at' => 'Hari Ini',
                    'type' => 'izin',
                ]);
            }

            // D. Pelanggaran Baru (Dalam 48 jam terakhir saja)
            $pelanggarans = $siswa->pelanggaran()
                ->where('created_at', '>=', $recentCutoff)
                ->orderBy('created_at', 'desc')
                ->get();

            foreach ($pelanggarans as $pel) {
                $notifications->push((object)[
                    'id' => 'pelanggaran_' . $pel->id,
                    'title' => 'Catatan Pelanggaran Baru',
                    'message' => "Poin: +{$pel->point} Pts - {$pel->jenis_pelanggaran} ({$pel->keterangan})",
                    'icon' => 'bi-exclamation-triangle-fill text-danger',
                    'badge' => "+{$pel->point} Poin",
                    'badge_class' => 'bg-danger text-white',
                    'url' => route('siswa.profile'),
                    'created_at' => $pel->created_at ? $pel->created_at->diffForHumans() : 'Terbaru',
                    'type' => 'pelanggaran',
                ]);
            }

            // E. Status Tracer Alumni Siswa (Pending, ACC Disetujui, Ditolak)
            if ($siswa->status === 'Lulus') {
                $myTracers = AlumniTracer::where('siswa_id', $siswaId)
                    ->orderBy('updated_at', 'desc')
                    ->get();

                foreach ($myTracers as $tr) {
                    if ($tr->status_acc === 'Pending') {
                        $notifications->push((object)[
                            'id' => 'alumni_tracer_pending_' . $tr->id,
                            'title' => 'Data & Foto Alumni Menunggu ACC',
                            'message' => "Pengajuan status alumni '{$tr->nama_instansi}' & kesan pesan Anda sedang diverifikasi Admin.",
                            'icon' => 'bi-clock-history text-warning',
                            'badge' => 'Pending ACC',
                            'badge_class' => 'bg-warning text-dark',
                            'url' => route('siswa.profile'),
                            'created_at' => $tr->created_at ? $tr->created_at->diffForHumans() : 'Pending',
                            'type' => 'alumni',
                        ]);
                    } elseif ($tr->status_acc === 'Disetujui' && $tr->updated_at >= $recentCutoff) {
                        $notifications->push((object)[
                            'id' => 'alumni_tracer_acc_' . $tr->id,
                            'title' => 'Data & Foto Alumni Disetujui! (ACC)',
                            'message' => "Pengajuan tracer alumni & kesan pesan Anda di '{$tr->nama_instansi}' telah disetujui (ACC) Admin.",
                            'icon' => 'bi-check-circle-fill text-success',
                            'badge' => 'Baru Disetujui',
                            'badge_class' => 'bg-success text-white',
                            'url' => route('siswa.profile'),
                            'created_at' => $tr->updated_at ? $tr->updated_at->diffForHumans() : 'Terbaru',
                            'type' => 'alumni',
                        ]);
                    } elseif ($tr->status_acc === 'Ditolak' && $tr->updated_at >= $recentCutoff) {
                        $notifications->push((object)[
                            'id' => 'alumni_tracer_rejected_' . $tr->id,
                            'title' => 'Data / Foto Alumni Ditolak Admin',
                            'message' => "Pengajuan tracer alumni ditolak: \"{$tr->catatan_admin}\". Silakan perbarui data di profil Anda.",
                            'icon' => 'bi-x-circle-fill text-danger',
                            'badge' => 'Ditolak Admin',
                            'badge_class' => 'bg-danger text-white',
                            'url' => route('siswa.profile'),
                            'created_at' => $tr->updated_at ? $tr->updated_at->diffForHumans() : 'Terbaru',
                            'type' => 'alumni',
                        ]);
                    }
                }
            }
        }

        // ==========================================
        // 2. NOTIFIKASI UNTUK GURU
        // ==========================================
        elseif ($user->isGuru()) {
            $guru = $user->guru;
            if ($guru) {
                $guruId = $guru->id;

                // A. Jawaban Tugas Siswa Belum Dinilai (Menunggu Penilaian)
                $myTugasIds = Tugas::where('guru_id', $guruId)->pluck('id');
                $pendingSubmissionsCount = TugasSubmission::whereIn('tugas_id', $myTugasIds)
                    ->whereNull('nilai')
                    ->count();

                if ($pendingSubmissionsCount > 0) {
                    $notifications->push((object)[
                        'id' => 'guru_pending_grades',
                        'title' => 'Tugas Siswa Belum Dinilai',
                        'message' => "Ada {$pendingSubmissionsCount} pengumpulan tugas siswa yang belum Anda beri nilai.",
                        'icon' => 'bi-file-earmark-text-fill text-danger',
                        'badge' => "{$pendingSubmissionsCount} Belum Dinilai",
                        'badge_class' => 'bg-danger text-white',
                        'url' => route('tugas.index'),
                        'created_at' => 'Perlu Penilaian',
                        'type' => 'tugas',
                    ]);
                }

                // B. Pengajuan Izin Saya (Pending ATAU Disetujui/Ditolak dalam 48 jam terakhir)
                $myIzins = IzinGuru::where('guru_id', $guruId)
                    ->where(function($q) use ($recentCutoff) {
                        $q->where('status', 'Pending')
                          ->orWhere('updated_at', '>=', $recentCutoff);
                    })
                    ->orderBy('updated_at', 'desc')
                    ->get();

                foreach ($myIzins as $iz) {
                    if ($iz->status === 'Pending') {
                        $notifications->push((object)[
                            'id' => 'guru_my_izin_' . $iz->id,
                            'title' => 'Pengajuan Izin Menunggu ACC Admin',
                            'message' => "Pengajuan izin Anda tanggal " . WaktuHelper::formatShort($iz->tanggal_mulai) . " sedang diproses Admin.",
                            'icon' => 'bi-clock-history text-warning',
                            'badge' => 'Pending ACC',
                            'badge_class' => 'bg-warning text-dark',
                            'url' => route('guru.izin.index'),
                            'created_at' => $iz->created_at ? $iz->created_at->diffForHumans() : 'Pending',
                            'type' => 'izin',
                        ]);
                    } elseif ($iz->status === 'Disetujui' && $iz->updated_at >= $recentCutoff) {
                        $notifications->push((object)[
                            'id' => 'guru_my_izin_acc_' . $iz->id,
                            'title' => 'Pengajuan Izin Disetujui (ACC)',
                            'message' => "Pengajuan izin Anda (" . WaktuHelper::formatShort($iz->tanggal_mulai) . ") telah DISETUJUI Admin.",
                            'icon' => 'bi-check-circle-fill text-success',
                            'badge' => 'Izin ACC',
                            'badge_class' => 'bg-success text-white',
                            'url' => route('guru.izin.index'),
                            'created_at' => $iz->updated_at ? $iz->updated_at->diffForHumans() : 'Terbaru',
                            'type' => 'izin',
                        ]);
                    }
                }

                // C. Tugas Guru Pengganti / Pendamping Hari Ini (Otomatis Hilang Jika Sudah Selesai Diabsen)
                $substituteJobs = IzinGuru::with(['guru', 'tugas'])
                    ->where('guru_pengganti_id', $guruId)
                    ->where('status', 'Disetujui')
                    ->where('tanggal_mulai', '<=', date('Y-m-d'))
                    ->where('tanggal_selesai', '>=', date('Y-m-d'))
                    ->get();

                foreach ($substituteJobs as $sub) {
                    $subClass = $sub->tugas?->kelas;
                    $isSubFinished = false;

                    if ($subClass) {
                        $subSiswaTotal = Siswa::where('kelas', $subClass)->where('status', '!=', 'Lulus')->count();
                        $subAbsenCount = Absensi::where('kelas', $subClass)->where('tanggal', date('Y-m-d'))->count();
                        if ($subSiswaTotal > 0 && $subAbsenCount >= $subSiswaTotal) {
                            $isSubFinished = true;
                        }
                    }

                    // Tampilkan notifikasi HANYA jika tugas mendampingi / mengabsen kelas pengganti BELUM SELESAI
                    if (!$isSubFinished) {
                        $guruAbsenNama = $sub->guru ? $sub->guru->nama : 'Guru';
                        $targetKelasText = $subClass ? "Kelas {$subClass}" : "Kelas Terkait";
                        $notifications->push((object)[
                            'id' => 'substitute_' . $sub->id,
                            'title' => 'Tugas Mendampingi / Guru Pengganti',
                            'message' => "Anda ditunjuk mendampingi/menggantikan {$guruAbsenNama} hari ini ({$sub->alasan}). Silakan absen {$targetKelasText}.",
                            'icon' => 'bi-person-badge-fill text-primary',
                            'badge' => 'Tugas Mendampingi',
                            'badge_class' => 'bg-primary text-white',
                            'url' => route('absensi.index', ['kelas' => $subClass ?? '']),
                            'created_at' => 'Hari Ini',
                            'type' => 'izin',
                        ]);
                    }
                }

                // D. Presensi Harian Siswa Belum Di-absen (Khusus Kelas Mengajar Guru Hari Ini)
                $todayDate = date('Y-m-d');
                $todayEng = \Carbon\Carbon::parse($todayDate)->format('l');
                $dayMap = ['Monday'=>'Senin','Tuesday'=>'Selasa','Wednesday'=>'Rabu','Thursday'=>'Kamis','Friday'=>'Jumat','Saturday'=>'Sabtu','Sunday'=>'Minggu'];
                $todayIndo = $dayMap[$todayEng] ?? 'Senin';

                // Get classes taught by teacher TODAY
                $todayTeachingClasses = \App\Models\JadwalPelajaran::where('guru_id', $guruId)
                    ->where('hari', $todayIndo)
                    ->pluck('kelas');

                $substituteTugasIds = \App\Models\IzinGuru::where('guru_pengganti_id', $guruId)
                    ->where('status', 'Disetujui')
                    ->where('tanggal_mulai', '<=', $todayDate)
                    ->where('tanggal_selesai', '>=', $todayDate)
                    ->whereNotNull('tugas_id')
                    ->pluck('tugas_id');
                $substituteClasses = \App\Models\Tugas::whereIn('id', $substituteTugasIds)->pluck('kelas');

                $myTodayClasses = $todayTeachingClasses->merge($substituteClasses)->unique();

                // Only calculate & show notification IF teacher has scheduled classes TODAY
                if ($myTodayClasses->count() > 0) {
                    $myTodaySiswaIds = Siswa::whereIn('kelas', $myTodayClasses)
                        ->where('status', '!=', 'Lulus')
                        ->pluck('id');

                    $markedCount = Absensi::whereIn('siswa_id', $myTodaySiswaIds)
                        ->where('tanggal', $todayDate)
                        ->count();

                    $unmarkedCountForGuru = max(0, $myTodaySiswaIds->count() - $markedCount);

                    if ($unmarkedCountForGuru > 0) {
                        $notifications->push((object)[
                            'id' => 'guru_unmarked_absensi',
                            'title' => 'Presensi Kelas Hari Ini Belum Di-absen',
                            'message' => "Ada {$unmarkedCountForGuru} siswa di kelas mengajar Anda hari ini yang belum di-absen.",
                            'icon' => 'bi-shield-exclamation text-warning',
                            'badge' => 'Presensi Hari Ini',
                            'badge_class' => 'bg-warning text-dark',
                            'url' => route('absensi.index'),
                            'created_at' => 'Hari Ini',
                            'type' => 'absensi',
                        ]);
                    }
                }
            }
        }

        // ==========================================
        // 3. NOTIFIKASI UNTUK ADMIN
        // ==========================================
        elseif ($user->isAdmin()) {
            // A. Pengajuan Izin Guru Pending (Menunggu ACC Admin)
            $pendingGuruIzinCount = IzinGuru::where('status', 'Pending')->count();

            if ($pendingGuruIzinCount > 0) {
                $notifications->push((object)[
                    'id' => 'admin_pending_izin',
                    'title' => 'Pengajuan Izin Guru Menunggu ACC',
                    'message' => "Ada {$pendingGuruIzinCount} pengajuan izin & sakit dari guru yang membutuhkan persetujuan Admin.",
                    'icon' => 'bi-shield-lock-fill text-warning',
                    'badge' => "{$pendingGuruIzinCount} Menunggu ACC",
                    'badge_class' => 'bg-warning text-dark',
                    'url' => route('admin.izin.index'),
                    'created_at' => 'Perlu ACC',
                    'type' => 'izin',
                ]);
            }

            // B. Pendaftaran Ekskul Siswa Pending (Menunggu ACC Admin)
            $pendingEkskulCount = PendaftaranEkskul::where('status', 'Pending')->count();

            if ($pendingEkskulCount > 0) {
                $notifications->push((object)[
                    'id' => 'admin_pending_ekskul',
                    'title' => 'Pendaftaran Ekskul Siswa Menunggu ACC',
                    'message' => "Ada {$pendingEkskulCount} pendaftaran ekstrakurikuler siswa kelas 10 yang menunggu persetujuan (ACC).",
                    'icon' => 'bi-palette-fill text-primary',
                    'badge' => "{$pendingEkskulCount} Ekskul Pending",
                    'badge_class' => 'bg-primary text-white',
                    'url' => route('admin.ekskul.index'),
                    'created_at' => 'Perlu ACC',
                    'type' => 'ekskul',
                ]);
            }

            // C. Pengumpulan Tugas Siswa Belum Dinilai Guru
            $allUnfilledGrades = TugasSubmission::whereNull('nilai')->count();
            if ($allUnfilledGrades > 0) {
                $notifications->push((object)[
                    'id' => 'admin_unfilled_grades',
                    'title' => 'Tugas Siswa Belum Dinilai Guru',
                    'message' => "Terdapat total {$allUnfilledGrades} tugas siswa di sistem yang belum diberi nilai oleh guru mapel.",
                    'icon' => 'bi-file-earmark-text text-info',
                    'badge' => "{$allUnfilledGrades} Belum Dinilai",
                    'badge_class' => 'bg-info text-dark',
                    'url' => route('tugas.index'),
                    'created_at' => 'Monitoring',
                    'type' => 'tugas',
                ]);
            }

            // D. Tracer Alumni Pending ACC & Laporan Baru
            $pendingTracerCount = AlumniTracer::where('status_acc', 'Pending')->count();

            if ($pendingTracerCount > 0) {
                $notifications->push((object)[
                    'id' => 'admin_pending_alumni_tracer',
                    'title' => 'Tracer & Foto Alumni Menunggu ACC',
                    'message' => "Ada {$pendingTracerCount} pengajuan status pasca lulus, foto & kesan pesan alumni yang memerlukan persetujuan (ACC) Admin.",
                    'icon' => 'bi-mortarboard-fill text-warning',
                    'badge' => "{$pendingTracerCount} Perlu ACC",
                    'badge_class' => 'bg-warning text-dark',
                    'url' => route('admin.alumni.index'),
                    'created_at' => 'Perlu ACC',
                    'type' => 'alumni',
                ]);
            } else {
                $recentTracers = AlumniTracer::where('created_at', '>=', $recentCutoff)->count();
                if ($recentTracers > 0) {
                    $notifications->push((object)[
                        'id' => 'admin_recent_tracer',
                        'title' => 'Laporan Tracer Alumni Baru',
                        'message' => "Ada {$recentTracers} alumni baru saja mengisi formulir penelusuran alumni dalam 48 jam terakhir.",
                        'icon' => 'bi-mortarboard-fill text-success',
                        'badge' => "{$recentTracers} Laporan Baru",
                        'badge_class' => 'bg-success text-white',
                        'url' => route('admin.alumni.index'),
                        'created_at' => 'Terbaru',
                        'type' => 'alumni',
                    ]);
                }
            }
        }

        return $notifications;
    }
}
