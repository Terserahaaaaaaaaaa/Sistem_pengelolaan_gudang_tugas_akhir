<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanPoDetail extends Model
{
    protected $table = 'pengajuan_po_detail';

    protected $fillable = [
        'pengajuan_po_id',
        'barang_id',
        'qty_pengajuan',
        'qty_disetujui',
        'status_item',
    ];

    public function pengajuanPo()
    {
        return $this->belongsTo(PengajuanPo::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}