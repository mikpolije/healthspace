<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\JadwalPraktikDokter;
use App\Models\User;
use Illuminate\Http\Request;

class JadwalPraktikDokterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //
    public function index_jadwal($id_dokter)
    {
        //
        $jadwal = JadwalPraktikDokter::where('dokter_id', $id_dokter)->get();
        // $dokter0 = Dokter::where('id',$id_dokter)->first();
        $dokter = User::where('id',$id_dokter)->first();
        return view('dokter.jadwal_praktik_dokter', compact('jadwal','dokter','id_dokter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id_dokter)
    {
        // $dokter0 = Dokter::where('id',$id_dokter)->first();
        return view('dokter.jadwal_praktik_dokter-add',compact('id_dokter'));
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

        $hari = JadwalPraktikDokter::pluck('hari_praktik')->toArray(); 

        // if (in_array($request->hari_praktik, $hari)) {
        //     return redirect()->back()
        //     ->with('error','Hari Praktik Sudah ada,Silahkan Pilih Hari Praktik yang belum dipilih');
        
        // } else {
            $data = $request->validate([
                'hari_praktik'=>'required',
                'jam_praktik_awal'=>'required',
                'jam_praktik_akhir'=>'required',
                'dokter_id'=>'required',
                
            
            ]);
           JadwalPraktikDokter::create($data);
       
            
            return redirect('dokter/jadwal_praktik/'.$request->dokter_id)
            ->with('success','Data Jadwal Praktik Dokter Berhasil Ditambah');
        // }
      
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
        $data = JadwalPraktikDokter::where('id',$id)->first();
        return view('dokter.jadwal_praktik_dokter-edit',compact('data','id'));
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
    public function updates(Request $request, $id)
    {
        //
        $data = $request->validate([
            'hari_praktik'=>'required',
            'jam_praktik_awal'=>'required',
            'jam_praktik_akhir'=>'required',
       
            
        
        ]);
       JadwalPraktikDokter::where('id',$id)->update($data);
   
        
        return redirect('dokter/jadwal_praktik/'.$request->dokter_id)
        ->with('success','Data Jadwal Praktik Dokter Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        JadwalPraktikDokter::destroy($id);
        

        return redirect()->back()
        ->with('success','Data Jadwal Praktik Dokter Berhasil Dihapus');
    }
}
