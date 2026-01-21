<div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Tambah Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-module">
                @csrf
                <input type="hidden" name="id" id="module_id">
                
                <div class="modal-body">
                    <div class="row">
                        {{-- Field Nama Menu --}}
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Nama Menu</label>
                                <input type="text" name="title" id="title" class="form-control" placeholder="Masukkan nama menu (ex: Daftar Pegawai)" required>
                            </div>
                        </div>

                        {{-- Field URL / Slug --}}
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">URL / Slug</label>
                                <input type="text" name="url" id="url" class="form-control" placeholder="ex: /hris/pegawai" required>
                            </div>
                        </div>

                        {{-- Field Icon (Remix Icon) --}}
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Icon Class</label>
                                <input type="text" name="icon" id="icon" class="form-control" placeholder="ex: ri-user-line">
                            </div>
                        </div>

                        {{-- Field Role / Akses Menu --}}
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Role Akses Menu</label>
                                <select class="form-control" name="roles[]" id="roles-select" multiple="multiple">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Tentukan role mana saja yang dapat melihat menu ini di sidebar.</small>
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