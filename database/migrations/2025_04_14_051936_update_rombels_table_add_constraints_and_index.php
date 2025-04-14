<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('rombels', function (Blueprint $table) {
            $table->foreign('tahun_ajaran_id')->references('id')->on('tahun_ajarans')->onDelete('cascade');
            $table->foreign('tm_kelas_id')->references('id')->on('tm_kelas')->onDelete('cascade');
            $table->foreign('sekolah_id')->references('id')->on('sekolahs')->onDelete('cascade');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rombels', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropForeign(['sekolah_id']);
            $table->dropForeign(['tm_kelas_id']);
            $table->dropForeign(['tahun_ajaran_id']);
        });
    }
};
