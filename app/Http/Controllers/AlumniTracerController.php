<?php

namespace App\Http\Controllers;

use App\Models\AlumniTracer;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlumniTracerController extends Controller
{
    // Student Store Alumni Tracer Info (For Graduated Students)
    public function store(Request $request)
    {
        $user = auth()->user();
        if (!$user->isSiswa() || !$user->siswa || $user->siswa->status !== 'Lulus') {
            return redirect()->back()->with('error', 'Fitur ini khusus untuk siswa yang telah lulus.');
        }

        $request->validate([
            'status_alumni' => 'required|in:Kuliah,Bekerja,Kuliah & Bekerja,Wirausaha,Mencari Kerja',
            'nama_instansi' => 'required|string|max:255',
            'jurusan_atau_jabatan' => 'nullable|string|max:255',
            'tahun_masuk' => 'nullable|string|max:50',
            'lokasi' => 'nullable|string|max:255',
            'catatan' => 'nullable|string|max:1000',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'kesan_pesan' => 'nullable|string|max:2000',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('alumni/foto', 'public');
        }

        AlumniTracer::create([
            'siswa_id' => $user->siswa->id,
            'status_alumni' => $request->status_alumni,
            'nama_instansi' => $request->nama_instansi,
            'jurusan_atau_jabatan' => $request->jurusan_atau_jabatan,
            'tahun_masuk' => $request->tahun_masuk ?? date('Y'),
            'lokasi' => $request->lokasi,
            'catatan' => $request->catatan,
            'foto' => $fotoPath,
            'kesan_pesan' => $request->kesan_pesan,
            'status_acc' => 'Pending',
        ]);

        return redirect()->back()->with('success', 'Data tracer, foto, dan kesan & pesan Anda berhasil dikirim dan menunggu persetujuan (ACC) dari Admin!');
    }

    // Student Update Their Existing Alumni Tracer Entry
    public function updateByStudent(Request $request, AlumniTracer $alumniTracer)
    {
        $user = auth()->user();
        if (!$user->isSiswa() || !$user->siswa || $user->siswa->id !== $alumniTracer->siswa_id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk mengubah data ini.');
        }

        $request->validate([
            'status_alumni' => 'required|in:Kuliah,Bekerja,Kuliah & Bekerja,Wirausaha,Mencari Kerja',
            'nama_instansi' => 'required|string|max:255',
            'jurusan_atau_jabatan' => 'nullable|string|max:255',
            'tahun_masuk' => 'nullable|string|max:50',
            'lokasi' => 'nullable|string|max:255',
            'catatan' => 'nullable|string|max:1000',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'kesan_pesan' => 'nullable|string|max:2000',
        ]);

        $data = [
            'status_alumni' => $request->status_alumni,
            'nama_instansi' => $request->nama_instansi,
            'jurusan_atau_jabatan' => $request->jurusan_atau_jabatan,
            'tahun_masuk' => $request->tahun_masuk ?? date('Y'),
            'lokasi' => $request->lokasi,
            'catatan' => $request->catatan,
            'kesan_pesan' => $request->kesan_pesan,
            'status_acc' => 'Pending',
            'catatan_admin' => null,
        ];

        if ($request->hasFile('foto')) {
            if ($alumniTracer->foto && Storage::disk('public')->exists($alumniTracer->foto)) {
                Storage::disk('public')->delete($alumniTracer->foto);
            }
            $data['foto'] = $request->file('foto')->store('alumni/foto', 'public');
        }

        $alumniTracer->update($data);

        return redirect()->back()->with('success', 'Data tracer alumni berhasil diperbarui dan dikirim kembali untuk persetujuan (ACC) Admin!');
    }

    // Admin View All Graduated Students & Alumni Tracer Records with Search & Filter
    public function adminIndex(Request $request)
    {
        $q = trim($request->input('q', ''));
        $statusFilter = $request->input('status', '');
        $accFilter = $request->input('status_acc', '');
        $tahunFilter = $request->input('tahun', '');
        $kelasFilter = $request->input('kelas', '');

        $query = Siswa::where('status', 'Lulus')->with(['alumniTracer' => function($trQuery) {
            $trQuery->orderBy('created_at', 'desc');
        }]);

        // Search Filter by Student Name, NIS, Class, Major, Graduation Year, or Instansi
        if ($q) {
            $query->where(function($sub) use ($q) {
                $sub->where('nama', 'like', "%{$q}%")
                    ->orWhere('nis', 'like', "%{$q}%")
                    ->orWhere('kelas', 'like', "%{$q}%")
                    ->orWhere('jurusan', 'like', "%{$q}%")
                    ->orWhere('tahun_lulus', 'like', "%{$q}%")
                    ->orWhereHas('alumniTracer', function($t) use ($q) {
                        $t->where('nama_instansi', 'like', "%{$q}%")
                          ->orWhere('jurusan_atau_jabatan', 'like', "%{$q}%")
                          ->orWhere('lokasi', 'like', "%{$q}%")
                          ->orWhere('kesan_pesan', 'like', "%{$q}%");
                    });
            });
        }

        // Filter by Class (Kelas Terakhir)
        if ($kelasFilter) {
            $query->where('kelas', $kelasFilter);
        }

        // Filter by Graduation Year
        if ($tahunFilter) {
            $query->where('tahun_lulus', $tahunFilter);
        }

        // Filter by Tracer Status (Kuliah, Bekerja, Wirausaha, Belum Isi)
        if ($statusFilter) {
            if ($statusFilter === 'Belum Isi') {
                $query->whereDoesntHave('alumniTracer');
            } else {
                $query->whereHas('alumniTracer', function($t) use ($statusFilter) {
                    $t->where('status_alumni', $statusFilter);
                });
            }
        }

        // Filter by ACC Status (Pending, Disetujui, Ditolak)
        if ($accFilter) {
            $query->whereHas('alumniTracer', function($t) use ($accFilter) {
                $t->where('status_acc', $accFilter);
            });
        }

        $alumniSiswaList = $query->orderBy('tahun_lulus', 'desc')->orderBy('nama', 'asc')->get();
        $allGraduatedSiswa = Siswa::where('status', 'Lulus')->orderBy('tahun_lulus', 'desc')->orderBy('nama')->get();

        // Statistics
        $totalAlumni = $allGraduatedSiswa->count();
        $totalSudahTracer = Siswa::where('status', 'Lulus')->whereHas('alumniTracer')->count();
        $totalBelumTracer = max(0, $totalAlumni - $totalSudahTracer);

        $totalPending = AlumniTracer::where('status_acc', 'Pending')->count();
        $totalDisetujui = AlumniTracer::where('status_acc', 'Disetujui')->count();
        $totalDitolak = AlumniTracer::where('status_acc', 'Ditolak')->count();

        $totalKuliah = AlumniTracer::whereIn('status_alumni', ['Kuliah', 'Kuliah & Bekerja'])->count();
        $totalBekerja = AlumniTracer::whereIn('status_alumni', ['Bekerja', 'Kuliah & Bekerja'])->count();
        $totalWirausaha = AlumniTracer::where('status_alumni', 'Wirausaha')->count();

        // Unique filter options for dropdowns
        $kelasOptions = Siswa::where('status', 'Lulus')->whereNotNull('kelas')->distinct()->pluck('kelas')->sort()->values();
        $tahunOptions = Siswa::where('status', 'Lulus')->whereNotNull('tahun_lulus')->distinct()->pluck('tahun_lulus')->sortDesc()->values();

        return view('admin.alumni.index', compact(
            'alumniSiswaList', 'allGraduatedSiswa', 'q', 'statusFilter', 'accFilter', 'tahunFilter', 'kelasFilter',
            'kelasOptions', 'tahunOptions',
            'totalAlumni', 'totalSudahTracer', 'totalBelumTracer', 'totalPending', 'totalDisetujui', 'totalDitolak',
            'totalKuliah', 'totalBekerja', 'totalWirausaha'
        ));
    }

    // Admin Approve Alumni Tracer Record (ACC)
    public function approve(AlumniTracer $alumniTracer)
    {
        $alumniTracer->update([
            'status_acc' => 'Disetujui',
            'catatan_admin' => null,
        ]);

        $namaSiswa = $alumniTracer->siswa ? $alumniTracer->siswa->nama : 'Alumni';
        return redirect()->back()->with('success', "Data tracer alumni {$namaSiswa} berhasil disetujui (ACC)!");
    }

    // Admin Reject Alumni Tracer Record
    public function reject(Request $request, AlumniTracer $alumniTracer)
    {
        $request->validate([
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        $alumniTracer->update([
            'status_acc' => 'Ditolak',
            'catatan_admin' => $request->catatan_admin ?? 'Data atau foto belum sesuai ketentuan.',
        ]);

        $namaSiswa = $alumniTracer->siswa ? $alumniTracer->siswa->nama : 'Alumni';
        return redirect()->back()->with('success', "Pengajuan data alumni {$namaSiswa} telah ditolak.");
    }

    // Admin Store New Alumni Tracer Directly
    public function adminStore(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'status_alumni' => 'required|in:Kuliah,Bekerja,Kuliah & Bekerja,Wirausaha,Mencari Kerja',
            'nama_instansi' => 'required|string|max:255',
            'jurusan_atau_jabatan' => 'nullable|string|max:255',
            'tahun_masuk' => 'nullable|string|max:50',
            'lokasi' => 'nullable|string|max:255',
            'catatan' => 'nullable|string|max:1000',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'kesan_pesan' => 'nullable|string|max:2000',
            'status_acc' => 'required|in:Pending,Disetujui,Ditolak',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('alumni/foto', 'public');
        }

        AlumniTracer::create([
            'siswa_id' => $request->siswa_id,
            'status_alumni' => $request->status_alumni,
            'nama_instansi' => $request->nama_instansi,
            'jurusan_atau_jabatan' => $request->jurusan_atau_jabatan,
            'tahun_masuk' => $request->tahun_masuk ?? date('Y'),
            'lokasi' => $request->lokasi,
            'catatan' => $request->catatan,
            'foto' => $fotoPath,
            'kesan_pesan' => $request->kesan_pesan,
            'status_acc' => $request->status_acc,
            'catatan_admin' => $request->status_acc === 'Ditolak' ? $request->catatan_admin : null,
        ]);

        return redirect()->back()->with('success', 'Data tracer alumni baru berhasil ditambahkan oleh Admin!');
    }

    // Admin Edit & Update Alumni Tracer
    public function update(Request $request, AlumniTracer $alumniTracer)
    {
        $request->validate([
            'status_alumni' => 'required|in:Kuliah,Bekerja,Kuliah & Bekerja,Wirausaha,Mencari Kerja',
            'nama_instansi' => 'required|string|max:255',
            'jurusan_atau_jabatan' => 'nullable|string|max:255',
            'tahun_masuk' => 'nullable|string|max:50',
            'lokasi' => 'nullable|string|max:255',
            'catatan' => 'nullable|string|max:1000',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'kesan_pesan' => 'nullable|string|max:2000',
            'status_acc' => 'required|in:Pending,Disetujui,Ditolak',
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        $data = [
            'status_alumni' => $request->status_alumni,
            'nama_instansi' => $request->nama_instansi,
            'jurusan_atau_jabatan' => $request->jurusan_atau_jabatan,
            'tahun_masuk' => $request->tahun_masuk ?? date('Y'),
            'lokasi' => $request->lokasi,
            'catatan' => $request->catatan,
            'kesan_pesan' => $request->kesan_pesan,
            'status_acc' => $request->status_acc,
            'catatan_admin' => $request->status_acc === 'Ditolak' ? $request->catatan_admin : null,
        ];

        if ($request->hasFile('foto')) {
            if ($alumniTracer->foto && Storage::disk('public')->exists($alumniTracer->foto)) {
                Storage::disk('public')->delete($alumniTracer->foto);
            }
            $data['foto'] = $request->file('foto')->store('alumni/foto', 'public');
        }

        $alumniTracer->update($data);

        $namaSiswa = $alumniTracer->siswa ? $alumniTracer->siswa->nama : 'Alumni';
        return redirect()->back()->with('success', "Data tracer alumni {$namaSiswa} berhasil diperbarui oleh Admin!");
    }

    // Admin Delete Alumni Tracer Entry
    public function destroy(AlumniTracer $alumniTracer)
    {
        if ($alumniTracer->foto && Storage::disk('public')->exists($alumniTracer->foto)) {
            Storage::disk('public')->delete($alumniTracer->foto);
        }

        $alumniTracer->delete();
        return redirect()->back()->with('success', 'Data jejak alumni berhasil dihapus.');
    }
}
