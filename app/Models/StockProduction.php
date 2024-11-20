<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockProduction extends Model
{
    use HasFactory;
    protected $table = 'stock_productions';
    protected $fillable = [
        'name',
        'price',
        'description',
        'suppliers_id',
        'store_id',
        'delete_stock_producction',
        'created_by',
        'updated_by',
    ];
    public function store(){
        return $this->belongsTo(Store::class,'store_id');
    }

    public function purchaseDetails()
    {
        return $this->belongsTomany(PurchaseDetail::class,'purchase_details', 'stock_production_id', 'purchase_notes_id')->withTimestamps();
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class, 'suppliers_id');
    }


}
