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
        Schema::table('users', function (Blueprint $table) {
            // tambah kolom role
            $table->enum('role', [
                'admin',
                'logistik',
                'keuangan',
                'pimpinan'
            ])->after('email');

            //tambah kolom status
            $table->enum('status', [
                'pending',
                'aktif',
                'nonaktif'
            ])->default('pending')->after('role');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
            $table->dropColumn('status');
        });
    }
};
