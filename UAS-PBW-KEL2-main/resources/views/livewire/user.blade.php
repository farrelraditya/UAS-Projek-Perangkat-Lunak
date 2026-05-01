<div>
    
    <div class="container">
        <div class="row my-2">
            <div class="col-12">
                <button 
                    wire:click="PilihMenu('lihat')" 
                    class="btn {{ $pilihanMenu == 'lihat' ? 'btn-primary' : 'btn-outline-primary' }}">
                    Semua Pengguna
                </button>

                <button 
                    wire:click="PilihMenu('Tambah')" 
                    class="btn {{ $pilihanMenu == 'Tambah' ? 'btn-primary' : 'btn-outline-primary' }}">
                    Tambah Pengguna
                </button>

                <button wire:loading class="btn btn-info">
                    Loading .....
                </button>
            </div>
        </div>
        <div class="row">
            @if($pilihanMenu=='lihat')
            <div class="card border-primary">
                <div class="card-header">
                    Semua Pengguna
                </div>
                 <div class="card-body">
                    <table class="table table-bordered">
                        <thead> 
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Peran</th>
                            <th>Data</th>
                        </thead>
                        <tbody>
                            @foreach ($semuaPengguna as $pengguna)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{$pengguna->name}}</td>
                                <td>{{$pengguna->email}}</td>
                                <td>{{$pengguna->peran}}</td>
                                <td>
                                <button wire:click="pilihEdit({{$pengguna->id}})" 
                                        class="btn {{ $pilihanMenu == 'edit' ? 'btn-primary' : 'btn-outline-primary' }}">
                                           Edit Pengguna
                                  </button>
                                  <button wire:click="pilihHapus({{$pengguna->id}})" 
                                        class="btn {{ $pilihanMenu == 'hapus' ? 'btn-primary' : 'btn-outline-primary' }}">
                                           hapus Pengguna
                                  </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @elseif ($pilihanMenu=='Tambah')
            <div class="card border-primary">
                <div class="card-header">
                    Tambah Pengguna
                </div>
                <div class="card-body">
                <form wire:submit.prevent='simpan'>

                        <label>Nama</label>
                        <input type="text" class="form-control" wire:model='nama' />
                        @error('nama')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <br />

                        <label>Email</label>
                        <input type="email" class="form-control" wire:model='email' />
                        @error('email')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <br />
                        <label>Password</label>
                        <input type="password" class="form-control" wire:model='password' />

                        @error('Password')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <br />
                        <label>Peran</label>
                        <select class="form-control" wire:model='peran'> 
                            <option>--Pilih Peran--</option>
                            <option value="kasir">kasir</option>
                            <option value="Admin">Admin</option>
                        </select>
                        @error('password')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror

                        <br />
                        <button type="submit" class="btn btn-primary mt-3">SIMPAN</button>
                    </form>
                </div>
            </div>
            @elseif ($pilihanMenu=='edit')
            <div class="card border-primary">
                <div class="card-header">
                    edit Pengguna
                </div>
                <div class="card-body">
                <form wire:submit.prevent='simpanEdit'>

                    <label>Nama</label>
                    <input type="text" class="form-control" wire:model='nama' />
                    @error('nama')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <br />

                    <label>Email</label>
                    <input type="email" class="form-control" wire:model='email' />
                    @error('email')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <br />
                    <label>Password</label>
                    <input type="password" class="form-control" wire:model='password' />

                    @error('Password')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <br />
                    <label>Peran</label>
                    <select class="form-control" wire:model='peran'> 
                        <option>--Pilih Peran--</option>
                        <option value="kasir">kasir</option>
                        <option value="Admin">Admin</option>
                    </select>
                    @error('password')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <br />
                    <button type="submit" class="btn btn-primary mt-3">SIMPAN</button>
                    <button type="button" wire:click='batal' class="btn btn-secondary mt-3">BATAL</button>
                    </form>
                </div>
            </div>
            @elseif ($pilihanMenu=='hapus')
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">
                    hapus Pengguna
                </div>
                <div class="card-body">
                    Anda yakin akan menghapus user ini?
                    <p>Nama : {{$penggunaTerpilih -> name}} </p>
                    <button class="btn btn-danger" wire:click='hapus'>HAPUS</button>
                    <button class="btn btn-secondary" wire:click='batal'>BATAL</button>
                </div>
            </div>
            @endif
        </div>
    </div>

</div>
