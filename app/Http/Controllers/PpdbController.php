<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\ProfilSekolah;
use App\Models\Siswa;
use App\Models\PpdbPendaftaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PpdbController extends Controller
{
    /**
     * Display public PPDB registration page
     */
    public function publicIndex()
    {
        $profil = ProfilSekolah::first();
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();
        $totalPendaftar = PpdbPendaftaran::count();
        $totalDiterima = PpdbPendaftaran::where('status', 'Diterima')->count();

        return view('ppdb.public_index', compact('profil', 'jurusans', 'totalPendaftar', 'totalDiterima'));
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
        $uniqueNo = 'PPDB-' . date('Y') . '-' . strtoupper(Str::random(5));
        while (PpdbPendaftaran::where('no_pendaftaran', $uniqueNo)->exists()) {
            $uniqueNo = 'PPDB-' . date('Y') . '-' . strtoupper(Str::random(5));
        }

        $validated['no_pendaftaran'] = $uniqueNo;
        $validated['status'] = 'Pending';

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('ppdb/foto', 'public');
        }

        if ($request->hasFile('berkas_ijazah')) {
            $validated['berkas_ijazah'] = $request->file('berkas_ijazah')->store('ppdb/ijazah', 'public');
        }

        $pendaftaran = PpdbPendaftaran::create($validated);

        return redirect()->route('ppdb.bukti', $pendaftaran->no_pendaftaran)
            ->with('success', 'Selamat! Pendaftaran Siswa Baru (PPDB Online) Anda berhasil dikirim.');
    }

    /**
     * View/Print registration ticket
     */
    public function bukti($no_pendaftaran)
    {
        $pendaftaran = PpdbPendaftaran::where('no_pendaftaran', $no_pendaftaran)->firstOrFail();
        $profil = ProfilSekolah::first();

        return view('ppdb.bukti', compact('pendaftaran', 'profil'));
    }

    /**
     * Admin Portal: List all PPDB registrations
     */
    public function adminIndex(Request $request)
    {
        $status = $request->query('status');
        $q = $request->query('q');

        $query = PpdbPendaftaran::orderBy('created_at', 'desc');

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
        $totalPendaftar = PpdbPendaftaran::count();
        $totalPending = PpdbPendaftaran::where('status', 'Pending')->count();
        $totalDiterima = PpdbPendaftaran::where('status', 'Diterima')->count();
        $totalDitolak = PpdbPendaftaran::where('status', 'Ditolak')->count();

        return view('admin.ppdb.index', compact('pendaftarans', 'jurusans', 'totalPendaftar', 'totalPending', 'totalDiterima', 'totalDitolak', 'status', 'q'));
    }

    /**
     * Admin Portal: Update registration status (and optionally convert to official Siswa record)
     */
    public function adminUpdateStatus(Request $request, PpdbPendaftaran $ppdbPendaftaran)
    {
        $request->validate([
            'status' => 'required|in:Pending,Diterima,Ditolak',
            'catatan_admin' => 'nullable|string',
            'kelas_tujuan' => 'nullable|string',
        ]);

        $ppdbPendaftaran->status = $request->status;
        $ppdbPendaftaran->catatan_admin = $request->catatan_admin;
        $ppdbPendaftaran->save();

        // If status changed to Diterima and requested to convert to official student
        if ($request->status === 'Diterima' && $request->has('buat_akun_siswa')) {
            // Generate NIS based on count
            $lastNis = Siswa::max('nis');
            $nextNis = $lastNis ? ((int)$lastNis + 1) : 10001;

            $kelasTarget = $request->kelas_tujuan ?: 'X ' . $ppdbPendaftaran->pilihan_jurusan;

            // Create Siswa record
            $siswa = Siswa::create([
                'nis' => (string)$nextNis,
                'nama' => $ppdbPendaftaran->nama_lengkap,
                'kelas' => $kelasTarget,
                'jurusan' => $ppdbPendaftaran->pilihan_jurusan,
                'status' => 'Aktif',
                'foto' => $ppdbPendaftaran->foto,
            ]);

            // Create User Login
            $emailClean = strtolower(Str::slug($ppdbPendaftaran->nama_lengkap)) . '.' . $siswa->nis . '@siswa.astikadharma.sch.id';
            User::create([
                'name' => $ppdbPendaftaran->nama_lengkap,
                'email' => $emailClean,
                'password' => Hash::make('12345678'),
                'role' => 'siswa',
                'siswa_id' => $siswa->id,
                'foto' => $ppdbPendaftaran->foto,
            ]);
        }

        return redirect()->back()->with('success', 'Status pendaftaran PPDB ' . $ppdbPendaftaran->no_pendaftaran . ' berhasil diperbarui.');
    }

    /**
     * Admin Portal: Delete registration
     */
    public function adminDestroy(PpdbPendaftaran $ppdbPendaftaran)
    {
        if ($ppdbPendaftaran->foto && Storage::disk('public')->exists($ppdbPendaftaran->foto)) {
            Storage::disk('public')->delete($ppdbPendaftaran->foto);
        }

        if ($ppdbPendaftaran->berkas_ijazah && Storage::disk('public')->exists($ppdbPendaftaran->berkas_ijazah)) {
            Storage::disk('public')->delete($ppdbPendaftaran->berkas_ijazah);
        }

        $ppdbPendaftaran->delete();

        return redirect()->back()->with('success', 'Data pendaftar PPDB berhasil dihapus.');
    }
}
