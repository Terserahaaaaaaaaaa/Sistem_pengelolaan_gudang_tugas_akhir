@extends('layouts.template')

@section('content')
<br><br>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1">Permintaan Barang</h3>
        <p class="text-muted mb-0">Kelola data permintaan barang.</p>
    </div>

    <a href="{{ route('permintaan-barang.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Permintaan
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
                        <th>No Permintaan</th>
                        <th>Tanggal</th>
                        <th>Divisi</th>
                        <th>Total Item</th>
                        <th>Status</th>
                        <th width="120">Aksi</th>
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
                            <span class="badge bg-primary">
                                {{ ucfirst(str_replace('_', ' ', $item->status_permintaan)) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('permintaan-barang.show', $item->id) }}"
                               class="btn btn-info btn-sm">
                                <i class="bi bi-eye-fill"></i>
                            </a>

                            <form action="{{ route('permintaan-barang.destroy', $item->id) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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
                        <td colspan="7" class="text-center text-muted">
                            Data permintaan barang belum ada.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection