<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Services\CustomerService;
use App\Models\Services\ProductService;
use Livewire\Component;

class Sale extends Component
{
    public $selectedItem;
    public $products;
    protected $customers;

    //Modelo de venta
    public $ci_customer;
    public $name_customer;
    public $phone_customer;
    public $email_customer;

    public $items = [];



    public function mount(ProductService $productService,CustomerService $customerService)
    {
        //dd($productService->getAllVarietyProducts());
        $this->products = $productService->getAllVarietyProducts();
        $this->customers = $customerService->getAll();

    }

    public function submit(){

    }

    public function render()
    {
        return view('livewire.sale',[
            'products' => $this->products,
            'customers' => $this->customers,
        ]);
    }
}
