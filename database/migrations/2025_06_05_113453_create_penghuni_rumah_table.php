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
        Schema::create('penghuni_rumah', function (Blueprint $table) {
            $table->increments('id_penghuni_rumah');
            $table->unsignedBigInteger('id_penghuni');
            $table->unsignedBigInteger('id_rumah');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->foreign('id_penghuni')->references('id')->on('penghuni')->onDelete('cascade');
            $table->foreign('id_rumah')->references('id')->on('rumah')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penghuni_rumah');
    }
};
