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
        Schema::create('roti', function (Blueprint $table) {
            $table->id();
            $table->string('nama_roti');
            $table->string('jenis_roti');
            $table->date('tanggal_produksi');
            $table->date('tanggal_kadaluarsa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roti');
    }
};
