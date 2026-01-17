@extends('layouts.master')
@section('slug')
<div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">{{ $title ?? ''}}</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                                        <li class="breadcrumb-item active">{{ $title ?? ''}}</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>

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
                    <!-- end row -->                    
@endsection    
@section('scripts')
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