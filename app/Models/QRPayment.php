<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QRPayment extends Model
{
    use HasFactory;
    protected $table = 'qr_payments';
    protected $fillable = [
        'qr_code',
        'sale_note_id',
        'payment_status',
        'cod_transaction',
        'cod_qr',
    ];
    public function sale(){
        return $this->belongsTo(SaleNote::class,'sale_note_id','id');
    }
}
