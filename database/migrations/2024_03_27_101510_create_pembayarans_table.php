<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pembayaran');
            $table->foreignId('konsul_id')->constrained()->nullable();
            $table->string('jumlah_pembayaran');
            $table->string('tanggal_pembayaran')->nullable();
            $table->string('metode_pembayaran')->nullable();
            $table->string('payment_token');
            $table->string('payment_url');
            $table->string('status_pembayaran');





            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembayarans');
    }
};
