<?php

namespace Modules\Products\Interfaces;

interface EntityRepositoryInterface
{
    public function all(bool $paginate = true);
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}