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
        Schema::create('riwayat_hafalans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hafalan_siswa_id');
            $table->text('catatan');
            $table->enum('status', ["baru","diperbarui","dihapus"]);
            $table->timestamp('tanggal');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_hafalans');
    }
};
