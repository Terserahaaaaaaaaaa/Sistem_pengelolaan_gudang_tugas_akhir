<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermintaanBarang extends Model
{
    protected $table = 'permintaan_barang';

    protected $fillable = [
        'no_permintaan',
        'tanggal_permintaan',
        'divisi',
        'keterangan',
        'status_permintaan',
    ];

    public function detail()
    {
        return $this->hasMany(PermintaanDetail::class);
    }

    public function barangKeluar()
    {
        return $this->hasMany(BarangKeluar::class);
    }

    //relasi ke pengajuan po
    public function pengajuanPo()
    {
        return $this->hasMany(PengajuanPo::class,'permintaan_barang_id');
    }
}