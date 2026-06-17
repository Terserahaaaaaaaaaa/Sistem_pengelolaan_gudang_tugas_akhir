@extends('layouts.template')

@section('content')

<div class="mb-4">
    <h2 class="fw-bold mb-1">Buat Pengajuan PO</h2>
    <p class="text-muted mb-0">
        Form pengajuan pembelian barang.
    </p>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">

        <form action="{{ route('pengajuan-po.store') }}"
              method="POST">

            @csrf

            <input type="hidden"
                name="permintaan_barang_id"
                value="{{ request('permintaan_id') }}">
       
            <div class="row">

                <div class="col-md-4 mb-3">
                    <label class="form-label">No PO</label>

                    <input type="text"
                           name="no_po"
                           class="form-control"
                           required>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Tanggal PO</label>

                    <input type="date"
                           name="tanggal_po"
                           class="form-control"
                           required>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Sumber PO</label>

                    <select name="sumber_po"
                            class="form-select"
                            required>

                        <option value="">-- Pilih Sumber --</option>

                        <option value="permintaan_barang">
                            Permintaan Barang
                        </option>

                        <option value="stok_minimum">
                            Stok Minimum
                        </option>

                    </select>
                </div>

            </div>

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Kontak Pembelian
                    </label>

                    <input type="text"
                           name="kontak_pembelian"
                           class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Metode Pembelian
                    </label>

                    <select name="metode_pembelian"
                            class="form-select">

                        <option value="">
                            -- Pilih Metode --
                        </option>

                        <option value="whatsapp">
                            WhatsApp
                        </option>

                        <option value="online">
                            Online
                        </option>

                        <option value="beli_langsung">
                            Beli Langsung
                        </option>

                    </select>
                </div>

            </div>

            <hr>

            <h5 class="mb-3">Detail Barang</h5>

            <div id="detail-wrapper">

                @if($permintaan)

                    @foreach($permintaan->detail as $detail)

                    <div class="row detail-item mb-3">

                        <div class="col-md-4">

                            <label class="form-label">
                                Barang
                            </label>

                            <select name="barang_id[]"
                                    class="form-select"
                                    required>

                                @foreach($barang as $item)

                                    <option value="{{ $item->id }}"
                                            data-harga="{{ $item->harga }}"
                                            {{ $item->id == $detail->barang_id ? 'selected' : '' }}>

                                        {{ $item->nama_barang }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                        <div class="col-md-2">

                            <label class="form-label">
                                Harga
                            </label>

                            <input type="text"
                                class="form-control harga"
                                data-harga="{{ $detail->barang->harga }}"
                                value="Rp {{ number_format($detail->barang->harga,0,',','.') }}"
                                readonly>

                        </div>

                        <div class="col-md-2">

                            <label class="form-label">
                                Qty Pengajuan
                            </label>

                            <input type="number"
                                name="qty_pengajuan[]"
                                class="form-control"
                                value="{{ $detail->qty }}"
                                min="1"
                                required>

                        </div>

                        <div class="col-md-2">

                            <label class="form-label">
                                Subtotal
                            </label>

                            <input type="text"
                                class="form-control subtotal"
                                readonly>

                        </div>

                        <div class="col-md-2">
                            <button type="button"
                                    class="btn btn-danger mt-4"
                                    onclick="this.closest('.detail-item').remove(); hitungTotalPO();">

                                <i class="bi bi-trash"></i>

                            </button>
                        </div>

                    </div>

                    @endforeach

                @else

                    <div class="row detail-item mb-3">

                        <div class="col-md-5">

                            <label class="form-label">
                                Barang
                            </label>

                            <select name="barang_id[]"
                                    class="form-select"
                                    required>

                                <option value="">
                                    -- Pilih Barang --
                                </option>

                                @foreach($barang as $item)

                                    <option value="{{ $item->id }}"
                                            data-harga="{{ $item->harga }}">
                                        {{ $item->nama_barang }}
                                    </option>

                                @endforeach

                            </select>

                        </div>

                        <div class="col-md-2">

                            <label class="form-label">
                                Harga
                            </label>

                            <input type="text"
                                class="form-control harga"
                                readonly>

                        </div>

                        <div class="col-md-3">

                            <label class="form-label">
                                Qty Pengajuan
                            </label>

                            <input type="number"
                                name="qty_pengajuan[]"
                                class="form-control"
                                min="1"
                                required>

                        </div>

                        <div class="col-md-2">

                            <label class="form-label">
                                Subtotal
                            </label>

                            <input type="text"
                                class="form-control subtotal"
                                readonly>

                        </div>

                    </div>

                @endif

            </div>

            <button type="button"
                    class="btn btn-secondary mb-4"
                    onclick="tambahDetail()">

                <i class="bi bi-plus-circle"></i>
                Tambah Barang

            </button>

            <div>

                <div class="text-end mb-3">

                    <h5>
                        Total PO :
                        <span id="total-po">
                            Rp 0
                        </span>
                    </h5>

                </div>

                <button class="btn btn-primary">
                    <i class="bi bi-save"></i>
                    Simpan PO
                </button>

                <a href="{{ route('pengajuan-po.index') }}"
                   class="btn btn-secondary">

                    Kembali

                </a>

            </div>

        </form>

    </div>
</div>

<script>
//buat munculin harga di form tambah po di detail barangnya
function hitungTotalPO()
{
    let total = 0;

    document.querySelectorAll('.detail-item').forEach(function(row){

        let hargaText = row.querySelector('.harga').dataset.harga || 0;

        let harga = parseInt(hargaText);

        let qtyInput = row.querySelector('input[name="qty_pengajuan[]"]');

        let qty = parseInt(qtyInput.value) || 0;

        let subtotal = harga * qty;

        row.querySelector('.subtotal').value =
            'Rp ' + subtotal.toLocaleString('id-ID');

        total += subtotal;
    });

    document.getElementById('total-po').innerText =
        'Rp ' + total.toLocaleString('id-ID');
}

function tambahDetail()
{
    let wrapper = document.getElementById('detail-wrapper');

    let html = `
    <div class="row detail-item mb-3">

        <div class="col-md-4">

            <select name="barang_id[]"
                    class="form-select"
                    required>

                <option value="">
                    -- Pilih Barang --
                </option>

                @foreach($barang as $item)

                    <option value="{{ $item->id }}"
                            data-harga="{{ $item->harga }}">
                        {{ $item->nama_barang }}
                    </option>

                @endforeach

            </select>

        </div>

        <div class="col-md-2">

            <input type="text"
                class="form-control harga"
                readonly>

        </div>

        <div class="col-md-2">

            <input type="number"
                name="qty_pengajuan[]"
                class="form-control"
                min="1"
                required>

        </div>

        <div class="col-md-2">

            <input type="text"
                class="form-control subtotal"
                readonly>

        </div>

        <div class="col-md-2">

            <button type="button"
                    class="btn btn-danger"
                    onclick="this.closest('.detail-item').remove(); hitungTotalPO();">

                <i class="bi bi-trash"></i>

            </button>

        </div>

    </div>
    `;

    wrapper.insertAdjacentHTML('beforeend', html);
}

document.addEventListener('change', function(e){

    if(e.target.name === 'barang_id[]'){

        let option = e.target.options[e.target.selectedIndex];

        let harga = option.dataset.harga || 0;

        let row = e.target.closest('.detail-item');

        row.querySelector('.harga').value =
            'Rp ' + Number(harga).toLocaleString('id-ID');

        row.querySelector('.harga').dataset.harga = harga;

        hitungTotalPO();
    }

});

document.addEventListener('input', function(e){

    if(e.target.name === 'qty_pengajuan[]'){
        hitungTotalPO();
    }

});

window.onload = function () {
    hitungTotalPO();
};
</script>


@endsection