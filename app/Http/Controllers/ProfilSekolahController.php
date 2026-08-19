<?php

namespace App\Http\Controllers;

use App\Models\ProfilSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilSekolahController extends Controller
{
    public function edit()
    {
        $profil = ProfilSekolah::first();
        if (!$profil) {
            $profil = ProfilSekolah::create([
                'nama_sekolah' => 'Sekolah Astika Dharma',
                'npsn_status' => '10802999 | Negeri',
                'kepala_sekolah' => 'Dr. H. Ahmad Wijaya, M.Pd.',
                'nama_kepala_sekolah' => 'Dr. H. Ahmad Wijaya, M.Pd.',
                'akreditasi' => 'A',
                'jam_operasional' => 'Senin - Jumat (07:00 - 15:30 WITA)',
                'alamat' => 'Jl. Pendidikan No. 45, Kompleks Edukasi Terpadu Astika Dharma',
                'email' => 'info@astikadharma.sch.id',
                'telepon' => '081234567890',
                'visi' => 'Menjadi Lembaga Pendidikan Kejuruan Unggul, Berkarakter, Berkualitas, dan Berbasis Teknologi Terdepan.',
                'misi' => "1. Menyelenggarakan pembelajaran berbasis standar industri terkini.\n2. Mengembangkan jiwa kewirausahaan dan keterampilan vokasional siswa.\n3. Mewujudkan lulusan berdaya saing tinggi, jujur, dan berakhlak mulia.",
            ]);
        }

        return view('profil_sekolah.edit', compact('profil'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'npsn_status' => 'nullable|string|max:255',
            'kepala_sekolah' => 'nullable|string|max:255',
            'nama_kepala_sekolah' => 'nullable|string|max:255',
            'akreditasi' => 'nullable|string|max:10',
            'jam_operasional' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'telepon' => 'nullable|string|max:50',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'slogan' => 'nullable|string|max:255',
            'sambutan_kepala_sekolah' => 'nullable|string',
            'sejarah' => 'nullable|string',
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

        // Sync kepala_sekolah & nama_kepala_sekolah
        if (!empty($validated['kepala_sekolah'])) {
            $validated['nama_kepala_sekolah'] = $validated['kepala_sekolah'];
        } elseif (!empty($validated['nama_kepala_sekolah'])) {
            $validated['kepala_sekolah'] = $validated['nama_kepala_sekolah'];
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

        return redirect()->back()->with('success', 'Informasi Profil Sekolah berhasil diperbarui dan langsung tampil di Beranda Utama Website.');
    }
}
