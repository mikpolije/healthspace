@ -1,164 +1,166 @@
<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Konsul;
use Carbon\Carbon;
use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\JadwalPraktikDokter;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DashboardPasienController extends Controller
{
    public function index()
    {
        $datadokter = User::where('role','dokter')
        ->join('dokters','dokters.user_id','users.id')
        ->select('users.nama','users.id','users.profil','dokters.biaya_layanan')
        ->get();
        foreach($datadokter as $d){
        $jadwal =JadwalPraktikDokter::where('dokter_id',$d->id)->get();
        $d->jadwal_praktik = $jadwal;
        $d->profil =asset('profil/'.$d->profil);

        }
        $konsul = Konsul::where('pasien_id',auth()->user()->id)->count();
        $konsulterbaru = Konsul::where('pasien_id',auth()->user()->id)->orderBy('id','desc')->limit(2)->get();
        $chat_terbaru = Chat::join('users','chats.from_id','users.id')
        ->select('users.nama','chats.*')
        ->where('to_id',auth()->user()->id)->orderBy('id','desc')->limit(2)->get();
        foreach($chat_terbaru as $c){
            $c->tanggal = date('Y-m-d', strtotime($c->updated_at));
        }
        // return $chat_terbaru;
        // return $konsulterbaru;


        // return $datadokter;
        $pemesanan = DB::table('pembayarans')
        ->join('konsuls','pembayarans.konsul_id','konsuls.id')
        ->select('konsuls.*','pembayarans.*')->orderBy('pembayarans.id','desc')
        ->where('konsuls.pasien_id',auth()->user()->id)->first();
    // return $pemesanan;


 
    if($pemesanan==null){
        return view('pasien.dashboard',compact('datadokter','konsul','chat_terbaru'));
    }else{

        if($pemesanan->status_pembayaran=='pending'){
            // return view('pasien.dashboard',compact('datadokter','konsul'));
            return redirect('pasien/pemesanan/'.$pemesanan->id);
        }else{
            // if($pemesanan->status_konsultasi=='start'){
            //     return redirect('pasien/konsultasi');
            //     // return view('pasien.dashboard',compact('datadokter','konsul','chat_terbaru'));
            // }else{
                // return redirect('pasien/konsultasi');
                return view('pasien.dashboard',compact('datadokter','konsul','chat_terbaru'));
            // }

        
        }

    }
        


  
     
    }


    protected function initPaymentGateway()
    {
        \Midtrans\Config::$serverKey = 'SB-Mid-server-nF0FfCZfWF7W4OeOxvs1ZqA3';
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
    }

    public function pemesanan(Request $request)
    {
        $this->initPaymentGateway();
        $konsul = Konsul::create([
            'dokter_id' =>$request->dokter_id,
            'pasien_id'=>auth()->user()->id,
            'konsultasi'=>$request->konsultasi,
            'tgl_konsultasi'=> Carbon::now(),
            'status_konsultasi'=>'pending'
        ]);


        $Order_id = Str::random(5);
        
        $customerDetails = [
            'first_name' =>auth()->user()->nama,           
            'email' => auth()->user()->email,
            'phone' => Pasien::where('user_id',auth()->user()->id)->first()->no_telp,
        ]; 

        $params = [
            'enable_payments' => ['credit_card', 'mandiri_clickpay', 'cimb_clicks',
                                'bca_klikbca', 'bca_klikpay', 'bri_epay', 'echannel', 'permata_va',
                                'bca_va', 'bni_va', 'other_va', 'gopay', 'indomaret',
                                'danamon_online', 'akulaku'],
            'transaction_details' => [
                'order_id' => $Order_id,
                'gross_amount' => Dokter::where('user_id',$request->dokter_id)->first()->biaya_layanan,
            ],
            'customer_details' => $customerDetails,
            'expiry' => [
                'start_time' => date('Y-m-d H:i:s T'),
                'unit' => 'days',
                'duration' => 7,
            ],
        ];

        $snap = \Midtrans\Snap::createTransaction($params);


        $book = new Pembayaran();


        $book->jumlah_pembayaran =$params['transaction_details']['gross_amount'];
        $book->konsul_id = $konsul->id;
        $book->kode_pembayaran = $params['transaction_details']['order_id'];
        $book->status_pembayaran = $request->input('status_pembayaran','pending');
        $book->payment_token = $snap->token;
        $book->payment_url = $snap->redirect_url;
        $book->save();

        $last_id = $book->id;

        return redirect('pasien/pemesanan/'.$last_id);
    }

    public function pemesanan_view($id)
    {
        $pemesanan = Pembayaran::where('id',$id)->first();
        $konsultasi = Konsul::where('konsuls.id',$pemesanan->konsul_id)
        ->leftJoin('users','users.id','konsuls.dokter_id')
        ->leftJoin('dokters','users.id','dokters.user_id')
        ->select('konsuls.*','users.nama')
        ->first();

        if($pemesanan->status_pembayaran=='pending'){
            return view('pasien.pemesanan_view',compact('pemesanan','konsultasi'));
        }else{
            return redirect('pasien/konsultasi');
        }

       
    }
}
