<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chat;
use Pusher\Pusher;
use App\Models\Konsul;
use App\Models\Dokter;

class KonsultasiController extends Controller
{
    public function index()
    {

        $konsul = Konsul::where([
            'pasien_id'=> auth()->user()->id
        ])
        ->groupBy('dokter_id')->pluck('dokter_id');

        $dokter = Dokter::whereIN('user_id',$konsul)
        ->leftJoin('users','users.id','dokters.user_id')
        ->leftJoin('polis','polis.id','dokters.poli_id')
        ->select('dokters.*','users.nama','users.profil','polis.nama_poli')
        ->get();


        return view('pasien.konsultasi',compact('dokter'));
    }

    public function sendChat(Request  $request)
    {

        $from = auth()->user()->id;
        $to = $request->to;
        $konsul = Konsul::where('pasien_id',$from)
        ->where('dokter_id',$to)
        ->orderBy('id','DESC')->first();

        $chat = Chat::create([
            'from_id'=>$from,
            'to_id'=>$to,
            'konsul_id'=>$konsul->id,
            'isi_chat'=>$request->isi_chat
        ]);

        $options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $data = ['from' => $from, 'to' => $to, 'isi_chat'=>$chat];
        $pusher->trigger('my-channel', 'my-event', $data);
    }

    public function getChat($id)
    {
        $user_id = $id;
        $my_id = auth()->user()->id;
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

}
