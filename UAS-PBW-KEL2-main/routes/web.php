<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Beranda;
use App\Livewire\User;
use App\Livewire\Laporan;
use App\Livewire\Produk;
use App\Livewire\Transaksi;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', Beranda::class)->middleware(['auth'])->name('home');
Route::get('/User', User::class)->middleware(['auth'])->name('User');
Route::get('/Laporan', Laporan::class)->middleware(['auth'])->name('Laporan');
Route::get('/Produk', Produk::class)->middleware(['auth'])->name('Produk');
Route::get('/Transaksi', Transaksi::class)->middleware(['auth'])->name('Transaksi');
