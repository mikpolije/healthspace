<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konsul extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function last_chat()
    {
        return $this->hasOne(Chat::class)->where('type','text')->orderBy('id', 'DESC');
    }
    public function dokter()
    {
        return $this->belongsTo(User::class,'dokter_id');
    }
    public function pasien()
    {
        return $this->belongsTo(User::class,'pasien_id');
    }
}