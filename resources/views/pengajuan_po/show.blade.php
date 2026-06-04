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
                        <th>Qty Pengajuan</th>
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
                            {{ $detail->qty_pengajuan }}
                        </td>

                        <td>
                            {{ $detail->qty_disetujui }}
                        </td>

                        <td>

                            <span class="badge bg-secondary">
                                {{ ucfirst($detail->status_item) }}
                            </span>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="5"
                            class="text-center text-muted">

                            Detail PO belum ada.

                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection