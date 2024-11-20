<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleNote extends Model
{
    use HasFactory;
    protected $table = 'sales_notes';

    protected $fillable = [
        'customer_id',
        'sale_date',
        'total_quantity',
        'sale_state',
        'payment_method',
        'delete_sale_note',
        'created_by',
        'updated_by',
    ];
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
    public function stockSales()
    {
        return $this->belongsToMany(StockSales::class, 'sale_details')
                    ->withPivot('unitsale_price', 'amount', 'subtotal_price')
                    ->withTimestamps();
    }
    public function details()
    {
        return $this->hasMany(SaleDetail::class, 'sale_note_id');
    }
    public function qrPayment(){
        return $this->hasOne(QRPayment::class,'sale_note_id','id');
    }
}
