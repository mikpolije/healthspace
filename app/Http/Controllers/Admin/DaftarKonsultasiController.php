<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CatatanDokter;
use App\Models\Chat;
use App\Models\Dokter;
use App\Models\Konsul;
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

     public function index_chat($pasien)
     {
 
         $konsul = Konsul::where([
             'pasien_id'=> $pasien
         ])
         ->groupBy('dokter_id')->pluck('dokter_id');
 
         $dokter = Dokter::whereIN('user_id',$konsul)
         ->leftJoin('users','users.id','dokters.user_id')
         ->leftJoin('polis','polis.id','dokters.poli_id')
         ->select('dokters.*','users.nama','users.profil','polis.nama_poli')
         ->get();

         
 
 
         return view('admin.konsultasi',compact('dokter','pasien'));
     }

     public function getChat_riwayat($id,$pasien)
     {
         $user_id = $id;
         $my_id = $pasien;
         $messages = Chat::where(function ($query) use ($user_id, $my_id) {
             $query->where('from_id', $user_id)->where('to_id', $my_id);
         })->oRwhere(function ($query) use ($user_id, $my_id) {
             $query->where('from_id', $my_id)->where('to_id', $user_id);
         })->get();
 
         $konsul = Konsul::where('pasien_id',$my_id)
         ->where('dokter_id',$user_id)
         ->where('status_konsultasi','start')
         ->orderBy('id','DESC')->first();
 
         return response()->json([
             'status_konsultasi'=>$konsul ? 'active' : 'non active',
             'chats'=>$messages
         ]);
     }
 
     public function index(Request $request)
     {
         $search = $request->input('search');
     
         $query = DB::table('konsuls')
             ->leftJoin('users', 'konsuls.pasien_id', 'users.id')
             ->leftJoin('users as dokter', 'konsuls.dokter_id', 'dokter.id')
             ->select('users.nama', 'dokter.nama as nama_dokter', 'konsuls.*')
             ->orderBy('konsuls.tgl_konsultasi', 'desc');
     
         if ($search) {
             $query->where('users.nama', 'LIKE', "%{$search}%")
                 ->orWhere('dokter.nama', 'LIKE', "%{$search}%")
                 ->orWhere('konsuls.tgl_konsultasi', 'LIKE', "%{$search}%")
                 ->orWhere('konsuls.konsultasi', 'LIKE', "%{$search}%");
         }
     
         $data = $query->orderBy('tgl_konsultasi', 'desc')->get();
     
         return view('admin.daftar-konsultasi', compact('data', 'search'));
     }
     
    public function hasil_konsultasi($id)
    {
        $catatan = DB::table('catatan_dokters')
            ->leftjoin('icds', 'catatan_dokters.diagnosa', 'icds.code')
            ->select('icds.*', 'catatan_dokters.*')
            ->where('konsul_id', $id)
            ->first();
    
        $catatan2 = CatatanDokter::where('konsul_id', $id)->orderBy('id', 'desc')->first();
    
        if ($catatan2) {
            $resep = Resep::where('catatan_dokter_id', $catatan2->id)->get();
            return view('admin.catatan_resep', compact('catatan', 'catatan2', 'resep'));
        } else {
            // Jika data catatan2 tidak ditemukan, tampilkan blade data_null
            return view('admin.no_catatan_resep');
        }
    }

    public function no_catatan_resep($id)
    {
        return view('admin.no_catatan_resep', ['id' => $id]);
    }


    /**
     * Show the form for creating a new resource.
     *
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
