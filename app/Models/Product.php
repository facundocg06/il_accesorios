<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $table= "products";
    protected $fillable = [
        'name',
        'price',
        'barcode',
        'description',
        'url_front_page',

        'category_id',
        'brand_id',
        'delete_product',
        'created_by',
        'updated_by',
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(
            function ($product) {
                if ($productAuth = Auth::user()) {
                    $product->created_by = $productAuth->id;
                    $product->updated_by = $productAuth->id;
                }
            }
        );
        static::updating(function ($product) {
            if ($productAuth = Auth::user()) {
                $product->updated_by = $productAuth->id;
            }
        });
        static::deleting(function ($product) {
            $product->deleted= 'INACTIVO';
            if ($productAuth = Auth::user()) {
                $product->deleted_by = $productAuth->id;
            }
        });

    }

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function brand(){
        return $this->belongsTo(Brand::class);
    }
    public function stockSales(){
        return $this->hasMany(StockSales::class);
    }
}
