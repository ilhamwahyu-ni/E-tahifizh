<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MateriTahsin; // Pastikan Model MateriTahsin sudah dibuat
use Illuminate\Support\Facades\DB; // Opsional: Untuk truncate jika perlu

class MateriTahsinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Opsional: Kosongkan tabel sebelum mengisi ulang untuk menghindari duplikasi jika seeder dijalankan berkali-kali
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // Nonaktifkan cek foreign key sementara
        // MateriTahsin::truncate();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // Aktifkan kembali

        $daftarMateri = [
            // KELAS 1
            ['kelas' => 1, 'semester' => 1, 'topik_materi' => 'Makharijul huruf', 'urutan' => 1],
            ['kelas' => 1, 'semester' => 1, 'topik_materi' => 'Pembagian Makharijul Huruf', 'urutan' => 2],
            ['kelas' => 1, 'semester' => 2, 'topik_materi' => 'Tanda Baca', 'urutan' => 1],
            ['kelas' => 1, 'semester' => 2, 'topik_materi' => 'Huruf Bersambung', 'urutan' => 2], // Nama disesuaikan dari 'Huruf  B ersambung'

            // KELAS 2
            ['kelas' => 2, 'semester' => 1, 'topik_materi' => 'Tanda Tasydid', 'urutan' => 1],
            ['kelas' => 2, 'semester' => 1, 'topik_materi' => 'Mad Ashli', 'urutan' => 2],
            ['kelas' => 2, 'semester' => 2, 'topik_materi' => 'Tanda Sukun', 'urutan' => 1],
            ['kelas' => 2, 'semester' => 2, 'topik_materi' => 'Wajibul Ghunnah', 'urutan' => 2],

            // KELAS 3
            ['kelas' => 3, 'semester' => 1, 'topik_materi' => 'Qalqalah', 'urutan' => 1],
            ['kelas' => 3, 'semester' => 1, 'topik_materi' => 'Lafaz Jalalah', 'urutan' => 2],
            ['kelas' => 3, 'semester' => 1, 'topik_materi' => 'Iqlab', 'urutan' => 3],
            ['kelas' => 3, 'semester' => 1, 'topik_materi' => 'Izhar Halqi', 'urutan' => 4],
            ['kelas' => 3, 'semester' => 2, 'topik_materi' => 'Idgam bilaghunnah', 'urutan' => 1],
            ['kelas' => 3, 'semester' => 2, 'topik_materi' => 'Idgham bighunnah', 'urutan' => 2],
            ['kelas' => 3, 'semester' => 2, 'topik_materi' => 'Ikhfa haqiqi', 'urutan' => 3],
            ['kelas' => 3, 'semester' => 2, 'topik_materi' => 'Alif lam Syamsiyah', 'urutan' => 4],
            ['kelas' => 3, 'semester' => 2, 'topik_materi' => 'Alif Lam Qamariyah', 'urutan' => 5],

            // KELAS 4
            ['kelas' => 4, 'semester' => 1, 'topik_materi' => 'Hukum ra', 'urutan' => 1],
            ['kelas' => 4, 'semester' => 1, 'topik_materi' => 'Idgham Mimi', 'urutan' => 2],
            ['kelas' => 4, 'semester' => 1, 'topik_materi' => 'Ikhfa syafawi', 'urutan' => 3],
            ['kelas' => 4, 'semester' => 1, 'topik_materi' => 'Izhar Syafawi', 'urutan' => 4],
            ['kelas' => 4, 'semester' => 2, 'topik_materi' => 'Mad Layyin', 'urutan' => 1],
            ['kelas' => 4, 'semester' => 2, 'topik_materi' => 'Mad Tamkin', 'urutan' => 2],
            ['kelas' => 4, 'semester' => 2, 'topik_materi' => 'Mad Iwadh', 'urutan' => 3],
            ['kelas' => 4, 'semester' => 2, 'topik_materi' => 'Mad Shilah Qashirah', 'urutan' => 4],

            // KELAS 5
            ['kelas' => 5, 'semester' => 1, 'topik_materi' => 'Mad Wajib Muttashil', 'urutan' => 1],
            ['kelas' => 5, 'semester' => 1, 'topik_materi' => 'Mad Jaiz Munfashil', 'urutan' => 2],
            ['kelas' => 5, 'semester' => 1, 'topik_materi' => 'Mad Shilah Thawilah', 'urutan' => 3],
            ['kelas' => 5, 'semester' => 1, 'topik_materi' => 'Mad Lazim Mukhaffaf Harfi', 'urutan' => 4],
            ['kelas' => 5, 'semester' => 2, 'topik_materi' => 'Mad Aridh Lissukun', 'urutan' => 1],
            ['kelas' => 5, 'semester' => 2, 'topik_materi' => 'Mad Farqi', 'urutan' => 2],
            ['kelas' => 5, 'semester' => 2, 'topik_materi' => 'Mad Lazim Mukhaffaf Kilmi', 'urutan' => 3],

            // KELAS 6
            ['kelas' => 6, 'semester' => 1, 'topik_materi' => 'Mad Lazim Mutsaqqal Harfi', 'urutan' => 1],
            ['kelas' => 6, 'semester' => 1, 'topik_materi' => 'Mad Lazim Mutsaqqal Kilmi', 'urutan' => 2],
            ['kelas' => 6, 'semester' => 1, 'topik_materi' => 'Waqaf Ibtida’', 'urutan' => 3],
            ['kelas' => 6, 'semester' => 2, 'topik_materi' => 'Huruf-huruf Muqatha’ah', 'urutan' => 1],
            ['kelas' => 6, 'semester' => 2, 'topik_materi' => 'Ayat-ayat Gharibah', 'urutan' => 2],
        ];

        // Loop dan masukkan data ke database
        foreach ($daftarMateri as $materi) {
            // Gunakan updateOrCreate untuk menghindari duplikasi jika seeder dijalankan lagi
            // Mencari berdasarkan kombinasi unik kelas, semester, dan topik_materi
            MateriTahsin::updateOrCreate(
                [
                    'kelas' => $materi['kelas'],
                    'semester' => $materi['semester'],
                    'topik_materi' => $materi['topik_materi'],
                ],
                [
                    'urutan' => $materi['urutan'],
                    // 'deskripsi_lengkap' => null, // Set null atau isi jika ada deskripsi default
                ]
            );
        }

        $this->command->info('Seeder Materi Tahsin berhasil dijalankan.');
    }
}

