@extends('layouts.template')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Pengajuan PO</h2>
        <p class="text-muted mb-0">
            Daftar pengajuan pembelian barang.
        </p>
    </div>

    <a href="{{ route('pengajuan-po.create') }}"
       class="btn btn-primary">
        <i class="bi bi-plus-circle"></i>
        Buat PO
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>No PO</th>
                        <th>Tanggal</th>
                        <th>Sumber</th>
                        <th>Total Item</th>
                        <th>Status</th>
                        <th>Dibuat Oleh</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($pengajuanPo as $item)

                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                            <strong>{{ $item->no_po }}</strong>
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($item->tanggal_po)->format('d-m-Y') }}
                        </td>

                        <td>
                            <span class="badge bg-light text-dark">
                                {{ ucfirst(str_replace('_', ' ', $item->sumber_po)) }}
                            </span>
                        </td>

                        <td>
                            {{ $item->detail->count() }} Item
                        </td>

                        <td>
                            @if($item->status_po == 'pending')
                                <span class="badge bg-warning text-dark">
                                    Pending
                                </span>
                            @elseif($item->status_po == 'disetujui')
                                <span class="badge bg-success">
                                    Disetujui
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    Ditolak
                                </span>
                            @endif
                        </td>

                        <td>
                            {{ $item->pembuat->name ?? '-' }}
                        </td>

                        <td class="text-center">

                            <a href="{{ route('pengajuan-po.show', $item->id) }}"
                               class="btn btn-info btn-sm">
                                <i class="bi bi-eye-fill"></i>
                            </a>

                            <form action="{{ route('pengajuan-po.destroy', $item->id) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus PO ini?')">

                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash-fill"></i>
                                </button>

                            </form>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="8"
                            class="text-center text-muted py-5">

                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>

                            Belum ada pengajuan PO.

                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>
    </div>
</div>

@endsection