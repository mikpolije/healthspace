<?php

use App\Models\User;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->string('role');
            $table->string('email')->unique();
            // $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('profil')->nullable();
            $table->string('poli_id')->nullable();
            $table->string('google_id')->nullable();
            $table->string('gauth_type')->nullable();
            $table->string('gauth_id')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
        User::create([
            'nama' => 'Admin',
            'role' =>'admin',
            'email' =>'admin@gmail.co',
            'password'=>bcrypt(123),
            'profil'=>'profil.jpg'
        ]);
        User::create([
            'nama' => 'Pasien Elen',
            'role'=>'pasien',
            'email'=>'pasien@gmail.co',
            'password'=>bcrypt(123),
            'profil'=>'profil.jpg'
        ]);
        
        User::create([
            'nama' => 'dr. Faiqotul M.',
            'role'=>'dokter',
            'email'=>'faiqotul@gmail.co',
            'password'=>bcrypt(123),
            'profil'=>'doctor.png',
            'poli_id'=>'1'
        ]);
        
        User::create([
            'nama' => 'dr. Achmad Fawaid',
            'role'=>'dokter',
            'email'=>'achmad@gmail.co',
            'password'=>bcrypt(123),
            'profil'=>'doctor.png',
            'poli_id'=>'1'
        ]);

        User::create([
            'nama' => 'dr. Ayunda Afdal',
            'role'=>'dokter',
            'email'=>'ayunda@gmail.co',
            'password'=>bcrypt(123),
            'profil'=>'doctor.png',
            'poli_id'=>'1'
        ]);

        User::create([
            'nama' => 'drg. Salsabila Q.',
            'role'=>'dokter',
            'email'=>'salsabila@gmail.co',
            'password'=>bcrypt(123),
            'profil'=>'doctor.png',
            'poli_id'=>'2'
        ]);
  
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
