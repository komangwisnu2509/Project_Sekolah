<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profil_sekolahs', function (Blueprint $table) {
            if (!Schema::hasColumn('profil_sekolahs', 'deskripsi_tentang')) {
                $table->text('deskripsi_tentang')->nullable();
            }
            if (!Schema::hasColumn('profil_sekolahs', 'tentang_lengkap')) {
                $table->longText('tentang_lengkap')->nullable();
            }
            if (!Schema::hasColumn('profil_sekolahs', 'foto_tentang')) {
                $table->string('foto_tentang')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('profil_sekolahs', function (Blueprint $table) {
            if (Schema::hasColumn('profil_sekolahs', 'deskripsi_tentang')) {
                $table->dropColumn('deskripsi_tentang');
            }
            if (Schema::hasColumn('profil_sekolahs', 'tentang_lengkap')) {
                $table->dropColumn('tentang_lengkap');
            }
            if (Schema::hasColumn('profil_sekolahs', 'foto_tentang')) {
                $table->dropColumn('foto_tentang');
            }
        });
    }
};
