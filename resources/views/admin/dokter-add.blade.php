@extends('layouts.main')

@section('content')
<br>
<h5 class="fw-semibold">
    <a href="{{url('admin/dokter')}}"><i class="ti ti-arrow-left bg-danger rounded-circle text-white"></i>Kembali</a>
    Tambah Dokter
</h5>

<div class="card">
    <div class="card-body">
        <form action="{{url('admin/dokter')}}" method="post" enctype="multipart/form-data">
            @csrf

             <div class="form-group">
                <label for="" class="form-label">Nama</label>
                <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama">
            </div>
            <div class="form-group">
                <label for="" class="form-label">Email</label>
                <input type="text" class="form-control @error('email') is-invalid @enderror" name="email">
            </div>
            <div class="form-group">
                <label for="" class="form-label">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password">
            </div> 
            <div class="form-group">
                <label for="" class="form-label">Spesialis</label>
                <input type="text" class="form-control @error('spesialis') is-invalid @enderror" name="spesialis">
            </div> 

            <div class="form-group">
                <label for="" class="form-label">Biaya Layanan</label>
                <input type="text" class="form-control @error('biaya_layanan') is-invalid @enderror" name="biaya_layanan">
            </div>

            <div class="form-group">
                <label for="" class="form-label">Poli</label>
                <select name="poli_id" class="form-control">
                    @foreach($poli as $v)
                    <option value="{{$v->id}}">{{$v->nama_poli}}</option>
                    @endforeach
                </select>
            </div>




            <button type="submit" class="btn btn-success float-end mt-3">Tambah</button>

        </form>
    </div>
</div>

@endsection

@push('js')

@endpush