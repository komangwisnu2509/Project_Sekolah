<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ppdb_pendaftarans', function (Blueprint $table) {
            if (!Schema::hasColumn('ppdb_pendaftarans', 'tgl_daftar_ulang')) {
                $table->string('tgl_daftar_ulang')->nullable()->after('catatan_admin');
            }
            if (!Schema::hasColumn('ppdb_pendaftarans', 'waktu_daftar_ulang')) {
                $table->string('waktu_daftar_ulang')->nullable()->after('tgl_daftar_ulang');
            }
            if (!Schema::hasColumn('ppdb_pendaftarans', 'seragam_daftar_ulang')) {
                $table->string('seragam_daftar_ulang')->nullable()->after('waktu_daftar_ulang');
            }
            if (!Schema::hasColumn('ppdb_pendaftarans', 'lokasi_daftar_ulang')) {
                $table->string('lokasi_daftar_ulang')->nullable()->after('seragam_daftar_ulang');
            }
            if (!Schema::hasColumn('ppdb_pendaftarans', 'alasan_ditolak')) {
                $table->text('alasan_ditolak')->nullable()->after('lokasi_daftar_ulang');
            }
        });
    }

    public function down(): void
    {
        Schema::table('ppdb_pendaftarans', function (Blueprint $table) {
            $table->dropColumn([
                'tgl_daftar_ulang',
                'waktu_daftar_ulang',
                'seragam_daftar_ulang',
                'lokasi_daftar_ulang',
                'alasan_ditolak'
            ]);
        });
    }
};
