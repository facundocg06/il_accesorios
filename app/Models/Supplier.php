<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Supplier extends Model
{
    use HasFactory;
    protected $table = "suppliers";
    protected $fillable = [
        'nit_supplier',
        'reason_social',
        'phone_supplier',

        'delete_supplier',
        'created_by',
        'updated_by'
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(
            function ($supplier) {
                if ($userAuth = Auth::user()) {
                    $supplier->created_by = $userAuth->id;
                    $supplier->updated_by = $userAuth->id;
                }
            }
        );
        static::updating(function ($supplier) {
            if ($userAuth = Auth::user()) {
                $supplier->updated_by = $userAuth->id;
            }
        });
        static::deleting(function ($supplier) {
            $supplier->deleted= 'INACTIVO';
            if ($userAuth = Auth::user()) {
                $supplier->deleted_by = $userAuth->id;
            }
        });

    }
    public function stockProduction()
    {
        return $this->hasMany(StockProduction::class, 'suppliers_id');
    }
    public function purchaseNotes()
    {
        return $this->hasMany(PurchaseNotes::class, 'supplier_id');
    }

}
