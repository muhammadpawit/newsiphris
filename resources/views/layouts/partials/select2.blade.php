@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* Merapikan Container Utama Select2 */
.select2-container--default .select2-selection--multiple {
    border: 1px solid #ced4da !important;
    border-radius: 0.25rem !important;
    min-height: 38px !important;
    padding-bottom: 5px !important;
}

/* Mempercantik Pill / Tag yang Terpilih */
.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #e0ebff !important; /* Warna biru soft */
    border: 1px solid #0d6efd !important; /* Border biru tegas */
    color: #0d6efd !important; /* Warna teks biru */
    border-radius: 5px !important;
    padding: 2px 10px 2px 25px !important; /* Jarak untuk tombol X */
    font-size: 13px !important;
    font-weight: 500 !important;
    margin-top: 5px !important;
    position: relative !important;
}

/* Memperbaiki Posisi Tombol Hapus (X) */
.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    position: absolute !important;
    left: 8px !important;
    top: 50% !important;
    transform: translateY(-50%) !important;
    color: #0d6efd !important;
    border: none !important;
    font-size: 16px !important;
    margin: 0 !important;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
    background-color: transparent !important;
    color: #f06548 !important; /* Warna merah saat hover */
}

/* Merapikan Input Search di Dalamnya */
.select2-container--default .select2-search--inline .select2-search__field {
    margin-top: 8px !important;
    margin-left: 10px !important;
}
</style>
@endsection

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset(config('velzon.theme') . '/js/pages/select2.init.js') }}"></script>