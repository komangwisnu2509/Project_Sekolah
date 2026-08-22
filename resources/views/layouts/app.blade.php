<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="theme-color" content="#0f172a">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>Data Kelas - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Figtree', system-ui, -apple-system, sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            min-height: 100vh;
            -webkit-tap-highlight-color: transparent;
        }
        
        /* Layout Structure */
        .wrapper {
            display: flex;
            align-items: stretch;
            min-height: 100vh;
            position: relative;
        }
        
        /* Left Sidebar Styling */
        #sidebar {
            min-width: 260px;
            max-width: 260px;
            background-color: #0f172a;
            color: #94a3b8;
            transition: all 0.3s ease-in-out;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.05);
            z-index: 1040;
        }
        
        #sidebar .sidebar-header {
            padding: 20px 24px;
            background-color: #020617;
            border-bottom: 1px solid #1e293b;
        }
        
        #sidebar ul.components {
            padding: 16px 0;
        }
        
        #sidebar ul li {
            padding: 2px 14px;
        }
        
        #sidebar ul li a {
            padding: 12px 14px;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            color: #94a3b8;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.2s;
            font-weight: 500;
        }
        
        #sidebar ul li a i {
            font-size: 1.2rem;
            margin-right: 12px;
            transition: all 0.2s;
        }
        
        #sidebar ul li a:hover {
            color: #f8fafc;
            background-color: #1e293b;
        }
        
        #sidebar ul li a:hover i {
            color: #3b82f6;
        }
        
        #sidebar ul li.active a {
            color: #ffffff;
            background-color: #2563eb;
        }
        
        #sidebar ul li.active a i {
            color: #ffffff;
        }
        
        /* Main Content Styling */
        #content-area {
            width: 100%;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }
        
        /* Top Navbar */
        .top-navbar {
            background-color: #ffffff;
            padding: 14px 24px;
            border-bottom: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        }
        
        /* Page Content container */
        .main-container {
            padding: 24px;
            flex-grow: 1;
        }
        
        /* Card enhancements */
        .card {
            border: none;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
            border-radius: 12px;
        }

        /* Mobile Backdrop Overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(2px);
            z-index: 1030;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        /* Responsive Mobile / Tablet Styling for Android Portrait Screen */
        @media (max-width: 991.98px) {
            #sidebar {
                position: fixed;
                top: 0;
                left: -280px;
                height: 100vh;
                width: 280px;
                max-width: 280px;
            }

            #sidebar.show {
                left: 0;
            }

            .sidebar-overlay.show {
                display: block;
                opacity: 1;
            }

            .main-container {
                padding: 16px 12px;
            }

            .top-navbar {
                padding: 12px 16px;
            }

            .table-responsive {
                -webkit-overflow-scrolling: touch;
            }
        }

        /* Mobile & Tablet LANDSCAPE Orientation Optimization */
        @media (orientation: landscape) and (max-height: 600px) {
            .top-navbar {
                padding: 6px 16px !important;
            }
            .main-container {
                padding: 10px 8px !important;
            }
            .card-header {
                padding: 8px 12px !important;
            }
            .card-body {
                padding: 10px !important;
            }
            .table-responsive {
                max-height: 78vh;
                overflow-y: auto;
            }
        }

        /* Wide / Landscape Screen Table Fitting */
        @media (min-width: 576px) {
            .table-responsive .table {
                font-size: 0.88rem;
            }
            .table-responsive .table th, 
            .table-responsive .table td {
                padding-top: 0.65rem;
                padding-bottom: 0.65rem;
            }
        }

        /* Notification Badge Pulse Animation */
        .badge-pulse {
            animation: badgePulse 1.8s infinite;
        }
        @keyframes badgePulse {
            0% {
                box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
            }
            70% {
                box-shadow: 0 0 0 6px rgba(239, 68, 68, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(239, 68, 68, 0);
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar Navigation -->
        <nav id="sidebar">
            <div class="sidebar-header d-flex justify-content-between align-items-center">
                <a href="{{ route('dashboard') }}" class="text-white text-decoration-none d-flex align-items-center">
                    <i class="bi bi-rocket-takeoff-fill fs-3 text-primary me-2"></i>
                    <span class="fs-4 fw-bold tracking-wide">DATA KELAS</span>
                </a>
                <button type="button" class="btn text-white-50 p-0 d-lg-none" id="sidebarClose" aria-label="Close Sidebar">
                    <i class="bi bi-x-lg fs-4"></i>
                </button>
            </div>

            <ul class="list-unstyled components flex-grow-1 overflow-y-auto">
                @auth
                    <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    @if(!Auth::user()->isSiswa())
                        <li class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                            <a href="{{ route('profile.edit') }}">
                                <i class="bi bi-person-gear"></i> Profil Saya
                            </a>
                        </li>
                    @endif
                    @if(Auth::user()->isAdmin())
                        @php
                            $adminPendingIzinNav = \App\Models\IzinGuru::where('status', 'Pending')->count();
                            $pendingPpdbNav = \App\Models\PpdbPendaftaran::where('status', 'Pending')->count();
                            $adminPendingAlumniNav = \App\Models\AlumniTracer::where('status_acc', 'Pending')->count();
                            $adminPendingEkskulNav = \App\Models\PendaftaranEkskul::where('status', 'Pending')->count();
                            $adminPendingTugasNav = \App\Models\TugasSubmission::whereNull('nilai')->count();
                            
                            $masterGroupNotifNav = $adminPendingAlumniNav;
                            $jadwalGroupNotifNav = $adminPendingIzinNav;
                            $akademikGroupNotifNav = $pendingPpdbNav + $adminPendingEkskulNav + $adminPendingTugasNav;

                            $totalHeaderNotif = $pendingPpdbNav + $adminPendingIzinNav + $adminPendingAlumniNav + $adminPendingEkskulNav + $adminPendingTugasNav;
                        @endphp

                        <!-- Group 1: Master Data -->
                        <li>
                            <a href="#adminMasterSubmenu" data-bs-toggle="collapse" class="d-flex align-items-center justify-content-between {{ request()->routeIs('siswa.*') || request()->routeIs('guru.*') || request()->routeIs('kelas.*') || request()->routeIs('jurusan.*') || request()->routeIs('admin.alumni.*') ? 'text-white fw-bold' : '' }}">
                                <span><i class="bi bi-folder-fill me-2 text-primary"></i> Master Data Sekolah</span>
                                <div class="d-flex align-items-center gap-1">
                                    @if($masterGroupNotifNav > 0)
                                        <span class="badge bg-danger rounded-pill px-2 py-0.5 shadow-sm badge-pulse">{{ $masterGroupNotifNav }}</span>
                                    @endif
                                    <i class="bi bi-chevron-down ms-1"></i>
                                </div>
                            </a>
                            <div class="collapse {{ request()->routeIs('siswa.*') || request()->routeIs('guru.*') || request()->routeIs('kelas.*') || request()->routeIs('jurusan.*') || request()->routeIs('admin.alumni.*') ? 'show' : '' }} ps-3 mt-1" id="adminMasterSubmenu">
                                <ul class="list-unstyled mb-0">
                                    <li class="{{ request()->routeIs('siswa.*') ? 'active' : '' }} my-1">
                                        <a href="{{ route('siswa.index') }}" class="py-2 d-flex align-items-center justify-content-between">
                                            <span><i class="bi bi-people-fill me-2"></i> Data Siswa</span>
                                        </a>
                                    </li>
                                    <li class="{{ request()->routeIs('guru.*') ? 'active' : '' }} my-1">
                                        <a href="{{ route('guru.index') }}" class="py-2 d-flex align-items-center justify-content-between">
                                            <span><i class="bi bi-person-workspace me-2"></i> Data Guru</span>
                                        </a>
                                    </li>
                                    <li class="{{ request()->routeIs('staff.*') ? 'active' : '' }} my-1">
                                        <a href="{{ route('staff.index') }}" class="py-2 d-flex align-items-center justify-content-between">
                                            <span><i class="bi bi-person-badge me-2 text-info"></i> Data Staff</span>
                                        </a>
                                    </li>
                                    <li class="{{ request()->routeIs('kelas.*') ? 'active' : '' }} my-1">
                                        <a href="{{ route('kelas.index') }}" class="py-2 d-flex align-items-center justify-content-between">
                                            <span><i class="bi bi-building-fill me-2"></i> Data Kelas</span>
                                        </a>
                                    </li>
                                    <li class="{{ request()->routeIs('jurusan.*') ? 'active' : '' }} my-1">
                                        <a href="{{ route('jurusan.index') }}" class="py-2 d-flex align-items-center justify-content-between">
                                            <span><i class="bi bi-journal-text me-2"></i> Data Jurusan</span>
                                        </a>
                                    </li>
                                    <li class="{{ request()->routeIs('admin.alumni.*') ? 'active' : '' }} my-1">
                                        <a href="{{ route('admin.alumni.index') }}" class="py-2 d-flex align-items-center justify-content-between">
                                            <span><i class="bi bi-mortarboard-fill me-2 text-warning"></i> Tracer Alumni</span>
                                            @if($adminPendingAlumniNav > 0)
                                                <span class="badge bg-danger rounded-pill px-2 py-0.5 shadow-sm badge-pulse" title="{{ $adminPendingAlumniNav }} Alumni Menunggu Verifikasi">{{ $adminPendingAlumniNav }}</span>
                                            @endif
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <!-- Group 2: Jadwal & Piket -->
                        <li>
                            <a href="#adminJadwalSubmenu" data-bs-toggle="collapse" class="d-flex align-items-center justify-content-between {{ request()->routeIs('piket.*') || request()->routeIs('jadwal.*') || request()->routeIs('absensi.*') || request()->routeIs('admin.izin.*') ? 'text-white fw-bold' : '' }}">
                                <span><i class="bi bi-calendar-range-fill me-2 text-warning"></i> Jadwal, Piket & Absensi</span>
                                <div class="d-flex align-items-center gap-1">
                                    @if($jadwalGroupNotifNav > 0)
                                        <span class="badge bg-danger rounded-pill px-2 py-0.5 shadow-sm badge-pulse">{{ $jadwalGroupNotifNav }}</span>
                                    @endif
                                    <i class="bi bi-chevron-down ms-1"></i>
                                </div>
                            </a>
                            <div class="collapse {{ request()->routeIs('piket.*') || request()->routeIs('jadwal.*') || request()->routeIs('absensi.*') || request()->routeIs('admin.izin.*') ? 'show' : '' }} ps-3 mt-1" id="adminJadwalSubmenu">
                                <ul class="list-unstyled mb-0">
                                    <li class="{{ request()->routeIs('admin.izin.*') ? 'active' : '' }} my-1">
                                        <a href="{{ route('admin.izin.index') }}" class="py-2 d-flex align-items-center justify-content-between">
                                            <span><i class="bi bi-shield-lock-fill me-2 text-warning"></i> ACC Izin & Guru Pengganti</span>
                                            @if($adminPendingIzinNav > 0)
                                                <span class="badge bg-danger rounded-pill px-2 py-0.5 shadow-sm badge-pulse" title="{{ $adminPendingIzinNav }} Menunggu ACC Admin">{{ $adminPendingIzinNav }}</span>
                                            @endif
                                        </a>
                                    </li>
                                    <li class="{{ request()->routeIs('absensi.harian') ? 'active' : '' }} my-1">
                                        <a href="{{ route('absensi.harian') }}" class="py-2 d-flex align-items-center justify-content-between">
                                            <span><i class="bi bi-shield-check me-2 text-primary"></i> Presensi Harian Siswa</span>
                                        </a>
                                    </li>
                                    <li class="{{ request()->routeIs('absensi.index') || request()->routeIs('absensi.rekap') ? 'active' : '' }} my-1">
                                        <a href="{{ route('absensi.index') }}" class="py-2 d-flex align-items-center justify-content-between">
                                            <span><i class="bi bi-clipboard-check-fill me-2 text-success"></i> Absensi Per Kelas</span>
                                        </a>
                                    </li>
                                    <li class="{{ request()->routeIs('piket.*') ? 'active' : '' }} my-1">
                                        <a href="{{ route('piket.index') }}" class="py-2 d-flex align-items-center justify-content-between">
                                            <span><i class="bi bi-calendar-check-fill me-2"></i> Tugas Piket Guru</span>
                                        </a>
                                    </li>
                                    <li class="{{ request()->routeIs('jadwal.*') ? 'active' : '' }} my-1">
                                        <a href="{{ route('jadwal.index') }}" class="py-2 d-flex align-items-center justify-content-between">
                                            <span><i class="bi bi-calendar3 me-2"></i> Jadwal Pelajaran</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <!-- Group 3: Tugas & Profil Sekolah -->
                        <li>
                            <a href="#adminAkademikSubmenu" data-bs-toggle="collapse" class="d-flex align-items-center justify-content-between {{ request()->routeIs('tugas.*') || request()->routeIs('profil-sekolah.*') || request()->routeIs('admin.prestasi.*') || request()->routeIs('admin.ekskul.*') || request()->routeIs('admin.cms.*') || request()->routeIs('admin.ppdb.*') ? 'text-white fw-bold' : '' }}">
                                <span><i class="bi bi-gear-wide-connected me-2 text-info"></i> Prestasi, Ekskul & CMS</span>
                                <div class="d-flex align-items-center gap-1">
                                    @if($akademikGroupNotifNav > 0)
                                        <span class="badge bg-danger rounded-pill px-2 py-0.5 shadow-sm badge-pulse">{{ $akademikGroupNotifNav }}</span>
                                    @endif
                                    <i class="bi bi-chevron-down ms-1"></i>
                                </div>
                            </a>
                            <div class="collapse {{ request()->routeIs('tugas.*') || request()->routeIs('profil-sekolah.*') || request()->routeIs('admin.prestasi.*') || request()->routeIs('admin.ekskul.*') || request()->routeIs('admin.cms.*') || request()->routeIs('admin.ppdb.*') ? 'show' : '' }} ps-3 mt-1" id="adminAkademikSubmenu">
                                <ul class="list-unstyled mb-0">
                                    <li class="{{ request()->routeIs('admin.prestasi.*') ? 'active' : '' }} my-1">
                                        <a href="{{ route('admin.prestasi.index') }}" class="py-2 d-flex align-items-center justify-content-between">
                                            <span><i class="bi bi-trophy-fill me-2 text-warning"></i> Prestasi Siswa</span>
                                        </a>
                                    </li>
                                    <li class="{{ request()->routeIs('admin.ekskul.*') ? 'active' : '' }} my-1">
                                        <a href="{{ route('admin.ekskul.index') }}" class="py-2 d-flex align-items-center justify-content-between">
                                            <span><i class="bi bi-palette-fill me-2 text-primary"></i> Ekstrakurikuler</span>
                                            @if($adminPendingEkskulNav > 0)
                                                <span class="badge bg-danger rounded-pill px-2 py-0.5 shadow-sm badge-pulse" title="{{ $adminPendingEkskulNav }} Pendaftaran Ekskul Pending">{{ $adminPendingEkskulNav }}</span>
                                            @endif
                                        </a>
                                    </li>
                                    <li class="{{ request()->routeIs('tugas.*') ? 'active' : '' }} my-1">
                                        <a href="{{ route('tugas.index') }}" class="py-2 d-flex align-items-center justify-content-between">
                                            <span><i class="bi bi-file-earmark-text-fill me-2"></i> Tugas Sekolah</span>
                                            @if($adminPendingTugasNav > 0)
                                                <span class="badge bg-danger rounded-pill px-2 py-0.5 shadow-sm badge-pulse" title="{{ $adminPendingTugasNav }} Tugas Siswa Belum Dinilai">{{ $adminPendingTugasNav }}</span>
                                            @endif
                                        </a>
                                    </li>
                                     <li class="{{ request()->routeIs('admin.cms.*') ? 'active' : '' }} my-1">
                                          <a href="{{ route('admin.cms.index') }}" class="py-2 d-flex align-items-center justify-content-between">
                                              <span><i class="bi bi-globe me-2 text-success"></i> Web Sekolah (CMS)</span>
                                          </a>
                                     </li>
                                     <li class="{{ request()->routeIs('admin.ppdb.*') ? 'active' : '' }} my-1">
                                         <a href="{{ route('admin.ppdb.index') }}" class="py-2 d-flex align-items-center justify-content-between">
                                             <span><i class="bi bi-user-plus-fill me-2 text-warning"></i> Pendaftaran PPDB Online</span>
                                             @if($pendingPpdbNav > 0)
                                                 <span class="badge bg-danger rounded-pill px-2 py-0.5 shadow-sm badge-pulse" title="{{ $pendingPpdbNav }} Pendaftar PPDB Belum Diverifikasi">{{ $pendingPpdbNav }}</span>
                                             @endif
                                         </a>
                                     </li>
                                     <li class="{{ request()->routeIs('profil-sekolah.*') ? 'active' : '' }} my-1">
                                         <a href="{{ route('profil-sekolah.edit') }}" class="py-2">
                                             <i class="bi bi-building-gear me-2"></i> Profil Sekolah
                                         </a>
                                     </li>
                                </ul>
                            </div>
                        </li>
                    @elseif(Auth::user()->isGuru())
                        @php
                            $guruPendingIzinNav = 0;
                            $guruSubstituteNav = 0;
                            $guruPendingClassesTodayNav = 0;
                            $pendingGradesNav = 0;

                            if (Auth::user()->guru) {
                                $guruId = Auth::user()->guru->id;
                                $guruPendingIzinNav = \App\Models\IzinGuru::where('guru_id', $guruId)->where('status', 'Pending')->count();
                                $guruSubstituteNav = \App\Models\IzinGuru::where('guru_pengganti_id', $guruId)->where('status', 'Disetujui')->where('tanggal_mulai', '<=', date('Y-m-d'))->where('tanggal_selesai', '>=', date('Y-m-d'))->count();
                                
                                $todayNameNav = \Carbon\Carbon::now()->locale('id')->isoFormat('dddd');
                                $myTodayClassesNav = \App\Models\JadwalPelajaran::where('guru_id', $guruId)->where('hari', $todayNameNav)->pluck('kelas')->unique();
                                $todayDoneClassesNav = \App\Models\Absensi::where('tanggal', date('Y-m-d'))->where('guru_id', $guruId)->pluck('kelas')->unique();
                                $guruPendingClassesTodayNav = $myTodayClassesNav->diff($todayDoneClassesNav)->count();

                                $myTugasIdsNav = \App\Models\Tugas::where('guru_id', $guruId)->pluck('id');
                                $pendingGradesNav = \App\Models\TugasSubmission::whereIn('tugas_id', $myTugasIdsNav)->whereNull('nilai')->count();
                            }
                            $totalGuruIzinNotif = $guruPendingIzinNav + $guruSubstituteNav;
                            $totalActiveSiswaNav = \App\Models\Siswa::where('status', '!=', 'Lulus')->count();
                            $todayAbNav = \App\Models\Absensi::where('tanggal', date('Y-m-d'))->count();
                            $guruTodayBelumNav = max(0, $totalActiveSiswaNav - $todayAbNav);

                            $totalHeaderNotif = $pendingGradesNav + $guruPendingClassesTodayNav + $totalGuruIzinNotif;
                        @endphp

                        <!-- 1. Pengajuan Izin / Sakit Saya -->
                        <li class="{{ request()->routeIs('guru.izin.*') ? 'active' : '' }}">
                            <a href="{{ route('guru.izin.index') }}" class="d-flex align-items-center justify-content-between">
                                <span><i class="bi bi-calendar-event-fill text-warning me-2"></i> Pengajuan Izin / Sakit Saya</span>
                                @if($totalGuruIzinNotif > 0)
                                    <span class="badge bg-warning text-dark rounded-pill px-2 py-1 shadow-sm badge-pulse" title="{{ $totalGuruIzinNotif }} Notifikasi Izin / Tugas Pengganti">{{ $totalGuruIzinNotif }}</span>
                                @endif
                            </a>
                        </li>

                        <!-- 2. Presensi Harian Siswa -->
                        <li class="{{ request()->routeIs('absensi.harian') ? 'active' : '' }}">
                            <a href="{{ route('absensi.harian') }}" class="d-flex align-items-center justify-content-between">
                                <span><i class="bi bi-shield-check text-primary me-2"></i> Presensi Harian Siswa</span>
                                @if($guruTodayBelumNav > 0)
                                    <span class="badge bg-info text-dark rounded-pill px-2 py-1 shadow-sm" title="{{ $guruTodayBelumNav }} Siswa Belum Diabsen Hari Ini">{{ $guruTodayBelumNav }}</span>
                                @endif
                            </a>
                        </li>

                        <!-- 3. Input Absensi Kelas -->
                        <li class="{{ request()->routeIs('absensi.index') || request()->routeIs('absensi.rekap') ? 'active' : '' }}">
                            <a href="{{ route('absensi.index') }}" class="d-flex align-items-center justify-content-between">
                                <span><i class="bi bi-clipboard-check-fill text-success me-2"></i> Input Absensi Kelas</span>
                                @if($guruPendingClassesTodayNav > 0)
                                    <span class="badge bg-warning text-dark rounded-pill px-2 py-1 shadow-sm badge-pulse" title="{{ $guruPendingClassesTodayNav }} Kelas Belum Diabsen Hari Ini">{{ $guruPendingClassesTodayNav }}</span>
                                @endif
                            </a>
                        </li>

                        <!-- 4. Buat & Kelola Tugas -->
                        <li class="{{ request()->routeIs('tugas.*') ? 'active' : '' }}">
                            <a href="{{ route('tugas.index') }}" class="d-flex align-items-center justify-content-between">
                                <span><i class="bi bi-file-earmark-plus-fill me-2 text-info"></i> Buat & Kelola Tugas</span>
                                @if($pendingGradesNav > 0)
                                    <span class="badge bg-danger rounded-pill px-2 py-1 shadow-sm badge-pulse" title="{{ $pendingGradesNav }} Tugas Siswa Belum Dinilai">{{ $pendingGradesNav }}</span>
                                @endif
                            </a>
                        </li>

                        <!-- 5. Jadwal & Piket Guru -->
                        <li>
                            <a href="#guruJadwalSubmenu" data-bs-toggle="collapse" class="d-flex align-items-center justify-content-between {{ request()->routeIs('piket.*') || request()->routeIs('jadwal.*') ? 'text-white font-bold' : '' }}">
                                <span><i class="bi bi-calendar-range-fill me-2 text-warning"></i> Jadwal & Piket Guru</span>
                                <i class="bi bi-chevron-down"></i>
                            </a>
                            <div class="collapse {{ request()->routeIs('piket.*') || request()->routeIs('jadwal.*') ? 'show' : '' }} ps-3 mt-1" id="guruJadwalSubmenu">
                                <ul class="list-unstyled mb-0">
                                    <li class="{{ request()->routeIs('piket.*') ? 'active' : '' }} my-1">
                                        <a href="{{ route('piket.index') }}" class="py-2 d-flex align-items-center justify-content-between">
                                            <span><i class="bi bi-calendar-check-fill me-2"></i> Jadwal Piket</span>
                                        </a>
                                    </li>
                                    <li class="{{ request()->routeIs('jadwal.*') ? 'active' : '' }} my-1">
                                        <a href="{{ route('jadwal.index') }}" class="py-2 d-flex align-items-center justify-content-between">
                                            <span><i class="bi bi-calendar3 me-2"></i> Jadwal Mengajar Guru</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @else
                        @php
                            $siswaPointsNav = 0;
                            $siswaTodayTeacherLeaveNav = 0;
                            $pendingCountNav = 0;
                            $siswaPendingEkskulNav = 0;

                            if (Auth::user()->siswa) {
                                $siswaKelas = Auth::user()->siswa->kelas;
                                $siswaId = Auth::user()->siswa->id;

                                $siswaPointsNav = Auth::user()->siswa->pelanggaran()->sum('point');
                                $siswaTodayTeacherLeaveNav = \App\Models\IzinGuru::where('status', 'Disetujui')
                                    ->where('tanggal_mulai', '<=', date('Y-m-d'))
                                    ->where('tanggal_selesai', '>=', date('Y-m-d'))
                                    ->count();

                                $allTugasIds = \App\Models\Tugas::where('kelas', $siswaKelas)->pluck('id');
                                $submittedTugasIds = \App\Models\TugasSubmission::where('siswa_id', $siswaId)->pluck('tugas_id');
                                $pendingCountNav = $allTugasIds->diff($submittedTugasIds)->count();

                                $siswaPendingEkskulNav = \App\Models\PendaftaranEkskul::where('siswa_id', $siswaId)->where('status', 'Pending')->count();
                            }

                            $totalHeaderNotif = $pendingCountNav + $siswaPendingEkskulNav + $siswaTodayTeacherLeaveNav;
                        @endphp

                        <li class="{{ request()->routeIs('siswa.profile') ? 'active' : '' }}">
                            <a href="{{ route('siswa.profile') }}" class="d-flex align-items-center justify-content-between">
                                <span><i class="bi bi-person-badge-fill me-2"></i> Profil Saya</span>
                                @if($siswaPointsNav > 0)
                                    <span class="badge bg-danger rounded-pill px-2 py-1 shadow-sm" title="{{ $siswaPointsNav }} Poin Pelanggaran">{{ $siswaPointsNav }} Pts</span>
                                @endif
                            </a>
                        </li>
                        @if(Auth::user()->siswa?->status !== 'Lulus')
                            <li class="{{ request()->routeIs('siswa.jadwal') ? 'active' : '' }}">
                                <a href="{{ route('siswa.jadwal') }}" class="d-flex align-items-center justify-content-between">
                                    <span><i class="bi bi-calendar3 me-2 text-warning"></i> Jadwal Pelajaran</span>
                                    @if($siswaTodayTeacherLeaveNav > 0)
                                        <span class="badge bg-warning text-dark rounded-pill px-2 py-1 shadow-sm" title="{{ $siswaTodayTeacherLeaveNav }} Guru Izin / Guru Pengganti Hari Ini">{{ $siswaTodayTeacherLeaveNav }}</span>
                                    @endif
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('siswa.tugas') ? 'active' : '' }}">
                                <a href="{{ route('siswa.tugas') }}" class="d-flex align-items-center justify-content-between">
                                    <span><i class="bi bi-file-earmark-text-fill me-2 text-info"></i> Tugas Sekolah</span>
                                    @if($pendingCountNav > 0)
                                        <span class="badge bg-danger rounded-pill shadow-sm px-2 py-1 badge-pulse" title="{{ $pendingCountNav }} Tugas Belum Dikumpulkan">{{ $pendingCountNav }}</span>
                                    @endif
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('siswa.ekskul') ? 'active' : '' }}">
                                <a href="{{ route('siswa.ekskul') }}" class="d-flex align-items-center justify-content-between">
                                    <span><i class="bi bi-palette-fill me-2 text-primary"></i> Ekstrakurikuler</span>
                                    @if($siswaPendingEkskulNav > 0)
                                        <span class="badge bg-warning text-dark rounded-pill shadow-sm px-2 py-1 badge-pulse" title="{{ $siswaPendingEkskulNav }} Pendaftaran Ekskul Menunggu ACC">{{ $siswaPendingEkskulNav }}</span>
                                    @endif
                                </a>
                            </li>
                        @endif
                    @endif

                    <!-- Link Beranda Utama Sekolah & Logout untuk Semua Akun -->
                    <li class="mt-4 pt-3 border-top border-secondary border-opacity-25 {{ request()->routeIs('landing_page') ? 'active' : '' }}">
                        <a href="{{ route('landing_page') }}" target="_blank" class="d-flex align-items-center justify-content-between">
                            <span><i class="bi bi-globe text-info me-2"></i> Beranda Utama Sekolah</span>
                            <i class="bi bi-box-arrow-up-right small text-muted"></i>
                        </a>
                    </li>
                    <li class="mt-2">
                        <form method="POST" action="{{ route('logout') }}" id="sidebar-logout-form" class="d-none">
                            @csrf
                        </form>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();" class="text-danger fw-bold d-flex align-items-center justify-content-between py-2 px-3 rounded-2" style="background-color: rgba(220, 53, 69, 0.1);" title="Keluar Akun">
                            <span><i class="bi bi-box-arrow-right me-2 text-danger fs-5"></i> Log Out Akun</span>
                            <span class="badge bg-danger text-white small px-2 py-1">Keluar</span>
                        </a>
                    </li>
                @endauth
            </ul>
        </nav>

        <!-- Page Content -->
        <div id="content-area">
            <!-- Top Bar with Android Mobile Hamburger Button & Notification Bell -->
            <div class="top-navbar d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-light border p-2 d-lg-none rounded-3" id="sidebarCollapse" aria-label="Toggle Navigation">
                        <i class="bi bi-list fs-4 text-dark"></i>
                    </button>
                    <div class="header-title">
                        <h5 class="mb-0 fw-bold text-dark">
                            @if(Auth::user()->isAdmin())
                                Panel Admin
                            @elseif(Auth::user()->isGuru())
                                Portal Guru ({{ Auth::user()->guru->mata_pelajaran ?? 'Guru' }})
                            @else
                                Portal Siswa
                            @endif
                        </h5>
                    </div>
                </div>
                
                <div class="d-flex align-items-center gap-2">
                    @auth
                        <!-- Header Bell Notification Dropdown -->
                        @php
                            $totalHeaderNotif = $totalHeaderNotif ?? 0;
                        @endphp
                        <div class="dropdown me-1">
                            <button class="btn btn-light position-relative rounded-circle p-2 text-secondary border-0 shadow-sm" type="button" id="notifHeaderDropdown" data-bs-toggle="dropdown" aria-expanded="false" title="Notifikasi Baru">
                                <i class="bi bi-bell-fill fs-5 text-dark"></i>
                                @if($totalHeaderNotif > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger shadow-sm badge-pulse" style="font-size: 0.68rem; padding: 0.25em 0.55em;">
                                        {{ $totalHeaderNotif }}
                                    </span>
                                @endif
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3 p-2 mt-2" aria-labelledby="notifHeaderDropdown" style="width: 310px; max-height: 380px; overflow-y: auto;">
                                <li class="dropdown-header text-uppercase fw-bold text-dark border-bottom pb-2 mb-2 d-flex justify-content-between align-items-center">
                                    <span><i class="bi bi-bell me-1 text-primary"></i> Notifikasi Terbaru</span>
                                    @if($totalHeaderNotif > 0)
                                        <span class="badge bg-danger rounded-pill">{{ $totalHeaderNotif }} Baru</span>
                                    @else
                                        <span class="badge bg-success rounded-pill">0</span>
                                    @endif
                                </li>

                                @if(Auth::user()->isSiswa())
                                    @if($pendingCountNav > 0)
                                        <li>
                                            <a class="dropdown-item rounded-2 p-2 mb-1 border-bottom d-flex align-items-start gap-2" href="{{ route('siswa.tugas') }}">
                                                <span class="badge bg-danger p-2 rounded-circle mt-1"><i class="bi bi-file-earmark-text text-white fs-6"></i></span>
                                                <div>
                                                    <div class="fw-bold small text-dark">Tugas Belum Dikumpulkan</div>
                                                    <div class="text-muted small" style="font-size: 0.8rem;">Ada {{ $pendingCountNav }} tugas kelas belum Anda kerjakan.</div>
                                                </div>
                                            </a>
                                        </li>
                                    @endif
                                    @if($siswaPendingEkskulNav > 0)
                                        <li>
                                            <a class="dropdown-item rounded-2 p-2 mb-1 border-bottom d-flex align-items-start gap-2" href="{{ route('siswa.ekskul') }}">
                                                <span class="badge bg-warning p-2 rounded-circle mt-1"><i class="bi bi-palette text-dark fs-6"></i></span>
                                                <div>
                                                    <div class="fw-bold small text-dark">Pendaftaran Ekskul Pending</div>
                                                    <div class="text-muted small" style="font-size: 0.8rem;">Pendaftaran ekskul Anda menunggu verifikasi admin.</div>
                                                </div>
                                            </a>
                                        </li>
                                    @endif
                                    @if($siswaTodayTeacherLeaveNav > 0)
                                        <li>
                                            <a class="dropdown-item rounded-2 p-2 mb-1 border-bottom d-flex align-items-start gap-2" href="{{ route('siswa.jadwal') }}">
                                                <span class="badge bg-info p-2 rounded-circle mt-1"><i class="bi bi-calendar-event text-white fs-6"></i></span>
                                                <div>
                                                    <div class="fw-bold small text-dark">Informasi Guru Izin</div>
                                                    <div class="text-muted small" style="font-size: 0.8rem;">Ada {{ $siswaTodayTeacherLeaveNav }} guru izin / pengganti hari ini.</div>
                                                </div>
                                            </a>
                                        </li>
                                    @endif
                                @elseif(Auth::user()->isGuru())
                                    @if($pendingGradesNav > 0)
                                        <li>
                                            <a class="dropdown-item rounded-2 p-2 mb-1 border-bottom d-flex align-items-start gap-2" href="{{ route('tugas.index') }}">
                                                <span class="badge bg-danger p-2 rounded-circle mt-1"><i class="bi bi-clipboard-check text-white fs-6"></i></span>
                                                <div>
                                                    <div class="fw-bold small text-dark">Tugas Siswa Perlu Penilaian</div>
                                                    <div class="text-muted small" style="font-size: 0.8rem;">Ada {{ $pendingGradesNav }} jawaban siswa belum Anda beri nilai.</div>
                                                </div>
                                            </a>
                                        </li>
                                    @endif
                                    @if($guruPendingClassesTodayNav > 0)
                                        <li>
                                            <a class="dropdown-item rounded-2 p-2 mb-1 border-bottom d-flex align-items-start gap-2" href="{{ route('absensi.index') }}">
                                                <span class="badge bg-warning p-2 rounded-circle mt-1"><i class="bi bi-calendar-check text-dark fs-6"></i></span>
                                                <div>
                                                    <div class="fw-bold small text-dark">Absensi Kelas Hari Ini</div>
                                                    <div class="text-muted small" style="font-size: 0.8rem;">Ada {{ $guruPendingClassesTodayNav }} kelas belum di-absensi.</div>
                                                </div>
                                            </a>
                                        </li>
                                    @endif
                                    @if($totalGuruIzinNotif > 0)
                                        <li>
                                            <a class="dropdown-item rounded-2 p-2 mb-1 border-bottom d-flex align-items-start gap-2" href="{{ route('guru.izin.index') }}">
                                                <span class="badge bg-info p-2 rounded-circle mt-1"><i class="bi bi-clock-history text-white fs-6"></i></span>
                                                <div>
                                                    <div class="fw-bold small text-dark">Status Izin / Guru Pengganti</div>
                                                    <div class="text-muted small" style="font-size: 0.8rem;">Cek status pengajuan izin atau tugas mengajar pengganti.</div>
                                                </div>
                                            </a>
                                        </li>
                                    @endif
                                @elseif(Auth::user()->isAdmin())
                                    @if($pendingPpdbNav > 0)
                                        <li>
                                            <a class="dropdown-item rounded-2 p-2 mb-1 border-bottom d-flex align-items-start gap-2" href="{{ route('admin.ppdb.index') }}">
                                                <span class="badge bg-warning p-2 rounded-circle mt-1"><i class="bi bi-person-plus text-dark fs-6"></i></span>
                                                <div>
                                                    <div class="fw-bold small text-dark">Pendaftaran PPDB Baru</div>
                                                    <div class="text-muted small" style="font-size: 0.8rem;">Ada {{ $pendingPpdbNav }} calon siswa baru belum diverifikasi.</div>
                                                </div>
                                            </a>
                                        </li>
                                    @endif
                                    @if($adminPendingIzinNav > 0)
                                        <li>
                                            <a class="dropdown-item rounded-2 p-2 mb-1 border-bottom d-flex align-items-start gap-2" href="{{ route('admin.izin.index') }}">
                                                <span class="badge bg-danger p-2 rounded-circle mt-1"><i class="bi bi-shield-lock text-white fs-6"></i></span>
                                                <div>
                                                    <div class="fw-bold small text-dark">ACC Izin Guru Pending</div>
                                                    <div class="text-muted small" style="font-size: 0.8rem;">Ada {{ $adminPendingIzinNav }} permohonan izin guru belum di-ACC.</div>
                                                </div>
                                            </a>
                                        </li>
                                    @endif
                                    @if($adminPendingAlumniNav > 0)
                                        <li>
                                            <a class="dropdown-item rounded-2 p-2 mb-1 border-bottom d-flex align-items-start gap-2" href="{{ route('admin.alumni.index') }}">
                                                <span class="badge bg-info p-2 rounded-circle mt-1"><i class="bi bi-mortarboard text-white fs-6"></i></span>
                                                <div>
                                                    <div class="fw-bold small text-dark">Tracer Alumni Baru</div>
                                                    <div class="text-muted small" style="font-size: 0.8rem;">Ada {{ $adminPendingAlumniNav }} data alumni menunggu verifikasi.</div>
                                                </div>
                                            </a>
                                        </li>
                                    @endif
                                    @if($adminPendingEkskulNav > 0)
                                        <li>
                                            <a class="dropdown-item rounded-2 p-2 mb-1 border-bottom d-flex align-items-start gap-2" href="{{ route('admin.ekskul.index') }}">
                                                <span class="badge bg-primary p-2 rounded-circle mt-1"><i class="bi bi-palette text-white fs-6"></i></span>
                                                <div>
                                                    <div class="fw-bold small text-dark">Pendaftaran Ekskul Siswa</div>
                                                    <div class="text-muted small" style="font-size: 0.8rem;">Ada {{ $adminPendingEkskulNav }} pengajuan ekskul perlu persetujuan.</div>
                                                </div>
                                            </a>
                                        </li>
                                    @endif
                                    @if($adminPendingTugasNav > 0)
                                        <li>
                                            <a class="dropdown-item rounded-2 p-2 mb-1 border-bottom d-flex align-items-start gap-2" href="{{ route('tugas.index') }}">
                                                <span class="badge bg-secondary p-2 rounded-circle mt-1"><i class="bi bi-file-earmark-text text-white fs-6"></i></span>
                                                <div>
                                                    <div class="fw-bold small text-dark">Pengumpulan Tugas Siswa</div>
                                                    <div class="text-muted small" style="font-size: 0.8rem;">Ada {{ $adminPendingTugasNav }} tugas siswa belum dinilai guru.</div>
                                                </div>
                                            </a>
                                        </li>
                                    @endif
                                @endif

                                @if($totalHeaderNotif == 0)
                                    <li class="py-3 text-center">
                                        <i class="bi bi-check-circle-fill text-success fs-3 d-block mb-1"></i>
                                        <span class="text-muted small fw-semibold">Tidak ada notifikasi baru.<br>Semua tugas &amp; aksi sudah selesai!</span>
                                    </li>
                                @endif
                            </ul>
                        </div>

                        <!-- User Profile Link -->
                        <a href="{{ Auth::user()->isSiswa() ? route('siswa.profile') : route('profile.edit') }}" class="text-decoration-none d-flex align-items-center me-2 text-dark" title="Profil Saya">
                            @if(Auth::user()->foto)
                                <img src="{{ asset('storage/'.Auth::user()->foto) }}" width="34" height="34" class="rounded-circle object-fit-cover me-1 me-sm-2 border shadow-sm">
                            @elseif(Auth::user()->isGuru() && Auth::user()->guru && Auth::user()->guru->foto)
                                <img src="{{ asset('storage/'.Auth::user()->guru->foto) }}" width="34" height="34" class="rounded-circle object-fit-cover me-1 me-sm-2 border shadow-sm">
                            @elseif(Auth::user()->isSiswa() && Auth::user()->siswa && Auth::user()->siswa->foto)
                                <img src="{{ asset('storage/'.Auth::user()->siswa->foto) }}" width="34" height="34" class="rounded-circle object-fit-cover me-1 me-sm-2 border shadow-sm">
                            @else
                                <i class="bi bi-person-circle text-primary me-1 fs-4"></i>
                            @endif
                            <span class="fw-semibold small d-none d-sm-inline me-1">{{ Auth::user()->name }}</span>
                        </a>

                        <!-- Logout Button in Top Navbar -->
                        <form method="POST" action="{{ route('logout') }}" id="topbar-logout-form" class="d-none">
                            @csrf
                        </form>
                        <a class="btn btn-danger btn-sm px-2 px-sm-3 d-flex align-items-center gap-1 shadow-sm fw-bold" href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('topbar-logout-form').submit();" title="Keluar dari akun">
                            <i class="bi bi-box-arrow-right"></i> <span class="d-none d-sm-inline">Log Out</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-sm px-3 fw-bold">Log In</a>
                    @endauth
                </div>
            </div>

            <!-- Main Content Slot -->
            <div class="main-container">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Mobile Sidebar JavaScript Toggle for Android -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarCollapse');
            const sidebarClose = document.getElementById('sidebarClose');
            const sidebar = document.getElementById('sidebar');

            // Create Backdrop Overlay
            const overlay = document.createElement('div');
            overlay.className = 'sidebar-overlay';
            document.body.appendChild(overlay);

            function toggleSidebar() {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            }

            function closeSidebar() {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            }

            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', toggleSidebar);
            }

            if (sidebarClose) {
                sidebarClose.addEventListener('click', closeSidebar);
            }

            overlay.addEventListener('click', closeSidebar);

            // Close sidebar when tapping a link on Android mobile screen
            const sidebarLinks = sidebar.querySelectorAll('a:not([data-bs-toggle="collapse"])');
            sidebarLinks.forEach(function(link) {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 992) {
                        closeSidebar();
                    }
                });
            });
        });

        // Global Automatic Jurusan Sync JavaScript
        document.addEventListener('DOMContentLoaded', function() {
            function autoSyncJurusan(kelasSelect) {
                if (!kelasSelect) return;
                const form = kelasSelect.closest('form') || document;
                const jurusanSelect = form.querySelector('select[name="jurusan"]') || form.querySelector('#jurusan');
                if (!jurusanSelect) return;

                const rawKelas = kelasSelect.value ? kelasSelect.value.trim().toUpperCase() : '';
                if (!rawKelas) return;

                const tokens = rawKelas.split(/\s+/);
                let matchedOption = null;

                const majorMap = {
                    'DKV': ['DKV', 'DESAIN KOMUNIKASI VISUAL'],
                    'RPL': ['RPL', 'REKAYASA PERANGKAT LUNAK'],
                    'TKJ': ['TKJ', 'TEKNIK KOMPUTER'],
                    'MM': ['MM', 'MULTIMEDIA'],
                    'AKL': ['AKL', 'AKUNTANSI'],
                    'AK': ['AK', 'AKUNTANSI'],
                    'TKR': ['TKR', 'TEKNIK KENDARAAN RINGAN'],
                    'TSM': ['TSM', 'TEKNIK SEPEDA MOTOR'],
                    'OTKP': ['OTKP', 'OTOMATISASI', 'PERKANTORAN'],
                    'BDP': ['BDP', 'BISNIS DARING', 'PEMASARAN'],
                    'TB': ['TB', 'TATA BOGA'],
                    'TITL': ['TITL', 'TEKNIK INSTALASI'],
                    'TP': ['TP', 'TEKNIK PEMESINAN']
                };

                const options = Array.from(jurusanSelect.options);

                for (let opt of options) {
                    if (!opt.value) continue;
                    const optVal = opt.value.toUpperCase();
                    const optText = opt.text.toUpperCase();

                    for (let token of tokens) {
                        if (token.length >= 2) {
                            if (optVal.includes(token) || optText.includes(token) || token.includes(optVal)) {
                                matchedOption = opt;
                                break;
                            }
                            if (majorMap[token]) {
                                for (let alias of majorMap[token]) {
                                    if (optVal.includes(alias) || optText.includes(alias)) {
                                        matchedOption = opt;
                                        break;
                                    }
                                }
                            }
                        }
                        if (matchedOption) break;
                    }
                    if (matchedOption) break;
                }

                if (matchedOption) {
                    jurusanSelect.value = matchedOption.value;
                    jurusanSelect.classList.add('is-valid');
                    setTimeout(() => jurusanSelect.classList.remove('is-valid'), 2000);

                    const syncBadge = form.querySelector('#jurusanSyncBadge');
                    if (syncBadge) {
                        syncBadge.style.display = 'inline-block';
                        syncBadge.textContent = '✨ Otomatis Terpilih: ' + matchedOption.value;
                    }
                }
            }

            document.addEventListener('change', function(e) {
                if (e.target && (e.target.name === 'kelas' || e.target.id === 'kelas' || e.target.id === 'kelas_select')) {
                    autoSyncJurusan(e.target);
                }
            });
        });

        // Global Toggle Password Show / Hide JavaScript
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.toggle-password');
            if (btn) {
                const targetId = btn.getAttribute('data-target');
                let input = targetId ? document.getElementById(targetId) : null;
                if (!input) {
                    const container = btn.closest('.input-group') || btn.closest('.position-relative') || btn.parentElement;
                    input = container ? container.querySelector('input') : null;
                }
                if (input) {
                    const isPassword = input.type === 'password';
                    input.type = isPassword ? 'text' : 'password';
                    const icon = btn.querySelector('i');
                    if (icon) {
                        if (isPassword) {
                            icon.className = 'bi bi-eye-slash-fill text-primary';
                        } else {
                            icon.className = 'bi bi-eye';
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
