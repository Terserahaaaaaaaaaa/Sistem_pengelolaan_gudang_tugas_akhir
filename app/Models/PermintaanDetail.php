<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermintaanDetail extends Model
{
    protected $table = 'permintaan_detail';

    protected $fillable = [
        'permintaan_barang_id',
        'barang_id',
        'qty',
        'size',
        'keterangan',
    ];

    public function permintaanBarang()
    {
        return $this->belongsTo(PermintaanBarang::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}