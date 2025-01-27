<?php

namespace App\Models\Repository;

use App\Models\PurchaseDetail;

class PurchaseDetailRepository implements PurchaseDetailRepositoryInterface
{
    public function all()
    {
        return PurchaseDetail::all();
    }
    public function create($data)
    {
        return PurchaseDetail::create($data);
    }
    public function update($purchasedetail, $data){
        return $purchasedetail->update($data);
    }
    public function delete($purchasedetail){
        return $purchasedetail->delete();
    }
    public function find($id){
        return PurchaseDetail::find($id);
    }
}
