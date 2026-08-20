<x-guest-layout>
    <!-- Header Branding -->
    <div class="text-center mb-4">
        <div class="brand-icon-box">
            <i class="bi bi-person-check-fill fs-2 text-white"></i>
        </div>
        <h4 class="fw-bold text-white mb-1 tracking-wide">Aktivasi Akun Siswa Baru</h4>
        <p class="text-white-50 small mb-0">Khusus Calon Siswa Diterima PPDB Online</p>
    </div>

    <div class="alert alert-info border-0 py-2.5 small mb-4 rounded-3 d-flex align-items-center gap-2">
        <i class="bi bi-info-circle-fill fs-5 flex-shrink-0 text-info"></i>
        <span>Masukkan <strong>Email Aktif</strong> yang Anda daftarkan saat mengisi form PPDB Online untuk aktivasi akun Anda.</span>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name Field -->
        <div class="mb-3">
            <label for="name" class="form-label text-white-50 fw-semibold small mb-1">Nama Lengkap Siswa</label>
            <div class="position-relative">
                <i class="bi bi-person-fill input-group-icon"></i>
                <input id="name" type="text" name="name" value="{{ old('name') }}" 
                       class="form-control form-control-custom @error('name') is-invalid @enderror" 
                       placeholder="Masukkan Nama Lengkap Anda..." required autofocus autocomplete="name">
            </div>
            @error('name')
                <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
            @enderror
        </div>

        <!-- Email Address Field -->
        <div class="mb-3">
            <label for="email" class="form-label text-white-50 fw-semibold small mb-1">Email Terdaftar PPDB <span class="text-warning">*</span></label>
            <div class="position-relative">
                <i class="bi bi-envelope-fill input-group-icon"></i>
                <input id="email" type="email" name="email" value="{{ old('email') }}" 
                       class="form-control form-control-custom @error('email') is-invalid @enderror" 
                       placeholder="email.saat.ppdb@gmail.com" required autocomplete="username">
            </div>
            @error('email')
                <div class="text-danger small mt-1" style="line-height: 1.4;"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
            @enderror
        </div>

        <!-- Password Field -->
        <div class="mb-3">
            <label for="password" class="form-label text-white-50 fw-semibold small mb-1">Buat Password Akun Baru</label>
            <div class="position-relative">
                <i class="bi bi-lock-fill input-group-icon"></i>
                <input id="password" type="password" name="password" 
                       class="form-control form-control-custom pe-5 @error('password') is-invalid @enderror" 
                       placeholder="Minimal 8 karakter..." required autocomplete="new-password">
            </div>
            @error('password')
                <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password Field -->
        <div class="mb-4">
            <label for="password_confirmation" class="form-label text-white-50 fw-semibold small mb-1">Konfirmasi Password Baru</label>
            <div class="position-relative">
                <i class="bi bi-shield-lock-fill input-group-icon"></i>
                <input id="password_confirmation" type="password" name="password_confirmation" 
                       class="form-control form-control-custom pe-5 @error('password_confirmation') is-invalid @enderror" 
                       placeholder="Ulangi password di atas..." required autocomplete="new-password">
            </div>
            @error('password_confirmation')
                <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="d-grid mb-3">
            <button type="submit" class="btn btn-login">
                <i class="bi bi-check-circle-fill me-2"></i> Aktivasi & Registrasi Akun Siswa
            </button>
        </div>

        <!-- Already Registered Footer Link -->
        <div class="text-center pt-3 border-top border-secondary border-opacity-25">
            <span class="text-white-50 small">Sudah memiliki akun aktif?</span>
            <a href="{{ route('login') }}" class="text-primary text-decoration-none fw-bold ms-1 hover-underline">Masuk Ke Akun (Login)</a>
        </div>
    </form>
</x-guest-layout>
