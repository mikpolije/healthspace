@extends('layouts.main')

@section('content')
<br>
<h5 class="fw-semibold">
    <a href="{{url('dokter/jadwal_praktik',$data->dokter_id)}}"><i class="ti ti-arrow-left bg-danger rounded-circle text-white"></i>Kembali</a>
    Edit Jadwal Praktik Dokter
</h5>

<div class="card">
    <div class="card-body">
        <form action="{{url('dokter/jadwal_praktik/update',$id)}}" method="post" enctype="multipart/form-data">
            @csrf

          
                    <div class="col-md-6">
                        <div class="form-group basic">
                            <label for="" class="form-label">Hari Praktik</label>
                            <select name="hari_praktik" class="form-control">
                                <option value="senin" {{ $data->hari_praktik == 'senin' ? 'selected' : '' }}>Senin</option>
                                <option value="selasa" {{ $data->hari_praktik == 'selasa' ? 'selected' : '' }}>Selasa</option>
                                <option value="rabu" {{ $data->hari_praktik == 'rabu' ? 'selected' : '' }}>Rabu</option>
                                <option value="kamis" {{ $data->hari_praktik == 'kamis' ? 'selected' : '' }}>Kamis</option>
                                <option value="jumat" {{ $data->hari_praktik == 'jumat' ? 'selected' : '' }}>Jumat</option>
                                <option value="sabtu" {{ $data->hari_praktik == 'sabtu' ? 'selected' : '' }}>Sabtu</option>
                                <option value="minggu" {{ $data->hari_praktik == 'minggu' ? 'selected' : '' }}>Minggu</option>
                            </select>

                        </div> 
            <input type="hidden" value="{{$data->dokter_id}}" name="dokter_id">
            <div class="form-group">
                <label for="" class="form-label">Jam Praktik Awal</label>
                <input type="time" class="form-control @error('jam_praktik_awal') is-invalid @enderror" name="jam_praktik_awal" value="{{$data->jam_praktik_awal}}">
            </div>
            <div class="form-group">
                <label for="" class="form-label">Jam Praktik Akhir</label>
                <input type="time" class="form-control @error('jam_praktik_akhir') is-invalid @enderror" name="jam_praktik_akhir" value="{{$data->jam_praktik_akhir}}">
            </div>


            <button type="submit" class="btn btn-success float-end mt-3">Update</button>

        </form>
    </div>
</div>

@endsection

@push('js')

@endpush