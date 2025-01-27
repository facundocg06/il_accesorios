<?php

namespace App\Models\Repository;



interface CategoryRepositoryInterface
{
    public function all();
    public function create($data);
    public function update($category,$data);
    public function delete($id);
    public function find($id);
}
