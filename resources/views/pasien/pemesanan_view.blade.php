@extends('layouts.main')

@push('css')

<style>
    #snap-midtrans {
        display: block; 
        height: inherit; 
        width: inherit; 
        border: none; 
        min-height: 600px !important; 
        min-width: 320px; 
        border-radius: inherit;"
    }
</style>

@endpush

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row mb-5">
        <div class="col-md-5">
            <h4 class="title fw-bold">Pilih Metode Pembayaran</h4>
            <div class="w-100 h-100">
                <iframe src="{{$pemesanan->payment_url}}" frameborder="0" id="snap-midtrans"></iframe>
            </div>
        </div>

        <div class="col-md-7">

            <h4 class="title fw-bold">Ringkasan</h4>
            <p>Kode Booking : <span class="fw-bold float-end">{{$pemesanan->kode_pembayaran}}</span></p>
            <p>Konsultasi : <span class="fw-bold float-end">{{$konsultasi->konsultasi}}</span></p>
            <p>Nama Dokter : <span class="fw-bold float-end">{{$konsultasi->nama}}</span></p>

            <hr>

            <p>Harga : <span class="fw-bold float-end">{{$pemesanan->jumlah_pembayaran}}</span></p>
            <p>Status : <span class="fw-bold float-end badge {{$pemesanan->status_pembayaran == 'pending' ? 'bg-danger' : 'bg-success'}}">{{$pemesanan->status_pembayaran}}</span></p>
            <p>
                <a href="{{url('pasien/pemesanan/'.$pemesanan->id)}}" class="btn btn-sm btn-primary">Refresh</a>
            </p>

            <div class="card mt-3 bg-primary">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3 text-center">
                            <i class='bx bx-receipt text-center fw-bold text-white' style="font-size:44px;"></i>
                        </div>
                        <div class="col-9">
                            <h6 class="fw-bold text-white">Cek kembali metode pembayaranmu</h6>
                            <p class="text-white">Pastikan kamu mengecek kembali metode pembayaranmu untuk menghindari
                                adanya kesalahan transfer.</p>
                        </div>
                        <div class="col-3 text-center">
                            <i class='bx bx-money text-center fw-bold text-white' style="font-size:44px;"></i>
                        </div>
                        <div class="col-9">
                            <h6 class="fw-bold text-white">Cek kembali metode pembayaranmu</h6>
                            <p class="text-white">Pastikan kamu mengecek kembali metode pembayaranmu untuk menghindari
                                adanya kesalahan transfer.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-100 mt-3">
                @if($pemesanan->status_pembayaran == "pending")
                    <a href="{{route('cancel.payment', $pemesanan->id)}}" class="btn btn-danger float-start">Batalkan Transaksi</a>
                    <button class="btn btn-success float-end" disabled><i class="menu-icon tf-icons bx bx-chat"></i>  Lanjutkan Chat</button>
                @else
                    <a href="{{url('pasien/konsultasi')}}" class="btn btn-success float-end"> <i class="menu-icon tf-icons bx bx-chat"></i>  Lanjutkan Chat</a>
                @endif
            </div>

        </div>
    </div>

</div>

@endsection

@push('js')

<script>
    function iFrameResize() {
        // You can add iframe resizing logic here if needed
    }
</script>

@endpush
