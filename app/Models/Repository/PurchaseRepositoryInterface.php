<?php

namespace App\Models\Repository;

interface PurchaseRepositoryInterface
{
    public function all();
    public function create($data);
    public function update($purchase,$data);
    public function delete($id);
    public function find($id);
}
