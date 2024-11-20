<?php

namespace App\Models\Repository;

use App\Models\StockProduction;

interface StockRepositoryInterface
{
    public function all();
    public function create(array $data);
    public function update(StockProduction $stock, Array $data);
    public function delete( $stock);
    public function find(int $id);
}
