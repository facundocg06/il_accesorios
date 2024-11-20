<?php

namespace App\Providers;

use Livewire\Livewire;
use App\Models\PurchaseDetail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use App\Models\Repository\SaleRepository;
use App\Models\Repository\SizeRepository;
use App\Models\Repository\UserRepository;
use App\Models\Repository\BrandRepository;
use App\Models\Repository\ColorRepository;
use App\Models\Repository\PhotoRepository;
use App\Models\Repository\StockRepository;
use App\Models\Repository\StoreRepository;
use App\Models\Repository\ProductRepository;
use App\Models\Repository\CategoryRepository;
use App\Models\Repository\CustomerRepository;
use App\Models\Repository\PurchaseRepository;
use App\Models\Repository\SupplierRepository;
use App\Models\Repository\StockSalesRepository;
use App\Models\Repository\SaleRepositoryInterface;
use App\Models\Repository\SizeRepositoryInterface;
use App\Models\Repository\UserRepositoryInterface;
use App\Models\Repository\BrandRepositoryInterface;
use App\Models\Repository\ColorRepositoryInterface;
use App\Models\Repository\PhotoRepositoryInterface;
use App\Models\Repository\PurchaseDetailRepository;
use App\Models\Repository\StockRepositoryInterface;
use App\Models\Repository\StoreRepositoryInterface;
use App\Models\Repository\StockProductionRepository;
use App\Models\Repository\ProductRepositoryInterface;
use App\Models\Repository\CategoryRepositoryInterface;
use App\Models\Repository\CustomerRepositoryInterface;
use App\Models\Repository\PurchaseRepositoryInterface;
use App\Models\Repository\SupplierRepositoryInterface;
use App\Models\Repository\StockSalesRepositoryInterface;
use App\Models\Repository\PurchaseDetailRepositoryInterface;
use App\Models\Repository\StockProductionRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );
        $this->app->bind(
            CategoryRepositoryInterface::class,
            CategoryRepository::class
        );
        $this->app->bind(
            BrandRepositoryInterface::class,
            BrandRepository::class
        );
        $this->app->bind(
            ProductRepositoryInterface::class,
            ProductRepository::class
        );
        $this->app->bind(
            StoreRepositoryInterface::class,
            StoreRepository::class
        );
        $this->app->bind(
            ColorRepositoryInterface::class,
            ColorRepository::class
        );
        $this->app->bind(
            SizeRepositoryInterface::class,
            SizeRepository::class
        );
        $this->app->bind(
            StockSalesRepositoryInterface::class,
            StockSalesRepository::class
        );
        $this->app->bind(
            SupplierRepositoryInterface::class,
            SupplierRepository::class
        );
        $this->app->bind(
            CustomerRepositoryInterface::class,
            CustomerRepository::class
        );
        $this->app->bind(
            SaleRepositoryInterface::class,
            SaleRepository::class
        );
        $this->app->bind(
            PurchaseRepositoryInterface::class,
            PurchaseRepository::class
        );
        $this->app->bind(
            PurchaseDetailRepositoryInterface::class,
            PurchaseDetailRepository::class
        );
        $this->app->bind(
            StockRepositoryInterface::class,
            StockRepository::class
        );
        $this->app->bind(
            PhotoRepositoryInterface::class,
            PhotoRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Livewire::setScriptRoute(function ($handle) {
            // Define la ruta personalizada con tu contexto específico
            return Route::get('/inf513/grupo07sc/CREAMODA-LARAVEL/public/livewire/livewire.js', $handle);
        });
    }
}
