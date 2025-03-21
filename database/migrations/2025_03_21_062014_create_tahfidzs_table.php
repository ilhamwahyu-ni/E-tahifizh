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
        Schema::create('tahfidzs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id');
            $table->text('catatan');
            $table->integer('total_hafalan');
            $table->integer('target_hafalan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tahfidzs');
    }
};
