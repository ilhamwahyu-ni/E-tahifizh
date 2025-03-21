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
        Schema::create('tr_kelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tm_kelas_id');
            $table->string('nama');
            $table->string('ruangan');
            $table->integer('siswa_aktif');
            $table->string('ajaran', 4);
            $table->integer('semester');
            $table->enum('status', ["Aktif","Tidak_Aktif"])->default('Aktif');
       
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tr_kelas');
    }
};
