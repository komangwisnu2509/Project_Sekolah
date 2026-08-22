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
                'nama_sekolah' => 'Utama Widyalaya Astika Dharma',
                'npsn_status' => '50103648 | Swasta',
                'kepala_sekolah' => 'I Ketut Suena, S.Pd',
                'nama_kepala_sekolah' => 'I Ketut Suena, S.Pd',
                'slogan' => 'Unggul, Berkarakter Berbasis Tri Hita Karana & Inovatif Bersama ASDHA TV',
                'akreditasi' => 'A',
                'jam_operasional' => 'Senin - Jumat (07:00 - 15:30 WITA)',
                'alamat' => 'Desa Pempatan, Kecamatan Rendang, Kabupaten Karangasem, Bali',
                'email' => 'info@astikadharma.sch.id',
                'telepon' => '(0363) 123456 / 081234567890',
                'youtube' => 'https://youtube.com/@asdhatv?si=6dcfwv3FKNSWBKNu',
                'visi' => 'Mewujudkan Sumber Daya Manusia Hindu yang Unggul, Berkarakter Mulia Berlandaskan Tri Hita Karana dan Tri Kaya Parisudha, Berdaya Saing, serta Menguasai Teknologi Terdepan.',
                'misi' => "1. Menyelenggarakan pendidikan holistik berbasis karakter spiritual Hindu dan nilai-nilai kebangsaan.\n2. Mengembangkan literasi digital, kreativitas, dan media jurnalisme siswa melalui kanal ASDHA TV.\n3. Menerapkan pembelajaran berpusat pada siswa (deep learning) berbasis kearifan lokal.\n4. Meningkatkan kompetensi pendidik dalam penerapan teknologi serta kurikulum berkarakter.",
                'deskripsi_tentang' => 'Utama Widyalaya Astika Dharma (SMA Hindu Astika Dharma / ASDHA) adalah lembaga pendidikan berprestasi di Rendang, Karangasem, Bali. Melalui wadah kreasi media ASDHA TV, sekolah ini mencetak generasi muda berakhlak mulia, cerdas, dan tanggap terhadap perkembangan zaman.',
                'sambutan_kepala_sekolah' => 'Om Swastyastu. Selamat datang di portal resmi Utama Widyalaya Astika Dharma. Kami berkomitmen menyelenggarakan pendidikan berkualitas tinggi yang memadukan keunggulan akademik, spiritualitas Hindu, dan literasi digital abad 21 melalui inovasi jurnalisme visual ASDHA TV. Om Shanti Shanti Shanti Om.',
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
            'whatsapp' => 'nullable|string|max:50',
            'tiktok' => 'nullable|string|max:100',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'slogan' => 'nullable|string|max:255',
            'sambutan_kepala_sekolah' => 'nullable|string',
            'sejarah' => 'nullable|string',
            'deskripsi_tentang' => 'nullable|string',
            'tentang_lengkap' => 'nullable|string',
            'instagram' => 'nullable|string|max:100',
            'youtube' => 'nullable|string|max:100',
            'facebook' => 'nullable|string|max:100',
            'foto_kepala_sekolah' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'hero_banner' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:6144',
            'foto_tentang' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:6144',
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

        if ($request->hasFile('foto_tentang')) {
            if ($profil->foto_tentang && Storage::disk('public')->exists($profil->foto_tentang)) {
                Storage::disk('public')->delete($profil->foto_tentang);
            }
            $validated['foto_tentang'] = $request->file('foto_tentang')->store('profil', 'public');
        }

        $profil->fill($validated);
        $profil->save();

        return redirect()->back()->with('success', 'Informasi Profil Sekolah berhasil diperbarui dan langsung tampil di Beranda Utama Website.');
    }
}
