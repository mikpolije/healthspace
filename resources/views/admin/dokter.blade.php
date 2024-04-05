@extends('layouts.main')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card">

        <div class="card-header bg-success-dark">
            <h6 class="card-title text-white">Dokter
                <a href="{{url('admin/dokter/create')}}"><button class="btn btn-sm btn-primary float-end">Add</button></a>
            </h6>
        </div>

        <div class="card-body">

            <div class="table-responsive" style="min-height:180px;">
                <table class="table" id="tabelku">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Poli</th>
                            
                            <th width="25%">Actions</th>
                           
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach($data as $v)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$v->nama}}</td>
                            <td>{{$v->nama_poli}}</td>
                      
                                 
                            <td class="d-flex">
                                        <a class="dropdown-item" href="{{url('admin/dokter/'.$v->id)}}"><i
                                                class="bx bx-edit-alt me-1"></i> </a>
                                        <a class="dropdown-item" href="{{url('admin/dokter/hapus/'.$v->id)}}"><i
                                                class="bx bx-trash me-1"></i> </a>
                                                <a
                                    href="{{url('dokter/jadwal_praktik',$v->user_id)}}"><span
                                        class="badge bg-primary rounded-3 fw-semibold">Jadwal Praktik Dokter</span></a>
                                 
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
