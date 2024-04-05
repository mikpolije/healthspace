@extends('layouts.main')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <!-- <div class="card bg-success-dark px-5 py-2 text-white">
        <div class="d-flex justify-content-between">
            <div class="judul d-flex flex-column justify-content-center">
                <h4 class="text-white mb-0">Health Space</h4>
                <h6 class="text-white mt-0">Dashboard</h6>
            </div>
            <div class="doctor">
                <img src="{{url('assets/img/doctor.png')}}" height="50" alt="">
            </div>
        </div>
    </div> -->


    <div class="row mt-3">

    <div class="col-lg-4 col-md-12 col-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <i class="menu-icon tf-icons bx bx-first-aid card-title" style="font-size : 45px;"></i>
                        </div>

                    </div>
                    <span class="fw-medium d-block mb-1">Pasien</span>
                    <h3 class="card-title mb-2">{{$pasien}}</h3>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-12 col-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <i class="menu-icon tf-icons bx bx-first-aid card-title" style="font-size : 45px;"></i>
                        </div>

                    </div>
                    <span class="fw-medium d-block mb-1">Poli</span>
                    <h3 class="card-title mb-2">{{$poli}}</h3>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-12 col-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <i class="menu-icon tf-icons bx bx-git-repo-forked card-title" style="font-size : 45px;"></i>
                        </div>

                    </div>
                    <span class="fw-medium d-block mb-1">Dokter</span>
                    <h3 class="card-title mb-2">{{$dokter}}</h3>
                </div>
            </div>
        </div>

    </div>

    <div class="row mt-3">

<div class="col-lg-7 col-md-12 col-6 mb-4">
        <div class="card">
            <div class="card-body">
            <span class="fw-medium d-block mb-1">Statistik Konsultasi Pasien</span>
                <div class="card-title d-flex align-items-start justify-content-between">
     
                <div style="width: 100%; margin: auto;">
                    <canvas id="lineChart"></canvas>
                </div>

                </div>
             
            </div>
        </div>
    </div>

    
    <div class="col-lg-5 col-md-12 col-6 mb-4">
        <div class="card">
            <div class="card-body">
            <span class="fw-medium d-block mb-1">Statistik Invoice (%)</span>
                <div class="card-title d-flex align-items-start justify-content-between">
                  
                    <div style="width: 75%; margin: auto;">
                    <canvas id="invoiceChart"></canvas>
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
    var ctx = document.getElementById('lineChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($data['labels']),
            datasets: [
                {
                    label: 'Poli Umum',
                    data: @json($data['data_poli_umum']),
                    borderColor: 'rgba(255, 99, 132, 1)', // Warna untuk poli umum
                    borderWidth: 1,
                    fill: false
                },
                {
                    label: 'Poli Gigi',
                    data: @json($data['data_poli_gigi']),
                    borderColor: 'rgba(54, 162, 235, 1)', // Warna untuk poli gigi
                    borderWidth: 1,
                    fill: false
                },
                {
                    label: 'Jumlah Konsultasi',
                    data: @json($data['data_jumlah_konsultasi']),
                    borderColor: 'rgba(75, 192, 192, 1)', // Warna untuk jumlah konsultasi
                    borderWidth: 1,
                    fill: false
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
<script>
    var ctx = document.getElementById('invoiceChart').getContext('2d');
    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($data2['labels']) !!},
            datasets: [{
                data: {!! json_encode($data2['data']) !!},
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)', // Merah untuk pending
                    'rgba(54, 162, 235, 0.5)', // Biru untuk terbayar
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)', // Merah untuk pending
                    'rgba(54, 162, 235, 1)', // Biru untuk terbayar
                ],
                borderWidth: 1
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
                        var percentage = Math.round((currentValue / total) * 100);
                        return data.labels[tooltipItem.index] + ': ' + currentValue + ' (' + percentage + '%)';
                    }
                }
            }
        }
    });
</script>
    @endpush