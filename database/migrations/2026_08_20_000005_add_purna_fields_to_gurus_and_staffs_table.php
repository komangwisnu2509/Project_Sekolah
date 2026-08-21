<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('gurus', function (Blueprint $table) {
            $table->string('status')->default('Aktif')->after('mata_pelajaran');
            $table->string('tahun_purna')->nullable()->after('status');
            $table->text('pesan_purna')->nullable()->after('tahun_purna');
        });

        Schema::table('staffs', function (Blueprint $table) {
            $table->string('status')->default('Aktif')->after('jabatan');
            $table->string('tahun_purna')->nullable()->after('status');
            $table->text('pesan_purna')->nullable()->after('tahun_purna');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gurus', function (Blueprint $table) {
            $table->dropColumn(['status', 'tahun_purna', 'pesan_purna']);
        });

        Schema::table('staffs', function (Blueprint $table) {
            $table->dropColumn(['status', 'tahun_purna', 'pesan_purna']);
        });
    }
};
