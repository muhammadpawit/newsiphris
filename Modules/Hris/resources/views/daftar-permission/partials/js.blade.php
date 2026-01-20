@include('layouts.partials.datatable')
@include('layouts.partials.swalalert')
@include('layouts.partials.prism')
@include('layouts.partials.loader')
<script type="text/javascript">
$(function () {
   

    // DataTable
    var moduleTable = $('#module-table').DataTable({
        processing: false,
        serverSide: true,
        ajax: "{{ route('hris.daftar-permission.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'guard_name', name: 'guard_name' },
            { 
                data: 'action', 
                name: 'action', 
                orderable: false, 
                searchable: false 
            },
        ]
    });
    

    // Form Submit (Tambah & Update)
    $('#form-module').on('submit', function(e) {
        e.preventDefault();
        let id = $('#module_id').val();
        let url = id ? "{{ route('hris.daftar-permission.update', ':id') }}".replace(':id', id) : "{{ route('hris.daftar-permission.store') }}";
        
        // Gunakan FormData untuk handle method PUT di Laravel via AJAX
        let formData = $(this).serialize();
        if(id) formData += "&_method=PUT";

        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            success: function(response) {
                Swal.fire('Berhasil!', response.message, 'success');
                $('#showModal').modal('hide');
                moduleTable.ajax.reload();
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                let msg = '';
                $.each(errors, (key, value) => { msg += value[0] + '<br>'; });
                Swal.fire('Gagal!', msg, 'error');
            }
        });
    });

    // Auto Slug
    $('#title').on('input', function() {
        if (!$('#module_id').val()) { // Hanya auto-slug saat tambah baru
            let slug = $(this).val().toLowerCase().replace(/[^\w ]+/g, '').replace(/ +/g, '-');
            $('#url').val(slug);
        }
    });

    // Icon Preview
    $('#icon-input').on('input', function() {
        let iconClass = $(this).val();
        $('#icon-preview').html(iconClass ? `<i class="${iconClass}"></i>` : '<i class="ri-search-line"></i>');
    });

    // Export Handler
    $('#btn-export-excel, #btn-export-pdf').on('click', function () {
        Loader.show();
        let isExcel = $(this).attr('id') === 'btn-export-excel';
        let baseUrl = isExcel ? "{{ route('hris.daftar-permission.excel') }}" : "{{ route('hris.daftar-permission.pdf') }}";
        window.location.href = baseUrl + "?search=" + encodeURIComponent(moduleTable.search());
        setTimeout(() => Loader.hide(), 3000);
    });
});


function showDetail(id) {
    $('#global-loader').css('display', 'flex');

    $.get("{{ route('hris.daftar-permission.show', ':id') }}".replace(':id', id), function(response) {
        $('#global-loader').fadeOut('fast');
        if(response.success) {
            let data = response.data;
            
            // 1. Setup Modal
            $('#modal-title').text('Detail Role');
            $('#btn-save').hide(); // Sembunyikan tombol simpan
            
            // 2. Isi data & Set Readonly
            $('#form-module input').val(''); // Reset dulu
            $('#form-module input').prop('readonly', true); // Matikan semua input
            
            $('#name').val(data.name);
            $('#guard_name').val(data.guard_name);
            $('#showModal').modal('show');
        }
    });
}

// Fungsi Switch Mode ke Tambah
function addMode() {
    $('#modal-title').text('Tambah Module');
    $('#btn-save').show(); // Tampilkan tombol simpan
    $('#form-module input').prop('readonly', false); // Aktifkan input
    $('#form-module')[0].reset();
    $('#module_id').val('');
    $('#showModal').modal('show');
}

// Fungsi Edit (Dipanggil dari kolom Action DataTable)
function editData(id) {
    $('#global-loader').css('display', 'flex');

    $.get("{{ route('hris.daftar-permission.show', ':id') }}".replace(':id', id), function(response) {
        $('#global-loader').fadeOut('fast');
        if(response.success) {
            let data = response.data;
            
            $('#modal-title').text('Edit Module');
            $('#btn-save').show(); // Tampilkan tombol simpan
            $('#form-module input').prop('readonly', false); // Aktifkan input
            
            $('#module_id').val(data.id);
            $('#name').val(data.name);
            $('#guard_name').val(data.guard_name);
            $('#showModal').modal('show');
        }
    });
}

// Fungsi Delete
function confirmDelete(id, title) {
    Swal.fire({
        title: 'Hapus Data?',
        text: `Module '${title}' akan dihapus!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33', // Warna merah untuk hapus
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ route('hris.daftar-role.destroy', ':id') }}".replace(':id', id),
                type: "DELETE",
                data: { 
                    _token: "{{ csrf_token() }}" 
                },
                success: function(response) {
                    // Berhasil dihapus
                    Swal.fire('Terhapus!', response.message, 'success');
                    $('#module-table').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    // Tangkap pesan error dari Controller (seperti validasi status)
                    let errorMessage = 'Terjadi kesalahan sistem.';
                    
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    Swal.fire('Gagal!', errorMessage, 'error');
                }
            });
        }
    });
}
</script>