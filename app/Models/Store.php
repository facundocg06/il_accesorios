<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $table = "stores";
    protected $fillable = [
        'name',
        'location',
        'delete_store',
        'created_by',
        'updated_by',
    ];
    public function stockSales()
    {
        return $this->hasMany(StockSales::class);
    }
    public function storeSales()
    {
        return $this->hasMany(SaleNote::class);
    }
}
