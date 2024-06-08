@extends('layouts.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header bg-success-dark">
            <h6 class="card-title text-white">Daftar Konsultasi</h6>
        </div>
        <div class="card-body">
            <!-- Search Form -->
            <form method="GET" action="{{ url('admin/daftar-konsultasi') }}">
                <div class="input-group mb-3">
                    <input type="text" name="search" class="form-control" placeholder="Cari Berdasarkan Nama Pasien, Nama Dokter, atau konsultasi" value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </form>

            <div class="table-responsive" style="min-height:180px;">
                <table class="table" id="tabelku">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pasien</th>
                            <th>Nama Dokter</th>
                            <th>Tanggal Konsultasi</th>
                            <th>Konsultasi</th>
                            <th width="25%">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach($data as $v)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $v->nama }}</td>
                            <td>{{ $v->nama_dokter }}</td>
                            <td>{{ $v->tgl_konsultasi }}</td>
                            <td>{{ $v->konsultasi }}</td>
                            <td class="d-flex">
                                <a href="{{ url('admin/hasil_konsultasi', $v->id) }}">
                                    <span class="badge bg-primary rounded-3 fw-semibold">Catatan Dokter & Resep</span>
                                </a>
                                <br>
                                <a href="{{ url('admin/riwayat-konsultasi', $v->pasien_id) }}">
                                    <span class="badge bg-primary rounded-3 fw-semibold">Riwayat Konsultasi</span>
                                </a>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($data->isEmpty())
                    <p class="text-center">No consultations found</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
