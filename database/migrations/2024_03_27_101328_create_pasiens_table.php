<?php

use App\Models\Pasien;
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
        Schema::create('pasiens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('jenis_kelamin')->nullable();
            $table->string('no_telp')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('alamat')->nullable();
            $table->integer('berat_badan')->nullable();
            $table->integer('tinggi_badan')->nullable();
            $table->timestamps();
        });

        DB::table('pasiens')->insert([
            [
                'user_id'=>2, 
                'jenis_kelamin'=>'Perempuan',
                'no_telp'=>'08213131',
                'tanggal_lahir'=>'2003-07-07',
                'alamat'=>'Jakarta',
                'berat_badan'=>35,
                'tinggi_badan'=>175,          
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
        Schema::dropIfExists('pasiens');
    }
};
