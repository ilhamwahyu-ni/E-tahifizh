<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Doctrine\DBAL\Types\Type;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tm_kelas', function (Blueprint $table) {
            $table->unsignedTinyInteger('level')->change();
            $table->dropColumn('nama_rombel');
            $table->index('level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tm_kelas', function (Blueprint $table) {
            $table->dropIndex(['level']);
            $table->string('nama_rombel', 10)->nullable();
            $table->enum('level', ["1", "2", "3", "4", "5", "6"])->change();
        });
    }
};
