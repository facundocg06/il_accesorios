<?php

namespace App\Models\Repository;

use App\Models\Brand;

class BrandRepository implements BrandRepositoryInterface
{
    public function all()
    {
        return Brand::all();
    }

}
