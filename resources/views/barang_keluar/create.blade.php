@extends('layouts.template')

@section('content')

<br><br>

<div class="mb-4">
    <h3 class="mb-1">Tambah Barang Keluar</h3>
    <p class="text-muted mb-0">Input data barang keluar gudang.</p>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('barang-keluar.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">No Barang Keluar</label>
                    <input type="text" name="no_barang_keluar" class="form-control" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Tanggal Keluar</label>
                    <input type="date" name="tanggal_keluar" class="form-control" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Divisi Tujuan</label>
                    <input type="text" name="divisi_tujuan" class="form-control" placeholder="Contoh: Produksi" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="3"></textarea>
            </div>

            <hr>

            <h5 class="mb-3">Detail Barang</h5>

            <div id="detail-wrapper">
                <div class="row detail-item mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Barang</label>
                        <select name="barang_id[]" class="form-select" required>
                            <option value="">-- Pilih Barang --</option>
                            @foreach($barang as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->nama_barang }} - Stok: {{ $item->stok }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Qty Keluar</label>
                        <input type="number" name="qty[]" class="form-control" min="1" required>
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-secondary mb-4" onclick="tambahDetail()">
                <i class="bi bi-plus-circle"></i> Tambah Barang
            </button>

            <div>
                <button class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan
                </button>

                <a href="{{ route('barang-keluar.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function tambahDetail() {
    let wrapper = document.getElementById('detail-wrapper');

    let html = `
        <div class="row detail-item mb-3">
            <div class="col-md-6">
                <select name="barang_id[]" class="form-select" required>
                    <option value="">-- Pilih Barang --</option>
                    @foreach($barang as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->nama_barang }} - Stok: {{ $item->stok }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <input type="number" name="qty[]" class="form-control" min="1" required>
            </div>

            <div class="col-md-2">
                <button type="button"
                        class="btn btn-danger"
                        onclick="this.parentElement.parentElement.remove()">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
    `;

    wrapper.insertAdjacentHTML('beforeend', html);
}
</script>

@endsection