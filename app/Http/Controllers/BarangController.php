<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $namaAkun = $request->nama_akun;

        $query = Barang::query();

        // Search nama barang atau no akun
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                ->orWhere('no_akun', 'like', "%{$search}%");
            });
        }

        // Filter nama akun
        if ($namaAkun) {
            $query->where('nama_akun', $namaAkun);
        }

        //untuk menampilkan pagination 15 data
        $barang = $query->latest()->paginate(15);

        // daftar nama akun untuk dropdown
        $akunList = Barang::select('nama_akun')
            ->distinct()
            ->orderBy('nama_akun')
            ->pluck('nama_akun');

        return view('barang.index', compact(
            'barang',
            'akunList'
        ));
    }

    public function create()
    {
        //create hanya bisa dilakukan admin
        if(Auth::user()->role != 'admin'){
            abort(403);
        }
        
        $lastBarang = Barang::latest()->first();

        if (!$lastBarang) {

            $kodeBarang = 'BRG0001';

        } else {

            $lastNumber = (int) substr($lastBarang->kode_barang, 3);

            $kodeBarang = 'BRG' .
                str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        }

        return view('barang.create', compact('kodeBarang'));
    }

    public function store(Request $request)
    {
        //store hanya bisa dilakukan admin
        if(Auth::user()->role != 'admin'){
            abort(403);
        }

        $request->validate([
            'kode_barang' => 'required|unique:barang,kode_barang',
            'nama_barang' => 'required',
            'harga' => 'required|numeric|min:0',
            'no_akun' => 'nullable',
            'nama_akun' => 'nullable',
            'satuan' => 'nullable',
            'stok' => 'required|integer|min:0',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $foto = null;

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('barang', 'public');
        }

        Barang::create([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'harga' => $request->harga,
            'no_akun' => $request->no_akun,
            'nama_akun' => $request->nama_akun,
            'satuan' => $request->satuan,
            'stok' => $request->stok,
            'status_barang' => $this->cekStatusBarang($request->stok),
            'foto' => $foto,
        ]);

        return redirect()->route('barang.index')
            ->with('success', 'Data barang berhasil ditambahkan.');
    }

    public function show(Barang $barang)
    {
        return view('barang.show', compact('barang'));
    }

    public function edit(Barang $barang)
    {
        return view('barang.edit', compact('barang'));
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'kode_barang' => 'required|unique:barang,kode_barang,' . $barang->id,
            'nama_barang' => 'required',
            'harga' => 'required|numeric|min:0',
            'no_akun' => 'nullable',
            'nama_akun' => 'nullable',
            'satuan' => 'nullable',
            'stok' => 'required|integer|min:0',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $foto = $barang->foto;

        // upload foto baru
        if ($request->hasFile('foto')) {

            // hapus foto lama
            if ($barang->foto && Storage::disk('public')->exists($barang->foto)) {
                Storage::disk('public')->delete($barang->foto);
            }

            // simpan foto baru
            $foto = $request->file('foto')->store('barang', 'public');
        }

        $barang->update([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'harga' => $request->harga,
            'no_akun' => $request->no_akun,
            'nama_akun' => $request->nama_akun,
            'satuan' => $request->satuan,
            'stok' => $request->stok,
            'status_barang' => $this->cekStatusBarang($request->stok),
            'foto' => $foto,
        ]);

        return redirect()->route('barang.index')
            ->with('success', 'Data barang berhasil diperbarui.');
    }

    public function destroy(Barang $barang)
    {
        try {

            $barang->delete();

            return redirect()
                ->route('barang.index')
                ->with('success', 'Data barang berhasil dihapus.');

        } catch (\Exception $e) {

            return redirect()
                ->route('barang.index')
                ->with(
                    'error',
                    'Data barang tidak dapat dihapus karena sudah digunakan pada transaksi lain.'
                );
        }
    }

    private function cekStatusBarang($stok)
    {
        if ($stok == 0) {
            return 'habis';
        }

        if ($stok < 5) {
            return 'menipis';
        }

        return 'aman';
    }
}