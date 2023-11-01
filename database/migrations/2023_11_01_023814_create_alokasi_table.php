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
            $table->unsignedBigInteger('koordinator_id');
            $table->foreign('koordinator_id')->references('id')->on('koordinator');
            $table->unsignedBigInteger('kurir_id');
            $table->foreign('kurir_id')->references('id')->on('kurir');
            $table->unsignedBigInteger('roti_id');
            $table->foreign('roti_id')->references('id')->on('roti');
            $table->integer('jumlah_roti_alokasi');
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