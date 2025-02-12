<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryAdjustmentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\StockProducctionController;
use App\Http\Controllers\StockSalesController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Livewire\Product as ProductLivewire;
use App\Models\StockProduction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;





/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();
// Route::get('/', function () {
//     if (Auth::check()) {
//         return redirect()->route('home');
//     }
//     return view('auth.login');
// });


Route::get('/', [DashboardController::class, 'inicio'])->name('home')->middleware('auth');



Route::middleware('auth')->group(function () {
    Route::get('/ventas-reportes', [DashboardController::class, 'ventasReporte'])->name('ventas-reportes');

    /* -----------------------------------------CATEGORY------------------------------------------------- */
    Route::get('category/category-list', [CategoryController::class, 'category_list'])->name('category-list');
    Route::post('category/add-category', [CategoryController::class, 'register_category'])->name('category-add');
    Route::delete('category/category-delete/{id}', [CategoryController::class, 'delete_category'])->name('category-delete');
    Route::put('category/category-update/{id}', [CategoryController::class, 'update_category'])->name('category-update');

    /* -----------------------------------------PRODUCTS------------------------------------------------- */
    Route::get('product/product-add', [ProductController::class, 'product_add'])->name('product-add');
    Route::get('product/product-list', [ProductController::class, 'product_list'])->name('product-list');
    Route::delete('product/product-delete/{id}', [ProductController::class, 'delete_product'])->name('product-delete');
    Route::get('product/{id}/product-edit', [ProductController::class, 'product_edit'])->name('product-edit');


    Route::put('stock/update', action: [StockSalesController::class, 'updateStock'])->name('updateStock');
    // Ruta para agregar stock
    Route::post('/add-stock', [StockSalesController::class, 'addStock'])->name('addStock');



    Route::get('/products', ProductLivewire::class)->name('products.index');
    Route::get('/products/create', [ProductLivewire::class, 'create'])->name('products.create');


    /*/-----------------------------------------SALES-----------------------------------------------------*/
    Route::get('sales/sales-list', [SaleController::class, 'sales_list'])->name('sales-list');
    Route::get('sales/sales-add', [SaleController::class, 'sales_add'])->name('sales-add');
    Route::post('sales/register-sale', [SaleController::class, 'register_sale'])->name('register-sale');
    Route::get('sales/sales-preview/{sale}/{requestData}', [SaleController::class, 'sales_preview'])->name('sales-preview');
    Route::get('/sales/sales-print', [SaleController::class, 'sales_print'])->name('sales-print');
    Route::get('/get-products-by-store/{storeId}', [ProductController::class, 'getProductsByStore']);

    Route::put('/sales/confirm-sale/{id_sale}', [SaleController::class, 'confirm_sale'])->name('confirm-sale');


    Route::get('/date-reports', [SaleController::class, 'salesReportForm'])->name('reports.ventas.form');
    Route::post('/generate', [SaleController::class, 'generateSalesReport'])->name('reports.ventas.generate');
    Route::post('/reports/ventas/send', [SaleController::class, 'sendSalesReport'])->name('reports.ventas.send');
    /* -----------------------------------------USERS------------------------------------------------- */
    Route::get('user/user-list', [UserController::class, 'user_list'])->name('user-list');
    Route::post('user/user-add', [UserController::class, 'register_user'])->name('user-add');
    Route::get('user/user-edit/{id}', [UserController::class, 'edit_user'])->name('user-edit');
    Route::put('user/user-update/{id}', [UserController::class, 'update_user'])->name('user-update');
    Route::delete('user/user-delete/{id}', [UserController::class, 'delete_user'])->name('user-delete');

    /* -----------------------------------------SUPPLIERS------------------------------------------------- */
    route::get('supplier/supplier-list', [SupplierController::class, 'supplier_list'])->name('supplier-list');
    route::get('supplier/supplier-add', [SupplierController::class, 'register_supplier'])->name('supplier-add');
    route::delete('supplier/supplier-delete/{id}', [SupplierController::class, 'delete_supplier'])->name('supplier-delete');
    route::get('supplier/supplier-edit/{id}', [SupplierController::class, 'edit_supplier'])->name('supplier-edit');
    Route::put('supplier/supplier-update/{id}', [SupplierController::class, 'update_supplier'])->name('supplier-update');
    Route::get('supplier/supplier-view/{id}', [SupplierController::class, 'view_supplier'])->name('supplier-view');

    Route::post('supplier/stock/add', [SupplierController::class, 'register_stock'])->name('supplier-stock-add');

    Route::get('supplier/supplier-view/{id}/purchases-list', [PurchaseController::class, 'purchase_list'])->name('purchase-list');


    /* -----------------------------------------CUSTOMERS------------------------------------------------- */
    route::get('customer/customer-list', [CustomerController::class, 'customer_list'])->name('customer-list');
    Route::get('customer/customer-add', [CustomerController::class, 'register_customer'])->name('customer-add');
    route::delete('customer/customer-delete/{id}', [CustomerController::class, 'delete_customer'])->name('customer-delete');
    route::get('customer/customer-edit/{id}', [CustomerController::class, 'edit_customer'])->name('customer-edit');
    route::post('customer/customer-update/{id}', [CustomerController::class, 'update_customer'])->name('customer-update');

    /*-----------------------------------------StockProduction-------------------------------------------------*/
    Route::put('stock/stock-update/{id}', [SupplierController::class, 'update_stock'])->name('stock-update');
    Route::delete('stock/stock-delete/{id}', [SupplierController::class, 'delete_stock'])->name('stock-delete');


    /*-----------------------------------------PURCHASES-------------------------------------------------*/
    Route::get('supplier/{supplierId}/purchases/add', [PurchaseController::class, 'add_purchase'])->name('purchase-add');


    Route::get('purchase/purchase-view/{id}', [PurchaseController::class, 'view_purchase'])->name('purchase-view');
    Route::post('purchase/purchase-register', [PurchaseController::class, 'register_purchase'])->name('purchase-register');
    // Route::get('purchase/purchase-register', [PurchaseController::class, 'register_purchase'])->name('purchase-register');
    Route::delete('purchase/purchase-delete/{id}', [PurchaseController::class, 'delete_purchase'])->name('purchase-delete');
    Route::get('purchase/purchase-edit/{id}', [PurchaseController::class, 'edit_purchase'])->name('purchase-edit');
    Route::put('purchase/purchase-update/{id}', [PurchaseController::class, 'update_purchase'])->name('purchase-update');

    // Route::get('/get-supplier-by-nit', [SupplierController::class, 'getSupplierByNIT'])->name('get-supplier-by-nit');
    Route::get('/obtener-nit_supplier/{nit_supplier}', [PurchaseController::class, 'obtenernit_supplier'])->name('obtenernit_supplier');
    //inventario

    Route::get('/inventory-adjustments/create', [InventoryAdjustmentController::class, 'create'])->name('inventory-adjustments.create');
    Route::post('/inventory-adjustments', [InventoryAdjustmentController::class, 'store'])->name('inventory-adjustments.store');
    /*------------------------------------------STORE -------------------------------------------------------- */
    route::get('store/store-list', [StorageController::class, 'store_list'])->name('store-list');
    route::post('store/store-add', [StorageController::class, 'register_store'])->name('store-add');
    route::delete('store/store-delete/{id}', [StorageController::class, 'delete_store'])->name('store-delete');
    route::get('store/store-edit/{id}', [StorageController::class, 'edit_store']);
    route::put('store/store-update/{id}', [StorageController::class, 'update_store'])->name('store-update');
    /*------------------------------------------ //----// -------------------------------------------------------- */
    Route::get('/reports/ventas/producto', [SaleController::class, 'salesReportByProductForm'])
        ->name('reports.ventas.producto.form');

    Route::post('/reports/ventas/producto/generate', [SaleController::class, 'generateSalesByProductReport'])
        ->name('reports.ventas.producto.generate');
    Route::post('/sendemail', [SaleController::class, 'sendSalesByProductReport'])->name('reports.ventas.productos.email');

    Route::get('/reports/adjustments', [InventoryAdjustmentController::class, 'adjustmentReportForm'])
        ->name('reports.adjustments.form');

    // Generar reporte
    Route::post('/reports/adjustments/generate', [InventoryAdjustmentController::class, 'generateAdjustmentReport'])
        ->name('reports.adjustments.generate');

    // Enviar reporte por correo

    Route::post('/send-adjustment-email', [InventoryAdjustmentController::class, 'sendAdjustmentReport'])
        ->name('reports.adjustments.send_email');


    Route::get('/roles-permissions', [RolePermissionController::class, 'index'])->name('roles-permissions.index');
    Route::post('/roles', [RolePermissionController::class, 'storeRole'])->name('roles.store');
    Route::post('/permissions', [RolePermissionController::class, 'storePermission'])->name('permissions.store');
    Route::post('/assign-role', [RolePermissionController::class, 'assignRole'])->name('assign.role');
    Route::post('/assign-permission', [RolePermissionController::class, 'assignPermission'])->name('assign.permission');
    Route::post('/remove-role', [RolePermissionController::class, 'removeRole'])->name('remove.role');
    Route::post('/remove-permission', [RolePermissionController::class, 'removePermission'])->name('remove.permission');
});
