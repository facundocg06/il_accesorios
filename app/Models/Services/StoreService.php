<?php

namespace App\Models\Services;

use App\Models\Repository\StoreRepositoryInterface;
use App\Models\Store;

class StoreService
{
    protected $storeRepository;
    public function __construct(StoreRepositoryInterface $storeRepository)
    {
        $this->storeRepository = $storeRepository;
    }
    public function getAll()
    {
        return $this->storeRepository->all();
    }

    public function countAllStores()
    {
        return Store::count();
    }
    public function createStore($data){
        return $this->storeRepository->create($data);
    }
}
