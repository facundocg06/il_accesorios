<?php

namespace App\Models\Repository;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

interface SaleRepositoryInterface
{
    public function all();
    public function find($id);
    public function createSale(array $data);
    public function createSaleDetail(array $data);
    public function confirmSale($sale);
}
