@extends('layouts.main')

@push('css')
<style>
    .dokter-list {
        cursor: pointer;
    }
</style>
@endpush

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Modal View Dokter -->
    <div class="modal fade" id="modalView" tabindex="-1" aria-labelledby="modalViewLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="card ">
                        <img class="card-img-top shadow profil" src="" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title nama_dokter">Nama Dokter</h5>
                            <p class="card-text">
                               
                                <span id="biaya_layanan" class="float-end fw-bold biaya_layanan"></span>
                            </p>
                            <!-- <h6>Jadwal Praktik</h6>
                         -->
                            <!-- <h6>Jadwal Praktik</h6>
                            <p>Senin <span class="float-end">06.00 - 17.00</span></p>
                            <p>Selasa <span class="float-end">06.00 - 17.00</span></p>
                            <p>Rabu <span class="float-end">06.00 - 17.00</span></p>
                            <p>Kamis<span class="float-end">06.00 - 17.00</span></p>
                            <p>Jumat <span class="float-end">06.00 - 17.00</span></p>
                            <p>Sabtu <span class="float-end">06.00 - 17.00</span></p> -->
                            <h6>Jadwal Praktik</h6>
                        <div class="jadwal_praktik">
                            <!-- Tempat untuk menampilkan jadwal praktik -->
                        </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-success-dark bookingchat" data-bs-dismiss="modal">Chat</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal View Dokter -->

    <!-- Modal View  Order Konsultasi -->
    <div class="modal fade" id="modalOrderView" tabindex="-1" aria-labelledby="modalOrderViewLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{url('pasien/pemesanan')}}" method="post">
                    @csrf
                    <div class="modal-body">

                        <input type="text" class="d-none" name="dokter_id">
                        <div class="form-group">
                            <label for="">Nama Konsultasi</label>
                            <input type="text" class="form-control" name="konsultasi" required>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="submit" class="btn btn-success-dark">Chat</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal View  Order Konsultasi -->

    <div class="card bg-success-dark px-5 py-2 text-white">
        <div class="d-flex justify-content-between gap-1">
            <div class="judul d-flex flex-column justify-content-center col-4">
                <h3 class="text-white mb-2">Selamat Datang</h3>
                <h5 class="text-white mt-0">Konsultasi dengan dokter kami</h5>
            </div>
            <div class="col-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="fw-bold">Jumlah Konsultasi Anda</h6>
                        <h3 class="text-end">{{$kons->count()}}</h3>
                    </div>
                </div>
            </div>

            <div class="col-4">
                <div class="card h-100">
                    <h6 class="fw-bold mt-4 mx-3 mb-2">Konsultasi Terbaru Anda</h6>
                    <div class="konsultasi mb-2">
                    @if($kons->isEmpty())
    <div class="bg-secondary w-100 d-flex flex-row border-bottom py-1 px-1">
        <span class="text-white">Tidak Ada chat</span>
    </div>
@else
                    @foreach($kons as $c)
                        <div class="bg-secondary w-100 d-flex flex-row border-bottom py-1 px-1">
                            <div class="col-2">
                                <img src="{{url('profil/profil.jpg')}}" alt="" width="50" height="50"
                                    class="rounded rounded-circle me-2">
                            </div>
                            <div class="dokter col-7">
                                <h6 class="text-white mb-0">{{$c->dokter->nama}}</h6>
                                <span class="text-white" style="font-size:10px;">{{$c->last_chat? $c->last_chat->isi_chat : ''}}.</span>
                            </div>
                            <div class="time col-3 text-end">
                                <span style="font-size:9px;">@if($c->last_chat) @time_ago($c->last_chat->created_at) @else now  @endif</span>
                            </div>
                        </div>
                        @endforeach
                        @endif

                    

                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="card mt-3">
        <div class="card-body">

            <h4 class="card-title">Konsultasi Dokter</h4>

            <div class="card bg-info">
                <div class="card-body">
                    <div class="row">

                        @foreach($datadokter as $dokter)
                        <div class="col-md-3 mb-3 dokter-list" onclick="viewdokter({{$dokter}})">
                            <div class="card h-100">
                                <img class="card-img-top" src="{{url($dokter->profil)}}" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title text-center">{{$dokter->nama}}</h5>
                                    <p class="card-text text-center">
                                        Buka Praktik : 09.00 - 17.00
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>


        </div>
    </div>


</div>

@endsection

@push('js')
<script>
    let formatRupiah = (angka) => {
        let rupiahFormat = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(angka);
        return rupiahFormat;
    }

    let viewdokter = (dokter) => {
        $(".nama_dokter").html(dokter.nama)
        $(".profil").attr("src",dokter.profil);
        $(".biaya_layanan").html(formatRupiah(dokter.biaya_layanan))
        $('.bookingchat').attr('onClick', `vieworder(${dokter.id})`);
        $("#modalView").modal('show')
        $(".jadwal_praktik").empty();
        dokter.jadwal_praktik.forEach(jadwal => {
        $(".jadwal_praktik").append(`
            <p>${jadwal.hari_praktik} <span class="float-end">${jadwal.jam_praktik_awal} - ${jadwal.jam_praktik_akhir}</span></p>
        `);
    });
    }

    let vieworder = (id) => {
        $("#modalOrderView [name='dokter_id']").val(id)
        $("#modalView").modal('hide')
        $("#modalOrderView").modal('show')
    }
</script>
@endpush
