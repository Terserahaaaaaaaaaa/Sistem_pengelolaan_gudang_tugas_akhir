@extends('layouts.template')

@section('content')

<br><br>

<div class="mb-4">
    <h3 class="mb-1">Tambah Barang Masuk</h3>
    <p class="text-muted mb-0">
        Input data barang masuk berdasarkan PO yang telah disetujui.
    </p>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">

        <form action="{{ route('barang-masuk.store') }}"
              method="POST">

            @csrf

            <div class="row">

                <div class="col-md-4 mb-3">
                    <label class="form-label">
                        No Barang Masuk
                    </label>

                    <input type="text"
                           name="no_barang_masuk"
                           class="form-control"
                           required>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">
                        Tanggal Masuk
                    </label>

                    <input type="date"
                           name="tanggal_masuk"
                           class="form-control"
                           required>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">
                        No PO
                    </label>

                    <select name="pengajuan_po_id"
                            id="pengajuan_po_id"
                            class="form-select"
                            required>

                        <option value="">
                            -- Pilih PO --
                        </option>

                        @foreach($pengajuanPo as $po)

                            <option value="{{ $po->id }}">
                                {{ $po->no_po }}
                            </option>

                        @endforeach

                    </select>
                </div>

            </div>

            <hr>

            <h5>Detail Barang PO</h5>

            <div class="table-responsive">

                <table class="table table-bordered">

                    <thead>
                        <tr>
                            <th>Barang</th>
                            <th width="150">Qty PO</th>
                            <th width="200">Qty Diterima</th>
                        </tr>
                    </thead>

                    <tbody id="detail-po">

                        <tr>
                            <td colspan="3" class="text-center">
                                Pilih PO terlebih dahulu
                            </td>
                        </tr>

                    </tbody>

                </table>

            </div>

            <button class="btn btn-primary">
                <i class="bi bi-save"></i>
                Simpan
            </button>

            <a href="{{ route('barang-masuk.index') }}"
               class="btn btn-secondary">

                Kembali

            </a>

        </form>

    </div>
</div>

<script>

document.getElementById('pengajuan_po_id')
.addEventListener('change', function() {

    let poId = this.value;

    let tbody = document.getElementById('detail-po');

    if (!poId) {

        tbody.innerHTML = `
            <tr>
                <td colspan="3" class="text-center">
                    Pilih PO terlebih dahulu
                </td>
            </tr>
        `;

        return;
    }

    fetch('/barang-masuk/po/' + poId)

    .then(response => response.json())

    .then(data => {

        let html = '';

        data.forEach(item => {

            html += `
                <tr>

                    <td>
                        ${item.barang.nama_barang}

                        <input type="hidden"
                               name="barang_id[]"
                               value="${item.barang_id}">
                    </td>

                    <td>
                        ${item.qty_disetujui}
                    </td>

                    <td>

                        <input type="number"
                               name="qty[]"
                               value="${item.qty_disetujui}"
                               min="1"
                               class="form-control"
                               required>

                    </td>

                </tr>
            `;
        });

        tbody.innerHTML = html;

    });

});

</script>

@endsection