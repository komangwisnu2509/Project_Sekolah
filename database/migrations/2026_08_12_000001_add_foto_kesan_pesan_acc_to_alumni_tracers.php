<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alumni_tracers', function (Blueprint $table) {
            $table->string('foto')->nullable()->after('catatan');
            $table->text('kesan_pesan')->nullable()->after('foto');
            $table->enum('status_acc', ['Pending', 'Disetujui', 'Ditolak'])->default('Pending')->after('kesan_pesan');
            $table->text('catatan_admin')->nullable()->after('status_acc');
        });
    }

    public function down(): void
    {
        Schema::table('alumni_tracers', function (Blueprint $table) {
            $table->dropColumn(['foto', 'kesan_pesan', 'status_acc', 'catatan_admin']);
        });
    }
};
