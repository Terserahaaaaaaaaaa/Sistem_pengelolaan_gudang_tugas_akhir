@extends('layouts.template')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1">Detail Barang</h3>
        <p class="text-muted mb-0">Informasi lengkap data barang.</p>
    </div>

    <a href="{{ route('barang.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">

        <div class="row">

            {{-- FOTO --}}
            <div class="col-md-4 text-center mb-4">

                @if($barang->foto)
                    <img src="{{ asset('storage/' . $barang->foto) }}"
                         alt="{{ $barang->nama_barang }}"
                         class="img-fluid rounded shadow-sm"
                         style="max-height: 300px; object-fit: cover;">
                @else
                    <div class="border rounded p-5 text-muted">
                        Tidak ada foto
                    </div>
                @endif

            </div>

            {{-- DETAIL --}}
            <div class="col-md-8">

                <table class="table table-bordered align-middle">

                    <tr>
                        <th width="250">Kode Barang</th>
                        <td>{{ $barang->kode_barang }}</td>
                    </tr>

                    <tr>
                        <th>Nama Barang</th>
                        <td>{{ $barang->nama_barang }}</td>
                    </tr>

                    <tr>
                        <th>Harga Barang</th>
                        <td>
                            Rp {{ number_format($barang->harga, 0, ',', '.') }}
                        </td>
                    </tr>

                    <tr>
                        <th>No Akun</th>
                        <td>{{ $barang->no_akun ?? '-' }}</td>
                    </tr>

                    <tr>
                        <th>Nama Akun</th>
                        <td>{{ $barang->nama_akun ?? '-' }}</td>
                    </tr>

                    <tr>
                        <th>Satuan</th>
                        <td>{{ $barang->satuan ?? '-' }}</td>
                    </tr>

                    <tr>
                        <th>Stok</th>
                        <td>{{ $barang->stok }}</td>
                    </tr>

                    <tr>
                        <th>Status Barang</th>
                        <td>
                            @if($barang->status_barang == 'aman')
                                <span class="badge bg-success">
                                    Aman
                                </span>

                            @elseif($barang->status_barang == 'menipis')

                                <span class="badge bg-warning text-dark">
                                    Menipis
                                </span>

                            @else

                                <span class="badge bg-danger">
                                    Habis
                                </span>

                            @endif
                        </td>
                    </tr>

                </table>

                <a href="{{ route('barang.edit', $barang->id) }}"
                   class="btn btn-warning">

                    <i class="bi bi-pencil-square"></i>
                    Edit Barang

                </a>

            </div>

        </div>

    </div>
</div>

@endsection