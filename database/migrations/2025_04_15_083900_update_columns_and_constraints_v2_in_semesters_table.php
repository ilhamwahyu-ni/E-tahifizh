<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('semesters', function (Blueprint $table) {
            $table->boolean('is_active_temp')->after('tahun_ajaran_id')->nullable();
            $table->tinyInteger('type_temp')->after('id')->nullable()->comment('1: Ganjil, 2: Genap');

            if (!Schema::hasColumn('semesters', 'tahun_ajaran_id')) {
                $table->foreign('tahun_ajaran_id')
                    ->references('id')
                    ->on('tahun_ajarans')
                    ->onDelete('restrict');
            }
        });

        DB::table('semesters')->orderBy('id')->chunk(100, function ($semesters) {
            foreach ($semesters as $semester) {
                DB::table('semesters')
                    ->where('id', $semester->id)
                    ->update([
                        'is_active_temp' => ($semester->status === 'aktif'),
                        'type_temp' => ($semester->nama === 'Ganjil' ? 1 : 2),
                    ]);
            }
        });

        Schema::table('semesters', function (Blueprint $table) {
            // Check if columns exist before renaming
            if (Schema::hasColumn('semesters', 'is_active_temp') && !Schema::hasColumn('semesters', 'is_active')) {
                $table->renameColumn('is_active_temp', 'is_active');
            }
            if (Schema::hasColumn('semesters', 'type_temp') && !Schema::hasColumn('semesters', 'type')) {
                $table->renameColumn('type_temp', 'type');
            }

            if (Schema::hasColumn('semesters', 'is_active')) {
                $table->boolean('is_active')->default(true)->nullable(false)->change();
            }
            if (Schema::hasColumn('semesters', 'type')) {
                $table->tinyInteger('type')->default(1)->nullable(false)->comment('1: Ganjil, 2: Genap')->change();
            }

            $table->index(['is_active', 'type']);
        });
    }

    public function down(): void
    {
        Schema::table('semesters', function (Blueprint $table) {
            $table->enum('nama', ['Ganjil', 'Genap'])->nullable()->after('id');
            $table->enum('status', ['aktif', 'nonaktif'])->nullable()->after('tahun_ajaran_id');
        });

        DB::table('semesters')->orderBy('id')->chunk(100, function ($semesters) {
            foreach ($semesters as $semester) {
                DB::table('semesters')
                    ->where('id', $semester->id)
                    ->update([
                        'status' => ($semester->is_active ? 'aktif' : 'nonaktif'),
                        'nama' => ($semester->type === 1 ? 'Ganjil' : 'Genap'),
                    ]);
            }
        });

        Schema::table('semesters', function (Blueprint $table) {
            $table->dropIndex(['is_active', 'type']);
            $table->dropColumn(['is_active', 'type']);
        });
    }
};
