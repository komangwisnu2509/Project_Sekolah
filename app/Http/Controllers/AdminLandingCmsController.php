<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Berita;
use App\Models\Ekstrakurikuler;
use App\Models\Faq;
use App\Models\Fasilitas;
use App\Models\Galeri;
use App\Models\PrestasiSiswa;
use App\Models\ProfilSekolah;
use App\Models\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminLandingCmsController extends Controller
{
    /**
     * Dashboard CMS Beranda Utama & Web Sekolah
     */
    public function index()
    {
        $profil = ProfilSekolah::first() ?? new ProfilSekolah();
        $fasilitas = Fasilitas::latest()->get();
        $galeris = Galeri::latest()->get();
        $testimonis = Testimoni::latest()->get();
        $faqs = Faq::orderBy('urutan')->get();
        $beritas = Berita::latest()->get();
        $agendas = Agenda::orderBy('tanggal', 'desc')->get();
        $ekstrakurikulers = Ekstrakurikuler::orderBy('nama_ekskul')->get();
        $prestasis = PrestasiSiswa::orderBy('tahun', 'desc')->get();

        return view('admin.cms.index', compact('profil', 'fasilitas', 'galeris', 'testimonis', 'faqs', 'beritas', 'agendas', 'ekstrakurikulers', 'prestasis'));
    }

    /**
     * Update Profil Sekolah CMS
     */
    public function updateProfil(Request $request)
    {
        $validated = $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'slogan' => 'nullable|string|max:255',
            'sambutan_kepala_sekolah' => 'nullable|string',
            'nama_kepala_sekolah' => 'nullable|string|max:255',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'sejarah' => 'nullable|string',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'instagram' => 'nullable|string|max:100',
            'youtube' => 'nullable|string|max:100',
            'facebook' => 'nullable|string|max:100',
            'foto_kepala_sekolah' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'hero_banner' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:6144',
        ]);

        $profil = ProfilSekolah::first();
        if (!$profil) {
            $profil = new ProfilSekolah();
        }

        if ($request->hasFile('foto_kepala_sekolah')) {
            if ($profil->foto_kepala_sekolah && Storage::disk('public')->exists($profil->foto_kepala_sekolah)) {
                Storage::disk('public')->delete($profil->foto_kepala_sekolah);
            }
            $validated['foto_kepala_sekolah'] = $request->file('foto_kepala_sekolah')->store('profil', 'public');
        }

        if ($request->hasFile('hero_banner')) {
            if ($profil->hero_banner && Storage::disk('public')->exists($profil->hero_banner)) {
                Storage::disk('public')->delete($profil->hero_banner);
            }
            $validated['hero_banner'] = $request->file('hero_banner')->store('profil', 'public');
        }

        $profil->fill($validated);
        $profil->save();

        return redirect()->back()->with('success', 'Profil Sekolah berhasil diperbarui.');
    }

    // --- FASILITAS CRUD ---
    public function storeFasilitas(Request $request)
    {
        $validated = $request->validate([
            'nama_fasilitas' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'is_large' => 'nullable|boolean',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = asset('storage/' . $request->file('foto')->store('fasilitas', 'public'));
        }

        $validated['is_large'] = $request->has('is_large');
        Fasilitas::create($validated);

        return redirect()->back()->with('success', 'Fasilitas baru berhasil ditambahkan.');
    }

    public function updateFasilitas(Request $request, Fasilitas $fasilitas)
    {
        $validated = $request->validate([
            'nama_fasilitas' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = asset('storage/' . $request->file('foto')->store('fasilitas', 'public'));
        }

        $validated['is_large'] = $request->has('is_large');
        $fasilitas->update($validated);

        return redirect()->back()->with('success', 'Fasilitas berhasil diperbarui.');
    }

    public function destroyFasilitas(Fasilitas $fasilitas)
    {
        $fasilitas->delete();
        return redirect()->back()->with('success', 'Fasilitas berhasil dihapus.');
    }

    // --- GALERI CRUD ---
    public function storeGaleri(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'nullable|string|max:255',
            'kategori' => 'nullable|string|max:100',
            'foto' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $validated['foto'] = asset('storage/' . $request->file('foto')->store('galeri', 'public'));
        Galeri::create($validated);

        return redirect()->back()->with('success', 'Foto galeri baru berhasil ditambahkan.');
    }

    public function destroyGaleri(Galeri $galeri)
    {
        $galeri->delete();
        return redirect()->back()->with('success', 'Foto galeri berhasil dihapus.');
    }

    // --- TESTIMONI CRUD ---
    public function storeTestimoni(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'peran' => 'nullable|string|max:255',
            'konten' => 'required|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = asset('storage/' . $request->file('foto')->store('testimoni', 'public'));
        }

        Testimoni::create($validated);
        return redirect()->back()->with('success', 'Testimoni baru berhasil ditambahkan.');
    }

    public function destroyTestimoni(Testimoni $testimoni)
    {
        $testimoni->delete();
        return redirect()->back()->with('success', 'Testimoni berhasil dihapus.');
    }

    // --- FAQ CRUD ---
    public function storeFaq(Request $request)
    {
        $validated = $request->validate([
            'pertanyaan' => 'required|string',
            'jawaban' => 'required|string',
            'urutan' => 'nullable|integer',
        ]);

        Faq::create($validated);
        return redirect()->back()->with('success', 'Pertanyaan FAQ baru berhasil ditambahkan.');
    }

    public function destroyFaq(Faq $faq)
    {
        $faq->delete();
        return redirect()->back()->with('success', 'FAQ berhasil dihapus.');
    }

    // --- BERITA CRUD ---
    public function storeBerita(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'ringkasan' => 'nullable|string',
            'konten' => 'required|string',
            'kategori' => 'nullable|string|max:100',
            'tanggal_publikasi' => 'required|date',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'is_highlight' => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($request->judul) . '-' . Str::random(4);
        $validated['is_highlight'] = $request->has('is_highlight');

        if ($request->hasFile('foto')) {
            $validated['foto'] = asset('storage/' . $request->file('foto')->store('berita', 'public'));
        }

        // If highlight set, unset other highlights
        if ($validated['is_highlight']) {
            Berita::where('is_highlight', true)->update(['is_highlight' => false]);
        }

        Berita::create($validated);
        return redirect()->back()->with('success', 'Berita terbaru berhasil diterbitkan.');
    }

    public function updateBerita(Request $request, Berita $berita)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'ringkasan' => 'nullable|string',
            'konten' => 'required|string',
            'kategori' => 'nullable|string|max:100',
            'tanggal_publikasi' => 'required|date',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $validated['is_highlight'] = $request->has('is_highlight');

        if ($request->hasFile('foto')) {
            $validated['foto'] = asset('storage/' . $request->file('foto')->store('berita', 'public'));
        }

        if ($validated['is_highlight']) {
            Berita::where('id', '!=', $berita->id)->update(['is_highlight' => false]);
        }

        $berita->update($validated);
        return redirect()->back()->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroyBerita(Berita $berita)
    {
        $berita->delete();
        return redirect()->back()->with('success', 'Berita berhasil dihapus.');
    }

    // --- AGENDA / EVENT CRUD ---
    public function storeAgenda(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'nullable',
            'waktu_selesai' => 'nullable',
            'lokasi' => 'nullable|string|max:255',
            'kategori' => 'nullable|string|max:100',
        ]);

        Agenda::create($validated);
        return redirect()->back()->with('success', 'Agenda/Event acara sekolah berhasil ditambahkan.');
    }

    public function destroyAgenda(Agenda $agenda)
    {
        $agenda->delete();
        return redirect()->back()->with('success', 'Agenda/Event berhasil dihapus.');
    }

    // --- EKSTRAKURIKULER CRUD ---
    public function storeEkskul(Request $request)
    {
        $validated = $request->validate([
            'nama_ekskul' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'pembina' => 'nullable|string|max:255',
            'hari_latihan' => 'nullable|string|max:100',
            'jam_latihan' => 'nullable|string|max:100',
            'lokasi' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('ekskul', 'public');
        }

        $validated['status'] = 'Aktif';
        Ekstrakurikuler::create($validated);

        return redirect()->back()->with('success', 'Ekstrakurikuler sekolah baru berhasil ditambahkan.');
    }

    public function destroyEkskul(Ekstrakurikuler $ekstrakurikuler)
    {
        if ($ekstrakurikuler->foto && Storage::disk('public')->exists($ekstrakurikuler->foto)) {
            Storage::disk('public')->delete($ekstrakurikuler->foto);
        }
        $ekstrakurikuler->delete();
        return redirect()->back()->with('success', 'Ekstrakurikuler berhasil dihapus.');
    }
}
