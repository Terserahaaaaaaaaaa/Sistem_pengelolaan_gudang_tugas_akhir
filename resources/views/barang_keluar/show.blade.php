@extends('layouts.template')

@section('content')

<br><br>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1">Detail Barang Keluar</h3>
        <p class="text-muted mb-0">
            Informasi lengkap transaksi barang keluar.
        </p>
    </div>

    <a href="{{ route('barang-keluar.index') }}"
       class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">

        <table class="table table-bordered">

            <tr>
                <th width="250">No Barang Keluar</th>
                <td>{{ $barangKeluar->no_barang_keluar }}</td>
            </tr>

            <tr>
                <th>Tanggal Keluar</th>
                <td>
                    {{ \Carbon\Carbon::parse($barangKeluar->tanggal_keluar)->format('d-m-Y') }}
                </td>
            </tr>

            <tr>
                <th>Divisi Tujuan</th>
                <td>{{ $barangKeluar->divisi_tujuan }}</td>
            </tr>

            <tr>
                <th>Keterangan</th>
                <td>{{ $barangKeluar->keterangan ?? '-' }}</td>
            </tr>

            <tr>
                <th>Dicatat Oleh</th>
                <td>{{ $barangKeluar->user->name ?? '-' }}</td>
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
                        <th>Qty Keluar</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($barangKeluar->detail as $detail)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                            {{ $detail->barang?->kode_barang ?? '-' }}
                        </td>

                        <td>
                            {{ $detail->barang?->nama_barang ?? '-' }}
                        </td>

                        <td>{{ $detail->qty }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">
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