<div class="container">
    <div class="row my-2">
        <div class="col-12">
            <button 
                wire:click="pilihLaporan('barang_keluar')" 
                class="btn {{ $pilihanLaporan == 'barang_keluar' ? 'btn-primary' : 'btn-outline-primary' }}">
                Laporan Barang Keluar
            </button>
            
            <button wire:loading class="btn btn-info">
                Loading .....
            </button>
        </div>
    </div>
    
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Filter Tanggal</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Mulai</label>
                                <input type="date" class="form-control" wire:model.live="tanggalMulai">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Selesai</label>
                                <input type="date" class="form-control" wire:model.live="tanggalSelesai">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @if($pilihanLaporan == 'barang_keluar')
    <div class="row">
        <div class="col-12">
            <div class="card border-primary">
                <div class="card-header">
                    <h5 class="card-title">Laporan Barang Keluar</h5>
                    <h6 class="card-subtitle text-muted">Periode: {{ date('d-m-Y', strtotime($tanggalMulai)) }} s/d {{ date('d-m-Y', strtotime($tanggalSelesai)) }}</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah Keluar</th>
                                    <th>Total Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($laporanBarangKeluar as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->kode }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->total_keluar }}</td>
                                    <td>Rp. {{ number_format($item->total_nilai, 2, '.', ',') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data barang keluar pada periode ini</td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr class="font-weight-bold">
                                    <td colspan="3" class="text-right">Total:</td>
                                    <td>{{ $laporanBarangKeluar->sum('total_keluar') }}</td>
                                    <td>Rp. {{ number_format($laporanBarangKeluar->sum('total_nilai'), 2, '.', ',') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    
                    <div class="mt-3">
                        <button class="btn btn-success" onclick="window.print()">
                            Cetak Laporan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>