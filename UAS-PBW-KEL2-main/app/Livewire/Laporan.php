<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\DetilTransaksi;
use App\Models\Transaksi;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;

class Laporan extends Component
{
    public $tanggalMulai;
    public $tanggalSelesai;
    public $pilihanLaporan = 'barang_keluar';
    
    public function mount()
    {
        // Set default tanggal ke bulan ini
        $this->tanggalMulai = date('Y-m-01'); 
        $this->tanggalSelesai = date('Y-m-d');
    }
    
    public function pilihLaporan($jenis)
    {
        $this->pilihanLaporan = $jenis;
    }
    
    public function render()
    {
        $laporanBarangKeluar = [];
        
        if ($this->pilihanLaporan == 'barang_keluar') {
            // Query untuk laporan barang keluar
            $laporanBarangKeluar = DB::table('detil_transaksis')
                ->join('produks', 'detil_transaksis.produk_id', '=', 'produks.id')
                ->join('transaksis', 'detil_transaksis.transaksi_id', '=', 'transaksis.id')
                ->select(
                    'produks.kode',
                    'produks.nama',
                    DB::raw('SUM(detil_transaksis.jumlah) as total_keluar'),
                    DB::raw('SUM(detil_transaksis.jumlah * produks.harga) as total_nilai')
                )
                ->where('transaksis.status', '=', 'completed')
                ->whereBetween('transaksis.created_at', [$this->tanggalMulai . ' 00:00:00', $this->tanggalSelesai . ' 23:59:59'])
                ->groupBy('produks.id', 'produks.kode', 'produks.nama')
                ->orderBy('total_keluar', 'desc')
                ->get();
        }
        
        return view('livewire.laporan', [
            'laporanBarangKeluar' => $laporanBarangKeluar
        ]);
    }
}