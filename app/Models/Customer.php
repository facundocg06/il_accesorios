<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = "customers";
    protected $fillable = [
        'ci_customer',
        'name_customer',
        'last_name_customer',
        'phone_customer',
        'email_customer',
        'address_customer',
        'delete_customer',
        'created_by',
        'updated_by',

    ];
    public function sales_notes(){
        return $this->hasMany(SaleNote::class);
    }
}
