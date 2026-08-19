<?php

namespace App\Http\Controllers;

use App\Models\PrestasiSiswa;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PrestasiSiswaController extends Controller
{
    // Admin & Public Index
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = PrestasiSiswa::with('siswa');

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('tingkat')) {
            $query->where('tingkat', $request->tingkat);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function($builder) use ($q) {
                $builder->where('nama_siswa', 'like', "%{$q}%")
                        ->orWhere('judul_prestasi', 'like', "%{$q}%")
                        ->orWhere('penyelenggara', 'like', "%{$q}%")
                        ->orWhere('deskripsi', 'like', "%{$q}%");
            });
        }

        // If non-admin, optional filter: show active items or all items
        $prestasis = $query->orderBy('tahun', 'desc')->orderBy('created_at', 'desc')->get();
        $siswas = Siswa::orderBy('nama')->get();

        return view('admin.prestasi.index', compact('prestasis', 'siswas'));
    }

    // Admin Store Student Achievement
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'nullable|exists:siswa,id',
            'nama_siswa' => 'required_without:siswa_id|nullable|string|max:255',
            'judul_prestasi' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'tingkat' => 'required|string|max:100',
            'peringkat' => 'required|string|max:100',
            'tahun' => 'required|string|max:20',
            'penyelenggara' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string|max:2000',
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto_bukti')) {
            $fotoPath = $request->file('foto_bukti')->store('prestasi', 'public');
        }

        $namaSiswa = $request->nama_siswa;
        $kelasSiswa = null;

        if ($request->siswa_id) {
            $siswaModel = Siswa::find($request->siswa_id);
            if ($siswaModel) {
                $namaSiswa = $siswaModel->nama;
                $kelasSiswa = $siswaModel->kelas;
                if (!$fotoPath && $siswaModel->foto) {
                    $fotoPath = $siswaModel->foto;
                }
            }
        }

        PrestasiSiswa::create([
            'siswa_id' => $request->siswa_id,
            'nama_siswa' => $namaSiswa,
            'kelas' => $kelasSiswa,
            'judul_prestasi' => $request->judul_prestasi,
            'kategori' => $request->kategori,
            'tingkat' => $request->tingkat,
            'peringkat' => $request->peringkat,
            'tahun' => $request->tahun,
            'penyelenggara' => $request->penyelenggara,
            'deskripsi' => $request->deskripsi,
            'foto_bukti' => $fotoPath,
            'tampilkan_di_beranda' => $request->has('tampilkan_di_beranda'),
        ]);

        return redirect()->back()->with('success', 'Prestasi siswa berhasil ditambahkan dan disimpan!');
    }

    // Admin Update Student Achievement
    public function update(Request $request, PrestasiSiswa $prestasi)
    {
        $request->validate([
            'siswa_id' => 'nullable|exists:siswa,id',
            'nama_siswa' => 'required_without:siswa_id|nullable|string|max:255',
            'judul_prestasi' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'tingkat' => 'required|string|max:100',
            'peringkat' => 'required|string|max:100',
            'tahun' => 'required|string|max:20',
            'penyelenggara' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string|max:2000',
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $fotoPath = $prestasi->foto_bukti;
        if ($request->hasFile('foto_bukti')) {
            if ($prestasi->foto_bukti && !str_contains($prestasi->foto_bukti, 'siswa/')) {
                Storage::disk('public')->delete($prestasi->foto_bukti);
            }
            $fotoPath = $request->file('foto_bukti')->store('prestasi', 'public');
        }

        $namaSiswa = $request->nama_siswa ?? $prestasi->nama_siswa;
        $kelasSiswa = $prestasi->kelas;

        if ($request->siswa_id) {
            $siswaModel = Siswa::find($request->siswa_id);
            if ($siswaModel) {
                $namaSiswa = $siswaModel->nama;
                $kelasSiswa = $siswaModel->kelas;
            }
        }

        $prestasi->update([
            'siswa_id' => $request->siswa_id,
            'nama_siswa' => $namaSiswa,
            'kelas' => $kelasSiswa,
            'judul_prestasi' => $request->judul_prestasi,
            'kategori' => $request->kategori,
            'tingkat' => $request->tingkat,
            'peringkat' => $request->peringkat,
            'tahun' => $request->tahun,
            'penyelenggara' => $request->penyelenggara,
            'deskripsi' => $request->deskripsi,
            'foto_bukti' => $fotoPath,
            'tampilkan_di_beranda' => $request->has('tampilkan_di_beranda'),
        ]);

        return redirect()->back()->with('success', 'Data prestasi siswa berhasil diperbarui!');
    }

    // Toggle Display on Homepage / Active status
    public function toggleHomepage(PrestasiSiswa $prestasi)
    {
        $prestasi->update([
            'tampilkan_di_beranda' => !$prestasi->tampilkan_di_beranda
        ]);

        $statusText = $prestasi->tampilkan_di_beranda ? 'DIAKTIFKAN (Tampil di beranda)' : 'DINONAKTIFKAN (Disembunyikan)';
        return redirect()->back()->with('success', "Status prestasi '{$prestasi->judul_prestasi}' berhasil {$statusText}.");
    }

    // Delete Achievement
    public function destroy(PrestasiSiswa $prestasi)
    {
        if ($prestasi->foto_bukti && !str_contains($prestasi->foto_bukti, 'siswa/')) {
            Storage::disk('public')->delete($prestasi->foto_bukti);
        }
        $prestasi->delete();

        return redirect()->back()->with('success', 'Prestasi siswa berhasil dihapus.');
    }
}
