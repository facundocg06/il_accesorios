<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    use HasFactory;
    protected $table = 'sale_details';
    protected $fillable = [
        'stock_sale_id',
        'sale_note_id',
        'unitsale_price',
        'amount',
        'subtotal_price',
    ];
    public function stockSale(){
        return $this->belongsTo(StockSales::class);
    }
    public function saleNote(){
        return $this->belongsTo(SaleNote::class);
    }
}
