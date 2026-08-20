<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ppdb_pendaftarans', function (Blueprint $table) {
            if (!Schema::hasColumn('ppdb_pendaftarans', 'email')) {
                $table->string('email')->nullable()->after('no_hp_wa');
            }
        });

        Schema::table('siswa', function (Blueprint $table) {
            if (!Schema::hasColumn('siswa', 'email')) {
                $table->string('email')->nullable()->after('nama');
            }
        });
    }

    public function down(): void
    {
        Schema::table('ppdb_pendaftarans', function (Blueprint $table) {
            if (Schema::hasColumn('ppdb_pendaftarans', 'email')) {
                $table->dropColumn('email');
            }
        });

        Schema::table('siswa', function (Blueprint $table) {
            if (Schema::hasColumn('siswa', 'email')) {
                $table->dropColumn('email');
            }
        });
    }
};
