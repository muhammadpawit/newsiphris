<?php

namespace Modules\Hris\Repositories\User;

use App\Models\Permission;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getQuery()
    {
        // Method ini yang akan dipanggil oleh DataTables di Controller
        return $this->model->select(['id', 'name','email', 'created_at']);
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function store(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $item = $this->find($id); // Mencari user/pegawai
        
        // 1. Update data dasar (name, email, dll)
        $item->update($data);

        // 2. Sinkronisasi Role
        // Jika roles ada di dalam request, pasangkan ke user. 
        // Jika dikosongkan di modal, maka user tidak akan punya role.
        if (isset($data['roles'])) {
            $item->syncRoles($data['roles']);
        } else {
            // Opsional: Hapus semua role jika tidak ada yang dipilih
            $item->syncRoles([]);
        }

        return $item;
    }

    public function delete($id)
    {
        return $this->find($id)->delete();
    }
}