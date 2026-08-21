<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tables = ['beritas', 'agendas', 'fasilitas', 'galeris', 'testimonis', 'faqs', 'gurus', 'staffs'];

        foreach ($tables as $table) {
            if (Schema::hasTable($table) && !Schema::hasColumn($table, 'is_active')) {
                Schema::table($table, function (Blueprint $t) {
                    $t->boolean('is_active')->default(true);
                });
            }
        }
    }

    public function down(): void
    {
        $tables = ['beritas', 'agendas', 'fasilitas', 'galeris', 'testimonis', 'faqs', 'gurus', 'staffs'];

        foreach ($tables as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'is_active')) {
                Schema::table($table, function (Blueprint $t) {
                    $t->dropColumn('is_active');
                });
            }
        }
    }
};
