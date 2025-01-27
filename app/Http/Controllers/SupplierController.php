<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Exception;
use App\Models\Services\SupplierService;
use App\Http\Messages\ErrorMessages;
use App\Http\Messages\SuccessMessages;
use App\Http\Requests\SupplierRequest;
use App\Models\Services\StockService;
use App\Models\StockProduction;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    protected $supplierService;
    protected $stockService;

    public function __construct(SupplierService $supplierService, StockService $stockService)
    {
        $this->supplierService = $supplierService;
        $this->stockService = $stockService;
    }

    public function supplier_list()
    {
        $suppliers = $this->supplierService->getAll();
        return view('content.supplier.supplier-list', compact('suppliers'));
    }

    public function register_supplier(SupplierRequest $supplierRequest)
    {
        try {
            $this->supplierService->createSupplier($supplierRequest->all());
            return redirect()->route('supplier-list')->with('success', SuccessMessages::SUPPLIER_CREATED);
        } catch (Exception $e) {
            return redirect()->route('supplier-list')->with('error', ErrorMessages::SUPPLIER_CREATION_ERROR);
        }
    }

    public function delete_supplier($id)
    {
        DB::beginTransaction();
        try {
            $supplier = Supplier::findOrFail($id);

            foreach ($supplier->stockProduction as $stockProduction) {
                $stockProduction->delete();
            }

            $supplier->delete();

            DB::commit();
            return redirect()->route('supplier-list')->with('success', SuccessMessages::SUPPLIER_DELETED);
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('supplier-list')->with('error',ErrorMessages::SUPPLIER_DELETE_ERROR);
        }
    }

    public function update_supplier(Request $request, $id)
    {
        try {
            $this->supplierService->updateSupplier($id, $request->all());
            return redirect()->route('supplier-list')->with('success', SuccessMessages::SUPPLIER_UPDATED);
        } catch (Exception $e) {
            dd($e);
            return redirect()->route('supplier-list')->with('error', ErrorMessages::SUPPLIER_UPDATE_ERROR);
        }
    }

    public function view_supplier($id)
    {
        $supplier = Supplier::with('stockProduction')->find($id);
        if (!$supplier) {
            return redirect()->route('ruta_de_error')->with('error', 'Proveedor no encontrado');
        }
        $stockcount = $supplier->stockProduction->count();
        $stockProductions = $supplier->stockProduction;
        return view('content.supplier.supplier-view', compact('supplier', 'stockcount', 'stockProductions'));
    }

    public function register_stock(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'suppliers_id' => 'required|exists:suppliers,id'
        ]);

        try {
            $stock = new StockProduction($validated);
            $stock->save();

            return back()->with('success', SuccessMessages::STOCK_CREATED);
        } catch (Exception $e) {
            return back()->with('error', ErrorMessages::STOCK_CREATION_ERROR);
        }
    }

    public function delete_stock($id)
    {
        try {
            $this->stockService->deleteStock($id);
            return redirect()->route('supplier-list')->with('success', SuccessMessages::STOCK_DELETED);
        } catch (Exception $e) {
            return redirect()->route('supplier-list')->with('error', ErrorMessages::STOCK_DELETE_ERROR);
        }
    }

    public function update_stock(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'suppliers_id' => 'required|exists:suppliers,id'
        ]);

        try {
            DB::beginTransaction();
            $stockProduction = StockProduction::findOrFail($id);
            $stockProduction->update([
                'name' => $validated['name'],
                'price' => $validated['price'],
                'description' => $validated['description'],
                'suppliers_id' => $validated['suppliers_id']
            ]);
            DB::commit();
            return redirect()->route('supplier-view', ['id' => $validated['suppliers_id']])->with('success',SuccessMessages::STOCK_UPDATED );        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('supplier-view', ['id' => $validated['suppliers_id']])->with('error', ErrorMessages::STOCK_UPDATE_ERROR);
        }
    }


}
