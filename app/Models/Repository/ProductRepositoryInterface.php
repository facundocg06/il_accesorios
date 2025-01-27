<?php

namespace App\Models\Repository;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

interface ProductRepositoryInterface
{
    public function all($request);
    public function create($data);
    public function find($id);
    public function update($product, $data);

}
