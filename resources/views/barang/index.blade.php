@extends('layouts.template')

@section('content')
<br><br>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1">Data Barang</h3>
        <p class="text-muted mb-0">Kelola data barang perlengkapan produksi.</p>
    </div>

    @if(Auth::user()->role == 'admin')
        <a href="{{ route('barang.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Barang
        </a>
    @endif
</div>

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

<form method="GET" action="{{ route('barang.index') }}">
    <div class="row mb-3">

        {{-- Search --}}
        <div class="col-md-5">
            <input type="text"
                   name="search"
                   class="form-control"
                   placeholder="Cari nama barang atau no akun..."
                   value="{{ request('search') }}">
        </div>

        {{-- Filter Nama Akun --}}
        <div class="col-md-4">
            <select name="nama_akun" class="form-select">
                <option value="">-- Semua Nama Akun --</option>

                @foreach($akunList as $akun)
                    <option value="{{ $akun }}"
                        {{ request('nama_akun') == $akun ? 'selected' : '' }}>
                        {{ $akun }}
                    </option>
                @endforeach

            </select>
        </div>

        {{-- Tombol --}}
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-search"></i> Cari
            </button>

            <a href="{{ route('barang.index') }}"
               class="btn btn-secondary">
                Reset
            </a>
        </div>

    </div>
</form>

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
                        <th>Harga</th>
                        <th>Satuan</th>
                        <th>No Akun</th>
                        <th>Nama Akun</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($barang as $item)
                    <tr>

                        {{-- nomor --}}
                        <td>
                            {{ ($barang->currentPage() - 1) * $barang->perPage() + $loop->iteration }}
                        </td>


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
                        <td>
                            Rp {{ number_format($item->harga, 0, ',', '.') }}
                        </td>
                        <td>{{ $item->satuan ?? '-' }}</td>
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
    @if(Auth::user()->role == 'admin')
        <a href="{{ route('barang.edit', $item->id) }}"
        class="btn btn-warning btn-sm"
        title="Edit">

            <i class="bi bi-pencil-square"></i>
        </a>
    @endif

    {{-- hapus --}}
    @if(Auth::user()->role == 'admin')
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
    @endif
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
<div class="d-flex justify-content-center mt-4">
    <!--biar searchnya ngga hilang pake ini appends(request()->query())->-->
{{ $barang->appends(request()->query())->links() }}
</div>

@endsection