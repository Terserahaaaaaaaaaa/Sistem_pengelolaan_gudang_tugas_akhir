<?php

namespace App\Http\Controllers;

use App\Models\Barang;

class StokBarangController extends Controller
{
    public function index()
    {
        $barang = Barang::orderBy('nama_barang')->get();

        return view('stok_barang.index', compact('barang'));
    }
}