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
        Schema::create('lapak', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lapak');
            $table->string('alamat');
            $table->unsignedBigInteger('id_kurir');
            $table->foreign('id_kurir')->references('id')->on('kurir');
            $table->unsignedBigInteger('id_area');
            $table->foreign('id_area')->references('id')->on('area');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lapak');
    }
};
