<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'name_category',
        'description_category',

        'delete_category',
        'created_by',
        'updated_by',

    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(
            function ($category) {
                if ($categoryAuth = Auth::user()) {
                    $category->created_by = $categoryAuth->id;
                    $category->updated_by = $categoryAuth->id;
                }
            }
        );
        static::updating(function ($category) {
            if ($categoryAuth = Auth::user()) {
                $category->updated_by = $categoryAuth->id;
            }
        });
        static::deleting(function ($category) {
            $category->deleted= 'INACTIVO';
            if ($categoryAuth = Auth::user()) {
                $category->deleted_by = $categoryAuth->id;
            }
        });

    }
    public function product(){
        return $this->hasMany(Product::class);
    }
}
