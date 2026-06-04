<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\PermintaanBarang;
use App\Models\PermintaanDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $barang = Barang::orderBy('nama_barang')->get();

        return view('permintaan_barang.create', compact('barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_permintaan' => 'required|unique:permintaan_barang,no_permintaan',
            'tanggal_permintaan' => 'required|date',
            'divisi' => 'required|string|max:255',
            'keterangan' => 'nullable',

            'barang_id' => 'required|array',
            'barang_id.*' => 'required|exists:barang,id',

            'qty' => 'required|array',
            'qty.*' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            $permintaan = PermintaanBarang::create([
                'no_permintaan' => $request->no_permintaan,
                'tanggal_permintaan' => $request->tanggal_permintaan,
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
        $permintaanBarang->delete();

        return redirect()->route('permintaan-barang.index')
            ->with('success', 'Data permintaan barang berhasil dihapus.');
    }

    public function daftarAdmin()
    {
        $permintaanBarang = PermintaanBarang::with('detail.barang')
            ->whereIn('status_permintaan', ['baru', 'tidak_terpenuhi'])
            ->latest()
            ->get();

        return view('daftar_permintaan.admin_index', compact('permintaanBarang'));
    }
}