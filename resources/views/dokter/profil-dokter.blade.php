@extends('layouts.main')

@section('content')
<br />
<h5 class="fw-semibold">
    <a href="{{url('dokter/dashboard')}}">
    <i class="fas fa-arrow-left bg-danger rounded-circle text-white"></i> Kembali
</a>
    Edit Profil Dokter
</h5>
<div class="section mb-5 p-2">
    <form action="{{url('dokter/profil_dokter_update',$users->id)}}" method="post" enctype="multipart/form-data">
        @csrf

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
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $users->email }}">
                        </div>
                        
                        <div class="form-group basic">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Password">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">Show</button>
                                </div>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror                
                        </div>

                        <!--- <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="name">Biaya Layanan</label>
                                <input type="number" class="form-control  @error('biaya_layanan') is-invalid @enderror" value="{{$users->biaya_layanan }}" name="spesialis" placeholder="Spesialis">
                            </div>
                        </div>-->

                        <div class="form-group basic">
                            <label for="" class="form-label">Poli</label>
                            <select name="poli_id" class="form-control">
                                @foreach($poli as $v)
                                <option value="{{ $v->id }}" {{ $v->id == $users->poli_id ? 'selected' : '' }}>{{ $v->nama_poli }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <br />

        <div class="form-button-group transparent">
            <button type="submit" class="btn btn-success btn-block btn-lg">Simpan</button>
        </div>

    </form>
</div>

@endsection

@push('js')

<script>
    const togglePasswordButton = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    togglePasswordButton.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.textContent = type === 'password' ? 'Show' : 'Hide';
    });
</script>


@endpush
