<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\BarangKeluarDetail;
use App\Models\PermintaanBarang;
use App\Models\PermintaanDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BarangKeluarController extends Controller
{
    public function index()
    {
        $barangKeluar = BarangKeluar::with(['detail.barang', 'user'])
            ->latest()
            ->get();

        return view('barang_keluar.index', compact('barangKeluar'));
    }

    public function create()
    {
        //create hanya bisa dilakukan oleh logistik
        if(Auth::user()->role != 'logistik'){
            abort(403);
        }

        $barang = Barang::orderBy('nama_barang')->get();

        $tanggal = now()->format('dmy');

        $jumlahHariIni = BarangKeluar::whereDate(
            'tanggal_keluar',
            today()
        )->count();

        $urutan = str_pad($jumlahHariIni + 1, 2, '0', STR_PAD_LEFT);

        $kodeBarangKeluar = 'BK' . $tanggal . $urutan;

        return view(
            'barang_keluar.create',
            compact(
                'barang',
                'kodeBarangKeluar'
            )
        );
    }

    public function store(Request $request)
    {
        //store hanya bisa dilakukan logistik
        if(Auth::user()->role != 'logistik'){
            abort(403);
        }
        
        $request->validate([

            'divisi_tujuan' => 'required|string|max:255',

            'barang_id' => 'required|array',
            'barang_id.*' => 'required|exists:barang,id',

            'qty' => 'required|array',
            'qty.*' => 'required|integer|min:1',
        ]);

        $tanggal = now()->format('dmy');

        $jumlahHariIni = BarangKeluar::whereDate(
            'tanggal_keluar',
            today()
        )->count();

        $urutan = str_pad($jumlahHariIni + 1, 2, '0', STR_PAD_LEFT);

        $kodeBarangKeluar = 'BK' . $tanggal . $urutan;

        DB::transaction(function () use ($request, $kodeBarangKeluar) {

            $barangKeluar = BarangKeluar::create([
                'no_barang_keluar' => $kodeBarangKeluar,
                'tanggal_keluar' => now(),
                'divisi_tujuan' => $request->divisi_tujuan,
                'permintaan_barang_id' => null,
                'keterangan' => $request->keterangan,
                'dicatat_oleh' => Auth::id(),
            ]);

            $adaKekurangan = false;
            $permintaan = null;

            foreach ($request->barang_id as $index => $barangId) {

                $barang = Barang::findOrFail($barangId);
                $qtyDiminta = (int) $request->qty[$index];

                $stokTersedia = $barang->stok;

                $qtyKeluar = min($stokTersedia, $qtyDiminta);
                $qtyKurang = $qtyDiminta - $qtyKeluar;

                // barang tetap keluar sesuai stok yang tersedia
                if ($qtyKeluar > 0) {
                    BarangKeluarDetail::create([
                        'barang_keluar_id' => $barangKeluar->id,
                        'barang_id' => $barang->id,
                        'qty' => $qtyKeluar,
                    ]);

                    $barang->stok -= $qtyKeluar;
                    $barang->status_barang = $this->cekStatusBarang($barang->stok);
                    $barang->save();
                }

                // kalau ada kekurangan, buat permintaan barang
                if ($qtyKurang > 0) {

                    if (!$permintaan) {
                        $tglPermintaan = now()->format('dmy');

                        $jumlahPermintaan = PermintaanBarang::whereDate(
                            'tanggal_permintaan',
                            today()
                        )->count();

                        $urutPermintaan = str_pad(
                            $jumlahPermintaan + 1,
                            2,
                            '0',
                            STR_PAD_LEFT
                        );

                        $kodePermintaan = 'PB' . $tglPermintaan . $urutPermintaan;
                        
                        $permintaan = PermintaanBarang::create([
                            'no_permintaan' => $kodePermintaan,
                            'tanggal_permintaan' => now(),
                            'divisi' => $request->divisi_tujuan,
                            'keterangan' => 'Permintaan otomatis dari barang keluar karena stok tidak mencukupi.',
                            'status_permintaan' => 'baru',
                        ]);
                    }

                    PermintaanDetail::create([
                        'permintaan_barang_id' => $permintaan->id,
                        'barang_id' => $barang->id,
                        'qty' => $qtyKurang,
                        'size' => null,
                        'keterangan' => 'Kebutuhan ' . $qtyDiminta . ', stok keluar ' . $qtyKeluar . ', kekurangan ' . $qtyKurang,
                    ]);

                    $adaKekurangan = true;
                }
            }

            if ($adaKekurangan && $permintaan) {
                $barangKeluar->update([
                    'permintaan_barang_id' => $permintaan->id,
                ]);
            }
        });

        return redirect()->route('barang-keluar.index')
            ->with('success', 'Barang keluar berhasil diproses. Jika stok kurang, permintaan barang otomatis dibuat.');
    }

    public function show(BarangKeluar $barangKeluar)
    {
        $barangKeluar->load(['detail.barang', 'user']);

        return view('barang_keluar.show', compact('barangKeluar'));
    }

    public function destroy(BarangKeluar $barangKeluar)
    {
        //hapus hanya bisa dilakukan oleh logistik
        if(Auth::user()->role != 'logistik'){
            abort(403);
        }

        $barangKeluar->delete();

        return redirect()->route('barang-keluar.index')
            ->with('success', 'Data barang keluar berhasil dihapus.');
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