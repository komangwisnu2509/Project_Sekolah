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
        Schema::table('beritas', function (Blueprint $table) {
            if (!Schema::hasColumn('beritas', 'penulis')) {
                $table->string('penulis')->nullable()->after('kategori');
            }
            if (!Schema::hasColumn('beritas', 'tags')) {
                $table->text('tags')->nullable()->after('is_highlight');
            }
        });
    }

    public function down(): void
    {
        Schema::table('beritas', function (Blueprint $table) {
            if (Schema::hasColumn('beritas', 'penulis')) {
                $table->dropColumn('penulis');
            }
            if (Schema::hasColumn('beritas', 'tags')) {
                $table->dropColumn('tags');
            }
        });
    }
};
