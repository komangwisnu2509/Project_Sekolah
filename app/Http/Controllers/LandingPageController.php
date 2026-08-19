<?php

namespace App\Http\Controllers;

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
        $jurusans = Schema::hasTable('jurusans') ? Jurusan::all() : collect();
        $fasilitas = Schema::hasTable('fasilitas') ? Fasilitas::all() : collect();
        $ekstrakurikuler = Schema::hasTable('ekstrakurikulers') ? Ekstrakurikuler::all() : collect();
        $beritaHighlight = Schema::hasTable('beritas') ? Berita::where('is_highlight', true)->latest()->first() : null;
        $beritaList = (Schema::hasTable('beritas') && $beritaHighlight) ? Berita::where('id', '!=', $beritaHighlight->id)->latest()->take(3)->get() : collect();
        $galeri = Schema::hasTable('galeris') ? Galeri::all() : collect();
        $testimoni = Schema::hasTable('testimonis') ? Testimoni::all() : collect();
        $faqs = Schema::hasTable('faqs') ? Faq::all() : collect();

        return view('landing page.landing_page', compact(
            'siswaCount', 'guruCount', 'alumniCount', 'tahunDedikasi',
            'profil', 'prestasiUtama', 'prestasiList', 'jurusans', 'fasilitas',
            'ekstrakurikuler', 'beritaHighlight', 'beritaList',
            'galeri', 'testimoni', 'faqs'
        ));
    }

    public function sambutan() {
        return view('landing page.pages.sambutan');
    }

    public function sejarah() {
        return view('landing page.pages.sejarah');
    }

    public function visiMisi() {
        $profil = ProfilSekolah::first();
        return view('landing page.pages.visi_misi', compact('profil'));
    }

    public function guruStaff() {
        $gurus = Guru::all();
        return view('landing page.pages.guru_staff', compact('gurus'));
    }

    public function kurikulum() {
        return view('landing page.pages.kurikulum');
    }

    public function pengumuman() {
        return view('landing page.pages.pengumuman');
    }

    public function agenda() {
        return view('landing page.pages.agenda');
    }
}
