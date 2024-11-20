<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    use HasFactory;

    protected $table = 'purchase_details';

    protected $fillable = [
        'purchase_note_id',
        'stock_production_id',
        'price_purchase_detail',
        'amount',
    ];

    // public function stockProduction()
    // {
    //     return $this->belongsTo(StockProduction::class);
    // }

    // public function purchaseNote()
    // {
    //     return $this->belongsTo(PurchaseNotes::class);
    // }
    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetail::class, 'purchase_note_id');
    }


    public function purchaseNote()
    {
        return $this->belongsTo(PurchaseNotes::class, 'purchase_note_id');
    }
    public function stockProduction()
    {
        return $this->belongsTo(StockProduction::class, 'stock_production_id');
    }
}
