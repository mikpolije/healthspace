@extends('layouts.main')

@section('content')
<br>
<h5 class="fw-semibold">
    <a href="{{url('dokter/jadwal_praktik',$id_dokter)}}"><i class="ti ti-arrow-left bg-danger rounded-circle text-white"></i>Kembali</a>
    Tambah Jadwal Praktik Dokter
</h5>

<div class="card">
    <div class="card-body">
        <form action="{{url('dokter/jadwal_praktiks')}}" method="post" enctype="multipart/form-data">
            @csrf

          
            <div class="form-group">
                <label for="" class="form-label">Hari Praktik</label>
                <select name="hari_praktik" class="form-control">
                    <option value="senin">Senin</option>
                    <option value="selasa">Selasa</option>
                    <option value="rabu">Rabu</option>
                    <option value="kamis">Kamis</option>
                    <option value="jumat">Jumat</option>
                    <option value="sabtu">Sabtu</option>
                    <option value="minggu">Minggu</option>
                </select>
            </div>
            <input type="hidden" value="{{$id_dokter}}" name="dokter_id">
            <div class="form-group">
                <label for="" class="form-label">Jam Praktik Awal</label>
                <input type="time" class="form-control @error('jam_praktik_awal') is-invalid @enderror" name="jam_praktik_awal">
            </div>
            <div class="form-group">
                <label for="" class="form-label">Jam Praktik Akhir</label>
                <input type="time" class="form-control @error('jam_praktik_akhir') is-invalid @enderror" name="jam_praktik_akhir">
            </div>


            <button type="submit" class="btn btn-success float-end mt-3">Tambah</button>

        </form>
    </div>
</div>

@endsection

@push('js')

@endpush