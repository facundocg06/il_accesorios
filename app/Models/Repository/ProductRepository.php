<?php

namespace App\Models\Repository;

use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

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
        Log::info("Datos recibidos para crear producto:", $data);
        $filteredData = Arr::only($data, (new Product)->getFillable());
        return Product::create($filteredData);
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
