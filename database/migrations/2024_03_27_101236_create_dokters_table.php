<?php

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
        Schema::create('dokters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('poli_id')->constrained();
            // $table->string('hari_praktik');
            // $table->string('spesialis');
            $table->integer('biaya_layanan');

            $table->timestamps();
        });

        DB::table('dokters')->insert([
            [
                'user_id'=>3,
                'poli_id'=>1,
                'biaya_layanan'=>15000
            ],

            [
                'user_id'=>4,
                'poli_id'=>1,
                'biaya_layanan'=>15000
            ],

            [
                'user_id'=>5,
                'poli_id'=>1,
                'biaya_layanan'=>15000
            ],

            [
                'user_id'=>6,
                'poli_id'=>2,
                'biaya_layanan'=>15000
            ],
        ]);  
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dokters');
    }
};
