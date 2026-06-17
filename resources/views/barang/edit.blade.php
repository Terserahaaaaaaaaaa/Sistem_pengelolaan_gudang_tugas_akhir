@extends('layouts.template')

@section('content')
<div class="mb-4">
    <h3 class="mb-1">Edit Barang</h3>
    <p class="text-muted mb-0">Ubah data barang perlengkapan produksi.</p>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Foto Barang</label>

                <input type="file"
                    name="foto"
                    class="form-control">

                @if($barang->foto)
                    <img src="{{ asset('storage/' . $barang->foto) }}"
                        width="120"
                        class="mt-3 rounded">
                @endif
            </div>

            <div class="mb-3">
                <label class="form-label">Kode Barang</label>

                <input type="text"
                    name="kode_barang"
                    class="form-control"
                    value="{{ $barang->kode_barang }}"
                    readonly>

            </div>

            <div class="mb-3">
                <label class="form-label">Nama Barang</label>
                <input type="text" name="nama_barang" class="form-control @error('nama_barang') is-invalid @enderror"
                       value="{{ old('nama_barang', $barang->nama_barang) }}">
                @error('nama_barang')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Harga Barang</label>
                <input type="number"
                    name="harga"
                    class="form-control"
                    value="{{ old('harga', $barang->harga) }}"
                    min="0"
                    required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">No Akun</label>
                    <input type="text" name="no_akun" class="form-control"
                           value="{{ old('no_akun', $barang->no_akun) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Akun</label>
                    <input type="text" name="nama_akun" class="form-control"
                           value="{{ old('nama_akun', $barang->nama_akun) }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Satuan</label>
                    <input type="text" name="satuan" class="form-control"
                           value="{{ old('satuan', $barang->satuan) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror"
                           value="{{ old('stok', $barang->stok) }}" min="0">
                    @error('stok')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex gap-2">
                <button class="btn btn-success">
                    <i class="bi bi-check-circle"></i> Update
                </button>

                <a href="{{ route('barang.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection