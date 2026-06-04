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
        Schema::create('pengajuan_po_detail', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pengajuan_po_id')
                ->constrained('pengajuan_po')
                ->cascadeOnDelete();

            $table->foreignId('barang_id')
                ->constrained('barang')
                ->restrictOnDelete();

            $table->integer('qty_pengajuan');
            $table->integer('qty_disetujui')->default(0);
            $table->enum('status_item', ['pending', 'disetujui', 'sebagian', 'ditolak'])->default('pending');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_po_detail');
    }
};
