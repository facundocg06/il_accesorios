<?php

namespace App\Models\Repository;

use App\Models\SaleNote;
use App\Models\SaleDetail;


class SaleRepository implements SaleRepositoryInterface
{
    public function all(){
        return SaleNote::all();
    }
    public function find($id){
        return SaleNote::find($id);
    }
    public function createSale(array $data)
    {
        return SaleNote::create([
            'customer_id' => $data['customer_id'],
            'sale_date' => $data['sale_date'],
            'total_quantity' => $data['total_quantity'],
            'sale_state' => $data['sale_state'],
            'payment_method' => $data['payment_method'],
        ]);
    }
    public function createSaleDetail(array $data)
    {
        return SaleDetail::create([
            'stock_sale_id' => $data['stock_sale_id'],
            'sale_note_id' => $data['sale_note_id'],
            'unitsale_price' => $data['unitsale_price'],
            'amount' => $data['amount'],
            'subtotal_price' => $data['subtotal_price'],
        ]);
    }
    public function confirmSale($sale){
        $sale->sale_state = 'PAGADO';
        $sale->save();
    }
}
