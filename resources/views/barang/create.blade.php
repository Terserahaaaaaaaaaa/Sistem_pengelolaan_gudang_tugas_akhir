@extends('layouts.template')

@section('content')
<div class="mb-4">
    <h3 class="mb-1">Tambah Barang</h3>
    <p class="text-muted mb-0">Input data barang perlengkapan produksi.</p>
</div>

            <div class="card border-0 shadow-sm">
    <div class="card-body">

        <form action="{{ route('barang.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="mb-3">
                <label class="form-label">
                    Foto Barang
                    <small class="text-muted">(opsional)</small>
                </label>

                <input type="file"
                       name="foto"
                       class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Kode Barang</label>
                <input type="text" name="kode_barang" class="form-control @error('kode_barang') is-invalid @enderror"
                       value="{{ old('kode_barang') }}" placeholder="Contoh: BRG001">
                @error('kode_barang')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Barang</label>
                <input type="text" name="nama_barang" class="form-control @error('nama_barang') is-invalid @enderror"
                       value="{{ old('nama_barang') }}" placeholder="Masukkan nama barang">
                @error('nama_barang')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">No Akun</label>
                    <input type="text" name="no_akun" class="form-control"
                           value="{{ old('no_akun') }}" placeholder="Masukkan no akun">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Akun</label>
                    <input type="text" name="nama_akun" class="form-control"
                           value="{{ old('nama_akun') }}" placeholder="Masukkan nama akun">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Satuan</label>
                    <input type="text" name="satuan" class="form-control"
                           value="{{ old('satuan') }}" placeholder="Contoh: pcs, pack, kg">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Stok</label>
                    <input type="number"
                        name="stok"
                        class="form-control @error('stok') is-invalid @enderror"
                        value="{{ old('stok') }}"
                        min="0"
                        placeholder="Masukkan stok awal"
                        required>

                    @error('stok')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            <div class="d-flex gap-2">
                <button class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan
                </button>

                <a href="{{ route('barang.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection