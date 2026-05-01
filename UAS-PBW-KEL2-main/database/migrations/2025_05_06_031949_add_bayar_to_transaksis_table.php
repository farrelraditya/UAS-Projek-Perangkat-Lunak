<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transaksis', function (Blueprint $table) 
        {
            // 1. Buat kolom 'bayar' terlebih dahulu
            if (!Schema::hasColumn('transaksis', 'bayar')){
                $table->bigInteger('bayar')->nullable();
            }

            // 2. Baru buat kolom 'kembalian' dan letakkan setelah 'bayar'
            if (!Schema::hasColumn('transaksis', 'kembalian')){
                $table->bigInteger('kembalian')->nullable()->after('bayar');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            // Hapus kedua kolom jika migrasi di-rollback
            $table->dropColumn(['bayar', 'kembalian']);
        });
    }
};