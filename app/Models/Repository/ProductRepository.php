<?php

namespace App\Models\Repository;

use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    public function all($request)
    {
        $query = Product::query();

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        return $query->get();
    }
    public function create($data)
    {
        return Product::create($data);
    }
    public function find($id)
    {
        return Product::find($id);
    }
    public function update($product, $data)
    {
        $product->update($data);
    }
}
