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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_penghuni');
            $table->unsignedBigInteger('id_rumah');
            $table->unsignedBigInteger('id_iuran');
            $table->integer('periode_bulan'); //bulan yang dibayar(1-12)
            $table->integer('periode_tahun'); 
            $table->date('tanggal_bayar'); 
            $table->enum('status_lunas',['lunas','belum']);
            $table->foreign('id_penghuni')->references('id')->on('penghuni')->onDelete('cascade');
            $table->foreign('id_rumah')->references('id')->on('rumah')->onDelete('cascade');
            $table->foreign('id_iuran')->references('id')->on('iuran')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
