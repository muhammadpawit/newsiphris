@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Module</div>

                <div class="card-body">
                    

                    <form method="POST" action="{{ route('hris.daftar-module.update', $module->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Nama Module</label>
                            <input type="text" name="title" class="form-control" value="{{ $module->title }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Slug (URL)</label>
                            <input type="text" name="url" class="form-control" value="{{ $module->url }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Icon (Remix Icon Class)</label>
                            <input type="text" name="icon" class="form-control" value="{{ $module->icon }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    @include('layouts.partials.swalalert')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#icon-input').change(function () {
                $('#icon-preview i').attr('class', $(this).val());
            });
        });
        
    </script>
@endsection