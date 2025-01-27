<?php

namespace App\Models\Services;

use Illuminate\Support\Facades\DB;
use App\Http\Messages\ErrorMessages;
use App\Models\Repository\StockRepositoryInterface;

class StockService
{
    protected $stockRepository;

    public function __construct(StockRepositoryInterface $stockRepository)
    {
        $this->stockRepository = $stockRepository;
    }
    public function getAll()
    {
        return $this->stockRepository->all();
    }
    public function find($id)
    {
        return $this->stockRepository->find($id);
    }
    public function createStock($data)
    {
        return DB::transaction(function () use ($data) {
            $Stock = $this->stockRepository->create($data);
            return $Stock;
        });
    }
    public function deleteStock($idStock)
    {
        return DB::transaction(function () use ($idStock) {
            $Stock = $this->stockRepository->find($idStock);
            if (!$Stock) {
                return ErrorMessages::STOCK_NOT_FOUND;
            }
            $Stock = $this->stockRepository->delete($Stock);
            return $Stock;
        });
    }
    public function updateStock($stock, $data)
    {
        return DB::transaction(function () use ($stock, $data) {
            $Stock = $this->stockRepository->find($stock);
            if (!$Stock) return ErrorMessages::STOCK_NOT_FOUND;

            return $this->stockRepository->update($Stock, $data);
        });
    }

    public function countAllstock()
    {
        return $this->stockRepository->all()->count();
    }
}
