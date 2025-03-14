<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class DaftarInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function index(Request $request)
     {
         $searchNama = $request->get('search_nama'); // Get the search keyword for name
         $searchStatus = $request->get('search_status'); // Get the search keyword for status
     
         // Query to fetch data with joins
         $query = DB::table('pembayarans')
             ->leftjoin('konsuls', 'pembayarans.konsul_id', 'konsuls.id')
             ->leftjoin('users', 'konsuls.pasien_id', 'users.id')
             ->select('users.nama', 'konsuls.*', 'pembayarans.*')
             ->orderBy('pembayarans.tanggal_pembayaran', 'desc');

         // If search keyword for name is provided, add a where clause to filter the results
         if (!empty($searchNama)) {
             $query->where('users.nama', 'like', '%' . $searchNama . '%');
         }
     
         // If search keyword for status is provided, add a where clause to filter the results
         if (!empty($searchStatus)) {
             $query->where('pembayarans.status_pembayaran', $searchStatus);
         }
     
         // Execute the query
         $data = $query->get();
     
         return view('admin.daftar-invoice', compact('data'));
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