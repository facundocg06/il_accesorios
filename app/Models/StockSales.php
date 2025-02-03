<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockSales extends Model
{
    use HasFactory;
    protected $table = 'stock_sales';
    protected $fillable = [
        'quantity',
        'product_id',
        'store_id',
        'created_by',
        'updated_by',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }

    public function salesNotes()
    {
        return $this->belongsToMany(SaleNote::class, 'sale_details')
            ->withPivot('unitsale_price', 'amount', 'subtotal_price')
            ->withTimestamps();
    }
}
