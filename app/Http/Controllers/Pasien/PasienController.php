<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Konsul;
use App\Models\Pasien;
use App\Models\Pembayaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PasienController extends Controller
{
    //

    
    protected function initPaymentGateway()
    {
    	// Set your Merchant Server Key
	\Midtrans\Config::$serverKey = 'SB-Mid-server-nF0FfCZfWF7W4OeOxvs1ZqA3';
	// Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
	\Midtrans\Config::$isProduction = false;
	// Set sanitization on (default)
	\Midtrans\Config::$isSanitized = true;
	// Set 3DS transaction for credit card to true
	\Midtrans\Config::$is3ds = true;
    }

    public function prosesbooking(Request $request){

        $this->initPaymentGateway();

        $Pemesan = User::where('id',Auth::user()->id)->first();
        $Pasien = Pasien::where('user_id',Auth::user()->id)->first();
        $paket = Konsul::where('id',$request->konsul_id)->first();

        $Order_id = Str::random(5);
        
        $customerDetails = [
            'first_name' =>$Pemesan->nama,           
            'email' => $Pemesan->email,
            'phone' => $Pasien->no_telp,

        ]; 

        $params = [
            'enable_payments' => ['credit_card', 'mandiri_clickpay', 'cimb_clicks',
                                'bca_klikbca', 'bca_klikpay', 'bri_epay', 'echannel', 'permata_va',
                                'bca_va', 'bni_va', 'other_va', 'gopay', 'indomaret',
                                'danamon_online', 'akulaku'],
            'transaction_details' => [
                'order_id' => $Order_id,
                'gross_amount' => '20000',
            ],
            'customer_details' => $customerDetails,
            'expiry' => [
                'start_time' => date('Y-m-d H:i:s T'),
                'unit' => 'minute',
                'duration' => 30,
            ],
        ];
        // return $params['transaction_details']['order_id'];

        $snap = \Midtrans\Snap::createTransaction($params);


        $book = new Pembayaran();

        // $book->tanggal_pembayaran = $request->input('tanggal_booking');
        // $book->pasien_id =$Pasien->id;
        $book->jumlah_pembayaran =$params['transaction_details']['gross_amount'];
        $book->konsul_id = '1';
        $book->kode_pembayaran = $params['transaction_details']['order_id'];
        $book->status_pembayaran = $request->input('status_pembayaran','pending');
        $book->payment_token = $snap->token;
        $book->payment_url = $snap->redirect_url;
        $book->save();

        $last_id = $book->id;


		// alert()->success('Berhasil','Menambahkan Data Profil');
		return redirect()->route('pemesanan-pending', $last_id)->with(['success' => 'Booking Berhasil']);

    }

        public function bookingcancel($id){

        Pembayaran::where('id',$id)->first()->update([
            'status_pembayaran'=>'cancel'
        ]);
        return redirect('/pemesanan')->with('success', 'Berhasil Membatalkan');
}

    public function bookingpending(){


        $p = Pasien::where('user_id',auth()->user()->id)->first();
    
        $status = Pembayaran::
        leftjoin('konsuls','pembayarans.konsul_id','konsuls.id')
        ->select('konsuls.pasien_id','pembayarans.*')
        ->where('status_pembayaran','pending')->where('konsuls.pasien_id',7)->orderBy('id', 'DESC')->first();

    
         return view('pasien.pemesanan_pending',compact('status'));
   
   
}



public function notification_payment(Request $request){
     //setting key server midtrans ya
        \Midtrans\Config::$clientKey = 'SB-Mid-client-bDo4QQ4exVny80Af';
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = 'SB-Mid-server-nF0FfCZfWF7W4OeOxvs1ZqA3';
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        //mengambil response dari midtrans
        $payload = $request->getContent();
        //melakukan parsing response dari midtrans
        $notification = json_decode($payload);
        // $json = json_decode($request->get('json')); //nama json dipanggil dari token yg awto kepanggil dari API

    // return $notification->transaction_status;

        //melakukan pengecekan status transaksi
        // return $notification->va_numbers[0]->bank;
        if ($notification->transaction_status == "settlement") {
            $p = Pembayaran::where('kode_pembayaran', $notification->order_id)->first();

            $p->update([
                'status_pembayaran' => 'terbayar',
                'tanggal_pembayaran' => date('Y-m-d'),
                'metode_pembayaran'=>$notification->va_numbers[0]->bank

            ]);
            $k = Konsul::where('id',$p->konsul_id)->first();
            $k->update([
                'status_konsultasi'=>'start'
            ]);
            // dd($notification);
            // return $p;
            $pasiens =User::where('id',$k->pasien_id)->first();
            $dokters =User::where('id',$k->dokter_id)->first();

            $pasien =$pasiens->nama ;
            $email_pasien = $pasiens->email;
            $data = [
                'name' => $pasien,
                'body' => "Kepada Pasien : $pasien. ",
              
           
            ];
        
            Mail::send('email.notif_pasien', $data, function ($message) use ($pasien, $email_pasien) {
        
        
                $message->to($email_pasien, $pasien)->subject('Pemberitahuan HealthSpace');
            });

            $dokter =$dokters->nama ;
            $email_dokter =$dokters->email;
            $data = [
                'name' => $dokter,
                'body' => "Kepada Dokter : $dokter. ",
              
           
            ];
        
            Mail::send('email.notif_dokter', $data, function ($message) use ($dokter, $email_dokter) {
        
        
                $message->to($email_dokter, $dokter)->subject('Pemberitahuan HealthSpace');
            });

        } else {
            //selain settlemned menunggu untuk melakukan pembayaran
            return 'menunggu pembayaran';
        }


}

public function return(){
    return 'sukses bayar !!!';
}
}
