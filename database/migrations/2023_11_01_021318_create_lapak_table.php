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
            $table->id("id_lapak");
            $table->string('nama_lapak');
            $table->string('alamat_lapak');
            $table->string('contact_lapak');
            $table->string('image');
            $table->unsignedBigInteger('area_id');
            $table->foreign('area_id')->references('id')->on('area');
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