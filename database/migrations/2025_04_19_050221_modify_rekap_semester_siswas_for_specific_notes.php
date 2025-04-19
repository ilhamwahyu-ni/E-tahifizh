<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // Pastikan package doctrine/dbal sudah terinstall untuk renameColumn
        Schema::table('rekap_semester_siswas', function (Blueprint $table) {
            // 1. Ganti nama kolom 'catatan_global' menjadi 'catatan_global_hafalan'
            $table->renameColumn('catatan_global', 'catatan_global_hafalan');

            // 2. Tambahkan kolom baru 'catatan_global_tahsin' setelah kolom yang baru diganti nama
            $table->text('catatan_global_tahsin')->nullable()->after('catatan_global_hafalan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('rekap_semester_siswas', function (Blueprint $table) {
            // 1. Hapus kolom 'catatan_global_tahsin'
            $table->dropColumn('catatan_global_tahsin');

            // 2. Kembalikan nama kolom 'catatan_global_hafalan' menjadi 'catatan_global'
            $table->renameColumn('catatan_global_hafalan', 'catatan_global');
        });
    }
};
