<?php

namespace App\Models\Repository;

use App\Models\Supplier;

interface SupplierRepositoryInterface
{
    public function all();
    public function create(array $data);
    public function update(Supplier $supplier, array $data);
    public function delete(Supplier $supplier);
    public function find(int $id);
}
