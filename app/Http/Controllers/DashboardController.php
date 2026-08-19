<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\JadwalPelajaran;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\PiketGuru;
use App\Models\ProfilSekolah;
use App\Models\Siswa;
use App\Models\Tugas;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalKelas = Kelas::count();
        $totalJurusan = Jurusan::count();
        $totalSiswa = Siswa::count();
        $totalTugas = Tugas::count();
        $totalGuru = Guru::count();

        $user = auth()->user();
        $myPiketDashboard = collect();
        $myTugasCount = 0;
        $myPiketCount = 0;

        $siswa = null;
        $pelanggarans = collect();
        $totalPoints = 0;
        $siswaMedia = collect();

        $mySubstituteDuties = collect();
        $activeIzinGurusSiswa = collect();

        if ($user && $user->isGuru() && $user->guru) {
            $guruId = $user->guru->id;
            $today = date('Y-m-d');
            $myPiketDashboard = PiketGuru::where('guru_id', $guruId)->get();
            $myPiketCount = $myPiketDashboard->count();
            $myTugasCount = Tugas::where('guru_id', $guruId)->count();
            $recentTugas = Tugas::where('guru_id', $guruId)->latest()->take(5)->get();

            // Fetch substitute teacher duties assigned to this teacher by Admin
            $mySubstituteDuties = \App\Models\IzinGuru::with(['guru', 'tugas'])
                ->where('guru_pengganti_id', $guruId)
                ->where('status', 'Disetujui')
                ->where('tanggal_mulai', '<=', $today)
                ->where('tanggal_selesai', '>=', $today)
                ->get();

            // Filter teaching schedules strictly for this teacher's guru_id
            $myJadwalQuery = JadwalPelajaran::with('guru')->where('guru_id', $guruId);

            $totalJadwal = $myJadwalQuery->count();
            $recentJadwal = $myJadwalQuery->orderByRaw("CASE 
                WHEN hari = 'Senin' THEN 1
                WHEN hari = 'Selasa' THEN 2
                WHEN hari = 'Rabu' THEN 3
                WHEN hari = 'Kamis' THEN 4
                WHEN hari = 'Jumat' THEN 5
                ELSE 6 END")->orderBy('jam_mulai', 'asc')->take(5)->get();

        } else if ($user && $user->isSiswa() && $user->siswa) {
            $siswa = $user->siswa;
            $kelasSiswa = $siswa->kelas;
            $totalJadwal = JadwalPelajaran::where('kelas', $kelasSiswa)->count();
            
            $recentTugas = Tugas::where('kelas', $kelasSiswa)->latest()->take(5)->get();
            $recentJadwal = JadwalPelajaran::with('guru')->where('kelas', $kelasSiswa)->orderByRaw("CASE 
                WHEN hari = 'Senin' THEN 1
                WHEN hari = 'Selasa' THEN 2
                WHEN hari = 'Rabu' THEN 3
                WHEN hari = 'Kamis' THEN 4
                WHEN hari = 'Jumat' THEN 5
                ELSE 6 END")->orderBy('jam_mulai', 'asc')->take(5)->get();

            $today = date('Y-m-d');
            $activeIzinGurusSiswa = \App\Models\IzinGuru::with(['guru', 'guruPengganti', 'tugas'])
                ->where('status', 'Disetujui')
                ->where('tanggal_mulai', '<=', $today)
                ->where('tanggal_selesai', '>=', $today)
                ->get()
                ->keyBy('guru_id');

            if ($siswa->status === 'Lulus') {
                $pelanggarans = $siswa->pelanggaran()->orderBy('tanggal', 'desc')->get();
                $totalPoints = $pelanggarans->sum('point');
                $siswaMedia = $siswa->media()->latest()->get();
            }

        } else {
            // Admin sees all
            $totalJadwal = JadwalPelajaran::count();
            $recentTugas = Tugas::latest()->take(5)->get();
            $recentJadwal = JadwalPelajaran::with('guru')->orderByRaw("CASE 
                WHEN hari = 'Senin' THEN 1
                WHEN hari = 'Selasa' THEN 2
                WHEN hari = 'Rabu' THEN 3
                WHEN hari = 'Kamis' THEN 4
                WHEN hari = 'Jumat' THEN 5
                ELSE 6 END")->orderBy('jam_mulai', 'asc')->take(5)->get();
        }

        // Today's School Attendance Summary
        $today = date('Y-m-d');
        $totalSiswaAktif = Siswa::where('status', '!=', 'Lulus')->count();
        $todayAbsensi = \App\Models\Absensi::where('tanggal', $today)->get();
        $todayHadirCount = $todayAbsensi->where('status', 'Hadir')->count();
        $todayIzinCount = $todayAbsensi->where('status', 'Izin')->count();
        $todaySakitCount = $todayAbsensi->where('status', 'Sakit')->count();
        $todayAlpaCount = $todayAbsensi->where('status', 'Alpa')->count();
        $todayBelumDiabsen = max(0, $totalSiswaAktif - $todayAbsensi->count());

        // Fetch dynamic School Profile
        $profilSekolah = ProfilSekolah::first();

        // Fetch Student Achievements & Extracurriculars for School Homepage Showcase
        $prestasiList = \App\Models\PrestasiSiswa::with('siswa')
            ->orderBy('tahun', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $siswas = \App\Models\Siswa::orderBy('nama')->get();

        $ekskulList = \App\Models\Ekstrakurikuler::orderBy('nama_ekskul')->get();
        $beritaTerbaru = \App\Models\Berita::orderBy('tanggal_publikasi', 'desc')->take(4)->get();
        $agendaMendatang = \App\Models\Agenda::where('tanggal', '>=', date('Y-m-d'))->orderBy('tanggal', 'asc')->take(4)->get();

        return view('dashboard', compact(
            'totalKelas',
            'totalJurusan',
            'totalJadwal',
            'totalSiswa',
            'totalTugas',
            'totalGuru',
            'recentJadwal',
            'recentTugas',
            'myPiketDashboard',
            'myTugasCount',
            'myPiketCount',
            'profilSekolah',
            'siswa',
            'pelanggarans',
            'totalPoints',
            'siswaMedia',
            'todayHadirCount',
            'todayIzinCount',
            'todaySakitCount',
            'todayAlpaCount',
            'todayBelumDiabsen',
            'totalSiswaAktif',
            'mySubstituteDuties',
            'activeIzinGurusSiswa',
            'prestasiList',
            'siswas',
            'ekskulList',
            'beritaTerbaru',
            'agendaMendatang'
        ));
    }
}
