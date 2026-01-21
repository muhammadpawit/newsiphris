<?php

namespace Modules\Hris\Repositories\User;

interface UserRepositoryInterface
{
    public function getQuery();
    public function find($id);
    public function store(array $data);
    public function update($id, array $data);
    public function delete($id);
}