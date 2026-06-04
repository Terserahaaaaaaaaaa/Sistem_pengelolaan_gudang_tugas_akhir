<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barang_keluar', function (Blueprint $table) {
            $table->id();
            $table->string('no_barang_keluar')->unique();
            $table->date('tanggal_keluar');
            $table->string('divisi_tujuan');

            $table->foreignId('permintaan_barang_id')
                ->nullable()
                ->constrained('permintaan_barang')
                ->nullOnDelete();

            $table->text('keterangan')->nullable();

            $table->foreignId('dicatat_oleh')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_keluar');
    }
};
