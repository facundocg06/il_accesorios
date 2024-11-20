<?php

namespace App\Models\Repository;

use App\Models\Supplier;

class SupplierRepository implements SupplierRepositoryInterface
{
    public function all()
    {
        return Supplier::all();
    }

    public function create(array $data)
    {
        return Supplier::create($data);
    }

    public function update(Supplier $supplier, array $data)
    {
        return $supplier->update($data);
    }

    public function delete(Supplier $supplier)
    {
        return $supplier->delete();
    }

    public function find(int $id)
    {
        return Supplier::find($id);
    }
}
