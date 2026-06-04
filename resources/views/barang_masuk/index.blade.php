@extends('layouts.template')

@section('content')

<br><br>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1">Barang Masuk</h3>
        <p class="text-muted mb-0">
            Kelola data barang masuk gudang.
        </p>
    </div>

    <a href="{{ route('barang-masuk.create') }}"
       class="btn btn-primary">

        <i class="bi bi-plus-circle"></i>
        Tambah Barang Masuk
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
                        <th>No Barang Masuk</th>
                        <th>Tanggal</th>
                        <th>Total Item</th>
                        <th>Dicatat Oleh</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($barangMasuk as $item)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $item->no_barang_masuk }}</td>

                        <td>
                            {{ \Carbon\Carbon::parse($item->tanggal_masuk)->format('d-m-Y') }}
                        </td>

                        <td>{{ $item->detail->count() }} Item</td>

                        <td>{{ $item->user->name ?? '-' }}</td>

                        <td>

                            <a href="{{ route('barang-masuk.show', $item->id) }}"
                               class="btn btn-info btn-sm">

                                <i class="bi bi-eye-fill"></i>
                            </a>

                            <form action="{{ route('barang-masuk.destroy', $item->id) }}"
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
                        <td colspan="6" class="text-center text-muted">
                            Data barang masuk belum ada.
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>
</div>

@endsection