<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Diperlukan untuk enum 'down'

// Nama class disesuaikan dengan nama file migrasi yang dibuat artisan
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Menggunakan Schema::table karena tabel sudah ada
        Schema::table('semesters', function (Blueprint $table) {
            // 1. Tambahkan Foreign Key Constraint (jika belum ada di create table)
            // Pastikan ini hanya ditambahkan jika BELUM ada constraint sebelumnya
            // Cek manual di DB atau asumsikan belum ada dari migrasi awal
            if (!Schema::hasColumn('semesters', 'tahun_ajaran_id_foreign')) { // Cek sederhana, nama constraint bisa bervariasi
                 $table->foreign('tahun_ajaran_id')
                       ->references('id')
                       ->on('tahun_ajarans')
                       ->onDelete('restrict'); // Sesuaikan onDelete
            }

            // 2. Ubah 'status' ke 'is_active' (boolean)
            // Buat kolom baru dulu (nullable), migrasi data, baru hapus kolom lama
            $table->boolean('is_active_new')->after('tahun_ajaran_id')->nullable()->default(true);

            // 3. Ubah 'nama' ke 'type' (tinyInteger)
            // Buat kolom baru dulu (nullable), migrasi data, baru hapus kolom lama
            $table->tinyInteger('type_new')->after('id')->nullable()->default(1)->comment('1: Ganjil, 2: Genap');

        });

         // Migrasi data dari kolom lama ke baru (jika ada data)
         DB::table('semesters')->where('status', 'aktif')->update(['is_active_new' => true]);
         DB::table('semesters')->where('status', 'nonaktif')->update(['is_active_new' => false]);
         DB::table('semesters')->where('nama', 'Ganjil')->update(['type_new' => 1]);
         DB::table('semesters')->where('nama', 'Genap')->update(['type_new' => 2]);


        Schema::table('semesters', function (Blueprint $table) {
             // 4. Hapus kolom enum lama
             $table->dropColumn('status');
             $table->dropColumn('nama');

             // 5. Rename kolom baru ke nama final
             $table->renameColumn('is_active_new', 'is_active');
             $table->renameColumn('type_new', 'type');

             // 6. Set kolom tidak nullable jika diperlukan setelah rename
             // $table->boolean('is_active')->nullable(false)->change(); // Perlu dbal
             // $table->tinyInteger('type')->nullable(false)->change(); // Perlu dbal

             // 7. Tambahkan index
             $table->index('is_active');
             $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('semesters', function (Blueprint $table) {
             // 1. Buat kembali kolom enum lama (nullable)
             $table->enum('nama', ["Ganjil","Genap"])->nullable()->after('id');
             $table->enum('status', ["aktif","nonaktif"])->nullable()->after('tahun_ajaran_id');

              // Migrasi data kembali dari kolom baru ke lama (jika ada data)
              DB::table('semesters')->where('is_active', true)->update(['status' => 'aktif']);
              DB::table('semesters')->where('is_active', false)->update(['status' => 'nonaktif']);
              DB::table('semesters')->where('type', 1)->update(['nama' => 'Ganjil']);
              DB::table('semesters')->where('type', 2)->update(['nama' => 'Genap']);

             // 2. Hapus index kolom baru
             $table->dropIndex(['is_active']); // Nama index default: semesters_is_active_index
             $table->dropIndex(['type']);      // Nama index default: semesters_type_index

             // 3. Hapus kolom boolean/integer baru
             $table->dropColumn('is_active');
             $table->dropColumn('type');

             // 4. Hapus Foreign Key Constraint (jika ditambahkan di 'up')
             // Gunakan nama constraint yang benar jika diketahui, atau array kolom
             $table->dropForeign(['tahun_ajaran_id']);

             // 5. Kembalikan kolom lama menjadi not nullable & default (jika perlu)
             // $table->enum('nama', ["Ganjil","Genap"])->nullable(false)->default('Ganjil')->change(); // Perlu dbal
             // $table->enum('status', ["aktif","nonaktif"])->nullable(false)->default('aktif')->change(); // Perlu dbal
        });
    }
};
