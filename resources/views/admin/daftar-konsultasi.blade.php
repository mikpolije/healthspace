@extends('layouts.main')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card">

        <div class="card-header bg-success-dark">
            <h6 class="card-title text-white">Daftar Konsultasi
                <!-- <a href="{{url('admin/dokter/create')}}"><button class="btn btn-sm btn-primary float-end">Add</button></a> -->
            </h6>
        </div>

        <div class="card-body">

            <div class="table-responsive" style="min-height:180px;">
                <table class="table" id="tabelku">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pasien</th>
                            <th>Nama Dokter</th>
                            <th>Tanggal Konsultasi</th>
                            <th>Diagnosa</th>


                            <!-- <th width="25%">Actions</th> -->
                       
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach($data as $v)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$v->nama}}</td>
                            <td>{{$v->nama_dokter}}</td>
                            <td>{{$v->tgl_konsultasi}}</td>
                            <td>{{$v->konsultasi}}</td>
                    
                            <td>
                              
                            </td>
                        </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

@endsection