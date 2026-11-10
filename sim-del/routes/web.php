<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - SIPUS-Del (Sistem Informasi Perpustakaan Del)
|--------------------------------------------------------------------------
*/

// Redirect root ke katalog utama buku
Route::get('/', fn() => redirect()->route('buku.index'));

// 7 Aksi Baku RESTful Resource Kategori
Route::resource('kategori', KategoriController::class);

// 7 Aksi Baku RESTful Resource Buku
Route::resource('buku', BukuController::class);

// Modul Sirkulasi Transaksi Peminjaman & Pengembalian Buku (ACID & Concurrency Locking)
Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
Route::patch('/peminjaman/{id}/kembali', [PeminjamanController::class, 'kembali'])->name('peminjaman.kembali');
