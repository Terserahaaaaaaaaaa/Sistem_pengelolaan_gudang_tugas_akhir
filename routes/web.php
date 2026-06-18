<?php

use App\Http\Controllers\UserController;
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

Route::resource('user', UserController::class);
Route::patch('/user/{user}/aktifkan', [UserController::class, 'aktifkan'])
    ->name('user.aktifkan');

Route::patch('/user/{user}/nonaktifkan', [UserController::class, 'nonaktifkan'])
    ->name('user.nonaktifkan');

Route::get('/user/{user}', [UserController::class, 'show'])
    ->name('user.show');

Route::get('/user/{user}/edit', [UserController::class, 'edit'])
    ->name('user.edit');

Route::put('/user/{user}', [UserController::class, 'update'])
    ->name('user.update');

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

    //permintaan barang
    Route::resource('permintaan-barang', PermintaanBarangController::class);

    //pengajuan po
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

    // untuk approve keuangan
    Route::post('/pengajuan-po/{pengajuanPo}/approve', [PengajuanPoController::class, 'approve'])
    ->name('pengajuan-po.approve');

        //LAPORAN
    Route::get('/laporan', [LaporanController::class, 'index'])
    ->name('laporan.index');
});








