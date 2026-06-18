<h1 style="color:red">
SHOW.BLADE.PHP
</h1>
@extends('layouts.template')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2 class="fw-bold mb-1">
            Detail Pengajuan PO
        </h2>

        <p class="text-muted mb-0">
            Informasi lengkap pengajuan pembelian.
        </p>
    </div>

    <a href="{{ route('pengajuan-po.index') }}"
       class="btn btn-secondary">

        <i class="bi bi-arrow-left"></i>
        Kembali

    </a>

</div>

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

                <td>
                    {{ ucfirst(str_replace('_', ' ', $pengajuanPo->sumber_po)) }}
                </td>
            </tr>

            <tr>
                <th>Kontak Pembelian</th>

                <td>
                    {{ $pengajuanPo->kontak_pembelian ?? '-' }}
                </td>
            </tr>

            <tr>
                <th>Metode Pembelian</th>

                <td>
                    {{ $pengajuanPo->metode_pembelian ?? '-' }}
                </td>
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

                    @else

                        <span class="badge bg-danger">
                            Ditolak
                        </span>

                    @endif

                </td>
            </tr>

            <tr>
                <th>Dibuat Oleh</th>

                <td>
                    {{ $pengajuanPo->pembuat->name ?? '-' }}
                </td>
            </tr>

        </table>

    </div>

</div>

<div class="card border-0 shadow-sm">

    <div class="card-body">

        <h5 class="mb-3">Detail Barang</h5>

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Harga Satuan</th>
                        <th>Qty Pengajuan</th>
                        <th>Subtotal</th>
                        <th>Qty Disetujui</th>
                        <th>Status Item</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($pengajuanPo->detail as $detail)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>
                            {{ $detail->barang->nama_barang ?? '-' }}
                        </td>

                        <td>
                            Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}
                        </td>

                        <td>
                            {{ $detail->qty_pengajuan }}
                        </td>

                        <td>
                            Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                        </td>

                        <td>
                            {{ $detail->qty_disetujui }}
                        </td>

                        <td>

                            @if($detail->status_item == 'pending')
                                <span class="badge bg-warning text-dark">
                                    Pending
                                </span>

                            @elseif($detail->status_item == 'disetujui')
                                <span class="badge bg-success">
                                    Disetujui
                                </span>

                            @else
                                <span class="badge bg-danger">
                                    Ditolak
                                </span>
                            @endif

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="7"
                            class="text-center text-muted">

                            Detail PO belum ada.

                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

            @php
                $totalPo = $pengajuanPo->detail->sum('subtotal');
            @endphp

            <div class="text-end mt-3">
                <h5>
                    Total PO :
                    <strong>
                        Rp {{ number_format($totalPo, 0, ',', '.') }}
                    </strong>
                </h5>
            </div>
            
        </div>

    </div>

</div>

@if(Auth::user()->role == 'keuangan' && $pengajuanPo->status_po == 'pending')

<form action="{{ route('pengajuan-po.approve', $pengajuanPo->id) }}"
      method="POST">

    @csrf

    <div class="card border-0 shadow-sm mt-4">

        <div class="card-body">

            <h5 class="mb-3">
                Form Approval
            </h5>

            <table class="table table-bordered">

                <thead>
                    <tr>
                        <th>Barang</th>
                        <th>Qty Pengajuan</th>
                        <th>Status</th>
                        <th>Qty Disetujui</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($pengajuanPo->detail as $detail)

                    <tr>

                        <td>
                            {{ $detail->barang->nama_barang }}
                        </td>

                        <td>
                            {{ $detail->qty_pengajuan }}
                        </td>

                        <td>

                            <select
                                name="status_item[{{ $detail->id }}]"
                                class="form-select">

                                <option value="disetujui">
                                    Disetujui
                                </option>

                                <option value="ditolak">
                                    Ditolak
                                </option>

                            </select>

                        </td>

                        <td>

                            <input
                                type="number"
                                name="qty_disetujui[{{ $detail->id }}]"
                                value="{{ $detail->qty_pengajuan }}"
                                min="0"
                                max="{{ $detail->qty_pengajuan }}"
                                class="form-control">

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

            <div class="text-end">

                <button type="submit"
                        class="btn btn-success">

                    <i class="bi bi-check-circle-fill"></i>
                    Simpan Approval

                </button>

            </div>

        </div>

    </div>

</form>

@endif
@endsection