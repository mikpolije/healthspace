<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Poli;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DokterController extends Controller
{
    public function index()
    {
        $data =DB::table('dokters')
        ->leftJoin('polis','dokters.poli_id','polis.id')
        ->leftJoin('users','dokters.user_id','users.id')
        ->select('users.nama','polis.*','dokters.*')
        ->orderBy('dokters.id','desc')->get();
        // return $data;
        return view('admin.dokter',compact('data'));
    }

    public function create()
    {
        $poli = Poli::all();
        return view('admin.dokter-add',compact('poli'));
    }

    public function store(Request $request){
      

        $data0 = $request->validate([
            'nama'=>'required',
            'email'=>'required',
            'password'=>'required',
            'poli_id'=>'required',

          
        
        ]);
        $data0['password']=bcrypt($request->password);
        $data0['role']='dokter';
        
        $data = $request->validate([
            'biaya_layanan'=>'required',
            'poli_id'=>'required',
            'biaya_layanan'=>'required',
            // 'jam_praktik'=>'required',
        
        ]);

        $data0['profil']='doctor.png';
        $user = User::create($data0);

        $data['user_id']=$user->id;
        // $data['profil']='doctor.png';
        
        
       Dokter::create($data);
   
        
        return redirect('admin/dokter')
        ->with('success','Data Dokter Berhasil Ditambah');
    }

    public function show($id){
         $data =DB::table('dokters')
        ->leftJoin('polis','dokters.id','polis.id')
        ->leftJoin('users','dokters.user_id','users.id')
        ->select('users.*','polis.nama_poli','dokters.*')
        ->where('dokters.id',$id)
        ->orderBy('dokters.id','desc')->first();
        $poli = Poli::all();
        return view('admin.dokter-edit',compact('data','poli','id'));
    }

    public function updates(Request $request,$id){

    
        $data0 = $request->validate([
            'nama'=>'required',
            'email'=>'required',   
            'poli_id'=>'required', 
        
        ]);
        
        $data = $request->validate([
            'biaya_layanan'=>'required',
            'poli_id'=>'required',
            'biaya_layanan'=>'required',
 
        
        ]);


    
       $dokter = Dokter::where('id',$id)->first();


       if($request->password){
        $data0['password']=bcrypt($request->password);
        // return $request;
    }
        $dokter->update($data);
        User::where('id',$dokter->user_id)->update($data0);
   
        
        return redirect('admin/dokter')
        ->with('success','Data Dokter Berhasil Diupdate');

    }

    public function destroy($id){
        $d =Dokter::where('id',$id)->first();
        if($d){
            $d->delete();
            // User::where('id',$d->user_id)->delete();
        }
        

        return redirect()->back()
        ->with('success','Data Dokter Berhasil Dihapus');
    }

}
