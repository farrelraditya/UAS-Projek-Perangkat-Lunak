# Sistem Kasir Kantin Paladium

![Build Status](https://img.shields.io/github/actions/workflow/status/farrelraditya/UAS-Projek-Perangkat-Lunak/laravel.yml?branch=main)
![Test Coverage](https://img.shields.io/badge/Coverage-68.42%25-brightgreen)

## A. Deskripsi Aplikasi
Sistem Kasir Kantin Paladium adalah aplikasi manajemen transaksi dan inventori berbasis web yang dirancang untuk mempercepat pencatatan kasir. Aplikasi ini dibangun menggunakan framework Laravel dan mencakup fitur autentikasi pengguna, manajemen produk, serta pencatatan transaksi.

## B. Cara Menjalankan Aplikasi
1. Lakukan clone repository ini.
2. Jalankan perintah `composer install` untuk mengunduh dependensi.
3. Salin file environment: `cp .env.example .env`
4. Hasilkan application key: `php artisan key:generate`
5. Jalankan migrasi database: `php artisan migrate`
6. Jalankan server lokal: `php artisan serve`

## C. Cara Menjalankan Test
Seluruh pengujian telah diotomatisasi menggunakan PHPUnit. Untuk menjalankan pengujian di komputer lokal, jalankan perintah berikut di terminal:
`php artisan test`

Untuk melihat hasil test coverage (membutuhkan Xdebug), jalankan:
`php artisan test --coverage-html public/coverage-report`

## D. Penjelasan Strategi Pengujian
Sistem ini menggunakan strategi pengujian **White-box Testing** yang mengombinasikan *Unit Testing* dan *Integration Testing*. 
- **Unit Testing**: Menggunakan metode *Boundary Value Analysis* (BVA) dan *Equivalence Partitioning* (EP) untuk memvalidasi batasan nilai dan logika fungsi pada level komponen terkecil.
- **Integration Testing**: Memverifikasi aliran fungsionalitas antar modul, seperti rute HTTP, *Controller*, *Middleware*, dan operasi *Database*.