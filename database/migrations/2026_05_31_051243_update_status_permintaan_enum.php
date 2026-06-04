<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE permintaan_barang
            MODIFY status_permintaan
            ENUM(
                'menunggu',
                'diproses',
                'disetujui',
                'ditolak'
            )
            DEFAULT 'menunggu'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE permintaan_barang
            MODIFY status_permintaan
            ENUM(
                'menunggu',
                'diproses'
            )
            DEFAULT 'menunggu'
        ");
    }
};