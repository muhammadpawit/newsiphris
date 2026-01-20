@extends('layouts.master')
@section('content')
@include('hris::daftar-module.partials.modal')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="card-title mb-0 flex-grow-1">{{ $title ?? 'Daftar Module' }}</h5>
                @include('hris::daftar-module.partials.buttons')
            </div>
            <div class="card-body">
                <table id="module-table" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No.</th>
                            <th>Nama Module</th>
                            <th>Slug</th>
                            <th>Icon</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
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
@include('hris::daftar-module.partials.js')
@endsection