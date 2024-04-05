@extends('layouts.main')

@section('content')
<br/>
<h5 class="fw-semibold">
<a href="{{ url('pasien/dashboard') }}">
    <i class="fas fa-arrow-left bg-danger rounded-circle text-white"></i> Kembali
</a>

Edit Profil Pasien</h5>
<div class="section mb-5 p-2">
    <form action="{{url('pasien/profil_pasien_update',$users->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        <!-- <div class="card">
            <div class="card-body">
            <div class="text-center mb-3">
                    <img src="{{asset('public/images/profil/'.auth()->user()->foto)}}" alt="Profil Image" class="rounded-circle" width="100" height="100">
                    <input type="file" name="foto" accept="image/*">
                </div>

                <div class="form-group basic">
                    <div class="input-wrapper">
                        <label class="label" for="email">Email</label>
                        <input type="email" class="form-control"
                            value="{{$users->email }}" name="email"
                            id="email" placeholder="Email">
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                    </div>
                </div>

                <div class="form-group basic">
                    <div class="input-wrapper">
                        <label class="label" for="name">Nama</label>
                        <input type="text" class="form-control"
                            value="{{auth()->user()->nama}}" name="nama"
                            id="nama" placeholder="Nama">
                      
                    </div>
                </div>

                <div class="form-group basic">
                    <div class="input-wrapper">
                        <label class="label" for="name">Tanggal Lahir</label>
                        <input type="date" class="form-control"
                            value="" name="tanggal_lahir"
                            id="tanggal_lahir" placeholder="Tanggal Lahir">
                    </div>
                </div>
   
                <div class="form-group basic">
                    <div class="input-wrapper">
                        <label class="label" for="name">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control">
                    <option value="Laki-Laki">Laki-Laki</option>
                    <option value="Perempuan">Perempuan</option>
        
                </select>
                    </div>
                </div>

                <div class="form-group basic">
                    <div class="input-wrapper">
                        <label class="label" for="name">No Telepon</label>
                        <input type="date" class="form-control"
                            value="" name="tanggal_lahir"
                            id="tanggal_lahir" placeholder="Tanggal Lahir">
                    </div>
                </div>
                <div class="form-group basic">
                    <div class="input-wrapper">
                        <label class="label" for="name">Alamat</label>
                        <input type="date" class="form-control"
                            value="" name="tanggal_lahir"
                            id="tanggal_lahir" placeholder="Tanggal Lahir">
                    </div>
                </div>
                <div class="form-group basic">
                    <div class="input-wrapper">
                        <label class="label" for="name">Berat Badan</label>
                        <input type="date" class="form-control"
                            value="" name="tanggal_lahir"
                            id="tanggal_lahir" placeholder="Tanggal Lahir">
                    </div>
                </div>
                <div class="form-group basic">
                    <div class="input-wrapper">
                        <label class="label" for="name">Tinggi Badan</label>
                        <input type="date" class="form-control"
                            value="" name="tanggal_lahir"
                            id="tanggal_lahir" placeholder="Tanggal Lahir">
                    </div>
                </div>
   

            </div>
        </div> -->
        <div class="card " style="background-color: rgba(76, 175, 80, 0.3);">
        <div class="text-center mb-3">
                    <img src="{{asset('profil/'.auth()->user()->profil)}}" alt="Profil Image" class="rounded-circle" width="100" height="100">
                    <input type="file" name="foto" accept="image/*">
                </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
              

                <div class="form-group basic">
                    <div class="input-wrapper">
                        <label class="label" for="name">Nama</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" value="{{auth()->user()->nama}}" name="nama" id="nama" placeholder="Nama">
                    </div>
                </div>

                <div class="form-group basic">
                    <div class="input-wrapper">
                        <label class="label" for="name">Tanggal Lahir</label>
                        <input type="date" class="form-control  @error('tanggal_lahir') is-invalid @enderror" value="{{$users->tanggal_lahir }}"  name="tanggal_lahir" id="tanggal_lahir" placeholder="Tanggal Lahir">
                    </div>
                </div>
                <div class="form-group basic">
                    <div class="input-wrapper">
                        <label class="label" for="name">Alamat</label>
                        <textarea type="text" class="form-control  @error('alamat') is-invalid @enderror"  name="alamat"  placeholder="Alamat">{{$users->alamat }} </textarea>
                    </div>
                </div>

               
            </div>

            <div class="col-md-6">
            <div class="form-group basic">
                    <div class="input-wrapper">
                        <label class="label" for="name">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control">
                        <option value="Laki-Laki" {{ $users->jenis_kelamin == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                    <option value="Perempuan" {{ $users->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>
                <div class="form-group basic">
                    <div class="input-wrapper">
                        <label class="label" for="name">No Telepon</label>
                        <input type="number" class="form-control @error('no_telp') is-invalid @enderror" value="{{$users->no_telp }}" name="no_telp" placeholder="No Telepon">
                    </div>
                </div>

               

                <div class="form-group basic">
                    <div class="input-wrapper">
                        <label class="label" for="name">Berat Badan</label>
                        <input type="number" class="form-control @error('berat_badan') is-invalid @enderror" value="{{$users->berat_badan }}"  name="berat_badan"  placeholder="Berat Bada">
                    </div>
                </div>

                <div class="form-group basic">
                    <div class="input-wrapper">
                        <label class="label" for="name">Tinggi Badan</label>
                        <input type="number" class="form-control  @error('tinggi_badan') is-invalid @enderror" value="{{$users->tinggi_badan }}"  name="tinggi_badan" iplaceholder="Tinggi Badanr">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br/>

        <div class="form-button-group transparent">
            <button type="submit" class="btn btn-success btn-block btn-lg">Simpan</button>
        </div>

    </form>
</div>

@endsection

@push('js')

@endpush
