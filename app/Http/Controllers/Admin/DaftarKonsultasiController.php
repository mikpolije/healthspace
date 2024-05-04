<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CatatanDokter;
use App\Models\Resep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DaftarKonsultasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = DB::table('konsuls')
        ->leftjoin('users','konsuls.pasien_id','users.id')
        ->leftjoin('users as dokter','konsuls.dokter_id','dokter.id')
        ->select('users.nama','dokter.nama as nama_dokter','konsuls.*')
        ->get();
// return $data;
        return view('admin.daftar-konsultasi',compact('data'));
    }

    public function hasil_konsultasi($id){
        $catatan = 
         DB::table('catatan_dokters')
        ->leftjoin('icds','catatan_dokters.diagnosa','icds.code')
        ->select('icds.*','catatan_dokters.*')
        ->where('konsul_id',$id)->first();

        $catatan2 = CatatanDokter::where('konsul_id',$id)->orderBy('id','desc')->first();


        $resep = Resep::where('catatan_dokter_id',$catatan2->id)->get();
        // return [$catatan,$catatan2,$resep];
    
        return view('admin.catatan_resep',compact('catatan','catatan2','resep'));
    }

    public function riwayat_konsul($id){
        $isichat = 
         DB::table('chats')
        ->leftjoin('users','chats')
        ->select('isi_chat.*')
        ->where('konsul_id',$id)->first();

        
        return view('admin.riwayat_konsul',compact('data'));
    }


    /**
     * Show the form for creating a new resource.     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
