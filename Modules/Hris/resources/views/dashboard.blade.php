@extends('layouts.master')
@section('content')
    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Jumlah Pegawai</h4>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    <div id="myChart" style="height: 350px;"></div>
                                </div><!-- end card-body -->
                            </div><!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
@endsection
@section('scripts')
    @include('layouts.partials.loader')
    @include('layouts.partials.apexchart')
    <script>
        var options = {
            chart: {
                type: 'bar', 
                height: 350,
                toolbar: { show: true }
            },
            // 1. UBAH BAGIAN INI: Ganti data statis dengan variable $chartSeries
            series: [{
                name: 'Jumlah Staff',
                data: {!! json_encode($chartSeries) !!} 
            }],
            // 2. UBAH BAGIAN INI: Ganti kategori bulan dengan variable $chartLabels
            xaxis: {
                categories: {!! json_encode($chartLabels) !!}
            },
            colors: ['#34c38f'], // Anda bisa ganti warna sesuai selera
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: false, // Ubah ke true jika ingin bar menyamping
                    columnWidth: '45%',
                    distributed: true, // Membuat warna tiap bar berbeda jika ingin
                }
            },
            dataLabels: {
                enabled: true
            },
            legend: {
                show: false // Sembunyikan legend jika menggunakan distributed colors
            }
        };

        var chart = new ApexCharts(document.querySelector("#myChart"), options);
        chart.render();
    </script>
@endsection