@extends('layouts.main')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card">

        <div class="card-header bg-success-dark">
            <h6 class="card-title text-white">Jadwal Praktik Dokter :{{$dokter->nama}}
                <a href="{{url('dokter/jadwal_praktik/create',$id_dokter)}}"><button class="btn btn-sm btn-primary float-end">Add</button></a>
            </h6>
        </div>

        <div class="card-body">

            <div class="table-responsive" style="min-height:180px;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Hari Praktik</th>
                            <th>Jam Praktik</th>
                            <th width="25%">Actions</th>
                           
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach($jadwal as $v)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$v->hari_praktik}}</td>
                            <td>{{$v->jam_praktik_awal}} - {{$v->jam_praktik_akhir}}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{url('dokter/jadwal_praktiks/'.$v->id)}}"><i
                                                class="bx bx-edit-alt me-1"></i> Edit</a>
                                        <a class="dropdown-item" href="{{url('dokter/jadwal_praktik/hapus/'.$v->id)}}"><i
                                                class="bx bx-trash me-1"></i> Delete</a>
                                    </div>
                                </div>
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