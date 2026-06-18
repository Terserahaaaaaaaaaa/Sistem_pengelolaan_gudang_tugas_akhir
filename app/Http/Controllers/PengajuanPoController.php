<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\PengajuanPo;
use App\Models\PengajuanPoDetail;
use App\Models\PermintaanBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengajuanPoController extends Controller
{
    // ADMIN
    public function index()
    {
        $pengajuanPo = PengajuanPo::with(['detail.barang', 'pembuat'])
            ->latest()
            ->get();

        return view('pengajuan_po.index', compact('pengajuanPo'));
    }

    public function create(Request $request)
    {
        //create hanya bisa dilakukan admin
        if(Auth::user()->role != 'admin'){
            abort(403);
        }

        $barang = Barang::orderBy('nama_barang')->get();

        $permintaan = null;

        if ($request->permintaan_id) {

            $permintaan = PermintaanBarang::with('detail.barang')
                ->findOrFail($request->permintaan_id);
        }

        $tanggal = now()->format('dmy');

        $jumlahHariIni = PengajuanPo::whereDate(
            'tanggal_po',
            today()
        )->count();

        $urutan = str_pad(
            $jumlahHariIni + 1,
            2,
            '0',
            STR_PAD_LEFT
        );

        $noPo = 'PO' . $tanggal . $urutan;

        return view('pengajuan_po.create', compact(
            'barang',
            'permintaan',
            'noPo'
        ));
    }

    public function store(Request $request)
    {
        //store hanya bisa dilakukan admin
        if(Auth::user()->role != 'admin'){
            abort(403);
        }

        $request->validate([
            'no_po' => 'required|unique:pengajuan_po,no_po',
            'sumber_po' => 'required',
            'kontak_pembelian' => 'nullable',
            'metode_pembelian' => 'nullable',

            'barang_id' => 'required|array',
            'barang_id.*' => 'required|exists:barang,id',

            'qty_pengajuan' => 'required|array',
            'qty_pengajuan.*' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {

            $po = PengajuanPo::create([

                'permintaan_barang_id' => $request->permintaan_barang_id,

                'no_po' => $request->no_po,
                'tanggal_po' => now(),
                'sumber_po' => $request->sumber_po,
                'kontak_pembelian' => $request->kontak_pembelian,
                'metode_pembelian' => $request->metode_pembelian,

                'status_po' => 'pending',

                'dibuat_oleh' => Auth::id(),
                'disetujui_oleh' => null,
            ]);

            foreach ($request->barang_id as $index => $barangId) {

                $barang = Barang::findOrFail($barangId);

                $harga = $barang->harga;

                $qty = $request->qty_pengajuan[$index];

                PengajuanPoDetail::create([

                    'pengajuan_po_id' => $po->id,
                    'barang_id' => $barangId,

                    'harga_satuan' => $harga,

                    'subtotal' => $harga * $qty,

                    'qty_pengajuan' => $qty,

                    'qty_disetujui' => 0,

                    'status_item' => 'pending',
                ]);
            }

            // UPDATE STATUS PERMINTAAN
            if ($request->permintaan_barang_id) {

                $permintaan = PermintaanBarang::find(
                    $request->permintaan_barang_id
                );

                if ($permintaan) {

                    $permintaan->update([
                        'status_permintaan' => 'diajukan_po'
                    ]);
                }
            }

        });

        return redirect()
            ->route('pengajuan-po.index')
            ->with('success', 'Pengajuan PO berhasil dibuat.');
    }

    public function show(PengajuanPo $pengajuanPo)
    {
        $pengajuanPo->load([
            'detail.barang',
            'pembuat',
            'penyetuju'
        ]);

        if(
            Auth::user()->role == 'keuangan' &&
            $pengajuanPo->status_po == 'pending'
        ){
            return view('pengajuan_po.approve', compact('pengajuanPo'));
        }

        return view('pengajuan_po.show', compact('pengajuanPo'));
    }

    public function destroy(PengajuanPo $pengajuanPo)
    {
        //hapus hanya bisa dilakukan admin
        if(Auth::user()->role != 'admin'){
            abort(403);
        }

        $pengajuanPo->delete();

        return redirect()
            ->route('pengajuan-po.index')
            ->with('success', 'Pengajuan PO berhasil dihapus.');
    }

    //KEUANGAN
    public function approve(Request $request, PengajuanPo $pengajuanPo)
    {
        //approve hanya bisa dilakukan keuangan
        if(Auth::user()->role != 'keuangan'){
            abort(403);
        }

        foreach ($pengajuanPo->detail as $detail) {

            $status = $request->status_item[$detail->id];

            $qty = $status == 'ditolak'
                ? 0
                : $request->qty_disetujui[$detail->id];

            $detail->update([
                'status_item' => $status,
                'qty_disetujui' => $qty,
            ]);
        }

        // cek jumlah item disetujui
        $jumlahDisetujui = $pengajuanPo->detail()
            ->where('status_item', 'disetujui')
            ->count();

        // total item
        $totalItem = $pengajuanPo->detail->count();

        // status PO
        if ($jumlahDisetujui == 0) {

            $statusPo = 'ditolak';

        } elseif ($jumlahDisetujui == $totalItem) {

            $statusPo = 'disetujui';

        } else {

            $statusPo = 'disetujui_sebagian';
        }

        $pengajuanPo->update([
            'status_po' => $statusPo,
            'disetujui_oleh' => Auth::id(),
        ]);

        // UPDATE STATUS PERMINTAAN BARANG
        if ($pengajuanPo->permintaanBarang) {

            $pengajuanPo->permintaanBarang->update([

                'status_permintaan' => match($statusPo) {

                    'disetujui' => 'terpenuhi',

                    'ditolak' => 'tidak_terpenuhi',

                    default => 'diajukan_po',

                }

            ]);
        }

        return redirect()
            ->route('pengajuan-po.index')
            ->with('success', 'Pengajuan PO berhasil diproses.');
    }
}