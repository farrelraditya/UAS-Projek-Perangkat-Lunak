<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaksi as ModelsTransaksi;
use App\Models\DetilTransaksi;
use App\Models\Produk;

class Transaksi extends Component
{
    public $kode,$total, $bayar, $kembalian,$totalSemuaBelanja;
    public $transaksiAktif;
    public $transaksiTerpilih;
    public $pilihanMenu = 'lihat';

    public function transaksiBaru(){
        $this->reset();
        $this->transaksiAktif = new ModelsTransaksi();
        $this->transaksiAktif->kode='INV/'. date('YmdHis');
        $this->transaksiAktif->total = 0;
        $this->transaksiAktif->status = 'pending';
        $this->transaksiAktif->save();
    }
    
    public function batalTransaksi(){
        if ($this->transaksiAktif){
            $detilTransaksi = DetilTransaksi::where('transaksi_id',$this->transaksiAktif->id)->get();
            foreach ($detilTransaksi as $detil){
                $detil->delete();
            }
            $this->transaksiAktif->delete();
        }
        $this->reset();
    }

    // Fungsi baru untuk menghapus transaksi yang sudah selesai
    public function pilihHapusTransaksi($id){
        $this->transaksiTerpilih = ModelsTransaksi::findOrFail($id);
        $this->pilihanMenu = 'hapus';
    }
    
    public function hapusTransaksi(){
        if ($this->transaksiTerpilih) {
            // Hapus detail transaksi terlebih dahulu
            $detilTransaksi = DetilTransaksi::where('transaksi_id', $this->transaksiTerpilih->id)->get();
            
            // Jika transaksi sudah completed, kembalikan stok produk
            if ($this->transaksiTerpilih->status == 'completed') {
                foreach ($detilTransaksi as $detil) {
                    $produk = $detil->produk;
                    $produk->stok += $detil->jumlah; // Kembalikan stok
                    $produk->save();
                }
            }
            
            // Hapus semua detail transaksi
            foreach ($detilTransaksi as $detil) {
                $detil->delete();
            }
            
            // Hapus transaksi
            $this->transaksiTerpilih->delete();
            
            session()->flash('success', 'Transaksi berhasil dihapus');
        }
        
        $this->reset('transaksiTerpilih');
        $this->pilihanMenu = 'lihat';
    }
    
    public function batal(){
        $this->reset('transaksiTerpilih');
        $this->pilihanMenu = 'lihat';
    }

    public function updatedKode(){
        // Check if transaction is active before proceeding
        if (!$this->transaksiAktif) {
            // Maybe show an error message to the user
            session()->flash('error', 'Silahkan buat transaksi baru terlebih dahulu');
            return;
        }
        
        $produk = Produk::where('kode',$this->kode)->first();
        if($produk && $produk->stok > 0){
            $detil=DetilTransaksi::firstOrNew([
                'transaksi_id'=>$this->transaksiAktif->id,
                'produk_id'=>$produk->id
            ],[
                'jumlah' => 0,
            ]);
            $detil->jumlah +=1;
            $detil->save();
            $this->reset('kode');

        }
    }
    
    public function updatedBayar()
    {
        if ($this->bayar >= $this->totalSemuaBelanja) {
            $this->kembalian = $this->bayar - $this->totalSemuaBelanja;
        } else {
            $this->kembalian = 0;
        }
    }
    
    public function bayarTransaksi()
    {
        if (!$this->transaksiAktif) {
            session()->flash('error', 'Tidak ada transaksi aktif');
            return;
        }
        
        if (!$this->bayar || $this->bayar < $this->totalSemuaBelanja) {
            session()->flash('error', 'Pembayaran kurang dari total belanja');
            return;
        }
        
        // Update transaction status
        $this->transaksiAktif->total = $this->totalSemuaBelanja;
        $this->transaksiAktif->bayar = $this->bayar;
        $this->transaksiAktif->kembalian = $this->kembalian;
        $this->transaksiAktif->status = 'completed';
        $this->transaksiAktif->save();
        
        // Update product stock
        $detilTransaksi = DetilTransaksi::where('transaksi_id', $this->transaksiAktif->id)->get();
        foreach ($detilTransaksi as $detil) {
            $produk = $detil->produk;
            $produk->stok -= $detil->jumlah;
            $produk->save();
        }
        
        session()->flash('success', 'Transaksi berhasil');
        $this->reset();
    }
    
    public function render()
    {
        if($this->transaksiAktif){
            $semuaProduk = DetilTransaksi::where('transaksi_id',$this->transaksiAktif->id)->get();
            $this->totalSemuaBelanja = $semuaProduk->sum(function ($detil){
                return $detil->produk->harga * $detil->jumlah;
            });
        }
        else{
            $semuaProduk = [];
        }
        
        // Ambil semua transaksi untuk ditampilkan di daftar
        $semuaTransaksi = ModelsTransaksi::where('status', 'completed')
                                        ->orderBy('created_at', 'desc')
                                        ->get();
        
        return view('livewire.transaksi')->with([
            'semuaProduk' => $semuaProduk,
            'semuaTransaksi' => $semuaTransaksi
        ]);
    }
}