<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'no_akun',
        'nama_akun',
        'satuan',
        'stok',
        'status_barang',
        'foto',
    ];

    public function permintaanDetail()
    {
        return $this->hasMany(PermintaanDetail::class);
    }

    public function pengajuanPoDetail()
    {
        return $this->hasMany(PengajuanPoDetail::class);
    }

    public function barangMasukDetail()
    {
        return $this->hasMany(BarangMasukDetail::class);
    }

    public function barangKeluarDetail()
    {
        return $this->hasMany(BarangKeluarDetail::class);
    }

    public function notifikasi()
    {
        return $this->hasMany(NotifikasiStok::class);
    }
}