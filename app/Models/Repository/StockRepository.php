<?php

namespace App\Models\Repository;

use App\Models\Repository\StockRepositoryInterface;
use App\Models\StockProduction;

class StockRepository implements StockRepositoryInterface
{
    public function all()
    {
        return StockProduction::all();
    }

    public function create(array $data)
    {
        // dd($data);
        return StockProduction::create($data);
    }
    public function update( $stock, $data){
        // dd($stock, $data);
        return $stock->update($data);
    }

    public function delete( $stock)
    {
        // dd($stock);
        return $stock->delete();
    }

    public function find($id)
    {
        return StockProduction::find($id);
    }
}
