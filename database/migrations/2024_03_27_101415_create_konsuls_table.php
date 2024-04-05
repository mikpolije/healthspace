<?php

use App\Models\Konsul;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('konsuls', function (Blueprint $table) {
            $table->id();
            $table->string('konsultasi');
            $table->string('status_konsultasi');
            $table->date('tgl_konsultasi');
            // $table->foreignId('pasien_id')->constrained();
            // $table->foreignId('dokter_id')->constrained();
            $table->bigInteger('pasien_id')->nullable();
            $table->bigInteger('dokter_id')->nullable();
            
            $table->timestamps();
        });

        // DB::table('konsuls')->insert([
            // [
                // 'konsultasi'=>'mata',
                // 'tgl_konsultasi'=>date('Y-m-d'),
                // 'pasien_id'=>1,
                // 'dokter_id'=>1            
            // ],
        // ]);  
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('konsuls');
    }
};
