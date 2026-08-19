<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tugas_submissions', function (Blueprint $table) {
            if (!Schema::hasColumn('tugas_submissions', 'status_izin_terlambat')) {
                $table->string('status_izin_terlambat')->nullable(); // 'Pending', 'Disetujui', 'Ditolak'
            }
            if (!Schema::hasColumn('tugas_submissions', 'alasan_terlambat')) {
                $table->text('alasan_terlambat')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('tugas_submissions', function (Blueprint $table) {
            if (Schema::hasColumn('tugas_submissions', 'status_izin_terlambat')) {
                $table->dropColumn('status_izin_terlambat');
            }
            if (Schema::hasColumn('tugas_submissions', 'alasan_terlambat')) {
                $table->dropColumn('alasan_terlambat');
            }
        });
    }
};
