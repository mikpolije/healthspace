@extends('layouts.main')

@section('content')


<div class="card-header bg-success-dark">
            <h6 class="card-title text-white">Catatan
         
            </h6>
        </div>
<div class="table-responsive">
    <table class="table">
        <tbody>
            <tr>
                <th class='w-25'>Gejala</th>
                <td>: {{$catatan->gejala}}</td>
            </tr>
            <tr>
                <th>Saran</th>
                <td>: {{$catatan->saran}}</td>
            </tr>
            <tr>
                <th>Diagnosa</th>
                <td>
                    <p>: {{$catatan->name_id}}</p>
                    <p class="fst-italic">{{$catatan->name_en}}</p>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="card-header bg-success-dark">
            <h6 class="card-title text-white">Resep
         
            </h6>
        </div>
<div class="card-body">

    <div class="table-responsive" style="min-height:180px;">
        <table class="table" id="tabelku">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Obat</th>
                    <th>Jumlah</th>
                    <th>Dosis</th>



                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach($resep as $v)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$v->nama_obat}}</td>
                    <td>{{$v->jumlah}}</td>
                    <td>{{$v->dosis}}</td>



                </tr>
                @endforeach


            </tbody>
        </table>
    </div>

</div>
@endsection