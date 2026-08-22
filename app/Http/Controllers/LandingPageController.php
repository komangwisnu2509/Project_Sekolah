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

    public function tentangSekolah() {
        $profil = Schema::hasTable('profil_sekolahs') ? ProfilSekolah::first() : null;
        $siswaCount = Schema::hasTable('siswas') ? (Siswa::count() ?: 500) : 500;
        $guruCount = Schema::hasTable('gurus') ? (Guru::count() ?: 50) : 50;
        $alumniCount = 1000;
        $tahunDedikasi = 25;
        $jurusans = Schema::hasTable('jurusans') ? Jurusan::where('is_active', true)->get() : collect();
        $fasilitas = Schema::hasTable('fasilitas') ? Fasilitas::where('is_active', true)->take(4)->get() : collect();

        return view('landing page.pages.tentang_sekolah', compact('profil', 'siswaCount', 'guruCount', 'alumniCount', 'tahunDedikasi', 'jurusans', 'fasilitas'));
    }

    public function fasilitasSekolah() {
        $profil = Schema::hasTable('profil_sekolahs') ? ProfilSekolah::first() : null;
        $fasilitas = Schema::hasTable('fasilitas') ? Fasilitas::where('is_active', true)->get() : collect();

        return view('landing page.pages.fasilitas_sekolah', compact('profil', 'fasilitas'));
    }

    public function ekstrakurikulerSekolah() {
        $profil = Schema::hasTable('profil_sekolahs') ? ProfilSekolah::first() : null;
        $ekstrakurikulers = Schema::hasTable('ekstrakurikulers') ? Ekstrakurikuler::where('status', 'Aktif')->get() : collect();

        return view('landing page.pages.ekstrakurikuler_sekolah', compact('profil', 'ekstrakurikulers'));
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

    public function berita(Request $request) {
        $profil = Schema::hasTable('profil_sekolahs') ? ProfilSekolah::first() : null;
        $q = $request->get('q');
        $kategori = $request->get('kategori');

        $query = Berita::where('is_active', true);
        if ($q) {
            $query->where(function($querySql) use ($q) {
                $querySql->where('judul', 'LIKE', "%{$q}%")
                         ->orWhere('ringkasan', 'LIKE', "%{$q}%")
                         ->orWhere('konten', 'LIKE', "%{$q}%");
            });
        }
        if ($kategori) {
            $query->where('kategori', $kategori);
        }

        $beritas = $query->orderBy('tanggal_publikasi', 'desc')->orderBy('created_at', 'desc')->get();
        $kategoris = Berita::where('is_active', true)->whereNotNull('kategori')->distinct()->pluck('kategori');
        $beritaHighlight = Berita::where('is_active', true)->where('is_highlight', true)->latest()->first();

        return view('landing page.pages.berita', compact('profil', 'beritas', 'kategoris', 'q', 'kategori', 'beritaHighlight'));
    }

    public function beritaDetail($id) {
        $profil = Schema::hasTable('profil_sekolahs') ? ProfilSekolah::first() : null;
        $berita = Berita::where('is_active', true)->findOrFail($id);
        
        $beritaLainnya = Berita::where('is_active', true)
            ->where('id', '!=', $berita->id)
            ->orderBy('tanggal_publikasi', 'desc')
            ->take(5)
            ->get();

        return view('landing page.pages.berita_detail', compact('profil', 'berita', 'beritaLainnya'));
    }

    public function storeFaqQuestion(Request $request) {
        $validated = $request->validate([
            'nama_penanya' => 'required|string|max:255',
            'email_penanya' => 'nullable|string|max:255',
            'pertanyaan' => 'required|string|max:1000',
        ]);

        $validated['is_active'] = false;
        $validated['urutan'] = (Faq::max('urutan') ?: 0) + 1;

        Faq::create($validated);

        return redirect()->back()->with('success', 'Pertanyaan Anda berhasil dikirim ke pihak sekolah! Admin akan meninjau dan menjawab pertanyaan Anda untuk ditampilkan di halaman FAQ.');
    }
}
