<?php

namespace App\Http\Controllers;

use App\Http\Messages\ErrorMessages;
use App\Http\Messages\SuccessMessages;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\Services\BrandService;
use App\Models\Services\CategoryService;
use App\Models\Services\ColorService;
use App\Models\Services\ProductService;
use App\Models\Services\SizeService;
use App\Models\Services\StoreService;
use App\Models\StockSales;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $categoryService;
    protected $productService;
    protected $brandService;
    protected $storeService;
    public function __construct(ProductService $productService, CategoryService $categoryService, BrandService $brandService,  StoreService $storeService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->brandService = $brandService;
        $this->storeService = $storeService;
    }
    public function  product_add()
    {
        $categories = $this->categoryService->getAll();
        $brands = $this->brandService->getAll();

        $stores = $this->storeService->getAll();
        //dd($categories,$brands,$colors,$sizes,$stores);
        return view('content.product.product-add', compact('categories', 'brands',  'stores'));
    }
    public function product_list(Request $request)
    {
        $products = $this->productService->getAllProducts($request);
        $categories = $this->categoryService->getAll();
        $stores = $this->storeService->getAll();
        $brands = $this->brandService->getAll();


        return view('content.product.product-list', compact('products', 'categories', 'stores', 'brands',));
    }
    public function register_product(ProductRequest $productRequest)
    {
        try {
            $this->productService->registerProduct($productRequest->all());
            return redirect()->route('product-list')->with('success', SuccessMessages::PRODUCT_CREATED);
        } catch (Exception $e) {
            return redirect()->route('product-list')->with('error', ErrorMessages::PRODUCT_CREATION_ERROR);
        }
    }
    public function product_edit($id)
    {
        return view('content.product.product-edit', compact('id'));
    }
    public function product_delete($id)
    {
        dd($id);
    }
    public function getProductsByStore($storeId)
    {
        $products = StockSales::where('store_id', $storeId)->get();
        return response()->json($products);
    }
}
