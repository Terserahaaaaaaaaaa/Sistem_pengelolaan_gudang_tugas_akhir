<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotifikasiStok extends Model
{
    protected $table = 'notifikasi_stok';

    protected $fillable = [
        'barang_id',
        'pesan',
        'status_notifikasi',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
