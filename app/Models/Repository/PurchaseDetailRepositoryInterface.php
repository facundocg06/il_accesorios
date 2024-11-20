<?php

namespace App\Models\Repository;

interface PurchaseDetailRepositoryInterface
{
    public function all();
    public function create($data);
    public function update($purchasedetail,$data);
    public function delete($id);
    public function find($id);
}
