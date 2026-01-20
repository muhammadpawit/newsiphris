<?php

namespace Modules\Hris\Repositories\Module;

interface ModulRepositoryInterface
{
    public function getQuery(); // Kita gunakan nama yang simpel saja
    public function find($id);
    public function store(array $data);
    public function update($id, array $data);
    public function delete($id);
}