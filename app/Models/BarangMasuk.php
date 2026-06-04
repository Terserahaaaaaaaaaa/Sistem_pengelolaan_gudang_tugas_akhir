<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    protected $table = 'barang_masuk';

    protected $fillable = [
        'no_barang_masuk',
        'tanggal_masuk',
        'pengajuan_po_id',
        'keterangan',
        'dicatat_oleh',
    ];

    public function detail()
    {
        return $this->hasMany(BarangMasukDetail::class);
    }

    public function pengajuanPo()
    {
        return $this->belongsTo(PengajuanPo::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'dicatat_oleh');
    }
}