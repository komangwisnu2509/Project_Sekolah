<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Siswa;
use App\Models\PpdbPendaftaran;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming student account activation/registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $emailInput = strtolower(trim($request->email));

        // 1. Check if email exists in PPDB database with status 'Diterima'
        $ppdbAccepted = PpdbPendaftaran::where('email', $emailInput)
            ->where('status', 'Diterima')
            ->first();

        // 2. Or check if email already exists in official Siswa table
        $siswaExisting = Siswa::where('email', $emailInput)->first();

        // If email is not found in accepted PPDB or existing student records, DENY registration!
        if (!$ppdbAccepted && !$siswaExisting) {
            throw ValidationException::withMessages([
                'email' => 'Email ini (' . $request->email . ') belum terdaftar atau belum dinyatakan DITERIMA pada seleksi PPDB Online. Registrasi akun hanya berlaku untuk calon siswa yang telah diterima.',
            ]);
        }

        // Find or create the official Siswa record for the accepted student
        $siswa = $siswaExisting;

        if ($ppdbAccepted) {
            $kelasTarget = 'X ' . $ppdbAccepted->pilihan_jurusan;
            // Automatically ensure the target Class exists in the kelas table
            \App\Models\Kelas::firstOrCreate(['nama_kelas' => $kelasTarget]);

            if (!$siswa) {
                // Generate NIS for accepted PPDB student
                $lastNis = Siswa::max('nis');
                $nextNis = $lastNis ? ((int)$lastNis + 1) : 10001;

                $siswa = Siswa::create([
                    'nis' => (string)$nextNis,
                    'nama' => $ppdbAccepted->nama_lengkap,
                    'email' => $ppdbAccepted->email,
                    'kelas' => $kelasTarget,
                    'jurusan' => $ppdbAccepted->pilihan_jurusan,
                    'status' => 'Aktif',
                    'foto' => $ppdbAccepted->foto,
                ]);
            } else {
                $siswa->update([
                    'kelas' => $kelasTarget,
                    'jurusan' => $ppdbAccepted->pilihan_jurusan,
                    'status' => 'Aktif',
                ]);
            }
        }

        // Create the User Account with student role
        $user = User::create([
            'name' => $siswa ? $siswa->nama : $request->name,
            'email' => $emailInput,
            'password' => Hash::make($request->password),
            'role' => 'siswa',
            'siswa_id' => $siswa ? $siswa->id : null,
            'foto' => $siswa ? $siswa->foto : null,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
