<?php

use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanController;
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('pdf/{record}', PdfController::class)->name('pdf');
// Route::get('/laporan/tahfiz/rombel/{rombel}/semester/{semester}/tahun/{tahunAjaran}', [LaporanController::class, 'generateRaportKelasPdf'])
//     ->name('laporan.tahfiz.kelas.pdf')
//     ->middleware('auth'); // Lindungi route
