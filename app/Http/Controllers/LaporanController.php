<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\PengajuanPo;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $jenis = $request->jenis;
        $tanggalAwal = $request->tanggal_awal;
        $tanggalAkhir = $request->tanggal_akhir;

        $data = collect();

        if ($jenis == 'barang_masuk') {

            $query = BarangMasuk::query();

            if ($tanggalAwal && $tanggalAkhir) {

                $query->whereBetween('tanggal_masuk', [
                    $tanggalAwal,
                    $tanggalAkhir
                ]);
            }

            $data = $query->latest()->get();
        }

        elseif ($jenis == 'barang_keluar') {

            $query = BarangKeluar::query();

            if ($tanggalAwal && $tanggalAkhir) {

                $query->whereBetween('tanggal_keluar', [
                    $tanggalAwal,
                    $tanggalAkhir
                ]);
            }

            $data = $query->latest()->get();
        }

        elseif ($jenis == 'po') {

            $query = PengajuanPo::query();

            if ($tanggalAwal && $tanggalAkhir) {

                $query->whereBetween('tanggal_po', [
                    $tanggalAwal,
                    $tanggalAkhir
                ]);
            }

            $data = $query->latest()->get();
        }

        elseif ($jenis == 'stok') {

            $data = Barang::latest()->get();
        }

        return view('laporan.index', compact(
            'data',
            'jenis',
            'tanggalAwal',
            'tanggalAkhir'
        ));
    }
}