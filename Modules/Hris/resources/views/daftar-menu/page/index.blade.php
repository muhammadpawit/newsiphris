@extends('layouts.master')

@section('content')

{{-- Memanggil Modal --}}
@include('hris::daftar-menu.partials.modal')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="card-title mb-0 flex-grow-1">{{ $title ?? 'Manajemen Akses Menu' }}</h5>
                
                {{-- Tombol Export/Refresh diletakkan di partials.buttons --}}
                @include('hris::daftar-menu.partials.buttons')
            </div>
            <div class="card-body">
                <table id="menu-akses-table" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No.</th>
                            <th>Nama Menu</th>
                            <th>Parent</th>
                            <th>Slug / URL</th>
                            <th>Akses Role</th>
                            <th style="width: 100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Data dimuat via AJAX --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@include('layouts.partials.select2')
@include('hris::daftar-menu.partials.js')
@endsection