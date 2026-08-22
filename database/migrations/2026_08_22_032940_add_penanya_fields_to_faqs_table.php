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
        Schema::table('faqs', function (Blueprint $table) {
            if (!Schema::hasColumn('faqs', 'nama_penanya')) {
                $table->string('nama_penanya')->nullable()->after('pertanyaan');
            }
            if (!Schema::hasColumn('faqs', 'email_penanya')) {
                $table->string('email_penanya')->nullable()->after('nama_penanya');
            }
            $table->text('jawaban')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('faqs', function (Blueprint $table) {
            if (Schema::hasColumn('faqs', 'nama_penanya')) {
                $table->dropColumn('nama_penanya');
            }
            if (Schema::hasColumn('faqs', 'email_penanya')) {
                $table->dropColumn('email_penanya');
            }
        });
    }
};
