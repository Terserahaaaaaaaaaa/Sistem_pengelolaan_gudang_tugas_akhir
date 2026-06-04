@extends('layouts.template')

@section('content')
<br><br>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1">Data Barang</h3>
        <p class="text-muted mb-0">Kelola data barang perlengkapan produksi.</p>
    </div>

    <a href="{{ route('barang.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Barang
    </a>
</div>

<br>

<br>

<!--untuk  menampilkan peringatan barang berhasil dihapus-->
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<!--untuk menampilkan peringatan barang tidak bisa dihapus karena data digunakan ditransaksi lain-->
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
                        <th>Foto</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>No Akun</th>
                        <th>Nama Akun</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($barang as $item)
                    <tr>

                        {{-- nomor --}}
                        <td>{{ $loop->iteration }}</td>

                        {{-- foto --}}
                        <td>
                            @if($item->foto)
                                <img src="{{ asset('storage/' . $item->foto) }}"
                                    alt="{{ $item->nama_barang }}"
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
                        <td>{{ $item->no_akun ?? '-' }}</td>
                        <td>{{ $item->nama_akun ?? '-' }}</td>

                        {{-- aksi --}}
                        <td>
    {{-- detail --}}
    <a href="{{ route('barang.show', $item->id) }}"
       class="btn btn-info btn-sm"
       title="Detail">

        <i class="bi bi-eye-fill"></i>
    </a>

    {{-- edit --}}
    <a href="{{ route('barang.edit', $item->id) }}"
       class="btn btn-warning btn-sm"
       title="Edit">

        <i class="bi bi-pencil-square"></i>
    </a>

    {{-- hapus --}}
    <form action="{{ route('barang.destroy', $item->id) }}"
          method="POST"
          class="d-inline"
          onsubmit="return confirm('Yakin ingin menghapus barang ini?')">

        @csrf
        @method('DELETE')

        <button class="btn btn-danger btn-sm"
                title="Hapus">

            <i class="bi bi-trash-fill"></i>
        </button>
    </form>
</td>

                    </tr>

                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            Data barang belum ada.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection