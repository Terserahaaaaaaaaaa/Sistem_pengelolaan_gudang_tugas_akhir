<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\PermintaanBarang;
use App\Models\PermintaanDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PermintaanBarangController extends Controller
{
    public function index()
    {
        $permintaanBarang = PermintaanBarang::with('detail.barang')
            ->latest()
            ->get();

        return view('permintaan_barang.index', compact('permintaanBarang'));
    }

    public function create()
    {
        //create hanya bisa dilakukan oleh logistik
        if(Auth::user()->role != 'logistik'){
            abort(403);
        }
        
        $barang = Barang::all();

        $tanggal = now()->format('dmy');

        $last = PermintaanBarang::whereDate(
            'created_at',
            today()
        )->count();

        $nomor = str_pad($last + 1, 2, '0', STR_PAD_LEFT);

        $kodePermintaan = 'PB' . $tanggal . $nomor;

        return view(
            'permintaan_barang.create',
            compact(
                'barang',
                'kodePermintaan'
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
            // 'no_permintaan' => 'required|unique:permintaan_barang,no_permintaan',
            // 'tanggal_permintaan' => 'required|date',
            'divisi' => 'required|string|max:255',
            'keterangan' => 'nullable',

            'barang_id' => 'required|array',
            'barang_id.*' => 'required|exists:barang,id',

            'qty' => 'required|array',
            'qty.*' => 'required|integer|min:1',
        ]);

        $tanggal = now()->format('dmy');

        $jumlahHariIni = PermintaanBarang::whereDate(
            'tanggal_permintaan',
            today()
        )->count();

        $urutan = str_pad($jumlahHariIni + 1, 2, '0', STR_PAD_LEFT);

        $kodePermintaan = 'PB' . $tanggal . $urutan;

        DB::transaction(function () use ($request, $kodePermintaan) {

            $permintaan = PermintaanBarang::create([
                'no_permintaan' => $kodePermintaan,
                'tanggal_permintaan' => now(),
                'divisi' => $request->divisi,
                'keterangan' => $request->keterangan,
                'status_permintaan' => 'baru',
            ]);

            foreach ($request->barang_id as $index => $barangId) {
                PermintaanDetail::create([
                    'permintaan_barang_id' => $permintaan->id,
                    'barang_id' => $barangId,
                    'qty' => $request->qty[$index],
                    'size' => $request->size[$index] ?? null,
                    'keterangan' => $request->detail_keterangan[$index] ?? null,
                ]);
            }
        });

        return redirect()->route('permintaan-barang.index')
            ->with('success', 'Data permintaan barang berhasil ditambahkan.');
    }

    public function show(PermintaanBarang $permintaanBarang)
    {
        $permintaanBarang->load('detail.barang');

        return view('permintaan_barang.show', compact('permintaanBarang'));
    }

    public function destroy(PermintaanBarang $permintaanBarang)
    {
        //hapus hanya bisa dilakukan oleh logistik
        if(Auth::user()->role != 'logistik'){
            abort(403);
        }

        $permintaanBarang->delete();

        return redirect()->route('permintaan-barang.index')
            ->with('success', 'Data permintaan barang berhasil dihapus.');
    }

    // public function daftarAdmin()
    // {
    //     $permintaanBarang = PermintaanBarang::with('detail.barang')
    //         ->whereIn('status_permintaan', ['baru', 'tidak_terpenuhi'])
    //         ->latest()
    //         ->get();

    //     return view('daftar_permintaan.admin_index', compact('permintaanBarang'));
    // }
}