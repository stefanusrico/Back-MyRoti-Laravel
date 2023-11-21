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
        Schema::create('alokasi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_lapak');
            $table->foreign('id_lapak')->references('id')->on('lapak');
            $table->unsignedBigInteger('id_roti');
            $table->foreign('id_roti')->references('id')->on('roti');
            $table->smallInteger('jumlah_roti_alokasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alokasi');
    }
};
