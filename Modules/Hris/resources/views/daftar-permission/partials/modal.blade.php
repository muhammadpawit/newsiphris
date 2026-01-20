<div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Tambah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-module">
                @csrf
                <input type="hidden" name="id" id="module_id">
                
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Nama Permission</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Masukkan nama permission" required>
                                <input type="text" name="guard_name" id="guard_name" class="form-control" value="web" hidden>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" id="btn-save">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>