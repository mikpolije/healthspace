<?php

use App\Models\JadwalPraktikDokter;
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
        Schema::create('jadwal_praktik_dokters', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('dokter_id')->constrained();
            $table->bigInteger('dokter_id')->nullable();
            $table->string('hari_praktik');
            $table->string('jam_praktik_awal');
            $table->string('jam_praktik_akhir');
            $table->timestamps();
        });

        // JadwalPraktikDokter::create([
        //     'dokter_id'=>1,
        //     'hari_praktik'=>'selasa',
        //     'jam_praktik_awal'=>'12:00',
        //     'jam_praktik_akhir'=>'20:00'
        // ]);
        // JadwalPraktikDokter::create([
        //     'dokter_id'=>1,
        //     'hari_praktik'=>'jumat',
        //     'jam_praktik_awal'=>'08:00',
        //     'jam_praktik_akhir'=>'12:00'
        // ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jadwal_praktik_dokters');
    }
};