@extends('layouts.main')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card">

        <div class="card-header bg-success-dark">
            <h6 class="card-title text-white">Daftar Invoice</h6>
        </div>

        <div class="card-body">

            <!-- Search Form -->
            <form method="GET" action="{{ route('daftar-invoice.index') }}" class="mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="search_nama">Cari Berdasarkan Nama Pasien:</label>
                            <input type="text" name="search_nama" class="form-control" id="search_nama" value="{{ request('search_nama') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="search_status">Cari Berdasarkan Status Pembayaran:</label>
                            <select name="search_status" class="form-control" id="search_status">
                                <option value="">Pilih Status Pembayaran</option>
                                <option value="cancel" {{ request('search_status') == 'cancel' ? 'selected' : '' }}>Cancel</option>
                                <option value="pending" {{ request('search_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="terbayar" {{ request('search_status') == 'terbayar' ? 'selected' : '' }}>Terbayar</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group text-end">
                            <button type="submit" class="btn btn-primary">Cari</button> <!-- Search Button -->
                        </div>
                    </div>
                </div>
            </form>

            <div class="table-responsive" style="min-height:180px;">
                <table class="table" id="tabelku">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Kode Pembayaran</th>
                            <th>Harga</th>
                            <th>Metode Pembayaran</th>
                            <th>Status Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach($data as $v)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$v->nama}}</td>
                            <td>{{$v->kode_pembayaran}}</td>
                            <td>{{$v->jumlah_pembayaran}}</td>
                            <td>{{$v->metode_pembayaran}}</td>
                            <td>{{$v->status_pembayaran}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

@endsection
