<div>
    
    <div class="container">
        <div class="row my-2">
            <div class="col-12">
                <button 
                    wire:click="PilihMenu('lihat')" 
                    class="btn {{ $pilihanMenu == 'lihat' ? 'btn-primary' : 'btn-outline-primary' }}">
                    Semua Produk
                </button>

                <button 
                    wire:click="PilihMenu('Tambah')" 
                    class="btn {{ $pilihanMenu == 'Tambah' ? 'btn-primary' : 'btn-outline-primary' }}">
                    Tambah Produk
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
                    Semua Produk
                </div>
                 <div class="card-body">
                    <table class="table table-bordered">
                        <thead> 
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Data</th>
                        </thead>
                        <tbody>
                            @foreach ($semuaProduk as $produk)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{$produk->kode}}</td>
                                <td>{{$produk->nama}}</td>
                                <td>{{$produk->harga}}</td>
                                <td>{{$produk->stok}}</td>
                                <td>
                                <button wire:click="pilihEdit({{$produk->id}})" 
                                        class="btn {{ $pilihanMenu == 'edit' ? 'btn-primary' : 'btn-outline-primary' }}">
                                           Edit Produk
                                  </button>
                                  <button wire:click="pilihHapus({{$produk->id}})" 
                                        class="btn {{ $pilihanMenu == 'hapus' ? 'btn-primary' : 'btn-outline-primary' }}">
                                           hapus Produk
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
                    Tambah Produk
                </div>
                <div class="card-body">
                    <form wire:submit.prevent='simpan'>

                        <label>Nama</label>
                        <input type="text" class="form-control" wire:model='nama' />
                        @error('nama')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <br />

                        <label>kode / Barcode</label>
                        <input type="text" class="form-control" wire:model='kode' />
                        @error('kode')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <br />
                        <label>Harga</label>
                        <input type="number" class="form-control" wire:model='harga' />

                        @error('harga')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror

                        <br />
                        <label>Stok</label>
                        <input type="number" class="form-control" wire:model='stok' />
                        @error('stok')
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
                    edit Produk
                </div>
                <div class="card-body">
                <form wire:submit.prevent='simpanEdit'>

                    <label>Nama</label>
                    <input type="text" class="form-control" wire:model='nama' />
                    @error('nama')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <br />

                    <label>kode / Barcode</label>
                    <input type="text" class="form-control" wire:model='kode' />
                    @error('kode')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <br />
                    <label>Harga</label>
                    <input type="number" class="form-control" wire:model='harga' />

                    @error('harga')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <br />
                    <label>Stok</label>
                    <input type="number" class="form-control" wire:model='stok' />
                    @error('stok')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <br />
                    <button type="submit" class="btn btn-primary mt-3">SIMPAN</button>
                    </form>
                    </div>
                </div>
            </div>
            @elseif ($pilihanMenu=='hapus')
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">
                    hapus Produk
                </div>
                <div class="card-body">
                    Anda yakin akan menghapus produk ini? 
                    <p>Nama : {{$produkTerpilih->nama}} </p>
                    <p>kode : {{$produkTerpilih->kode}} </p>
                    <button class="btn btn-danger" wire:click='hapus'>HAPUS</button>
                    <button class="btn btn-secondary" wire:click='batal'>BATAL</button>
                </div>
            </div>
            @endif
        </div>
    </div>

</div>