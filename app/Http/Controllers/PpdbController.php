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
            'email' => 'required|email|max:255',
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
     * Handle personal status check lookup by No Pendaftaran or Email
     */
    public function cekStatus(Request $request)
    {
        $request->validate([
            'search_key' => 'required|string',
        ]);

        $key = trim($request->search_key);

        $pendaftaran = PpdbPendaftaran::where('no_pendaftaran', $key)
            ->orWhere('email', strtolower($key))
            ->orWhere('nisn', $key)
            ->first();

        if (!$pendaftaran) {
            return redirect()->back()
                ->with('error', 'Data pendaftaran dengan Nomor Reg / Email / NISN (' . $key . ') tidak ditemukan. Silakan periksa kembali kata kunci Anda.')
                ->withInput();
        }

        return redirect()->route('ppdb.bukti', $pendaftaran->no_pendaftaran);
    }

    /**
     * Resolve existing class name in database matching the selected jurusan code
     */
    public static function resolveKelasForJurusan($pilihanJurusan, $customKelasInput = null)
    {
        if ($customKelasInput && trim($customKelasInput) !== '') {
            $existing = \App\Models\Kelas::where('nama_kelas', trim($customKelasInput))->first();
            if ($existing) {
                return $existing->nama_kelas;
            }
        }

        $jurusanClean = trim($pilihanJurusan);

        // 1. Search existing Grade X class in database matching the jurusan
        $matched = \App\Models\Kelas::where(function($query) use ($jurusanClean) {
            $query->where('nama_kelas', 'LIKE', 'X %' . $jurusanClean . '%')
                  ->orWhere('nama_kelas', 'LIKE', 'X-%' . $jurusanClean . '%')
                  ->orWhere('nama_kelas', 'LIKE', 'X ' . $jurusanClean)
                  ->orWhere('nama_kelas', 'LIKE', '%' . $jurusanClean . '%');
        })
        ->where('nama_kelas', 'LIKE', 'X%')
        ->first();

        if ($matched) {
            return $matched->nama_kelas;
        }

        // 2. Search any class containing jurusanClean
        $matchedAny = \App\Models\Kelas::where('nama_kelas', 'LIKE', '%' . $jurusanClean . '%')->first();
        if ($matchedAny) {
            return $matchedAny->nama_kelas;
        }

        // 3. Fallback: create class if missing
        $fallbackName = $customKelasInput ?: ('X ' . $jurusanClean);
        $newKelas = \App\Models\Kelas::firstOrCreate(['nama_kelas' => $fallbackName]);
        return $newKelas->nama_kelas;
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
            'tgl_daftar_ulang' => 'nullable|string',
            'waktu_daftar_ulang' => 'nullable|string',
            'seragam_daftar_ulang' => 'nullable|string',
            'lokasi_daftar_ulang' => 'nullable|string',
            'alasan_ditolak' => 'nullable|string',
        ]);

        $ppdbPendaftaran->status = $request->status;
        $ppdbPendaftaran->catatan_admin = $request->catatan_admin;

        if ($request->status === 'Diterima') {
            $ppdbPendaftaran->tgl_daftar_ulang = $request->tgl_daftar_ulang ?: '25 Agustus 2026';
            $ppdbPendaftaran->waktu_daftar_ulang = $request->waktu_daftar_ulang ?: '08:00 - 12:00 WITA';
            $ppdbPendaftaran->seragam_daftar_ulang = $request->seragam_daftar_ulang ?: 'Seragam SMP Asal / Rapi & Sopan';
            $ppdbPendaftaran->lokasi_daftar_ulang = $request->lokasi_daftar_ulang ?: 'Aula Utama Sekolah';
        } else if ($request->status === 'Ditolak') {
            $ppdbPendaftaran->alasan_ditolak = $request->alasan_ditolak ?: 'Mohon maaf, kualifikasi belum memenuhi syarat atau kuota pilihan jurusan telah penuh.';
        } else {
            $ppdbPendaftaran->tgl_daftar_ulang = $request->tgl_daftar_ulang;
            $ppdbPendaftaran->waktu_daftar_ulang = $request->waktu_daftar_ulang;
            $ppdbPendaftaran->seragam_daftar_ulang = $request->seragam_daftar_ulang;
            $ppdbPendaftaran->lokasi_daftar_ulang = $request->lokasi_daftar_ulang;
            $ppdbPendaftaran->alasan_ditolak = $request->alasan_ditolak;
        }

        $ppdbPendaftaran->save();

        // Send automated notification email to applicant
        if ($ppdbPendaftaran->email) {
            try {
                $profil = ProfilSekolah::first();
                \Illuminate\Support\Facades\Mail::to($ppdbPendaftaran->email)
                    ->send(new \App\Mail\PpdbStatusNotificationMail($ppdbPendaftaran, $profil));
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('Gagal mengirim email PPDB: ' . $e->getMessage());
            }
        }

        // If status changed to Diterima, automatically create/assign student to target class
        if ($request->status === 'Diterima') {
            $kelasTarget = self::resolveKelasForJurusan($ppdbPendaftaran->pilihan_jurusan, $request->kelas_tujuan);

            if ($request->has('buat_akun_siswa') || Siswa::where('email', $ppdbPendaftaran->email)->exists()) {
                // Generate NIS based on count
                $lastNis = Siswa::max('nis');
                $nextNis = $lastNis ? ((int)$lastNis + 1) : 10001;

                $siswa = Siswa::where('email', $ppdbPendaftaran->email)->first();
                if (!$siswa) {
                    $siswa = Siswa::create([
                        'nis' => (string)$nextNis,
                        'nama' => $ppdbPendaftaran->nama_lengkap,
                        'email' => $ppdbPendaftaran->email,
                        'kelas' => $kelasTarget,
                        'jurusan' => $ppdbPendaftaran->pilihan_jurusan,
                        'status' => 'Aktif',
                        'foto' => $ppdbPendaftaran->foto,
                    ]);
                } else {
                    $siswa->update([
                        'kelas' => $kelasTarget,
                        'jurusan' => $ppdbPendaftaran->pilihan_jurusan,
                        'status' => 'Aktif',
                    ]);
                }

                // Create User Login if not already existing
                if ($ppdbPendaftaran->email && !User::where('email', $ppdbPendaftaran->email)->exists()) {
                    User::create([
                        'name' => $ppdbPendaftaran->nama_lengkap,
                        'email' => $ppdbPendaftaran->email,
                        'password' => Hash::make('12345678'),
                        'role' => 'siswa',
                        'siswa_id' => $siswa->id,
                        'foto' => $ppdbPendaftaran->foto,
                    ]);
                }
            }
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
