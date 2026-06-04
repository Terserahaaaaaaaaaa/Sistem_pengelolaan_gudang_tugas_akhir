<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PengajuanPoController;
use App\Http\Controllers\PermintaanBarangController;
use App\Http\Controllers\StokBarangController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {

    Route::resource('barang', BarangController::class);

    Route::get('/stok-barang', [StokBarangController::class, 'index'])
        ->name('stok-barang.index');

    //barang masuk
    Route::resource('barang-masuk', BarangMasukController::class);
    Route::get(
        '/barang-masuk/po/{id}',
        [BarangMasukController::class, 'getPoDetail']
    )->name('barang-masuk.po-detail');

    //barang keluar
    Route::resource('barang-keluar', BarangKeluarController::class);

    Route::resource('permintaan-barang', PermintaanBarangController::class);

    Route::get('/daftar-permintaan', [PermintaanBarangController::class, 'daftarAdmin'])
        ->name('daftar-permintaan.admin_index');

    Route::get('/pengajuan-po', [PengajuanPoController::class, 'index'])
        ->name('pengajuan-po.index');

    Route::get('/pengajuan-po/create', [PengajuanPoController::class, 'create'])
        ->name('pengajuan-po.create');

    Route::post('/pengajuan-po', [PengajuanPoController::class, 'store'])
        ->name('pengajuan-po.store');

    Route::get('/pengajuan-po/{pengajuanPo}', [PengajuanPoController::class, 'show'])
        ->name('pengajuan-po.show');

    Route::delete('/pengajuan-po/{pengajuanPo}', [PengajuanPoController::class, 'destroy'])
        ->name('pengajuan-po.destroy');

        // KEUANGAN - APPROVAL PO
    Route::get('/keuangan/pengajuan-po', [PengajuanPoController::class, 'approvalIndex'])
        ->name('approval_po.index');

    Route::get('/keuangan/pengajuan-po/{pengajuanPo}', [PengajuanPoController::class, 'approvalShow'])
        ->name('approval_po.show');

    Route::post('/keuangan/pengajuan-po/{pengajuanPo}/approve', [PengajuanPoController::class, 'approve'])
        ->name('approval_po.approve');

        //LAPORAN
    Route::get('/laporan', [LaporanController::class, 'index'])
    ->name('laporan.index');
});




