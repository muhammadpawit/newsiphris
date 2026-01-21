@extends('layouts.master')
@section('content')
@include('hris::daftar-role.partials.modal')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="card-title mb-0 flex-grow-1">{{ $title ?? 'Daftar Module' }}</h5>
                @include('hris::daftar-role.partials.buttons')
            </div>
            <div class="card-body">
                <table id="module-table" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No.</th>
                            <th>Nama Role</th>
                            <th>Guard</th>
                            <th>Deskripsi</th>
                            <th style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@include('hris::daftar-role.partials.js')
@endsection