<?php

namespace App\Models\Repository;

use App\Models\Brand;
use App\Models\Photos;

class PhotoRepository implements PhotoRepositoryInterface
{
    public function uploadFile($product,$urlFile){
        return Photos::create([
            'product_id' => $product->id,
            'url_photo' => $urlFile
        ]);
    }
}
