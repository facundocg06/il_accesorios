<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photos extends Model
{
    use HasFactory;
    protected $table = 'photos';
    protected $fillable = [
        'url_photo',
        'product_id',

        'delete_photo',
        'created_by',
        'updated_by',
    ];
    public function product(){
        return $this->belongsTo(Product::class,'product_id','id');
    }
}
