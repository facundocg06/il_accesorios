<?php

namespace App\Livewire;

use App\Models\Supplier;
use Livewire\Component;

class PurchaseNotes extends Component
{
    public $nit_supplier;
    public $reason_social;
    public $purchase_date;
    public $total_quantity;

    public function updatedNitSupplier($value)
    {
        $supplier = Supplier::where('nit_supplier', $value)->first();
        $this->reason_social = $supplier ? $supplier->reason_social : 'Proveedor no encontrado';
    }


    public function render()
    {
        return view('livewire.purchase-notes');
    }




}
