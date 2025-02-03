<?php

namespace App\Livewire;

use Exception;
use App\Models\Photos;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Http\Messages\ErrorMessages;
use App\Models\Services\SizeService;
use App\Http\Requests\ProductRequest;
use App\Models\Services\BrandService;
use App\Models\Services\ColorService;
use App\Models\Services\StoreService;
use App\Http\Messages\SuccessMessages;
use App\Models\Services\ProductService;
use Illuminate\Support\Facades\Storage;
use App\Models\Services\CategoryService;

class Product extends Component
{
    use WithFileUploads;

    public $name;
    public $description;
    public $price;
    public $files = [];
    public $category_id;
    public $brand_id;
    public $barcode;
    //public $productVeriety = [];

    public $categories;
    public $brands;
    public $stores;

    public $product_id;

    public function mount(CategoryService $categoryService, BrandService $brandService, ColorService $colorService, SizeService $sizeService, StoreService $storeService, $product_id = null)
    {
        $this->categories = $categoryService->getAll();
        $this->brands = $brandService->getAll();
        $this->stores = $storeService->getAll();

        if ($product_id) {
            $this->product_id = $product_id;
            $this->loadProduct($product_id);
        }
    }

    public function loadProduct($product_id)
    {
        $product = app(ProductService::class)->getProductById($product_id);
        $this->name = $product->name;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->category_id = $product->category_id;
        $this->brand_id = $product->brand_id;
        $this->barcode = $product->barcode;
    }

    public function submit(ProductService $productService)
    {
        $validatedData = $this->validate(ProductRequest::getRules(), ProductRequest::getMessages());
        try {
            //dd($validatedData);
            if ($this->product_id) {
                $productService->updateProduct($this->product_id, $validatedData);
                return redirect()->route('product-list')->with('success', SuccessMessages::PRODUCT_UPDATED);
            } else {
                $product = $productService->registerProduct($validatedData);
                foreach ($validatedData['files'] as $file) {
                    $path = $file->store('products'); // Guarda la imagen en storage/app/public/products
                    Photos::create([
                        'product_id' => $product->id,
                        'url_photo' => $path
                    ]);
                    $product->url_front_page = $path;
                    $product->save();
                }
                return redirect()->route('product-list')->with('success', SuccessMessages::PRODUCT_CREATED);
            }
            return redirect()->route('product-list')->with('success', SuccessMessages::PRODUCT_CREATED);
            $this->reset();
            // $this->productVeriety = [];
        } catch (Exception $e) {
            return redirect()->route('product-list')->with('error', $e->getMessage());
        }
    }
    public function uploadFiles($productId) {}
    public function render()
    {
        return view('livewire.product');
    }
}
