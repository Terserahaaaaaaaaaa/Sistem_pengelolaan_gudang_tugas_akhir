@extends('layouts.template')

@section('content')

<br><br>

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="mb-1">Approval Pengajuan PO</h3>
        <p class="text-muted mb-0">
            Kelola persetujuan pengajuan purchase order.
        </p>
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
                        <th>No PO</th>
                        <th>Tanggal</th>
                        <th>Pembuat</th>
                        <th>Status</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($pengajuanPo as $po)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $po->no_po }}</td>

                        <td>
                            {{ \Carbon\Carbon::parse($po->tanggal_po)->format('d-m-Y') }}
                        </td>

                        <td>
                            {{ $po->pembuat->name ?? '-' }}
                        </td>

                        <td>

                            @if($po->status_po == 'pending')

                                <span class="badge bg-warning text-dark">
                                    Pending
                                </span>

                            @elseif($po->status_po == 'disetujui')

                                <span class="badge bg-success">
                                    Disetujui
                                </span>

                            @elseif($po->status_po == 'ditolak')

                                <span class="badge bg-danger">
                                    Ditolak
                                </span>

                            @else

                                <span class="badge bg-primary">
                                    Disetujui Sebagian
                                </span>

                            @endif

                        </td>

                        <td>

                            <a href="{{ route('approval_po.show', $po->id) }}"
                               class="btn btn-info btn-sm"
                               title="Detail">

                                <i class="bi bi-eye-fill"></i>

                            </a>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            Data pengajuan PO belum ada.
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection