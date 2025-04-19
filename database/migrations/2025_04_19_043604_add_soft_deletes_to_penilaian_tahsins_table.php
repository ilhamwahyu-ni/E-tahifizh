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
        Schema::table('penilaian_tahsins', function (Blueprint $table) {
            // Menambahkan kolom deleted_at untuk Soft Deletes
            $table->softDeletes(); // Ini akan membuat kolom `deleted_at` nullable
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penilaian_tahsins', function (Blueprint $table) {
            // Menghapus kolom deleted_at jika migrasi di-rollback
            $table->dropSoftDeletes();
        });
    }
};
