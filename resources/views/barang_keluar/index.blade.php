@extends('layouts.template')

@section('content')

<br><br>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1">Barang Keluar</h3>
        <p class="text-muted mb-0">Kelola data barang keluar gudang.</p>
    </div>

    @if(Auth::user()->role == 'logistik')
        <a href="{{ route('barang-keluar.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Barang Keluar
        </a>
    @endif
</div>

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

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No Barang Keluar</th>
                        <th>Tanggal</th>
                        <th>Divisi Tujuan</th>
                        <th>Total Item</th>
                        <th>Dicatat Oleh</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($barangKeluar as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->no_barang_keluar }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_keluar)->format('d-m-Y') }}</td>
                        <td>{{ $item->divisi_tujuan }}</td>
                        <td>{{ $item->detail->count() }} Item</td>
                        <td>{{ $item->user->name ?? '-' }}</td>
                        <td>
                            <a href="{{ route('barang-keluar.show', $item->id) }}"
                               class="btn btn-info btn-sm"
                               title="Detail">
                                <i class="bi bi-eye-fill"></i>
                            </a>

                            @if(Auth::user()->role == 'logistik')
                                <form action="{{ route('barang-keluar.destroy', $item->id) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm" title="Hapus">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            Data barang keluar belum ada.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection