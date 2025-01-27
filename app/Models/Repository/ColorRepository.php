<?php

namespace App\Models\Repository;

use App\Models\Color;

class ColorRepository implements ColorRepositoryInterface
{
    public function all(){
        return Color::all();
    }
}
