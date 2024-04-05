<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

class users extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add User::create() statements
        User::create([
            'nama' => 'Admin',
            'role' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt(123),
            'profil' => 'profil.jpg'
        ]);
        User::create([
            'nama' => 'Pasien Elen',
            'role' => 'pasien',
            'email' => 'pasien@gmail.com',
            'password' => bcrypt(123),
            'profil' => 'profil.jpg'
        ]);
        User::create([
            'nama' => 'Dokter Oliv',
            'role' => 'dokter',
            'email' => 'dokter@gmail.com',
            'password' => bcrypt(123),
            'profil' => 'doctor.png'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Implement if needed
    }
}
