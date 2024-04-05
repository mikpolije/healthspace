<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    //

    public function index(){
        $dokter = Dokter::
        leftjoin('polis','dokters.poli_id','polis.id')
        ->leftjoin('users','dokters.user_id','users.id')
        ->select('users.*','polis.nama_poli','dokters.*')->get();
        foreach ($dokter as $d){
            $d->profil = asset('profil/'.$d->profil);
        }
        // return $dokter;
        return view('homepage',compact('dokter'));

    }
}