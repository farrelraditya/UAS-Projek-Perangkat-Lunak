<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User as ModelUser;

class User extends Component
{
    public $pilihanMenu = 'lihat';
    public $nama;
    public $email;
    public $peran;
    public $password;
    public $penggunaTerpilih;

    public function pilihEdit($id){
        $this->penggunaTerpilih = ModelUser::findOrFail($id);
        $this->nama=$this->penggunaTerpilih->name;
        $this->email=$this->penggunaTerpilih->email;
        $this->peran=$this->penggunaTerpilih->peran;
        $this->pilihanMenu = 'edit';
    }

    public function simpanEdit(){
        $this->validate([
            'nama' => 'required',
            'email' => ['required', 'email','unique:users,email,'.$this->penggunaTerpilih->id],
            'peran' => 'required',

        ],[
            'nama.required' => 'Nama Harus Diisi',
            'email.required' => 'Email Harus Diisi',
            'email.email' => 'Format Harus Menggunakan Format Email',
            'email.unique' => 'Email Telah Digunakan',
            'peran.required' => 'Peran harus Dipilih',
        ]);
        $simpan = $this->penggunaTerpilih;
        $simpan->name = $this->nama;
        $simpan->email = $this->email;
        if($this->password){
            $simpan->password = bcrypt($this->password);
        }
        $simpan->peran = $this->peran;
        $simpan->save();

        $this->reset(['nama', 'email', 'password','peran','penggunaTerpilih']);
        $this->pilihanMenu='lihat';
    }

    public function pilihHapus($id){
        $this->penggunaTerpilih = ModelUser::findOrFail($id);
        $this->pilihanMenu = 'hapus';
    }    

    public function hapus(){
        $this->penggunaTerpilih->delete();
        $this->reset();
    }

    public function batal(){
        $this->reset();
    }

    public function simpan(){
        $this->validate([
            'nama' => 'required',
            'email' => ['required', 'email','unique:users,email'],
            'peran' => 'required',
            'password' => 'required'

        ],[
            'nama.required' => 'Nama Harus Diisi',
            'email.required' => 'Email Harus Diisi',
            'email.email' => 'Format Harus Menggunakan Format Email',
            'email.unique' => 'Email Telah Digunakan',
            'peran.required' => 'Peran harus Dipilih',
            'password.required' => 'Password Harus Diisi'
        ]);
        $simpan = new ModelUSer();
        $simpan->name = $this->nama;
        $simpan->email = $this->email;
        $simpan->password = bcrypt($this->password);
        $simpan->peran = $this->peran;
        $simpan->save();

        $this->reset(['nama', 'email', 'password','peran']);
        $this->pilihanMenu='lihat';
    }


    public function PilihMenu($menu)
    {
        $this->pilihanMenu = $menu;
    }

    public function render()
    {
        return view('livewire.user')->with(['semuaPengguna' => ModelUser::all()]);
    }
}
