<?php

namespace Modules\Hris\Repositories\Menu;

use App\Models\NewhrisMenu;

class MenuRepository implements MenuRepositoryInterface
{
    protected $model;

    public function __construct(NewhrisMenu $model)
    {
        $this->model = $model;
    }

    public function getQuery()
    {
        // Mengambil kolom yang diperlukan untuk manajemen menu akses
        return $this->model->select([
            'id', 
            'parent_id', 
            'title', 
            'url', 
            'icon', 
            'slug', 
            'target_id', 
            'order', 
            'is_title', 
            'created_at'
        ]);
    }

    public function find($id)
    {
        // findOrFail agar otomatis melempar 404 jika id tidak ada
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