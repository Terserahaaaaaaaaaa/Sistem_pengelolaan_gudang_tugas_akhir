@extends('layouts.template')

@section('content')

<br><br>

<div class="mb-4">

    <h3 class="mb-1">
        Laporan
    </h3>

    <p class="text-muted mb-0">
        Menampilkan data laporan sistem gudang.
    </p>

</div>

<div class="card border-0 shadow-sm mb-4">

    <div class="card-body">

        <form method="GET"
              action="{{ route('laporan.index') }}">

            <div class="row">

                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        Jenis Laporan
                    </label>

                    <select name="jenis"
                            class="form-select"
                            required>

                        <option value="">
                            -- Pilih Laporan --
                        </option>

                        <option value="barang_masuk"
                            {{ $jenis == 'barang_masuk' ? 'selected' : '' }}>
                            Barang Masuk
                        </option>

                        <option value="barang_keluar"
                            {{ $jenis == 'barang_keluar' ? 'selected' : '' }}>
                            Barang Keluar
                        </option>

                        <option value="po"
                            {{ $jenis == 'po' ? 'selected' : '' }}>
                            Pengajuan PO
                        </option>

                        <option value="stok"
                            {{ $jenis == 'stok' ? 'selected' : '' }}>
                            Stok Barang
                        </option>

                    </select>

                </div>

                <div class="col-md-3 mb-3">

                    <label class="form-label">
                        Tanggal Awal
                    </label>

                    <input type="date"
                           name="tanggal_awal"
                           value="{{ $tanggalAwal }}"
                           class="form-control">

                </div>

                <div class="col-md-3 mb-3">

                    <label class="form-label">
                        Tanggal Akhir
                    </label>

                    <input type="date"
                           name="tanggal_akhir"
                           value="{{ $tanggalAkhir }}"
                           class="form-control">

                </div>

                <div class="col-md-2 mb-3 d-flex align-items-end">

                    <button class="btn btn-primary w-100">

                        <i class="bi bi-search"></i>
                        Tampilkan

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@if($jenis)

<div class="card border-0 shadow-sm">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead>

                    @if($jenis == 'barang_masuk')

                    <tr>
                        <th>No</th>
                        <th>No Barang Masuk</th>
                        <th>Tanggal</th>
                        <th>Supplier</th>
                    </tr>

                    @elseif($jenis == 'barang_keluar')

                    <tr>
                        <th>No</th>
                        <th>No Barang Keluar</th>
                        <th>Tanggal</th>
                        <th>Divisi</th>
                    </tr>

                    @elseif($jenis == 'po')

                    <tr>
                        <th>No</th>
                        <th>No PO</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>

                    @elseif($jenis == 'stok')

                    <tr>
                        <th>No</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Stok</th>
                    </tr>

                    @endif

                </thead>

                <tbody>

                    @forelse($data as $item)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        @if($jenis == 'barang_masuk')

                            <td>{{ $item->no_barang_masuk }}</td>
                            <td>{{ $item->tanggal_masuk }}</td>
                            <td>{{ $item->supplier }}</td>

                        @elseif($jenis == 'barang_keluar')

                            <td>{{ $item->no_barang_keluar }}</td>
                            <td>{{ $item->tanggal_keluar }}</td>
                            <td>{{ $item->divisi_tujuan }}</td>

                        @elseif($jenis == 'po')

                            <td>{{ $item->no_po }}</td>
                            <td>{{ $item->tanggal_po }}</td>
                            <td>{{ $item->status_po }}</td>

                        @elseif($jenis == 'stok')

                            <td>{{ $item->kode_barang }}</td>
                            <td>{{ $item->nama_barang }}</td>
                            <td>{{ $item->stok }}</td>

                        @endif

                    </tr>

                    @empty

                    <tr>

                        <td colspan="4"
                            class="text-center text-muted">

                            Data tidak ditemukan.

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endif

@endsection