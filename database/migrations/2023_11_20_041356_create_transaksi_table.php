<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_alokasi');
            $table->foreign('id_alokasi')->references('id')->on('alokasi');
            $table->string('lapak');
            $table->integer('jumlah_roti_terjual');
            $table->integer('jumlah_roti_tidak_terjual');
            $table->double('pendapatan');
            $table->double('hutang');
            $table->string('catatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};