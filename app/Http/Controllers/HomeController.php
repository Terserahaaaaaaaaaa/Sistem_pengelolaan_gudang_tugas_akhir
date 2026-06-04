<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use App\Models\PengajuanPo;
use App\Models\PermintaanBarang;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    
    public function index()
    {
        $totalPo = PengajuanPo::count();

        $totalPermintaan = PermintaanBarang::count();

        $totalBarangMasuk = BarangMasuk::count();

        $totalBarangKeluar = BarangKeluar::count();

        //untuk menghitung stok menipis
        $stokMenipis = Barang::where('stok', '<=', 5)
            ->orderBy('stok', 'asc')
            ->take(5)
            ->get();

        // Barang Masuk per bulan
        $barangMasukBulanan = BarangMasuk::selectRaw('MONTH(tanggal_masuk) as bulan, COUNT(*) as total')
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        // Barang Keluar per bulan
        $barangKeluarBulanan = BarangKeluar::selectRaw('MONTH(tanggal_keluar) as bulan, COUNT(*) as total')
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        $dataMasuk = [];
        $dataKeluar = [];

        for ($i = 1; $i <= 12; $i++) {
            $dataMasuk[] = $barangMasukBulanan[$i] ?? 0;
            $dataKeluar[] = $barangKeluarBulanan[$i] ?? 0;
        }

        //untuk aktifitas bar masuk baru 3 hari terakhir
        $aktivitasMasuk = BarangMasuk::where('created_at', '>=', Carbon::now()->subDays(3))
            ->latest()
            ->get()
            ->map(function ($item) {
                return [
                    'jenis' => 'Barang Masuk',
                     'detail' => $item->no_barang_masuk,
                    'tanggal' => $item->created_at
                ];
            });

        //untuk aktifitas bar keluar baru 3 hari terakhir
        $aktivitasKeluar = BarangKeluar::where('created_at', '>=', Carbon::now()->subDays(3))
            ->latest()
            ->get()
            ->map(function ($item) {
                return [
                    'jenis' => 'Barang Keluar',
                    'detail' => $item->no_barang_keluar,
                    'tanggal' => $item->created_at
                ];
            });

        //ini untuk activitas po terbaru 3 hari terakhir
        $aktivitasPO = PengajuanPo::where('created_at', '>=', Carbon::now()->subDays(3))
            ->latest()
            ->get()
            ->map(function ($item) {
                return [
                    'jenis' => 'Pengajuan PO',
                    'detail' => $item->no_po,
                    'tanggal' => $item->created_at
                ];
            });

        //untuk aktifitas permintaan barang baru 3 hari terakhir
        $aktivitasPermintaan = PermintaanBarang::where('created_at', '>=', Carbon::now()->subDays(3))
            ->latest()
            ->get()
            ->map(function ($item) {
                return [
                    'jenis' => 'Permintaan Barang',
                    'detail' => $item->no_permintaan,
                    'tanggal' => $item->created_at
                ];
            });

        $aktivitas = $aktivitasMasuk
            ->concat($aktivitasKeluar)
            ->concat($aktivitasPO)
            ->concat($aktivitasPermintaan)
            ->sortByDesc('tanggal')
            ->take(10);

        return view('home', compact(
            'totalPo',
            'totalPermintaan',
            'totalBarangMasuk',
            'totalBarangKeluar',
            'dataMasuk',
            'dataKeluar',
            'stokMenipis',
            'aktivitas'
        ));
    }
}
