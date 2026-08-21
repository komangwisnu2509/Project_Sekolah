<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');
        $query = Staff::query();

        if ($q) {
            $query->where(function($query) use ($q) {
                $query->where('nip_nik', 'like', "%{$q}%")
                      ->orWhere('nama', 'like', "%{$q}%")
                      ->orWhere('jabatan', 'like', "%{$q}%")
                      ->orWhere('no_hp', 'like', "%{$q}%")
                      ->orWhere('email', 'like', "%{$q}%");
            });
        }

        $staffs = $query->orderBy('nama')->get();
        return view('staff.index', compact('staffs', 'q'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip_nik' => 'nullable|string|max:100|unique:staffs,nip_nik',
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'nama.required' => 'Nama staff wajib diisi.',
            'jabatan.required' => 'Jabatan / Posisi staff wajib diisi.',
            'nip_nik.unique' => 'NIP / NIK sudah terdaftar pada staff lain.',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('staff_foto', 'public');
        }

        Staff::create([
            'nip_nik' => $request->filled('nip_nik') ? trim($request->nip_nik) : null,
            'nama' => trim($request->nama),
            'jabatan' => trim($request->jabatan),
            'no_hp' => $request->filled('no_hp') ? trim($request->no_hp) : null,
            'email' => $request->filled('email') ? trim($request->email) : null,
            'foto' => $fotoPath,
        ]);

        return redirect()->back()->with('success', 'Data Staff / Tenaga Kependidikan berhasil ditambahkan.');
    }

    public function update(Request $request, Staff $staff)
    {
        $request->validate([
            'nip_nik' => 'nullable|string|max:100|unique:staffs,nip_nik,' . $staff->id,
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'nama.required' => 'Nama staff wajib diisi.',
            'jabatan.required' => 'Jabatan / Posisi staff wajib diisi.',
            'nip_nik.unique' => 'NIP / NIK sudah terdaftar pada staff lain.',
        ]);

        $data = [
            'nip_nik' => $request->filled('nip_nik') ? trim($request->nip_nik) : null,
            'nama' => trim($request->nama),
            'jabatan' => trim($request->jabatan),
            'no_hp' => $request->filled('no_hp') ? trim($request->no_hp) : null,
            'email' => $request->filled('email') ? trim($request->email) : null,
        ];

        if ($request->hasFile('foto')) {
            if ($staff->foto && Storage::disk('public')->exists($staff->foto)) {
                Storage::disk('public')->delete($staff->foto);
            }
            $data['foto'] = $request->file('foto')->store('staff_foto', 'public');
        }

        $staff->update($data);

        return redirect()->back()->with('success', 'Data Staff / Tenaga Kependidikan berhasil diperbarui.');
    }

    public function destroy(Staff $staff)
    {
        if ($staff->foto && Storage::disk('public')->exists($staff->foto)) {
            Storage::disk('public')->delete($staff->foto);
        }

        $staff->delete();

        return redirect()->back()->with('success', 'Data Staff berhasil dihapus.');
    }
}
