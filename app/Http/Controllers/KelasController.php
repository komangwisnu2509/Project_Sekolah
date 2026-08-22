<?php

namespace App\Http\Controllers;

use App\Models\JadwalPelajaran;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->input('tab', 'aktif'); // 'aktif' or 'alumni'
        $allKelas = Kelas::orderBy('nama_kelas')->get();
        $jurusanRecords = Jurusan::all();

        // Count ONLY active students per class name (status !== 'Lulus')
        $siswaCounts = Siswa::where('status', '!=', 'Lulus')
            ->selectRaw('kelas, count(*) as total')
            ->groupBy('kelas')
            ->pluck('total', 'kelas')
            ->toArray();

        // Group active classes strictly by Major/Jurusan
        $groupedKelas = [];

        foreach ($allKelas as $k) {
            $k->total_siswa = $siswaCounts[$k->nama_kelas] ?? 0;
            
            $namaKelas = trim($k->nama_kelas);
            $groupName = null;

            // 1. Check if class name matches any Jurusan abbreviation in parentheses e.g. (RPL), (TKJ)
            foreach ($jurusanRecords as $j) {
                if (preg_match('/\(([^)]+)\)/', $j->nama_jurusan, $m)) {
                    $abbr = $m[1];
                    if (preg_match('/\b' . preg_quote($abbr, '/') . '\b/i', $namaKelas)) {
                        $groupName = $j->nama_jurusan;
                        break;
                    }
                }
                if (stripos($namaKelas, $j->nama_jurusan) !== false) {
                    $groupName = $j->nama_jurusan;
                    break;
                }
            }

            // 2. Extract major prefix dynamically by stripping level (X, XI, XII, 10, 11, 12)
            if (!$groupName) {
                $cleaned = preg_replace('/^(?:X|XI|XII|10|11|12)\s+/i', '', $namaKelas);
                $cleaned = preg_replace('/\s+\d+$/', '', $cleaned);
                $cleaned = trim($cleaned);

                foreach ($jurusanRecords as $j) {
                    if (preg_match('/\(([^)]+)\)/', $j->nama_jurusan, $m)) {
                        if (strcasecmp($m[1], $cleaned) === 0) {
                            $groupName = $j->nama_jurusan;
                            break;
                        }
                    }
                    if (strcasecmp($j->nama_jurusan, $cleaned) === 0) {
                        $groupName = $j->nama_jurusan;
                        break;
                    }
                }

                if (!$groupName) {
                    $groupName = !empty($cleaned) ? strtoupper($cleaned) : 'UMUM / LAINNYA';
                }
            }

            $groupedKelas[$groupName][] = $k;
        }

        ksort($groupedKelas);

        // Fetch Graduated Students (Alumni) grouped by Tahun Lulus -> Kelas
        $alumniList = Siswa::where('status', 'Lulus')
            ->orderBy('tahun_lulus', 'desc')
            ->orderBy('kelas')
            ->orderByRaw('CAST(nis AS UNSIGNED) ASC')
            ->get();

        $groupedAlumni = [];
        foreach ($alumniList as $a) {
            $tahun = $a->tahun_lulus ?? date('Y');
            $groupedAlumni[$tahun][$a->kelas][] = $a;
        }
        krsort($groupedAlumni);

        return view('kelas.index', compact('groupedKelas', 'allKelas', 'groupedAlumni', 'tab'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string'
        ]);

        $inputName = trim($request->nama_kelas);
        
        // Strip any leading level (X, XI, XII, 10, 11, 12) if provided e.g. "DKV 2" or "X DKV 2"
        $code = preg_replace('/^(?:X|XI|XII|10|11|12)\s+/i', '', $inputName);
        $code = trim($code);

        $levels = ['X', 'XI', 'XII'];
        $createdClasses = [];

        foreach ($levels as $level) {
            $className = "{$level} {$code}";
            $createdClass = Kelas::firstOrCreate(['nama_kelas' => $className]);
            $createdClasses[] = $createdClass->nama_kelas;
        }

        $classListStr = implode(', ', $createdClasses);

        return redirect()->route('kelas.index')->with('success', "Kelas '{$inputName}' berhasil ditambahkan dan otomatis membuat 3 tingkat kelas: {$classListStr}.");
    }

    public function show($id)
    {
        $kelas = Kelas::findOrFail($id);
        
        $siswaList = Siswa::where('kelas', $kelas->nama_kelas)
            ->where('status', '!=', 'Lulus')
            ->orderByRaw('CAST(nis AS UNSIGNED) ASC')
            ->get();
        $totalSiswa = $siswaList->count();

        // Calculate Class Ranking & Overall School Ranking for Admin
        $allActiveStudents = Siswa::where('status', '!=', 'Lulus')->get();
        $gradedSubmissionsAvg = \App\Models\TugasSubmission::whereNotNull('nilai')
            ->selectRaw('siswa_id, avg(nilai) as sub_avg')
            ->groupBy('siswa_id')
            ->pluck('sub_avg', 'siswa_id');

        $rankedAll = $allActiveStudents->map(function($c) use ($gradedSubmissionsAvg) {
            $subAvg = $gradedSubmissionsAvg[$c->id] ?? null;
            $baseScore = $c->total_nilai ?? 85.00;
            $score = $subAvg !== null ? ($baseScore * 0.3) + ($subAvg * 0.7) : $baseScore;
            return [
                'id' => $c->id,
                'nis' => $c->nis,
                'nama' => $c->nama,
                'kelas' => $c->kelas,
                'foto' => $c->foto,
                'sub_avg' => $subAvg !== null ? round($subAvg, 1) : '-',
                'score' => round($score, 2),
            ];
        })->sortByDesc('score')->values();

        $rankedAllWithRank = $rankedAll->map(function($item, $idx) {
            $item['overall_rank'] = $idx + 1;
            return $item;
        });

        $classRankedList = $rankedAllWithRank->where('kelas', $kelas->nama_kelas)->values()->map(function($item, $idx) {
            $item['class_rank'] = $idx + 1;
            return $item;
        });

        $overallTop10 = $rankedAllWithRank->take(10);

        return view('kelas.show', compact('kelas', 'siswaList', 'totalSiswa', 'classRankedList', 'rankedAllWithRank', 'overallTop10'));
    }

    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);
        return view('kelas.edit', compact('kelas'));
    }

    public function update(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);

        $request->validate([
            'nama_kelas' => 'required|string|unique:kelas,nama_kelas,' . $kelas->id
        ]);

        $oldName = $kelas->nama_kelas;
        $newName = trim($request->nama_kelas);

        $kelas->update(['nama_kelas' => $newName]);

        // Cascade update related student, task, and schedule records using the updated class name
        if ($oldName !== $newName) {
            Siswa::where('kelas', $oldName)->update(['kelas' => $newName]);
            Tugas::where('kelas', $oldName)->update(['kelas' => $newName]);
            JadwalPelajaran::where('kelas', $oldName)->update(['kelas' => $newName]);
        }

        return redirect()->route('kelas.index')->with('success', 'Nama kelas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $namaKelas = $kelas->nama_kelas;

        // Delete active students belonging to this class along with their login User accounts
        $siswaList = Siswa::where('kelas', $namaKelas)->get();

        foreach ($siswaList as $siswa) {
            if ($siswa->foto && Storage::disk('public')->exists($siswa->foto)) {
                Storage::disk('public')->delete($siswa->foto);
            }

            if ($siswa->user) {
                $siswa->user->delete();
            } else {
                $siswa->delete();
            }
        }

        Tugas::where('kelas', $namaKelas)->delete();
        JadwalPelajaran::where('kelas', $namaKelas)->delete();

        $kelas->delete();

        return redirect()->route('kelas.index')->with('success', 'Kelas "' . $namaKelas . '" beserta seluruh data & akun siswa di dalamnya berhasil dihapus.');
    }

    public function toggleStatus($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->is_active = !$kelas->is_active;
        $kelas->save();

        $msg = $kelas->is_active ? 'ditampilkan (Show)' : 'disembunyikan (Hide)';
        return redirect()->back()->with('success', "Status tampil kelas '{$kelas->nama_kelas}' berhasil {$msg}.");
    }
}
