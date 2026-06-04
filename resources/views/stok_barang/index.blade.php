@extends('layouts.template')

@section('content')
<br><br>

<div class="mb-4">
    <h3 class="mb-1">Stok Barang</h3>
    <p class="text-muted mb-0">Informasi stok barang perlengkapan produksi.</p>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Satuan</th>
                        <th>Stok</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($barang as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                            @if($item->foto)
                                <img src="{{ asset('storage/' . $item->foto) }}"
                                     width="60"
                                     height="60"
                                     class="rounded"
                                     style="object-fit: cover;">
                            @else
                                <span class="text-muted">Tidak ada foto</span>
                            @endif
                        </td>

                        <td>{{ $item->kode_barang }}</td>
                        <td>{{ $item->nama_barang }}</td>
                        <td>{{ $item->satuan ?? '-' }}</td>
                        <td>{{ $item->stok }}</td>

                        <td>
                            @if($item->status_barang == 'aman')
                                <span class="badge bg-success">Aman</span>
                            @elseif($item->status_barang == 'menipis')
                                <span class="badge bg-warning text-dark">Menipis</span>
                            @else
                                <span class="badge bg-danger">Habis</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            Data stok barang belum ada.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection