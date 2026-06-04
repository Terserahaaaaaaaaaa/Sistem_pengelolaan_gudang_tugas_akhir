@extends('layouts.template')

@section('content')
<br><br>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1">Detail Permintaan Barang</h3>
        <p class="text-muted mb-0">Informasi lengkap permintaan barang.</p>
    </div>

    <a href="{{ route('permintaan-barang.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th width="250">No Permintaan</th>
                <td>{{ $permintaanBarang->no_permintaan }}</td>
            </tr>

            <tr>
                <th>Tanggal Permintaan</th>
                <td>{{ \Carbon\Carbon::parse($permintaanBarang->tanggal_permintaan)->format('d-m-Y') }}</td>
            </tr>

            <tr>
                <th>Divisi</th>
                <td>{{ $permintaanBarang->divisi }}</td>
            </tr>

            <tr>
                <th>Status</th>
                <td>
                    <span class="badge bg-primary">
                        {{ ucfirst(str_replace('_', ' ', $permintaanBarang->status_permintaan)) }}
                    </span>
                </td>
            </tr>

            <tr>
                <th>Keterangan</th>
                <td>{{ $permintaanBarang->keterangan ?? '-' }}</td>
            </tr>
        </table>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h5 class="mb-3">Detail Barang</h5>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Qty</th>
                        <th>Size</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($permintaanBarang->detail as $detail)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $detail->barang?->kode_barang ?? '-' }}</td>
                        <td>{{ $detail->barang?->nama_barang ?? '-' }}</td>
                        <td>{{ $detail->qty }}</td>
                        <td>{{ $detail->size ?? '-' }}</td>
                        <td>{{ $detail->keterangan ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            Detail barang belum ada.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection