<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chat;
use Pusher\Pusher;
use App\Models\Konsul;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\icds;
use App\Models\CatatanDokter;
use App\Models\Resep;
use DB;

class KonsultasiController extends Controller
{
    public function index()
    {
        $icds = icds::all();
        $konsul = Konsul::where([
            'dokter_id'=> auth()->user()->id
        ])
        ->groupBy('pasien_id')->pluck('pasien_id');

        $pasien = Pasien::whereIN('user_id',$konsul)
        ->leftJoin('users','users.id','pasiens.user_id')
        ->select('pasiens.*','users.nama','users.profil')
        ->get();

        return view('dokter.konsultasi',compact('pasien','icds'));
    }

    public function sendChat(Request  $request)
    {

        $from = auth()->user()->id;
        $to = $request->to;
        $konsul = Konsul::where('dokter_id',$from)
        ->where('pasien_id',$to)
        ->orderBy('id','DESC')->first();

        if(!$konsul){
            return response()->json(['status'=>'Tidak ada jadwal konsultasi']);
        }

        if($request->has('type')){
            switch ($request->type) {
                case 'end chat':
                    $kons = Konsul::where('dokter_id',$from)
                    ->where('pasien_id',$to)
                    ->where('status_konsultasi','start')
                    ->orderBy('id','DESC')->first();
                    if(!$kons){
                        return response()->json(['status_konsul'=>false]);
                    }
                    Konsul::where('id',$konsul->id)->update(['status_konsultasi'=>'berakhir']);
                    $chat = Chat::create([
                        'from_id'=>$from,
                        'to_id'=>$to,
                        'konsul_id'=>$konsul->id,
                        'type'=>$request->type,
                        'isi_chat'=>$request->isi_chat
                    ]);
                    break;
                
                default:
                        $chat = Chat::create([
                            'from_id'=>$from,
                            'to_id'=>$to,
                            'konsul_id'=>$konsul->id,
                            'isi_chat'=>$request->isi_chat
                        ]);
                    break;
            }
        }else{
            $chat = Chat::create([
                'from_id'=>$from,
                'to_id'=>$to,
                'konsul_id'=>$konsul->id,
                'isi_chat'=>$request->isi_chat
            ]);
        }
        $data = ['from' => $from, 'to' => $to, 'isi_chat'=>$chat];
        $this->sendToPusher($data);
    }

    public function sendToPusher($d)
    {
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

        $data = $d;
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
        })
        ->get();

        $status_konsul = Konsul::where('pasien_id',$user_id)->where('dokter_id',$my_id)->where('status_konsultasi','start')->first();

        return response()->json([
            'status_konsul'=> $status_konsul ? true : false,
            'chats'=>$messages
        ]);
    }

    public function kirimCatatan(Request $request)
    {
        $to = $request->to;
        $me = auth()->user()->id;
        $konsul = Konsul::where("pasien_id",$to)
        ->where("dokter_id",$me)->latest('id')->first();
        $catatan_id = CatatanDokter::create([
            "konsul_id"=>$konsul->id,
            "gejala"=>$request->gejala,
            "saran"=>$request->saran,
            "diagnosa"=>$request->diagnosa
        ])->id;
        $chat = Chat::create([
            "konsul_id"=>$konsul->id,
            "from_id"=>$me,
            "to_id"=>$to,
            "isi_chat"=>$catatan_id,
            "type"=>"catatan"
        ]);
        $data = ['from' => $me, 'to' => $to, 'isi_chat'=>$chat];
        $this->sendToPusher($data);
        return response()->json(["id_catatan"=>$catatan_id]);
    }

    public function kirimResep(Request $request)
    {
        $to = $request->to;
        $me = auth()->user()->id;
        $data_catatan = json_decode($request->data_catatan);
        $konsul = Konsul::where("pasien_id",$to)
        ->where("dokter_id",$me)->latest('id')->first();
        $catatan_id = CatatanDokter::create([
            "konsul_id"=>$konsul->id,
            "gejala"=>' ',
            "saran"=>' ',
            "diagnosa"=>' '
        ])->id;
        foreach($data_catatan as $catat){
            Resep::create([
                "catatan_dokter_id"=>$catatan_id,
                "nama_obat"=>$catat->nama_obat,
                "jumlah"=>$catat->jumlah,
                "dosis"=>$catat->dosis
            ]);
        }
        $chat = Chat::create([
            "konsul_id"=>$konsul->id,
            "from_id"=>$me,
            "to_id"=>$to,
            "isi_chat"=>$catatan_id,
            "type"=>"resep"
        ]);
        $data = ['from' => $me, 'to' => $to, 'isi_chat'=>$chat];
        $this->sendToPusher($data);
        return response()->json(["id_catatan"=>$catatan_id]);
    }

    public function getIcds(Request $request)
    {
        if ($request->ajax())
                {
                    $page = $request->page;
                    $resultCount = 25;

                    $offset = ($page - 1) * $resultCount;

                    $breeds = icds::where('name_en', 'LIKE',  '%' . $request->term. '%')->orderBy('name_en')->skip($offset)->take($resultCount)->get();

                    $count = icds::count();
                    $endCount = $offset + $resultCount;
                    $morePages = $endCount > $count;

                    $results = array(
                    "results" => $breeds,
                    "pagination" => array(
                        "more" => $morePages
                    )
                    );

                    return response()->json($results);
                }
    }


}
