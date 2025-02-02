<?php

namespace App\Livewire;

use App\Models\Services\CustomerService;
use App\Models\Services\ProductService;
use App\Models\Services\StoreService;
use Livewire\Component;

class Sale extends Component
{
    public $selectedItem;
    public $products;
    public $customers;
    public $stores;

    //Modelo de venta
    public $ci_customer;
    public $name_customer;
    public $phone_customer;
    public $email_customer;

    public $items = [];

    public function mount(ProductService $productService, CustomerService $customerService, StoreService $storeService)
    {
        $this->products = $productService->getAllVarietyProducts();
        $this->customers = $customerService->getAll();
        $this->stores = $storeService->getAll(); // Obtener tiendas
    }

    public function submit()
    {
        // Lógica de envío aquí
    }

    public function render()
    {
        return view('livewire.sale', [
            'products' => $this->products,
            'customers' => $this->customers,
            'stores' => $this->stores, // Pasar tiendas a la vista
        ]);
    }
}
