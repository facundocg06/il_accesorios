<?php

namespace App\Models\Services;

use Illuminate\Support\Facades\DB;
use App\Http\Messages\ErrorMessages;
use App\Http\Resources\UserResource;
use App\Http\Resources\VarietyProductsResource;
use App\Models\Repository\CategoryRepositoryInterface;
use App\Models\Repository\PhotoRepositoryInterface;
use App\Models\Repository\ProductRepositoryInterface;
use App\Models\Repository\StockSalesRepositoryInterface;

class ProductService
{
    protected $productRepository;
    protected $stockSalesRepository;
    protected $photoRepository;
    public function __construct(ProductRepositoryInterface $productRepository, StockSalesRepositoryInterface $stockSalesRepository, PhotoRepositoryInterface $photoRepository)
    {
        $this->productRepository = $productRepository;
        $this->stockSalesRepository = $stockSalesRepository;
        $this->photoRepository = $photoRepository;
    }
    public function getAllProducts($request)
    {
        return $this->productRepository->all($request);
    }
    public function getAllVarietyProducts(){
        return VarietyProductsResource::collection($this->stockSalesRepository->allVarietyProducts())->resolve();
    }
    public function getProductById($id){
        return $this->productRepository->find($id);
    }
    public function registerProduct($data)
    {
        return DB::transaction(function () use ($data) {
            $product = $this->productRepository->create($data);
            $this->addVarietiesProduct($product, $data['productVeriety']);
            return $product;
        });
    }
    public function uploadFile($file,$product)
    {
        $path = $file->store('products');
        $this->photoRepository->uploadFile($product,$path);
    }
    public function addVarietiesProduct($product, $variaties)
    {
        foreach ($variaties as $variety) {
            $this->stockSalesRepository->addVarietyToStock($product, $variety);
        }
    }

    public function updateProduct($product_id,$data){
        return DB::transaction(function () use ($product_id,$data) {
            $product = $this->productRepository->find($product_id);
            $this->productRepository->update($product,$data);
            return $product;
        });
    }

    
}
