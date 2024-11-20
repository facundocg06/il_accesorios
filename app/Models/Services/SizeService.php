<?php

namespace App\Models\Services;

use App\Models\Repository\SizeRepositoryInterface;

class SizeService
{
    protected $sizeRepository;
    public function __construct(SizeRepositoryInterface $sizeRepository)
    {
        $this->sizeRepository = $sizeRepository;
    }
    public function getAll(){
        return $this->sizeRepository->all();
    }
}
