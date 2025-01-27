<?php

namespace App\Http\Controllers;

use App\Http\Messages\ErrorMessages;
use App\Http\Messages\SuccessMessages;
use App\Http\Requests\PurchaseRequest;
use App\Models\PurchaseDetail;
use App\Models\PurchaseNotes;
use App\Models\Services\PurchaseService;
use App\Models\Services\StockService;
use App\Models\Services\StoreService;
use App\Models\Services\SupplierService;
use App\Models\StockProduction;
use App\Models\Supplier;
use Carbon\Carbon;
use Exception;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PurchaseController extends Controller
{
    protected $purchaseService;
    protected $storeService;
    protected $supplierService;
    protected $stockService;

    public function __construct(PurchaseService $purchaseService, StoreService $storeService, SupplierService $supplierService, StockService $stockService)
    {
        $this->purchaseService = $purchaseService;
        $this->storeService = $storeService;
        $this->supplierService = $supplierService;
        $this->stockService = $stockService;
    }

    public function purchase_list($id)
    {
        $purchases = PurchaseNotes::where('supplier_id', $id)->get()->map(function ($purchase) {
            $purchase->purchase_date = \Carbon\Carbon::parse($purchase->purchase_date)->format('Y-m-d');
            return $purchase;
        });

        $supplier = Supplier::find($id);

        $purchaseCount = $purchases->count();
        $purchaseSumQuantity = $purchases->sum('total_quantity');

        return view('content.purchase.purchase-list', compact('purchases', 'purchaseCount', 'supplier', 'purchaseSumQuantity'));
    }

    // public function purchase_list($id)
    // {
    //     $purchases = $this->purchaseService->getAll()->map(function ($purchase) {
    //         $purchase->purchase_date = \Carbon\Carbon::parse($purchase->purchase_date)->format('Y-m-d');
    //         return $purchase;
    //     });

    //     $purchaseCount = $this->purchaseService->countAllPurchaseNote();
    //     $storeCount = $this->storeService->countAllStores();
    //     $supplierCount = $this->supplierService->countAllSuppliers();
    //     $purchaseSumQuantity = $this->purchaseService->sumInversion();

    //     return view('content.purchase.purchase-list', compact('purchases', 'purchaseCount', 'storeCount', 'supplierCount', 'purchaseSumQuantity'));
    // }

    public function add_purchase($supplierId)
    {
        $supplier = Supplier::find($supplierId);
        if (!$supplier) {
            return back()->with('error', 'Proveedor no encontrado');
        }

        $purchase = $this->purchaseService->getAll();
        $stockService = $supplier->stockProduction;
        return view('content.purchase.purchase-add', compact('supplier', 'stockService', 'purchase'));
    }

    public function register_purchase(Request $request)
    {
        try {
            $validated = $request->validate([
                'purchase_date' => 'required|date',
                'total_quantity' => 'required|numeric',
                'supplier_id' => 'required|exists:suppliers,id',
                'products' => 'required|array',
                'products.*.stock_production_id' => 'required|exists:stock_productions,id',
                'products.*.amount' => 'required|numeric',
                'products.*.price_purchase_detail' => 'required|numeric'
            ]);

            $purchaseNote = PurchaseNotes::create([
                'purchase_date'   => $request->purchase_date,
                'total_quantity'  => $request->total_quantity,
                'supplier_id' => $request->supplier_id,
            ]);

            foreach ($request->products as $product) {
                PurchaseDetail::create([
                    'stock_production_id' => $product['stock_production_id'],
                    'purchase_note_id'    => $purchaseNote->id,
                    'amount'              => $product['amount'],
                    'price_purchase_detail' => $product['price_purchase_detail'],
                ]);
            }

            return redirect()->route('purchase-list', $request->supplier_id)->with('success', 'Compra creada exitosamente');
        } catch (Exception $e) {
            // dd($e);
            return back()->with('error', ErrorMessages::PURCHASE_CREATION_ERROR);
        }
    }

    public function view_purchase($id)
    {
        $purchase = PurchaseNotes::with([
            'purchaseDetails.stockProduction',
            'supplier'
        ])->findOrFail($id);

        $totalItems = $purchase->purchaseDetails->sum('amount');
        $totalCost = $purchase->purchaseDetails->reduce(function ($total, $detail) {
            return $total + ($detail->amount * $detail->price_purchase_detail);
        }, 0);

        return view('content.purchase.purchase-view', compact('purchase', 'totalItems', 'totalCost'));
    }


    public function delete_purchase($id)
    {
        try {
            DB::beginTransaction();
            $purchase = PurchaseNotes::findOrFail($id);
            $purchase->delete();
            DB::commit();
            return redirect()->route('purchase-list', ['id' => $id])->with('success', SuccessMessages::PURCHASE_DELETED);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', ErrorMessages::PURCHASE_DELETE_ERROR);
        }
    }

    public function edit_purchase($id)
    {
        $purchase = PurchaseNotes::with(['purchaseDetails', 'supplier'])->findOrFail($id);
        $suppliers = Supplier::all();
        $stockServices = StockProduction::all();
        return view('content.purchase.purchase-edit', compact('purchase', 'suppliers', 'stockServices'));
    }

    public function update_purchase(Request $request, $id)
    {
        $validated = $request->validate([
            'purchase_date' => 'required|date',
            'total_quantity' => 'required|numeric',
            'supplier_id' => 'required|exists:suppliers,id',
            'products' => 'required|array',
            'products.*.stock_production_id' => 'required|exists:stock_productions,id',
            'products.*.amount' => 'required|numeric',
            'products.*.price_purchase_detail' => 'required|numeric',
            'products.*.deleted' => 'required|boolean'
        ]);

        $purchase = PurchaseNotes::findOrFail($id);
        $purchase->update([
            'purchase_date' => $validated['purchase_date'],
            'total_quantity' => $validated['total_quantity'],
            'supplier_id' => $validated['supplier_id'],
        ]);

        foreach ($validated['products'] as $productData) {
            if ($productData['deleted']) {
                PurchaseDetail::where('purchase_note_id', $id)
                    ->where('stock_production_id', $productData['stock_production_id'])
                    ->delete();
            } else {
                $detail = PurchaseDetail::firstOrNew([
                    'purchase_note_id' => $id,
                    'stock_production_id' => $productData['stock_production_id']
                ]);
                $detail->amount = $productData['amount'];
                $detail->price_purchase_detail = $productData['price_purchase_detail'];
                $detail->save();
            }
        }

        return redirect()->route('purchase-list')->with('success', 'Compra actualizada exitosamente.');
    }
}
