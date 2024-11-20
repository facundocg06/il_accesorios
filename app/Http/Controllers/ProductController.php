<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Http\Messages\ErrorMessages;
use App\Models\Services\SizeService;
use App\Http\Requests\ProductRequest;
use App\Models\Services\BrandService;
use App\Models\Services\ColorService;
use App\Models\Services\StoreService;
use App\Http\Messages\SuccessMessages;
use App\Models\Services\ProductService;
use App\Models\Services\CategoryService;

class ProductController extends Controller
{
    protected $categoryService;
    protected $productService;
    protected $brandService;
    protected $colorService;
    protected $sizeService;
    protected $storeService;
    public function __construct(ProductService $productService,CategoryService $categoryService, BrandService $brandService,ColorService $colorService,SizeService $sizeService,StoreService $storeService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->brandService = $brandService;
        $this->colorService = $colorService;
        $this->sizeService = $sizeService;
        $this->storeService = $storeService;
    }
    public function  product_add (){
        $categories = $this->categoryService->getAll();
        $brands = $this->brandService->getAll();
        $colors = $this->colorService->getAll();
        $sizes = $this->sizeService->getAll();
        $stores = $this->storeService->getAll();
        //dd($categories,$brands,$colors,$sizes,$stores);
        return view('content.product.product-add',compact('categories','brands','colors','sizes','stores'));
    }
    public function product_list(Request $request){
        $products = $this->productService->getAllProducts($request);
        $categories = $this->categoryService->getAll();
        return view('content.product.product-list',compact('products','categories'));
    }
    public function register_product(ProductRequest $productRequest){
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
    public function product_delete($id){
        dd($id);
    }

}
