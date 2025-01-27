<?php

namespace App\Models\Repository;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

interface StockSalesRepositoryInterface
{
    public function allVarietyProducts();
    public function addVarietyToStock($product,$variety);
    public function updateStock($stock_sale_id,$quantity);
}
