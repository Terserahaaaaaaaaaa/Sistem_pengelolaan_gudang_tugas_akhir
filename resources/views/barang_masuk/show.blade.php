@extends('layouts.template')

@section('content')

<br><br>

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="mb-1">Detail Barang Masuk</h3>

        <p class="text-muted mb-0">
            Informasi lengkap transaksi barang masuk.
        </p>
    </div>

    <a href="{{ route('barang-masuk.index') }}"
       class="btn btn-secondary">

        <i class="bi bi-arrow-left"></i>
        Kembali

    </a>

</div>

<div class="card border-0 shadow-sm mb-4">

    <div class="card-body">

        <table class="table table-bordered">

            <tr>
                <th width="250">
                    No Barang Masuk
                </th>

                <td>
                    {{ $barangMasuk->no_barang_masuk }}
                </td>
            </tr>

            <tr>
                <th>
                    Tanggal Masuk
                </th>

                <td>
                    {{ \Carbon\Carbon::parse($barangMasuk->tanggal_masuk)->format('d-m-Y') }}
                </td>
            </tr>

            <tr>
                <th>
                    No PO
                </th>

                <td>
                    {{ $barangMasuk->pengajuanPo->no_po ?? '-' }}
                </td>
            </tr>

            <tr>
                <th>
                    Dicatat Oleh
                </th>

                <td>
                    {{ $barangMasuk->user->name ?? '-' }}
                </td>
            </tr>

            <tr>
                <th>
                    Keterangan
                </th>

                <td>
                    {{ $barangMasuk->keterangan ?? '-' }}
                </td>
            </tr>

        </table>

    </div>

</div>

<div class="card border-0 shadow-sm">

    <div class="card-body">

        <h5 class="mb-3">
            Detail Barang
        </h5>

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead>

                    <tr>
                        <th>No</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Qty</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($barangMasuk->detail as $detail)

                    <tr>

                        <td>
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            {{ $detail->barang->kode_barang ?? '-' }}
                        </td>

                        <td>
                            {{ $detail->barang->nama_barang ?? '-' }}
                        </td>

                        <td>
                            {{ $detail->qty }}
                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="4"
                            class="text-center text-muted">

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