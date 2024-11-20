<?php

namespace App\Models\Services;

use App\Models\Repository\BrandRepositoryInterface;

class BrandService
{
    protected $branRepository;

    public function __construct(BrandRepositoryInterface $branRepository)
    {
        $this->branRepository = $branRepository;
    }
    public function getAll(){
        return $this->branRepository->all();
    }
}
