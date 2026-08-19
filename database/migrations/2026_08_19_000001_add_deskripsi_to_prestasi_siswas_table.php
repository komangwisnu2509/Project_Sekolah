<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('prestasi_siswas', function (Blueprint $table) {
            if (!Schema::hasColumn('prestasi_siswas', 'deskripsi')) {
                $table->text('deskripsi')->nullable()->after('penyelenggara');
            }
        });
    }

    public function down(): void
    {
        Schema::table('prestasi_siswas', function (Blueprint $table) {
            if (Schema::hasColumn('prestasi_siswas', 'deskripsi')) {
                $table->dropColumn('deskripsi');
            }
        });
    }
};
