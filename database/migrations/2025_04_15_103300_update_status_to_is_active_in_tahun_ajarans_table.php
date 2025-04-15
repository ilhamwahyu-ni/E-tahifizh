<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tahun_ajarans', function (Blueprint $table) {
            $table->boolean('is_active')->default(false)->after('nama');
        });

        // Migrasi data dari status ke is_active
        DB::table('tahun_ajarans')->where('status', 'aktif')->update(['is_active' => true]);
        DB::table('tahun_ajarans')->where('status', 'nonaktif')->update(['is_active' => false]);

        Schema::table('tahun_ajarans', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }

    public function down(): void
    {
        Schema::table('tahun_ajarans', function (Blueprint $table) {
            $table->enum('status', ['aktif', 'nonaktif'])->default('nonaktif')->after('nama');
        });

        // Migrasi balik data dari is_active ke status
        DB::table('tahun_ajarans')->where('is_active', true)->update(['status' => 'aktif']);
        DB::table('tahun_ajarans')->where('is_active', false)->update(['status' => 'nonaktif']);

        Schema::table('tahun_ajarans', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
};
