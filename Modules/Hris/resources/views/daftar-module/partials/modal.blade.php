<div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Tambah Module</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-module">
                @csrf
                <input type="hidden" name="id" id="module_id">
                
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Nama Module</label>
                                <input type="text" name="title" id="title" class="form-control" placeholder="Masukkan nama module" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3" placeholder="Deskripsi singkat module"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Slug (URL)</label>
                                <input type="text" name="url" id="url" class="form-control" placeholder="contoh: hris" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" id="module_status" class="form-select" required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="development">Development</option>
                                    <option value="active">Aktif</option>
                                    <option value="inactive">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Icon (Remix Icon Class)</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="icon-preview"><i class="ri-search-line"></i></span>
                                    <input type="text" name="icon" id="icon-input" class="form-control" placeholder="ri-dashboard-line">
                                    <a href="https://remixicon.com/" target="_blank" class="btn btn-outline-secondary" title="Cari Icon">
                                        <i class="ri-external-link-line"></i>
                                    </a>
                                </div>
                                <small class="text-muted">Klik icon link untuk mencari nama icon di website Remix Icon.</small>
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