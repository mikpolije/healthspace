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


    <div class="card bg-success-dark px-5 py-2 text-white">
        <div class="d-flex justify-content-between gap-1">
            <div class="col-4">
                <img src="{{url('profil/'.auth()->user()->profil)}}" alt="" width="200" height="200" class="rounded rounded-circle me-2">
            </div>
            <div class="judul d-flex flex-column justify-content-center col-10">
                <h1 class="text-white mb-8">Selamat Datang</h1>
                <h3 class="text-white mt-0">{{auth()->user()->nama}}</h3>
            </div>

        </div>
    </div>




    <div class="  px-5 py-2 text-white mt-3">
        <div class="d-flex justify-content-between gap-1">
        <div class="judul d-flex flex-column justify-content-center col-4">
    <div class="card bg-success-dark text-white">
        <h3 class="card-header">Pesan Masuk (3)</h3>
           
        <div class="card bg-secondary">
    <div class="card-body">
        <div class="row">
        
            <div class="col-auto">
                <img src="{{url('profil/profil.jpg')}}" alt="Gambar Profil" class="rounded-circle" width="50" height="50">
            </div>
        
            <div class="col">
                <h5 class="card-title text-white">Oliv</h5>
                <h6 class="card-title text-white">Hai</h6>
               
            </div>
    
            <div class="col-auto">
                <span class="badge bg-success">3</span>
            </div>
        </div>
    </div>
    <hr class="border border-dark">
    <div class="card-body">
        <div class="row">
        
            <div class="col-auto">
                <img src="{{url('profil/profil.jpg')}}" alt="Gambar Profil" class="rounded-circle" width="50" height="50">
            </div>
        
            <div class="col">
                <h5 class="card-title text-white">Oliv</h5>
                <h6 class="card-title text-white">Hai</h6>
               
            </div>
    
            <div class="col-auto">
                <span class="badge bg-success">3</span>
            </div>
        </div>
    </div>
</div>


        </div>
    </div>


            <div class="col-4">
                        <div class="row">
                            <div class="col-md">
                                <div class="card-body">
                                    <div class="card bg-success-dark text-white">
                                        <p class="card-white-text text-center fs-7">Jumlah Pasien Hari Ini</p>
                                        <p class="card-white-text text-center fs-1">{{$konsultasi}}</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <div class="card-body">
                                    <div class="card bg-success-dark text-white">
                                        <p class="card-white-text text-center fs-7">Jumlah Pasien Bulan Ini</p>
                                        <p class="card-white-text text-center fs-1">{{$konsultasiBulanIni}}</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                   
            </div>

            <div class="col-4">
                <div class="card h-100">

                    <div class="konsultasi mb-2">
                        <br>
                        <h3 class="text-black mb-2 text-center"> 5 Kasus Terbanyak (%)</h3>
                        <div style="width: 80%; margin: auto;">
                            <canvas id="myPieChart"></canvas>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>






</div>

@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    var ctx = document.getElementById('myPieChart').getContext('2d');
    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($data['labels']) !!},
            datasets: [{
                data: {!! json_encode($data['data']) !!},
                backgroundColor: [
                    'red',
                    'blue',
                    'green',
                    'yellow',
                    'orange'
                ]
            }]
        },
        options: {
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        var dataset = data.datasets[tooltipItem.datasetIndex];
                        var total = dataset.data.reduce(function(previousValue, currentValue, currentIndex, array) {
                            return previousValue + currentValue;
                        });
                        var currentValue = dataset.data[tooltipItem.index];
                        var percentage = Math.floor(((currentValue / total) * 100) + 0.5); // Mendapatkan persentase dan membulatkannya

                        return percentage + '%';
                    }
                }
            }
        }
    });
</script>
@endpush