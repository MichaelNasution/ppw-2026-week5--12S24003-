<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BukuController;
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
