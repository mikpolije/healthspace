@extends('layouts.main')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card">

        <div class="card-header bg-success-dark">
            <h6 class="card-title text-white">Daftar Pasien
                <!-- <a href="{{url('admin/daftar-pasien/create')}}"><button class="btn btn-sm btn-primary float-end">Add</button></a> -->
            </h6>
        </div>

        <div class="card-body">

            <div class="table-responsive" style="min-height:180px;">
                <table class="table" id="tabelku">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th width="20%">Nama</th>
                            <th width="20%">Jenis Kelamin</th>
                            <th width="20%">Tanggal Lahir</th>
                            <th>Alamat</th>
                            <th>TB</th>
                            <th>BB</th>
                            <th width="25%">Actions</th>

                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach($data as $v)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$v->nama}}</td>
                            <td>{{$v->jenis_kelamin}}</td>
                            <td>{{$v->tanggal_lahir}}</td>
                            <td>{{$v->alamat}}</td>
                            <td>{{$v->tinggi_badan}}</td>
                            <td>{{$v->berat_badan}}</td>
                            <!-- <td class="d-flex">
                                <a class="dropdown-item me-2" href="{{ url('admin/daftar-pasien/'.$v->id) }}">
                                    <i class="bx bx-edit-alt me-1"></i> 
                                </a>
                                </td>  -->
                            <td class="d-flex">
                                <a class="dropdown-item" href="{{ url('admin/daftar-pasien/hapus/'.$v->id) }}">
                                    <i class="bx bx-trash me-1"></i> 
                                </a>
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