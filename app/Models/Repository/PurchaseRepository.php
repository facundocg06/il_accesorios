<?php

namespace App\Models\Repository;

use App\Models\PurchaseDetail;
use App\Models\PurchaseNotes;

class PurchaseRepository implements PurchaseRepositoryInterface
{
    public function all()
    {
        return PurchaseNotes::all();
    }
    // public function create($data)
    // {
    //     return PurchaseNotes::create($data);
    // }

    public function create($data)
    {
        $purchaseNote = PurchaseNotes::create([
            'purchase_date' => $data['purchase_date'],
            'total_quantity' => $data['total_quantity'],
            'supplier_id' => $data['supplier_id'],
        ]);

        foreach ($data['products'] as $product) {
            PurchaseDetail  ::create([
                'stock_production_id' => $product['stock_production_id'],
                'purchase_note_id' => $purchaseNote->id,
                'amount' => $product['amount'],
                'price_purchase_detail' => $product['price_purchase_detail'],
            ]);
        }

        return $purchaseNote;
    }

    public function update($purchase, $data){
        return $purchase->update($data);
    }
    public function delete($purchase){
        return $purchase->delete();
    }
    public function find($id){
        return PurchaseNotes::find($id);
    }
}
