<?php

namespace App\Livewire;
use App\Models\Produk as ModelProduk;

use Livewire\Component;

class Produk extends Component
{
    public $pilihanMenu = 'lihat';
    public $nama;
    public $kode;
    public $harga;
    public $stok;
    public $produkTerpilih;

    public function pilihEdit($id){
        $this->produkTerpilih = ModelProduk::findOrFail($id);
        $this->nama=$this->produkTerpilih->nama;
        $this->kode=$this->produkTerpilih->kode;
        $this->harga=$this->produkTerpilih->harga;
        $this->stok=$this->produkTerpilih->stok;
        $this->pilihanMenu = 'edit';
    }

    public function simpanEdit(){
        $this->validate([
            'nama' => 'required',
            'kode' => ['required','unique:produks,kode, '.$this->produkTerpilih->id],
            'harga' => 'required',
            'stok' => 'required'

        ],[
            'nama.required' => 'Nama Harus Diisi',
            'kode.required' => 'kode Harus Diisi',
            'kode.unique' => 'kode Telah Digunakan',
            'harga.required' => 'harga harus Diisi',
            'stok.required' => 'stok Harus Diisi'
        ]);
        $simpan = $this->produkTerpilih;
        $simpan->nama = $this->nama;
        $simpan->kode = $this->kode;
        $simpan->stok =$this->stok;
        $simpan->harga = $this->harga;
        $simpan->save();

        $this->reset();
        $this->pilihanMenu='lihat';
    }

    public function pilihHapus($id){
        $this->produkTerpilih = ModelProduk::findOrFail($id);
        $this->pilihanMenu = 'hapus';
    }    

    public function hapus(){
        $this->produkTerpilih->delete();
        $this->reset();
    }

    public function batal(){
        $this->reset();
    }

    public function simpan(){
        $this->validate([
            'nama' => 'required',
            'kode' => ['required','unique:produks,kode'],
            'harga' => 'required',
            'stok' => 'required'

        ],[
            'nama.required' => 'Nama Harus Diisi',
            'kode.required' => 'kode Harus Diisi',
            'kode.unique' => 'kode Telah Digunakan',
            'harga.required' => 'harga harus Diisi',
            'stok.required' => 'stok Harus Diisi'
        ]);
        $simpan = new ModelProduk();
        $simpan->nama = $this->nama;
        $simpan->kode = $this->kode;
        $simpan->stok =$this->stok;
        $simpan->harga = $this->harga;
        $simpan->save();

        $this->reset(['nama', 'kode', 'stok','harga']);
        $this->pilihanMenu='lihat';
    }


    public function PilihMenu($menu)
    {
        $this->pilihanMenu = $menu;
    }
    public function render()
    {
        return view('livewire.produk')->with([
            'semuaProduk'=> ModelProduk::all()
        ]);
    }
}
