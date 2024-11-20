<?php

namespace App\Models\Repository;

use App\Models\StockSales;

class StockSalesRepository implements StockSalesRepositoryInterface
{
    public function addVarietyToStock($product,$variety){
        $product->stockSales()->create($variety);
    }
    public function allVarietyProducts()
    {
        return StockSales::all();
    }
    public function updateStock($stock_sale_id,$quantity){

        $stock_sale = StockSales::find($stock_sale_id);
        $stock_sale->quantity -= $quantity;
        $stock_sale->save();
    }
}
