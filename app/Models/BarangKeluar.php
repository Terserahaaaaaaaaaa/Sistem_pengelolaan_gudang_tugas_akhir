<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    protected $table = 'barang_keluar';

    protected $fillable = [
        'no_barang_keluar',
        'tanggal_keluar',
        'divisi_tujuan',
        'permintaan_barang_id',
        'keterangan',
        'dicatat_oleh',
    ];

    public function detail()
    {
        return $this->hasMany(BarangKeluarDetail::class);
    }

    public function permintaanBarang()
    {
        return $this->belongsTo(PermintaanBarang::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'dicatat_oleh');
    }
}