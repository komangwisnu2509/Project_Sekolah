<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profil_sekolahs', function (Blueprint $table) {
            if (!Schema::hasColumn('profil_sekolahs', 'slogan')) {
                $table->string('slogan')->nullable();
            }
            if (!Schema::hasColumn('profil_sekolahs', 'sambutan_kepala_sekolah')) {
                $table->text('sambutan_kepala_sekolah')->nullable();
            }
            if (!Schema::hasColumn('profil_sekolahs', 'nama_kepala_sekolah')) {
                $table->string('nama_kepala_sekolah')->nullable();
            }
            if (!Schema::hasColumn('profil_sekolahs', 'sejarah')) {
                $table->text('sejarah')->nullable();
            }
            if (!Schema::hasColumn('profil_sekolahs', 'instagram')) {
                $table->string('instagram')->nullable();
            }
            if (!Schema::hasColumn('profil_sekolahs', 'youtube')) {
                $table->string('youtube')->nullable();
            }
            if (!Schema::hasColumn('profil_sekolahs', 'facebook')) {
                $table->string('facebook')->nullable();
            }
            if (!Schema::hasColumn('profil_sekolahs', 'foto_kepala_sekolah')) {
                $table->string('foto_kepala_sekolah')->nullable();
            }
            if (!Schema::hasColumn('profil_sekolahs', 'hero_banner')) {
                $table->string('hero_banner')->nullable();
            }
        });
    }

    public function down(): void
    {
        // No down action needed
    }
};
