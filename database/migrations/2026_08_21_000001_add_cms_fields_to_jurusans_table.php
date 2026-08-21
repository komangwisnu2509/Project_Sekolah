<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jurusans', function (Blueprint $table) {
            if (!Schema::hasColumn('jurusans', 'deskripsi')) {
                $table->text('deskripsi')->nullable()->after('nama_jurusan');
            }
            if (!Schema::hasColumn('jurusans', 'detail_informasi')) {
                $table->text('detail_informasi')->nullable()->after('deskripsi');
            }
            if (!Schema::hasColumn('jurusans', 'foto')) {
                $table->string('foto')->nullable()->after('detail_informasi');
            }
            if (!Schema::hasColumn('jurusans', 'icon')) {
                $table->string('icon')->nullable()->after('foto');
            }
        });
    }

    public function down(): void
    {
        Schema::table('jurusans', function (Blueprint $table) {
            $table->dropColumn(['deskripsi', 'detail_informasi', 'foto', 'icon']);
        });
    }
};
