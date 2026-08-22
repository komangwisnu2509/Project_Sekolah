<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profil_sekolahs', function (Blueprint $table) {
            if (!Schema::hasColumn('profil_sekolahs', 'whatsapp')) {
                $table->string('whatsapp')->nullable()->after('telepon');
            }
            if (!Schema::hasColumn('profil_sekolahs', 'tiktok')) {
                $table->string('tiktok')->nullable()->after('youtube');
            }
        });
    }

    public function down(): void
    {
        Schema::table('profil_sekolahs', function (Blueprint $table) {
            if (Schema::hasColumn('profil_sekolahs', 'whatsapp')) {
                $table->dropColumn('whatsapp');
            }
            if (Schema::hasColumn('profil_sekolahs', 'tiktok')) {
                $table->dropColumn('tiktok');
            }
        });
    }
};
