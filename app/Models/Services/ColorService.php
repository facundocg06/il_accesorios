<?php

namespace App\Models\Services;

use App\Models\Repository\ColorRepositoryInterface;

class ColorService
{
    protected $colorRepository;

    public function __construct(ColorRepositoryInterface $colorRepository)
    {
        $this->colorRepository = $colorRepository;
    }
    public function getAll(){
        return $this->colorRepository->all();
    }
}
