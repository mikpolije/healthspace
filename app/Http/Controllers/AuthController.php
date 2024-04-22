<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Konsul;
use App\Models\Pasien;
use App\Models\Poli;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;


class AuthController extends Controller
{
    //
    public function postregister(Request $request)
    {
        $input = $request->all();

        $rules = [

            'password'  => 'required',
            'email'  => 'required',

        ];
        // error message untuk validasi
        $message = [
            'required' => ':attribute tidak boleh kosong!'
        ];
        // instansiasi validator
        $validator = Validator::make($request->all(), $rules, $message);

        // proses validasi
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }


        // if ($request->password != $request->kpassword) {
        //     return redirect()->back()->with('error', 'Password tidak sama');
        // }

        if (User::where('email', '=', $input['email'])->first() == false) {
            $request->merge([
                'role' => 'pasien',
                'password' => bcrypt($request->password),
                'email' => $request->email,

            ]);
         $user=   User::create($request->except(['_token']));
            Pasien::create([
                'user_id'=>$user->id
            ]);

            return redirect('login')->with('message', 'Berhasil Mendaftar');
            // return $i;
        } else {
            // return "eror";
            return redirect()->back()->with('errorr', 'Email sudah terdaftar');
        }
    }
    public function postlogin(Request $request)
    {

        $input = $request->all();

        $rules = [

            'email'     => 'required',
            'password'  => 'required',


        ];
        // error message untuk validasi
        $message = [
            'required' => ':attribute tidak boleh kosong!'
        ];
        // instansiasi validator
        $validator = Validator::make($request->all(), $rules, $message);

        // proses validasi
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }


        if (User::where('email', '=', $input['email'])->first() == true) {
            if (auth()->attempt(array('email' => $input['email'], 'password' => $input['password']))) {

                switch (Auth::user()->role) {
                    case 'admin':

                        return redirect('/admin/dashboard')->with('success', 'Berhasil Login');
                        break;
                    case 'pasien':

                        return redirect('/pasien/dashboard')->with('success', 'Berhasil Login');
                        break;
                    case 'dokter':

                        return redirect('/dokter/dashboard')->with('success', 'Berhasil Login');
                        break;
                    default:
                        return redirect('/login');
                        break;
                }
            } else {
                return redirect()->back()
                    ->with('error', 'Password salah');
            }
        } else {
            return redirect()->back()
                ->with('error', 'Email tidak ada atau belum terdaftar');
        }
        // }
    }

    public function login()
    {
        if (auth()->check()) {
            switch (Auth::user()->role) {
                
                case 'admin':
                    return redirect('/admin/dashboard');
                    break;
                case 'pasien':
                    return redirect('/pasien/dashboard');
                    break;
                case 'dokter':
                    return redirect('/dokter/dashboard');
                    break;
                default:
                    return redirect('/login');
                    break;
            }
            
 
        }
        return view('login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function profil_pasien(){
        $users =DB::table('pasiens')
        ->leftJoin('users','pasiens.user_id','users.id')
        ->select('users.*','pasiens.*')
        ->where('pasiens.user_id',auth()->user()->id)
        ->orderBy('pasiens.id','desc')->first();
        $users->profil = asset('profil/'.$users->profil);
        // return $users;

        return view('pasien.profil-pasien',compact('users'));
    }

    public function profil_pasien_update(Request $request,$id){

        
        $data0 = $request->validate([
            'nama'=>'required',
            // 'email'=>'required',    
        
        ]);
        
        $data = $request->validate([
            'tanggal_lahir'=>'required',
            'alamat'=>'required',
            'berat_badan'=>'required',
            'tinggi_badan'=>'required',
            'no_telp'=>'required',
            'jenis_kelamin'=>'required',
        
        ]);

        if($request->hasFile('foto')){
            $tujuan_upload = public_path('profil');
            $file = $request->file('foto');
            $namaFile = Carbon::now()->format('Ymd') . $file->getClientOriginalName();
            $file->move($tujuan_upload, $namaFile);
            // return $file;
            $data0['profil'] = $namaFile;
        }
    
       $pasien = Pasien::where('id',$id)->first();


    //    if($request->password){
    //     $data0['password']=bcrypt($request->password);
    //     // return $request;
    // }
        $pasien->update($data);
      
        // return $req;
    
        User::where('id',$pasien->user_id)->update($data0);
   
        
        return redirect('pasien/profil-pasien')
        ->with('success',' Profil Pasien Berhasil Diupdate');

    }

    public function profil_dokter(){
        $users =DB::table('dokters')
        ->leftJoin('users','dokters.user_id','users.id')
        ->select('users.*','dokters.*')
        ->where('dokters.user_id',auth()->user()->id)
        ->orderBy('dokters.id','desc')->first();
        $users->profil = asset('profil/'.$users->profil);
        // return $users;
        $poli = Poli::all();

        return view('dokter.profil-dokter',compact('users','poli'));
    }

    public function profil_dokter_update(Request $request,$id){

        // return $request;

        
        $data0 = $request->validate([
            'nama'=>'required',
            'poli_id'=>'required'
            // 'email'=>'required',    
        
        ]);
        
        $data = $request->validate([
            // 'hari_praktik'=>'required',
            // 'jam_praktik'=>'required',
            // 'biaya_layanan'=>'required',
            'poli_id'=>'required'
           
        
        ]);
        

        if($request->hasFile('foto')){
            $tujuan_upload = public_path('profil');
            $file = $request->file('foto');
            $namaFile = Carbon::now()->format('Ymd') . $file->getClientOriginalName();
            $file->move($tujuan_upload, $namaFile);
            // return $file;
            $data0['profil'] = $namaFile;
        }
    
       $d = Dokter::where('id',$id)->first();


        $d->update($data);
      
     
    
        User::where('id',$d->user_id)->update($data0);
   
        
        return redirect('dokter/profil-dokter')
        ->with('success',' Profil Pasien Berhasil Diupdate');

    }



public function redirectToProvider()
{
    return Socialite::driver('google')->redirect();
}
public function handleProviderCallback()
{

    try {

        $user = Socialite::driver('google')->stateless()->user();

        $finduser = User::where('gauth_id', $user->id)->first();

        if($finduser){

            Auth::login($finduser);

            return redirect('/pasien/dashboard')->with('success', 'Berhasil Login');

        }else{
      

            $user = User::create([
                'nama' => $user->name,
                'email' => $user->email,
                'role' =>'pasien',
                'gauth_id'=> $user->id,
                'gauth_type'=> 'google',
                'password' => bcrypt(123),
                'role'=>'pasien',
                'profil'=>'profil.jpg'
                // Tambahkan kolom lain sesuai kebutuhan
            ]);
    
            Pasien::create([
                'user_id'=>$user->id
            ]);

            Auth::login($user);

            return redirect('/pasien/dashboard')->with('success', 'Berhasil Login');
        }

    } catch (Exception $e) {
        dd($e->getMessage());
    }
}

public function kirim(){
    $name = 'elen';
    $email = 'gologand@gmail.com';
    $data = [
        'name' => $name,
        'body' => "Kepada Pengguna : $name. ",
      
   
    ];

    Mail::send('email.lupapassword', $data, function ($message) use ($name, $email) {


        $message->to($email, $name)->subject('Pemberitahuan HealthSpace');
    });

    return $data;
}
}