<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JurusanController extends Controller
{
    public function index()
    {
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();
        return view('jurusan.index', compact('jurusans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jurusan' => 'required|unique:jurusans,nama_jurusan',
            'deskripsi' => 'nullable|string',
            'detail_informasi' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'is_active' => 'nullable|boolean',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:3072',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('jurusans', 'public');
        }

        $namaJurusan = trim($request->nama_jurusan);

        $jurusan = Jurusan::create([
            'nama_jurusan' => $namaJurusan,
            'deskripsi' => $request->deskripsi,
            'detail_informasi' => $request->detail_informasi,
            'icon' => $request->icon ?? 'monitor',
            'is_active' => $request->has('is_active') ? (bool) $request->is_active : true,
            'foto' => $fotoPath,
        ]);

        // Extract code/name for auto class generation (e.g., "ULW" or "Usaha Perjalanan Wisata (ULW)")
        $code = $namaJurusan;

        if (preg_match('/\(([^)]+)\)/', $namaJurusan, $matches)) {
            $code = trim($matches[1]);
        }

        $code = strtoupper($code);

        // Automatically create classes X, XI, XII for this major
        $levels = ['X', 'XI', 'XII'];
        $createdClasses = [];

        foreach ($levels as $level) {
            $className = "{$level} {$code} 1";
            $createdClass = Kelas::firstOrCreate(['nama_kelas' => $className]);
            $createdClasses[] = $createdClass->nama_kelas;
        }

        $classListStr = implode(', ', $createdClasses);

        return redirect()->route('jurusan.index')->with('success', "Jurusan '{$namaJurusan}' berhasil ditambahkan dan otomatis membuat kelas: {$classListStr}.");
    }

    public function edit(Jurusan $jurusan)
    {
        return view('jurusan.edit', compact('jurusan'));
    }

    public function update(Request $request, Jurusan $jurusan)
    {
        $request->validate([
            'nama_jurusan' => 'required|string|unique:jurusans,nama_jurusan,' . $jurusan->id,
            'deskripsi' => 'nullable|string',
            'detail_informasi' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'is_active' => 'nullable|boolean',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:3072',
        ]);

        $oldName = $jurusan->nama_jurusan;
        $newName = trim($request->nama_jurusan);

        $fotoPath = $jurusan->foto;
        if ($request->hasFile('foto')) {
            if ($jurusan->foto && Storage::disk('public')->exists($jurusan->foto)) {
                Storage::disk('public')->delete($jurusan->foto);
            }
            $fotoPath = $request->file('foto')->store('jurusans', 'public');
        }

        $jurusan->update([
            'nama_jurusan' => $newName,
            'deskripsi' => $request->deskripsi,
            'detail_informasi' => $request->detail_informasi,
            'icon' => $request->icon ?? ($jurusan->icon ?: 'monitor'),
            'is_active' => $request->has('is_active') ? (bool) $request->is_active : $jurusan->is_active,
            'foto' => $fotoPath,
        ]);

        // Cascade update related student records using updated major name
        if ($oldName !== $newName) {
            Siswa::where('jurusan', $oldName)->update(['jurusan' => $newName]);
        }

        return redirect()->route('jurusan.index')->with('success', 'Data jurusan berhasil diperbarui.');
    }

    public function toggleStatus(Jurusan $jurusan)
    {
        $jurusan->update([
            'is_active' => !$jurusan->is_active
        ]);

        $statusText = $jurusan->is_active ? 'ditampilkan di Landing Page (Show)' : 'disembunyikan dari Landing Page (Hide)';
        return redirect()->back()->with('success', "Jurusan '{$jurusan->nama_jurusan}' berhasil {$statusText}.");
    }

    public function destroy(Jurusan $jurusan)
    {
        if ($jurusan->foto && Storage::disk('public')->exists($jurusan->foto)) {
            Storage::disk('public')->delete($jurusan->foto);
        }
        $jurusan->delete();
        return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil dihapus.');
    }
}
