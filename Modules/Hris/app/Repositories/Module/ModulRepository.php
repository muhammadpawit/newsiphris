<?php

namespace Modules\Hris\Repositories\Module;

use App\Models\ModulAplikasiModel;

class ModulRepository implements ModulRepositoryInterface
{
    protected $model;

    public function __construct(ModulAplikasiModel $model)
    {
        $this->model = $model;
    }

    public function getQuery()
    {
        // Method ini yang akan dipanggil oleh DataTables di Controller
        return $this->model->select(['id', 'title', 'deskripsi', 'icon', 'color', 'url', 'status', 'created_at']);
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
        $item = $this->find($id);
        $item->update($data);
        return $item;
    }

    public function delete($id)
    {
        return $this->find($id)->delete();
    }
}