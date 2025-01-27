<?php

namespace App\Models\Repository;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

interface PhotoRepositoryInterface
{
    public function uploadFile($product,$urlFile);


}
