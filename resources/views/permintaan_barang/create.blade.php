@extends('layouts.template')

@section('content')
<br><br>

<div class="mb-4">
    <h3 class="mb-1">Tambah Permintaan Barang</h3>
    <p class="text-muted mb-0">Input data permintaan barang.</p>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('permintaan-barang.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">No Permintaan</label>
                    <input type="text" name="no_permintaan" class="form-control" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Tanggal Permintaan</label>
                    <input type="date" name="tanggal_permintaan" class="form-control" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Divisi</label>
                    <input type="text" name="divisi" class="form-control" required>
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
                    <div class="col-md-4">
                        <label class="form-label">Barang</label>
                        <select name="barang_id[]" class="form-select" required>
                            <option value="">-- Pilih Barang --</option>
                            @foreach($barang as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->nama_barang }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Qty</label>
                        <input type="number" name="qty[]" class="form-control" min="1" required>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Size</label>
                        <input type="text" name="size[]" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Keterangan Detail</label>
                        <input type="text" name="detail_keterangan[]" class="form-control">
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

                <a href="{{ route('permintaan-barang.index') }}" class="btn btn-secondary">
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
            <div class="col-md-4">
                <select name="barang_id[]" class="form-select" required>
                    <option value="">-- Pilih Barang --</option>
                    @foreach($barang as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->nama_barang }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <input type="number" name="qty[]" class="form-control" min="1" required>
            </div>

            <div class="col-md-2">
                <input type="text" name="size[]" class="form-control" placeholder="Size">
            </div>

            <div class="col-md-3">
                <input type="text" name="detail_keterangan[]" class="form-control" placeholder="Keterangan">
            </div>

            <div class="col-md-1">
                <button type="button" class="btn btn-danger" onclick="this.closest('.detail-item').remove()">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
    `;

    wrapper.insertAdjacentHTML('beforeend', html);
}
</script>
@endsection