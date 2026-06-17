@extends('layouts.template')

@section('content')

<br><br>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1">Data User</h3>
        <p class="text-muted mb-0">Kelola data pengguna sistem.</p>
    </div>
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
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th width="220">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($users as $user)
                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $user->name }}</td>

                        <td>{{ $user->email }}</td>

                        <td>
                            <span class="badge bg-primary">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>

                        <td>
                            @if($user->status == 'aktif')
                                <span class="badge bg-success">
                                    Aktif
                                </span>

                            @elseif($user->status == 'pending')
                                <span class="badge bg-warning text-dark">
                                    Pending
                                </span>

                            @else
                                <span class="badge bg-danger">
                                    Nonaktif
                                </span>
                            @endif
                        </td>

                        <td>

    {{-- Detail --}}
    <a href="{{ route('user.show', $user->id) }}"
       class="btn btn-info btn-sm"
       title="Detail">
        <i class="bi bi-eye-fill"></i>
    </a>

    {{-- Edit --}}
    <a href="{{ route('user.edit', $user->id) }}"
       class="btn btn-warning btn-sm"
       title="Edit">
        <i class="bi bi-pencil-fill"></i>
    </a>

    {{-- Aktifkan --}}
    @if($user->status != 'aktif')
    <form action="{{ route('user.aktifkan', $user->id) }}"
          method="POST"
          class="d-inline">
        @csrf
        @method('PATCH')

        <button class="btn btn-success btn-sm"
                title="Aktifkan">
            <i class="bi bi-check-circle-fill"></i>
        </button>
    </form>
    @endif

    {{-- Nonaktifkan --}}
    @if($user->status == 'aktif')
    <form action="{{ route('user.nonaktifkan', $user->id) }}"
          method="POST"
          class="d-inline">
        @csrf
        @method('PATCH')

        <button class="btn btn-secondary btn-sm"
                title="Nonaktifkan">
            <i class="bi bi-slash-circle-fill"></i>
        </button>
    </form>
    @endif

    {{-- Hapus --}}
    <form action="{{ route('user.destroy', $user->id) }}"
          method="POST"
          class="d-inline"
          onsubmit="return confirm('Yakin ingin menghapus user ini?')">

        @csrf
        @method('DELETE')

        <button class="btn btn-danger btn-sm"
                title="Hapus">
            <i class="bi bi-trash-fill"></i>
        </button>
    </form>

</td>
                        {{-- <td>

                            @if($user->status != 'aktif')
                            <form action="{{ route('user.aktifkan', $user->id) }}"
                                  method="POST"
                                  class="d-inline">

                                @csrf
                                @method('PATCH')

                                <button class="btn btn-success btn-sm">
                                    Aktifkan
                                </button>
                            </form>
                            @endif

                            @if($user->status == 'aktif')
                            <form action="{{ route('user.nonaktifkan', $user->id) }}"
                                  method="POST"
                                  class="d-inline">

                                @csrf
                                @method('PATCH')

                                <button class="btn btn-warning btn-sm">
                                    Nonaktifkan
                                </button>
                            </form>
                            @endif

                        </td> --}}

                    </tr>

                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            Data user belum ada.
                        </td>
                    </tr>
                    @endforelse

                </tbody>

            </table>

        </div>
    </div>
</div>

@endsection