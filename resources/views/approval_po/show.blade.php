@extends('layouts.template')

@section('content')

<br><br>

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="mb-1">Detail Approval PO</h3>
        <p class="text-muted mb-0">
            Informasi detail pengajuan purchase order.
        </p>
    </div>

    <a href="{{ route('approval_po.index') }}"
       class="btn btn-secondary">

        <i class="bi bi-arrow-left"></i> Kembali

    </a>

</div>

{{-- ALERT --}}
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

{{-- INFORMASI PO --}}
<div class="card border-0 shadow-sm mb-4">

    <div class="card-body">

        <table class="table table-bordered">

            <tr>
                <th width="250">No PO</th>
                <td>{{ $pengajuanPo->no_po }}</td>
            </tr>

            <tr>
                <th>Tanggal PO</th>
                <td>
                    {{ \Carbon\Carbon::parse($pengajuanPo->tanggal_po)->format('d-m-Y') }}
                </td>
            </tr>

            <tr>
                <th>Sumber PO</th>
                <td>{{ $pengajuanPo->sumber_po }}</td>
            </tr>

            <tr>
                <th>Kontak Pembelian</th>
                <td>{{ $pengajuanPo->kontak_pembelian ?? '-' }}</td>
            </tr>

            <tr>
                <th>Metode Pembelian</th>
                <td>{{ $pengajuanPo->metode_pembelian ?? '-' }}</td>
            </tr>

            <tr>
                <th>Dibuat Oleh</th>
                <td>{{ $pengajuanPo->pembuat->name ?? '-' }}</td>
            </tr>

            <tr>
                <th>Status PO</th>

                <td>

                    @if($pengajuanPo->status_po == 'pending')

                        <span class="badge bg-warning text-dark">
                            Pending
                        </span>

                    @elseif($pengajuanPo->status_po == 'disetujui')

                        <span class="badge bg-success">
                            Disetujui
                        </span>

                    @elseif($pengajuanPo->status_po == 'ditolak')

                        <span class="badge bg-danger">
                            Ditolak
                        </span>

                    @else

                        <span class="badge bg-primary">
                            Disetujui Sebagian
                        </span>

                    @endif

                </td>

            </tr>

        </table>

    </div>

</div>

{{-- FORM APPROVAL --}}
<form action="{{ route('approval_po.approve', $pengajuanPo->id) }}"
      method="POST">

    @csrf

    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <h5 class="mb-3">Detail Barang</h5>

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>
                            <th>No</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Qty Pengajuan</th>
                            <th width="220">Keputusan</th>
                            <th width="200">Qty Disetujui</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse ($pengajuanPo->detail as $detail)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>
                                {{ $detail->barang?->kode_barang ?? '-' }}
                            </td>

                            <td>
                                {{ $detail->barang?->nama_barang ?? '-' }}
                            </td>

                            <td>
                                {{ $detail->qty_pengajuan }}
                            </td>

                            {{-- STATUS ITEM --}}
                            <td>

                                <select
                                    name="status_item[{{ $detail->id }}]"
                                    class="form-select status-select"
                                    data-target="qty-{{ $detail->id }}"
                                >

                                    <option value="disetujui">
                                        Disetujui
                                    </option>

                                    <option value="ditolak">
                                        Ditolak
                                    </option>

                                </select>

                            </td>

                            {{-- QTY --}}
                            <td>

                                <input
                                    type="number"
                                    class="form-control qty-input"
                                    name="qty_disetujui[{{ $detail->id }}]"
                                    id="qty-{{ $detail->id }}"
                                    value="{{ $detail->qty_pengajuan }}"
                                    min="0"
                                    max="{{ $detail->qty_pengajuan }}"
                                >

                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                Detail barang belum ada.
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <div class="mt-4 text-end">

        <button type="submit"
                class="btn btn-success">

            <i class="bi bi-check-circle"></i>
            Simpan Approval

        </button>

    </div>

</form>

{{-- SCRIPT --}}
<script>

document.querySelectorAll('.status-select').forEach(function(select){

    select.addEventListener('change', function(){

        let target = document.getElementById(
            this.dataset.target
        );

        if(this.value == 'ditolak'){

            target.value = 0;
            target.setAttribute('readonly', true);

        } else {

            target.removeAttribute('readonly');

        }

    });

});

</script>

@endsection