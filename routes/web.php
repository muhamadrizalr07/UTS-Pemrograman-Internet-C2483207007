<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\SeleksiController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('beranda');

Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
Route::get('/mahasiswa/{id}', [MahasiswaController::class, 'show'])->whereNumber('id')->name('mahasiswa.show');
Route::get('/status/{status}', [MahasiswaController::class, 'byStatus'])
    ->where('status', 'diterima|cadangan|tidak-layak')
    ->name('mahasiswa.status');

Route::get('/kriteria', [KriteriaController::class, 'index'])->name('kriteria');

Route::get('/hasil-skor', [SeleksiController::class, 'hasil'])->name('hasil');
Route::get('/peringkat', [SeleksiController::class, 'peringkat'])->name('peringkat');
