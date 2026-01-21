@include('layouts.partials.datatable')
@include('layouts.partials.swalalert')
@include('layouts.partials.prism')
@include('layouts.partials.loader')

<script type="text/javascript">
$(document).ready(function() {
    // 1. Inisialisasi Select2 Multiple untuk Role Akses
    $('#roles-select').select2({
        placeholder: " Pilih Role Akses Menu",
        allowClear: true,
        width: '100%',
        dropdownParent: $('#showModal')
    });
});

$(function () {
    // 2. Inisialisasi DataTable Menu
    var menuTable = $('#menu-akses-table').DataTable({
        processing: true, 
        serverSide: true,
        ajax: "{{ route('hris.daftar-menu.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'title', name: 'title' },
            { data: 'parent', name: 'parent' },
            { data: 'slug', name: 'slug' },
            { data: 'roles_assignment', name: 'roles_assignment' }, // Pastikan ini ada
            { data: 'action', name: 'action', orderable: false, searchable: false }, // Ini yang menyebabkan error tadi
        ]
    });

    // 3. Form Submit (Tambah & Update Menu)
    $('#form-module').on('submit', function(e) {
        e.preventDefault();
        let id = $('#module_id').val();
        let url = id ? "{{ route('hris.daftar-menu.update', ':id') }}".replace(':id', id) : "{{ route('hris.daftar-menu.store') }}";
        
        let formData = $(this).serialize();
        if(id) formData += "&_method=PUT";

        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            success: function(response) {
                Swal.fire('Berhasil!', response.message, 'success');
                $('#showModal').modal('hide');
                menuTable.ajax.reload();
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                let msg = '';
                if (errors) {
                    $.each(errors, (key, value) => { msg += value[0] + '<br>'; });
                } else {
                    msg = xhr.responseJSON.message || 'Terjadi kesalahan sistem.';
                }
                Swal.fire('Gagal!', msg, 'error');
            }
        });
    });

    // 4. Auto Slug dari Title Menu
    $('#title').on('input', function() {
        if (!$('#module_id').val()) { 
            let slug = $(this).val().toLowerCase().replace(/[^\w ]+/g, '').replace(/ +/g, '-');
            $('#url').val('/' + slug);
        }
    });

    // 5. Export Handler (Excel & PDF)
    $('#btn-export-excel, #btn-export-pdf').on('click', function () {
        Loader.show();
        let isExcel = $(this).attr('id') === 'btn-export-excel';
        let baseUrl = isExcel ? "{{ route('hris.daftar-menu.excel') }}" : "{{ route('hris.daftar-menu.pdf') }}";
        window.location.href = baseUrl + "?search=" + encodeURIComponent(menuTable.search());
        setTimeout(() => Loader.hide(), 3000);
    });
});

// --- FUNGSI GLOBAL ---

// 6. Mode Tambah
function addMode() {
    $('#roles-select').val(null).trigger('change');
    $('#modal-title').text('Tambah Menu Baru');
    $('#btn-save').show();
    $('#form-module input').prop('readonly', false);
    $('#form-module')[0].reset();
    $('#module_id').val('');
    $('#showModal').modal('show');
}

// 7. Mode Edit Data
function editData(id) {
    Loader.show(); 

    $.get("{{ route('hris.daftar-menu.show', ':id') }}".replace(':id', id), function(response) {
        Loader.hide();
        
        if(response.success) {
            let data = response.data;
            
            $('#modal-title').text('Edit Konfigurasi Menu');
            $('#btn-save').show();
            $('#form-module input').prop('readonly', false);
            
            $('#module_id').val(data.id);
            $('#title').val(data.title);
            $('#url').val(data.url);
            $('#icon').val(data.icon);
            
            if (data.roles && data.roles.length > 0) {
                let assignedRoles = data.roles.map(role => role.id);
                $('#roles-select').val(assignedRoles).trigger('change');
            } else {
                $('#roles-select').val(null).trigger('change');
            }

            $('#showModal').modal('show');
        }
    });
}

// 8. Mode Lihat Detail
function showDetail(id) {
    Loader.show();

    $.get("{{ route('hris.daftar-menu.show', ':id') }}".replace(':id', id), function(response) {
        Loader.hide();
        if(response.success) {
            let data = response.data;
            
            $('#modal-title').text('Detail Konfigurasi Menu');
            $('#btn-save').hide(); 
            
            $('#form-module input').prop('readonly', true);
            
            $('#title').val(data.title);
            $('#url').val(data.url);
            $('#icon').val(data.icon);
            
            if (data.roles && data.roles.length > 0) {
                let assignedRoles = data.roles.map(role => role.id);
                $('#roles-select').val(assignedRoles).trigger('change');
            }

            $('#showModal').modal('show');
        }
    });
}

// 9. Konfirmasi Hapus
function confirmDelete(id, title) {
    Swal.fire({
        title: 'Hapus Menu?',
        text: `Menu '${title}' akan dihapus dari sistem!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ route('hris.daftar-menu.destroy', ':id') }}".replace(':id', id),
                type: "DELETE",
                data: { 
                    _token: "{{ csrf_token() }}" 
                },
                success: function(response) {
                    Swal.fire('Terhapus!', response.message, 'success');
                    $('#menu-akses-table').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    let errorMessage = xhr.responseJSON.message || 'Terjadi kesalahan sistem.';
                    Swal.fire('Gagal!', errorMessage, 'error');
                }
            });
        }
    });
}
</script>