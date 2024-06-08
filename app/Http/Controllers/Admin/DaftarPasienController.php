<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DaftarPasienController extends Controller
{
    public function index(Request $request)
{
    $query = DB::table('pasiens')
             ->leftJoin('users', 'pasiens.user_id', '=', 'users.id')
             ->select('users.nama', 'pasiens.*')
             ->orderBy('pasiens.created_at', 'desc'); // Order by the created_at timestamp in descending order
    
    // Check if search parameters are provided
    if ($request->has('search')) {
        $search = $request->search;
        // Add conditions for searching name or gender
        $query->where('users.nama', 'like', '%' . $search . '%')
              ->orWhere('pasiens.jenis_kelamin', 'like', '%' . $search . '%');
    }

    // Get the filtered results
    $data = $query->get();

    return view('admin.daftar-pasien', compact('data'));
}


    public function create()
    {
       
        return view('admin.daftar-pasien-add');
    }

    public function store(Request $request){
      

        $data0 = $request->validate([
            'nama'=>'required',
            'email'=>'required',
            'password'=>'required',
          
        
        ]);
        $data0['password']=bcrypt($request->password);
        $data0['role']='dokter';
        
        $data = $request->validate([
            'spesialis'=>'required',
            'poli_id'=>'required',
            'biaya_layanan'=>'required',
            // 'jam_praktik'=>'required',
        
        ]);

        $user = User::create($data0);

        $data['user_id']=$user->id;
       Pasien::create($data);
   
        
        return redirect('admin/daftar-pasien')
        ->with('success','Data Pasien Berhasil Ditambah');
    }

    public function show($id){
         $data =DB::table('pasiens')
         ->leftJoin('users','pasiens.user_id','users.id')
         ->select('users.nama','pasiens.*')
        ->where('pasiens.id',$id)
        ->orderBy('pasiens.id','desc')->first();
       
        return view('admin.dokter-edit',compact('data','id'));
    }

    public function updates(Request $request,$id){

    
        $data0 = $request->validate([
            'nama'=>'required',
            'email'=>'required',    
        
        ]);
        
        $data = $request->validate([
            'spesialis'=>'required',
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
   
        
        return redirect('admin/pasien')
        ->with('success','Data Pasien Berhasil Diupdate');

    }

    public function destroy($id){
        $d =Pasien::where('id',$id)->first();
        if($d){
            $d->delete();
            // User::where('id',$d->user_id)->delete();
        }
        

        return redirect()->back()
        ->with('success','Data Pasien Berhasil Dihapus');
    }

}