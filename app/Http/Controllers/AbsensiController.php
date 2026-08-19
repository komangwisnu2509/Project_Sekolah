<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\ProfilSekolah;
use App\Models\Siswa;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $allowedKelasNames = collect();

        $selectedKelas = $request->input('kelas', '');
        $tanggal = $request->input('tanggal', date('Y-m-d'));

        $todayEng = \Carbon\Carbon::parse($tanggal)->format('l');
        $dayMap = ['Monday'=>'Senin','Tuesday'=>'Selasa','Wednesday'=>'Rabu','Thursday'=>'Kamis','Friday'=>'Jumat','Saturday'=>'Sabtu','Sunday'=>'Minggu'];
        $todayIndo = $dayMap[$todayEng] ?? 'Senin';

        if ($user->isGuru() && $user->guru) {
            $guruId = $user->guru->id;
            // Filter teaching classes strictly for selected date's day of week
            $teachingClasses = \App\Models\JadwalPelajaran::where('guru_id', $guruId)
                ->where('hari', $todayIndo)
                ->pluck('kelas');

            $substituteTugasIds = \App\Models\IzinGuru::where('guru_pengganti_id', $guruId)
                ->where('status', 'Disetujui')
                ->where('tanggal_mulai', '<=', $tanggal)
                ->where('tanggal_selesai', '>=', $tanggal)
                ->whereNotNull('tugas_id')
                ->pluck('tugas_id');
            $substituteClasses = \App\Models\Tugas::whereIn('id', $substituteTugasIds)->pluck('kelas');

            $allowedKelasNames = $teachingClasses->merge($substituteClasses)->unique();
            $kelas = Kelas::whereIn('nama_kelas', $allowedKelasNames)->orderBy('nama_kelas')->get();
        } else {
            $kelas = Kelas::orderBy('nama_kelas')->get();
        }

        // Time-Aware Auto-Select Class for Guru based on current teaching schedule
        $activeJadwalInfo = null;
        if ($user->isGuru() && $user->guru) {
            $guruId = $user->guru->id;
            $todayEng = \Carbon\Carbon::parse($tanggal)->format('l');
            $dayMap = ['Monday'=>'Senin','Tuesday'=>'Selasa','Wednesday'=>'Rabu','Thursday'=>'Kamis','Friday'=>'Jumat','Saturday'=>'Sabtu','Sunday'=>'Minggu'];
            $todayIndo = $dayMap[$todayEng] ?? 'Senin';

            $nowTime = date('H:i:s');

            // 1. Active class right now (jam_mulai <= NOW <= jam_selesai)
            $activeJadwalInfo = \App\Models\JadwalPelajaran::where('guru_id', $guruId)
                ->where('hari', $todayIndo)
                ->where('jam_mulai', '<=', $nowTime)
                ->where('jam_selesai', '>=', $nowTime)
                ->first();

            // 2. If no active class right now, pick next upcoming class today
            if (!$activeJadwalInfo) {
                $activeJadwalInfo = \App\Models\JadwalPelajaran::where('guru_id', $guruId)
                    ->where('hari', $todayIndo)
                    ->where('jam_mulai', '>', $nowTime)
                    ->orderBy('jam_mulai')
                    ->first();
            }

            // 3. If no upcoming class today, pick first class today
            if (!$activeJadwalInfo) {
                $activeJadwalInfo = \App\Models\JadwalPelajaran::where('guru_id', $guruId)
                    ->where('hari', $todayIndo)
                    ->orderBy('jam_mulai')
                    ->first();
            }

            if (!$request->has('kelas') && $activeJadwalInfo) {
                $selectedKelas = $activeJadwalInfo->kelas;
            }
        }

        if (!$selectedKelas) {
            $selectedKelas = $kelas->first()?->nama_kelas ?? '';
        }

        $kelasX = $kelas->filter(fn($k) => str_starts_with($k->nama_kelas, 'X ') || str_starts_with($k->nama_kelas, '10 '));
        $kelasXI = $kelas->filter(fn($k) => str_starts_with($k->nama_kelas, 'XI ') || str_starts_with($k->nama_kelas, '11 '));
        $kelasXII = $kelas->filter(fn($k) => str_starts_with($k->nama_kelas, 'XII ') || str_starts_with($k->nama_kelas, '12 '));
        $kelasOther = $kelas->reject(fn($k) => 
            str_starts_with($k->nama_kelas, 'X ') || str_starts_with($k->nama_kelas, '10 ') ||
            str_starts_with($k->nama_kelas, 'XI ') || str_starts_with($k->nama_kelas, '11 ') ||
            str_starts_with($k->nama_kelas, 'XII ') || str_starts_with($k->nama_kelas, '12 ')
        );

        $siswas = collect();
        $existingAbsensi = collect();

        if ($selectedKelas) {
            $siswas = Siswa::where('kelas', $selectedKelas)
                ->where('status', '!=', 'Lulus')
                ->orderByRaw('CAST(nis AS UNSIGNED) ASC')
                ->get();

            $existingAbsensi = Absensi::whereIn('siswa_id', $siswas->pluck('id'))
                ->where('tanggal', $tanggal)
                ->get()
                ->keyBy('siswa_id');
        }

        // Check if all classes in school or all teacher's assigned classes are marked
        $totalActiveSiswa = Siswa::where('status', '!=', 'Lulus')->count();
        $totalTodayAbsensi = Absensi::where('tanggal', $tanggal)->count();
        $isAllClassesDone = ($totalActiveSiswa > 0 && $totalTodayAbsensi >= $totalActiveSiswa);

        $mySiswaIdsCount = Siswa::whereIn('kelas', $kelas->pluck('nama_kelas'))->where('status', '!=', 'Lulus')->count();
        $myAbsenCount = Absensi::whereIn('kelas', $kelas->pluck('nama_kelas'))->where('tanggal', $tanggal)->count();
        $isMyClassesDone = ($mySiswaIdsCount > 0 && $myAbsenCount >= $mySiswaIdsCount);

        return view('absensi.index', compact(
            'kelas', 'selectedKelas', 'tanggal', 'siswas', 'existingAbsensi',
            'kelasX', 'kelasXI', 'kelasXII', 'kelasOther', 'activeJadwalInfo', 'allowedKelasNames',
            'isAllClassesDone', 'isMyClassesDone'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas' => 'required|string',
            'tanggal' => 'required|date',
            'absensi' => 'required|array',
            'absensi.*.status' => 'required|in:Hadir,Izin,Sakit,Alpa',
            'absensi.*.alasan' => 'nullable|string|max:255',
        ]);

        $user = auth()->user();

        // Strict Teacher Access Authorization
        if ($user->isGuru() && $user->guru) {
            $guruId = $user->guru->id;
            $teachingClasses = \App\Models\JadwalPelajaran::where('guru_id', $guruId)->pluck('kelas');
            $substituteTugasIds = \App\Models\IzinGuru::where('guru_pengganti_id', $guruId)
                ->where('status', 'Disetujui')
                ->whereNotNull('tugas_id')
                ->pluck('tugas_id');
            $substituteClasses = \App\Models\Tugas::whereIn('id', $substituteTugasIds)->pluck('kelas');
            $allowedKelasNames = $teachingClasses->merge($substituteClasses)->unique();

            if (!$allowedKelasNames->contains($request->kelas)) {
                return redirect()->back()->with('error', "Akses Ditolak: Anda tidak berwenang mengabsen kelas {$request->kelas}. Presensi hanya dapat dilakukan oleh Guru pengampu jadwal atau Guru Pengganti yang ditugaskan.");
            }
        }

        $guruId = $user->isGuru() && $user->guru ? $user->guru->id : null;
        $savedCount = 0;

        foreach ($request->input('absensi') as $siswaId => $data) {
            Absensi::updateOrCreate(
                [
                    'siswa_id' => $siswaId,
                    'tanggal' => $request->tanggal,
                ],
                [
                    'guru_id' => $guruId,
                    'kelas' => $request->kelas,
                    'status' => $data['status'],
                    'alasan' => $data['status'] !== 'Hadir' ? ($data['alasan'] ?? null) : null,
                ]
            );
            $savedCount++;
        }

        $formattedDate = date('d/m/Y', strtotime($request->tanggal));
        return redirect()->route('absensi.index', ['kelas' => $request->kelas, 'tanggal' => $request->tanggal])
            ->with('success', "Absensi kelas {$request->kelas} untuk tanggal {$formattedDate} ({$savedCount} siswa) berhasil disimpan.");
    }

    public function rekap(Request $request)
    {
        $user = auth()->user();
        if ($user->isGuru() && $user->guru) {
            $guruId = $user->guru->id;
            $teachingClasses = \App\Models\JadwalPelajaran::where('guru_id', $guruId)->pluck('kelas');
            $substituteTugasIds = \App\Models\IzinGuru::where('guru_pengganti_id', $guruId)
                ->where('status', 'Disetujui')
                ->whereNotNull('tugas_id')
                ->pluck('tugas_id');
            $substituteClasses = \App\Models\Tugas::whereIn('id', $substituteTugasIds)->pluck('kelas');

            $allowedKelasNames = $teachingClasses->merge($substituteClasses)->unique();
            $kelas = Kelas::whereIn('nama_kelas', $allowedKelasNames)->orderBy('nama_kelas')->get();
        } else {
            $kelas = Kelas::orderBy('nama_kelas')->get();
        }

        $selectedKelas = $request->input('kelas', $kelas->first()?->nama_kelas ?? '');
        $bulan = $request->input('bulan', date('Y-m'));

        $kelasX = $kelas->filter(fn($k) => str_starts_with($k->nama_kelas, 'X ') || str_starts_with($k->nama_kelas, '10 '));
        $kelasXI = $kelas->filter(fn($k) => str_starts_with($k->nama_kelas, 'XI ') || str_starts_with($k->nama_kelas, '11 '));
        $kelasXII = $kelas->filter(fn($k) => str_starts_with($k->nama_kelas, 'XII ') || str_starts_with($k->nama_kelas, '12 '));
        $kelasOther = $kelas->reject(fn($k) => 
            str_starts_with($k->nama_kelas, 'X ') || str_starts_with($k->nama_kelas, '10 ') ||
            str_starts_with($k->nama_kelas, 'XI ') || str_starts_with($k->nama_kelas, '11 ') ||
            str_starts_with($k->nama_kelas, 'XII ') || str_starts_with($k->nama_kelas, '12 ')
        );

        $siswas = collect();
        if ($selectedKelas) {
            $siswas = Siswa::where('kelas', $selectedKelas)
                ->where('status', '!=', 'Lulus')
                ->with(['absensi' => function($q) use ($bulan) {
                    if ($bulan) {
                        $q->where('tanggal', 'like', $bulan . '%');
                    }
                    $q->orderBy('tanggal', 'desc');
                }])
                ->orderByRaw('CAST(nis AS UNSIGNED) ASC')
                ->get();
        }

        return view('absensi.rekap', compact(
            'kelas', 'selectedKelas', 'bulan', 'siswas',
            'kelasX', 'kelasXI', 'kelasXII', 'kelasOther'
        ));
    }

    public function exportPdf(Request $request)
    {
        $selectedKelas = $request->input('kelas');
        $bulan = $request->input('bulan', date('Y-m'));

        if (!$selectedKelas) {
            return redirect()->back()->with('error', 'Pilih kelas terlebih dahulu untuk cetak PDF.');
        }

        $profilSekolah = ProfilSekolah::first();
        $siswas = Siswa::where('kelas', $selectedKelas)
            ->where('status', '!=', 'Lulus')
            ->with(['absensi' => function($q) use ($bulan) {
                if ($bulan) {
                    $q->where('tanggal', 'like', $bulan . '%');
                }
                $q->orderBy('tanggal', 'desc');
            }])
            ->orderByRaw('CAST(nis AS UNSIGNED) ASC')
            ->get();

        $namaBulan = \Carbon\Carbon::parse($bulan . '-01')->translatedFormat('F Y');

        $html = view('absensi.pdf', compact('selectedKelas', 'bulan', 'namaBulan', 'siswas', 'profilSekolah'))->render();

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $filename = "Laporan_Absensi_{$selectedKelas}_{$bulan}.pdf";
        return $dompdf->stream($filename, ['Attachment' => true]);
    }

    public function harian(Request $request)
    {
        $tanggal = $request->input('tanggal', date('Y-m-d'));
        $selectedKelas = $request->input('kelas', '');
        $statusFilter = $request->input('status', '');
        $search = $request->input('q', '');

        $user = auth()->user();

        // Convert $tanggal to Indonesian day name
        $dayEng = \Carbon\Carbon::parse($tanggal)->format('l');
        $dayMap = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];
        $hariIndo = $dayMap[$dayEng] ?? 'Senin';

        // Fetch teaching schedule & substitute duties for $tanggal for logged-in Guru
        $myTodayJadwals = collect();
        $myTodayClasses = collect();

        if ($user && $user->isGuru() && $user->guru) {
            $guruId = $user->guru->id;
            $myTodayJadwals = \App\Models\JadwalPelajaran::where('guru_id', $guruId)
                ->where('hari', $hariIndo)
                ->orderBy('jam_mulai')
                ->get();

            $substituteTugasIds = \App\Models\IzinGuru::where('guru_pengganti_id', $guruId)
                ->where('status', 'Disetujui')
                ->where('tanggal_mulai', '<=', $tanggal)
                ->where('tanggal_selesai', '>=', $tanggal)
                ->whereNotNull('tugas_id')
                ->pluck('tugas_id');

            $substituteClasses = \App\Models\Tugas::whereIn('id', $substituteTugasIds)->pluck('kelas');

            $myTodayClasses = $myTodayJadwals->pluck('kelas')->merge($substituteClasses)->unique();
        }

        $kelas = Kelas::orderBy('nama_kelas')->get();

        $query = Siswa::where('status', '!=', 'Lulus');
        if ($selectedKelas) {
            $query->where('kelas', $selectedKelas);
        }
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }
        $allActiveSiswa = $query->orderBy('kelas')->orderByRaw('CAST(nis AS UNSIGNED) ASC')->get();

        // Get absensi records for all active students on $tanggal
        $absensiRecords = Absensi::with('guru')
            ->whereIn('siswa_id', $allActiveSiswa->pluck('id'))
            ->where('tanggal', $tanggal)
            ->get()
            ->keyBy('siswa_id');

        // Overall stats for $tanggal
        $totalSiswa = $allActiveSiswa->count();
        $totalTercatat = $absensiRecords->count();
        $totalHadir = $absensiRecords->where('status', 'Hadir')->count();
        $totalIzin = $absensiRecords->where('status', 'Izin')->count();
        $totalSakit = $absensiRecords->where('status', 'Sakit')->count();
        $totalAlpa = $absensiRecords->where('status', 'Alpa')->count();
        $totalBelum = max(0, $totalSiswa - $totalTercatat);

        // Filter list if statusFilter is requested
        $siswas = $allActiveSiswa->filter(function($s) use ($absensiRecords, $statusFilter) {
            $record = $absensiRecords->get($s->id);
            $status = $record ? $record->status : 'Belum Diabsen';
            if ($statusFilter === 'Non-Hadir') {
                return in_array($status, ['Izin', 'Sakit', 'Alpa']);
            }
            if ($statusFilter) {
                return $status === $statusFilter;
            }
            return true;
        });

        // Group summary per class for the day with detailed student lists (Hadir, Izin, Alpa, Belum Diabsen)
        $summaryPerKelas = $allActiveSiswa->groupBy('kelas')->map(function($classStudents, $className) use ($absensiRecords, $user, $myTodayClasses) {
            $records = $absensiRecords->whereIn('siswa_id', $classStudents->pluck('id'));
            
            $hadirStudents = $classStudents->filter(fn($s) => $absensiRecords->get($s->id)?->status === 'Hadir')->values();
            $izinStudents = $classStudents->filter(fn($s) => in_array($absensiRecords->get($s->id)?->status, ['Izin', 'Sakit']))->values();
            $alpaStudents = $classStudents->filter(fn($s) => $absensiRecords->get($s->id)?->status === 'Alpa')->values();
            $unmarkedStudents = $classStudents->filter(fn($s) => !$absensiRecords->has($s->id))->values();

            $isAllowedForGuru = $user->isAdmin() || ($user->isGuru() && $myTodayClasses->contains($className));

            return [
                'kelas' => $className,
                'total' => $classStudents->count(),
                'hadir' => $records->where('status', 'Hadir')->count(),
                'izin' => $records->where('status', 'Izin')->count(),
                'sakit' => $records->where('status', 'Sakit')->count(),
                'alpa' => $records->where('status', 'Alpa')->count(),
                'belum' => max(0, $classStudents->count() - $records->count()),
                'hadirStudents' => $hadirStudents,
                'izinStudents' => $izinStudents,
                'alpaStudents' => $alpaStudents,
                'unmarkedStudents' => $unmarkedStudents,
                'isAllowedForGuru' => $isAllowedForGuru,
            ];
        });

        // Pure Indonesian Date Formatting (e.g., Rabu, 12 Agustus 2026)
        $daysMap = ['Monday'=>'Senin','Tuesday'=>'Selasa','Wednesday'=>'Rabu','Thursday'=>'Kamis','Friday'=>'Jumat','Saturday'=>'Sabtu','Sunday'=>'Minggu'];
        $monthsMap = ['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];

        $ts = strtotime($tanggal);
        $formattedIndoDate = ($daysMap[date('l', $ts)] ?? date('l', $ts)) . ', ' . date('d', $ts) . ' ' . ($monthsMap[date('m', $ts)] ?? date('F', $ts)) . ' ' . date('Y', $ts);

        // Group filtered active students by class
        $siswasGroupedByKelas = $siswas->groupBy('kelas');

        return view('absensi.harian', compact(
            'tanggal', 'hariIndo', 'formattedIndoDate', 'selectedKelas', 'statusFilter', 'search', 'kelas', 'siswas', 'siswasGroupedByKelas', 'absensiRecords',
            'totalSiswa', 'totalTercatat', 'totalHadir', 'totalIzin', 'totalSakit', 'totalAlpa', 'totalBelum',
            'summaryPerKelas', 'myTodayJadwals', 'myTodayClasses'
        ));
    }

    public function exportPdfHarian(Request $request)
    {
        $tanggal = $request->input('tanggal', date('Y-m-d'));
        $selectedKelas = $request->input('kelas', '');

        $profilSekolah = ProfilSekolah::first();
        $query = Siswa::where('status', '!=', 'Lulus');
        if ($selectedKelas) {
            $query->where('kelas', $selectedKelas);
        }
        $siswas = $query->orderBy('kelas')->orderByRaw('CAST(nis AS UNSIGNED) ASC')->get();

        $absensiRecords = Absensi::with('guru')
            ->whereIn('siswa_id', $siswas->pluck('id'))
            ->where('tanggal', $tanggal)
            ->get()
            ->keyBy('siswa_id');

        $formattedDate = \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y');

        $html = view('absensi.pdf_harian', compact('tanggal', 'formattedDate', 'selectedKelas', 'siswas', 'absensiRecords', 'profilSekolah'))->render();

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $filename = "Laporan_Absensi_Harian_" . str_replace('-', '', $tanggal) . ".pdf";
        return $dompdf->stream($filename, ['Attachment' => true]);
    }
}
