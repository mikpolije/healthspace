<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatatanDokter extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function reseps()
    {
        return $this->hasMany(Resep::class, 'catatan_dokter_id');
    }

}