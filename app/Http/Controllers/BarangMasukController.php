<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangMasukDetail;
use App\Models\PengajuanPo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BarangMasukController extends Controller
{
    public function index()
    {
        $barangMasuk = BarangMasuk::with(['detail.barang', 'user'])
            ->latest()
            ->get();

        return view('barang_masuk.index', compact('barangMasuk'));
    }

    // form tambah barang masuk
    public function create()
    {
        //create hanya bisa dilakukan oleh logistik
        if(Auth::user()->role != 'logistik'){
            abort(403);
        }

        // hanya PO yang sudah disetujui
        $pengajuanPo = PengajuanPo::where('status_po', 'disetujui')
            ->whereDoesntHave('barangMasuk')
            ->get();

        $tanggal = now()->format('dmy');

        $jumlahHariIni = BarangMasuk::whereDate(
            'tanggal_masuk',
            today()
        )->count();

        $urutan = str_pad($jumlahHariIni + 1, 2, '0', STR_PAD_LEFT);

        $kodeBarangMasuk = 'BM' . $tanggal . $urutan;

        return view('barang_masuk.create', compact('pengajuanPo', 'kodeBarangMasuk'));
    }

    public function store(Request $request)
    {
        //store hanya bisa dilakukan logistik
        if(Auth::user()->role != 'logistik'){
            abort(403);
        }
        
        $request->validate([
            // wajib pilih PO
            'pengajuan_po_id' => 'required|exists:pengajuan_po,id',

            'barang_id' => 'required|array',
            'barang_id.*' => 'required|exists:barang,id',

            'qty' => 'required|array',
            'qty.*' => 'required|integer|min:1',
        ]);

        $tanggal = now()->format('dmy');

        $jumlahHariIni = BarangMasuk::whereDate(
            'tanggal_masuk',
            today()
        )->count();

        $urutan = str_pad($jumlahHariIni + 1, 2, '0', STR_PAD_LEFT);

        $kodeBarangMasuk = 'BM' . $tanggal . $urutan;

        $sudahDipakai = BarangMasuk::where(
            'pengajuan_po_id',
            $request->pengajuan_po_id
        )->exists();

        if ($sudahDipakai) {
            return back()->with(
                'error',
                'PO tersebut sudah pernah digunakan untuk Barang Masuk.'
            );
        }

        DB::transaction(function () use ($request, $kodeBarangMasuk) {

            $barangMasuk = BarangMasuk::create([
                'no_barang_masuk' => $kodeBarangMasuk,
                'tanggal_masuk' => now(),
                'pengajuan_po_id' => $request->pengajuan_po_id,
                'keterangan' => $request->keterangan,
                'dicatat_oleh' => Auth::id(),
            ]);

            foreach ($request->barang_id as $index => $barangId) {

                $qty = $request->qty[$index];

                BarangMasukDetail::create([
                    'barang_masuk_id' => $barangMasuk->id,
                    'barang_id' => $barangId,
                    'qty' => $qty,
                ]);

                // update stok barang
                $barang = Barang::findOrFail($barangId);

                $barang->stok += $qty;

                $barang->status_barang = $this->cekStatusBarang($barang->stok);

                $barang->save();
            }
        });

        return redirect()
            ->route('barang-masuk.index')
            ->with('success', 'Data barang masuk berhasil ditambahkan.');
    }

    public function show(BarangMasuk $barangMasuk)
    {
        $barangMasuk->load([
            'detail.barang',
            'pengajuanPo',
            'user'
        ]);

        return view(
            'barang_masuk.show',
            compact('barangMasuk')
        );
    }

    public function destroy(BarangMasuk $barangMasuk)
    {
        //hapus hanya bisa dilakukan oleh logistik
        if(Auth::user()->role != 'logistik'){
            abort(403);
        }

        // Kalau suatu saat Barang Masuk dihapus, stoknya tidak kembali berkurang. makanya pake code dibawah biar ngga gitu
        DB::transaction(function () use ($barangMasuk) {
            foreach ($barangMasuk->detail as $detail) {

                $barang = $detail->barang;

                $barang->stok -= $detail->qty;

                $barang->status_barang = $this->cekStatusBarang($barang->stok);

                $barang->save();
            }

            $barangMasuk->delete();
        });
        
        return redirect()
            ->route('barang-masuk.index')
            ->with('success', 'Data barang masuk berhasil dihapus.');
    }
    
    public function getPoDetail($id)
    {
        $po = PengajuanPo::with('detail.barang')
            ->findOrFail($id);

        return response()->json($po->detail);
    }

    private function cekStatusBarang($stok)
    {
        if ($stok == 0) {
            return 'habis';
        }

        if ($stok <= 5) {
            return 'menipis';
        }

        return 'aman';
    }
}