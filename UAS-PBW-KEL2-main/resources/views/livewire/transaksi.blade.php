<div class="container">
    <div class="row mt-2">
        <div class="col-12">
            <button 
                wire:click="PilihMenu('lihat')" 
                class="btn {{ $pilihanMenu == 'lihat' ? 'btn-primary' : 'btn-outline-primary' }}">
                Daftar Transaksi
            </button>
            
            @if(!$transaksiAktif)
                <button class="btn btn-success" wire:click='transaksiBaru'>Transaksi Baru</button>
            @else
                <button class="btn btn-danger" wire:click='batalTransaksi'>Batalkan Transaksi</button>
            @endif
            <button class="btn btn-info" wire:loading>Loading....</button>
        </div>
    </div>
    
    @if(session()->has('success'))
        <div class="alert alert-success mt-2">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session()->has('error'))
        <div class="alert alert-danger mt-2">
            {{ session('error') }}
        </div>
    @endif
    
    @if($pilihanMenu == 'lihat' && !$transaksiAktif)
    <div class="row mt-3">
        <div class="col-12">
            <div class="card border-primary">
                <div class="card-header">
                    Daftar Transaksi
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Kode Invoice</th>
                                    <th>Tanggal</th>
                                    <th>Total</th>
                                    <th>Bayar</th>
                                    <th>Kembalian</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($semuaTransaksi as $transaksi)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $transaksi->kode }}</td>
                                    <td>{{ $transaksi->created_at->format('d-m-Y H:i') }}</td>
                                    <td>{{ number_format($transaksi->total, 2, '.', ',') }}</td>
                                    <td>{{ number_format($transaksi->bayar, 2, '.', ',') }}</td>
                                    <td>{{ number_format($transaksi->kembalian, 2, '.', ',') }}</td>
                                    <td>
                                        <button class="btn btn-danger btn-sm" wire:click="pilihHapusTransaksi({{ $transaksi->id }})">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    
    @if($pilihanMenu == 'hapus')
    <div class="row mt-3">
        <div class="col-12">
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">
                    Hapus Transaksi
                </div>
                <div class="card-body">
                    <p>Anda yakin akan menghapus transaksi ini?</p>
                    <p>Kode Invoice: {{ $transaksiTerpilih->kode }}</p>
                    <p>Total: Rp. {{ number_format($transaksiTerpilih->total, 2, '.', ',') }}</p>
                    <p>Tanggal: {{ $transaksiTerpilih->created_at->format('d-m-Y H:i') }}</p>
                    
                    <div class="alert alert-warning">
                        <strong>Perhatian!</strong> Menghapus transaksi akan mengembalikan stok produk.
                    </div>
                    
                    <button class="btn btn-danger" wire:click="hapusTransaksi">HAPUS</button>
                    <button class="btn btn-secondary" wire:click="batal">BATAL</button>
                </div>
            </div>
        </div>
    </div>
    @endif
    
    @if($transaksiAktif)
    <!-- The rest of your transaction form -->
    <div class="row">
        <div class="col-md-8">
            <div class="card border-primary">
                <div class="card-body">
                    <h5 class="card-title mb-3">No Invoice : {{ $transaksiAktif->kode }}</h5>
                    <input type="text" class="form-control" placeholder="Kode Produk" wire:model.live='kode'>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead> 
                            <tbody>
                                @foreach ($semuaProduk as $produk)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $produk->produk->kode }}</td>
                                        <td>{{ $produk->produk->nama }}</td>
                                        <td>{{ number_format($produk->produk->harga, 2, '.', ',')}} </td>
                                        <td> {{$produk->jumlah}}</td>
                                        <td>{{number_format($produk->produk->harga * $produk->jumlah, 2,'.',',')}}</td>
                                        <td>
                                    
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kanan: 3 card kecil -->
        <div class="col-md-4">
            <div class="card border-primary mb-2">
                <div class="card-body">
                    <h5 class="card-title">Total Biaya</h5>
                    <div class= "d-flex justify-content-between">
                    <span>Rp.</span>
                    <span>{{number_format($totalSemuaBelanja, 2,'.',',')}}</span>
                    </div>
                </div>
            </div>

            <div class="card border-primary mb-2">
                <div class="card-body">
                    <h5 class="card-title">Bayar</h5>
                    <input type="number" class="form-control" placeholder="Bayar" wire:model.live="bayar">
                </div>
            </div>

            <div class="card border-primary">
                <div class="card-body">
                    <h5 class="card-title">Kembalian</h5>
                    <div class= "d-flex justify-content-between">
                    <span>Rp.</span>
                    <span>{{number_format($kembalian ?? 0, 2,'.',',')}}</span>
                    </div>
                </div>
            </div>

            <button class="btn btn-success mt-2 w-100" wire:click="bayarTransaksi">Bayar</button>
        </div>
    </div>
    @endif
</div>