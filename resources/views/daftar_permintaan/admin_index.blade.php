@extends('layouts.template')

@section('content')
<br><br>

<div class="mb-4">
    <h3 class="mb-1">Daftar Permintaan Barang</h3>
    <p class="text-muted mb-0">
        Permintaan barang dari logistik yang perlu diproses menjadi pengajuan PO.
    </p>
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
                        <th>No Permintaan</th>
                        <th>Tanggal</th>
                        <th>Divisi</th>
                        <th>Total Item</th>
                        <th>Status</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($permintaanBarang as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->no_permintaan }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_permintaan)->format('d-m-Y') }}</td>
                        <td>{{ $item->divisi }}</td>
                        <td>{{ $item->detail->count() }} Item</td>
                        <td>
                            <span class="badge bg-warning text-dark">
                                {{ ucfirst(str_replace('_', ' ', $item->status_permintaan)) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('permintaan-barang.show', $item->id) }}"
                               class="btn btn-info btn-sm"
                               title="Detail">
                                <i class="bi bi-eye-fill"></i>
                            </a>

                            <a href="{{ route('pengajuan-po.create', ['permintaan_id' => $item->id]) }}"
                               class="btn btn-primary btn-sm"
                               title="Buat PO">
                                <i class="bi bi-file-earmark-plus"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            Belum ada permintaan barang yang perlu diproses.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection