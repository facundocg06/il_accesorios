<?php

namespace App\Models;

use App\Models\Repository\StockSalesRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailsAdjustment extends Model
{
    use HasFactory;

    protected $fillable = ['quantity', 'inventory_adjustment_id', 'stock_sale_id'];

    public function inventoryAdjustment()
    {
        return $this->belongsTo(InventoryAdjustment::class);
    }

    public function stockSale()
    {
        return $this->belongsTo(StockSales::class);
    }
}
