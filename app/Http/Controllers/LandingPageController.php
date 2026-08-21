<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Berita;
use App\Models\Ekstrakurikuler;
use App\Models\Faq;
use App\Models\Fasilitas;
use App\Models\Galeri;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\PrestasiSiswa;
use App\Models\ProfilSekolah;
use App\Models\Siswa;
use App\Models\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class LandingPageController extends Controller
{
    public function index()
    {
        // Counts for stats
        $siswaCount = Schema::hasTable('siswas') ? (Siswa::count() ?: 500) : 500;
        $guruCount = Schema::hasTable('gurus') ? (Guru::count() ?: 50) : 50;
        $alumniCount = 1000; // Static for now
        $tahunDedikasi = 25; // Static for now

        // Get single records
        $profil = Schema::hasTable('profil_sekolahs') ? ProfilSekolah::first() : null;
        $prestasiUtama = Schema::hasTable('prestasi_siswas') ? PrestasiSiswa::latest()->first() : null;
        $prestasiList = Schema::hasTable('prestasi_siswas') ? PrestasiSiswa::orderBy('tahun', 'desc')->get() : collect();

        // Get multiple records
        $jurusans = Schema::hasTable('jurusans') ? Jurusan::where('is_active', true)->get() : collect();
        $fasilitas = Schema::hasTable('fasilitas') ? Fasilitas::where('is_active', true)->get() : collect();
        $ekstrakurikuler = Schema::hasTable('ekstrakurikulers') ? Ekstrakurikuler::where('status', 'Aktif')->get() : collect();
        
        // Berita queries
        $beritasAll = Schema::hasTable('beritas') ? Berita::where('is_active', true)->orderBy('tanggal_publikasi', 'desc')->orderBy('created_at', 'desc')->get() : collect();
        $beritaHighlight = $beritasAll->where('is_highlight', true)->first() ?: $beritasAll->first();
        $beritaList = $beritaHighlight ? $beritasAll->where('id', '!=', $beritaHighlight->id)->take(3) : collect();

        // Agenda & Event queries
        $agendas = Schema::hasTable('agendas') ? Agenda::where('is_active', true)->orderBy('tanggal', 'asc')->get() : collect();

        $galeri = Schema::hasTable('galeris') ? Galeri::where('is_active', true)->get() : collect();
        $testimoni = Schema::hasTable('testimonis') ? Testimoni::where('is_active', true)->get() : collect();
        $faqs = Schema::hasTable('faqs') ? Faq::where('is_active', true)->orderBy('urutan')->get() : collect();
        $gurus = Schema::hasTable('gurus') ? Guru::where('is_active', true)->orderBy('nama')->get() : collect();
        $staffs = Schema::hasTable('staffs') ? \App\Models\Staff::where('is_active', true)->orderBy('nama')->get() : collect();

        return view('landing page.landing_page', compact(
            'siswaCount', 'guruCount', 'alumniCount', 'tahunDedikasi',
            'profil', 'prestasiUtama', 'prestasiList', 'jurusans', 'fasilitas',
            'ekstrakurikuler', 'beritaHighlight', 'beritaList', 'agendas',
            'galeri', 'testimoni', 'faqs', 'gurus', 'staffs'
        ));
    }

    public function sambutan() {
        $profil = Schema::hasTable('profil_sekolahs') ? ProfilSekolah::first() : null;
        return view('landing page.pages.sambutan', compact('profil'));
    }

    public function sejarah() {
        $profil = Schema::hasTable('profil_sekolahs') ? ProfilSekolah::first() : null;
        return view('landing page.pages.sejarah', compact('profil'));
    }

    public function visiMisi() {
        $profil = Schema::hasTable('profil_sekolahs') ? ProfilSekolah::first() : null;
        return view('landing page.pages.visi_misi', compact('profil'));
    }

    public function guruStaff() {
        $profil = Schema::hasTable('profil_sekolahs') ? ProfilSekolah::first() : null;
        $gurus = Schema::hasTable('gurus') ? Guru::where('is_active', true)->orderBy('nama')->get() : collect();
        $staffs = Schema::hasTable('staffs') ? \App\Models\Staff::where('is_active', true)->orderBy('nama')->get() : collect();
        return view('landing page.pages.guru_staff', compact('profil', 'gurus', 'staffs'));
    }

    public function kurikulum() {
        $profil = Schema::hasTable('profil_sekolahs') ? ProfilSekolah::first() : null;
        return view('landing page.pages.kurikulum', compact('profil'));
    }

    public function pengumuman() {
        $profil = Schema::hasTable('profil_sekolahs') ? ProfilSekolah::first() : null;
        $beritas = Schema::hasTable('beritas') ? Berita::where('is_active', true)->latest()->get() : collect();
        return view('landing page.pages.pengumuman', compact('profil', 'beritas'));
    }

    public function agenda() {
        $profil = Schema::hasTable('profil_sekolahs') ? ProfilSekolah::first() : null;
        $agendas = Schema::hasTable('agendas') ? Agenda::where('is_active', true)->orderBy('tanggal', 'desc')->get() : collect();
        return view('landing page.pages.agenda', compact('profil', 'agendas'));
    }
}
