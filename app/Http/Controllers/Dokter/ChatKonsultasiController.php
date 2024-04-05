<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatKonsultasiController extends Controller
{
    //
    public function konsultasi(){
       $icd= DB::table('icds')->get();
       return view('dokter.chat_pasien',compact('icd'));
        return $icd; 
    }
}