<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\ProfilSekolah;
use App\Models\Siswa;
use App\Models\SmbpPendaftaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SmbpController extends Controller
{
    /**
     * Display public SMBP registration page
     */
    public function publicIndex()
    {
        $profil = ProfilSekolah::first();
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();
        $totalPendaftar = SmbpPendaftaran::count();
        $totalDiterima = SmbpPendaftaran::where('status', 'Diterima')->count();

        return view('smbp.public_index', compact('profil', 'jurusans', 'totalPendaftar', 'totalDiterima'));
    }

    /**
     * Handle public online registration
     */
    public function storePublic(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nisn' => 'nullable|string|max:20',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'asal_sekolah' => 'required|string|max:255',
            'pilihan_jurusan' => 'required|string|max:255',
            'nama_orang_tua' => 'required|string|max:255',
            'no_hp_wa' => 'required|string|max:25',
            'alamat' => 'required|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'berkas_ijazah' => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        // Generate unique registration number
        $uniqueNo = 'SMBP-' . date('Y') . '-' . strtoupper(Str::random(5));
        while (SmbpPendaftaran::where('no_pendaftaran', $uniqueNo)->exists()) {
            $uniqueNo = 'SMBP-' . date('Y') . '-' . strtoupper(Str::random(5));
        }

        $validated['no_pendaftaran'] = $uniqueNo;
        $validated['status'] = 'Pending';

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('smbp/foto', 'public');
        }

        if ($request->hasFile('berkas_ijazah')) {
            $validated['berkas_ijazah'] = $request->file('berkas_ijazah')->store('smbp/ijazah', 'public');
        }

        $pendaftaran = SmbpPendaftaran::create($validated);

        return redirect()->route('smbp.bukti', $pendaftaran->no_pendaftaran)
            ->with('success', 'Selamat! Pendaftaran Siswa Baru (SMBP) Anda berhasil dikirim.');
    }

    /**
     * View/Print registration ticket
     */
    public function bukti($no_pendaftaran)
    {
        $pendaftaran = SmbpPendaftaran::where('no_pendaftaran', $no_pendaftaran)->firstOrFail();
        $profil = ProfilSekolah::first();

        return view('smbp.bukti', compact('pendaftaran', 'profil'));
    }

    /**
     * Admin Portal: List all SMBP registrations
     */
    public function adminIndex(Request $request)
    {
        $status = $request->query('status');
        $q = $request->query('q');

        $query = SmbpPendaftaran::orderBy('created_at', 'desc');

        if ($status) {
            $query->where('status', $status);
        }

        if ($q) {
            $query->where(function ($sub) use ($q) {
                $sub->where('nama_lengkap', 'like', "%{$q}%")
                    ->orWhere('no_pendaftaran', 'like', "%{$q}%")
                    ->orWhere('asal_sekolah', 'like', "%{$q}%")
                    ->orWhere('nisn', 'like', "%{$q}%");
            });
        }

        $pendaftarans = $query->paginate(15);
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();
        $totalPendaftar = SmbpPendaftaran::count();
        $totalPending = SmbpPendaftaran::where('status', 'Pending')->count();
        $totalDiterima = SmbpPendaftaran::where('status', 'Diterima')->count();
        $totalDitolak = SmbpPendaftaran::where('status', 'Ditolak')->count();

        return view('admin.smbp.index', compact('pendaftarans', 'jurusans', 'totalPendaftar', 'totalPending', 'totalDiterima', 'totalDitolak', 'status', 'q'));
    }

    /**
     * Admin Portal: Update registration status (and optionally convert to official Siswa record)
     */
    public function adminUpdateStatus(Request $request, SmbpPendaftaran $smbpPendaftaran)
    {
        $request->validate([
            'status' => 'required|in:Pending,Diterima,Ditolak',
            'catatan_admin' => 'nullable|string',
            'kelas_tujuan' => 'nullable|string',
        ]);

        $smbpPendaftaran->status = $request->status;
        $smbpPendaftaran->catatan_admin = $request->catatan_admin;
        $smbpPendaftaran->save();

        // If status changed to Diterima and requested to convert to official student
        if ($request->status === 'Diterima' && $request->has('buat_akun_siswa')) {
            // Generate NIS based on count
            $lastNis = Siswa::max('nis');
            $nextNis = $lastNis ? ((int)$lastNis + 1) : 10001;

            $kelasTarget = $request->kelas_tujuan ?: 'X ' . $smbpPendaftaran->pilihan_jurusan;

            // Create Siswa record
            $siswa = Siswa::create([
                'nis' => (string)$nextNis,
                'nama' => $smbpPendaftaran->nama_lengkap,
                'kelas' => $kelasTarget,
                'jurusan' => $smbpPendaftaran->pilihan_jurusan,
                'status' => 'Aktif',
                'foto' => $smbpPendaftaran->foto,
            ]);

            // Create User Login
            $emailClean = strtolower(Str::slug($smbpPendaftaran->nama_lengkap)) . '.' . $siswa->nis . '@siswa.astikadharma.sch.id';
            User::create([
                'name' => $smbpPendaftaran->nama_lengkap,
                'email' => $emailClean,
                'password' => Hash::make('12345678'),
                'role' => 'siswa',
                'siswa_id' => $siswa->id,
                'foto' => $smbpPendaftaran->foto,
            ]);
        }

        return redirect()->back()->with('success', 'Status pendaftaran ' . $smbpPendaftaran->no_pendaftaran . ' berhasil diperbarui.');
    }

    /**
     * Admin Portal: Delete registration
     */
    public function adminDestroy(SmbpPendaftaran $smbpPendaftaran)
    {
        if ($smbpPendaftaran->foto && Storage::disk('public')->exists($smbpPendaftaran->foto)) {
            Storage::disk('public')->delete($smbpPendaftaran->foto);
        }

        if ($smbpPendaftaran->berkas_ijazah && Storage::disk('public')->exists($smbpPendaftaran->berkas_ijazah)) {
            Storage::disk('public')->delete($smbpPendaftaran->berkas_ijazah);
        }

        $smbpPendaftaran->delete();

        return redirect()->back()->with('success', 'Data pendaftar SMBP berhasil dihapus.');
    }
}
