<?php

namespace App\Models\Repository;

use App\Models\Size;

class SizeRepository implements SizeRepositoryInterface
{
    public function all(){
        return Size::all();
    }
}
