<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseNotes extends Model
{
    use HasFactory;
    protected $table = 'purchase_notes';
    protected $dates = ['purchase_date'];
    protected $casts = [
        'purchase_date' => 'datetime',
    ];
    protected $fillable = [
        'purchase_date',
        'total_quantity',
        'supplier_id',
        'delete_purchase_notes',
        'created_by',
        'updated_by',
    ];
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetail::class, 'purchase_note_id');
    }

    protected static function booted()
    {
        static::deleting(function ($purchaseNote) {
            foreach ($purchaseNote->purchaseDetails as $detail) {
                $detail->delete();
            }
        });
    }
    // public function purchaseDetails()
    // {
    //     return $this->belongsTomany(PurchaseDetail::class,'purchase_details', 'stock_production_id', 'purchase_notes_id')->withTimestamps();
    // }

    // public function stockProductions()
    // {
    //     return $this->belongsToMany(StockProduction::class, 'purchase_details')
    //                 ->withPivot('unitpurchase_price', 'amount', 'subtotal_price')
    //                 ->withTimestamps();
    // }

}
