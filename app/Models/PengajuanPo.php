<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanPo extends Model
{
    protected $table = 'pengajuan_po';

    protected $fillable = [
        'permintaan_barang_id',
        'no_po',
        'tanggal_po',
        'sumber_po',
        'kontak_pembelian',
        'metode_pembelian',
        'status_po',
        'dibuat_oleh',
        'disetujui_oleh',
    ];

    public function detail()
    {
        return $this->hasMany(PengajuanPoDetail::class);
    }

    public function barangMasuk()
    {
        return $this->hasOne(BarangMasuk::class, 'pengajuan_po_id');
    }

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function penyetuju()
    {
        return $this->belongsTo(User::class, 'disetujui_oleh');
    }

    //relasi ke permintaan barang
    public function permintaanBarang()
{
    return $this->belongsTo(PermintaanBarang::class,'permintaan_barang_id');
}
}