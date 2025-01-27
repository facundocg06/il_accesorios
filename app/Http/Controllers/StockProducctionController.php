<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Http\Messages\ErrorMessages;
use App\Http\Messages\SuccessMessages;
use App\Http\Controllers\Controller;
use App\Http\Requests\StockRequest;
use App\Models\Services\StockService;
use App\Models\Services\SupplierService;
use App\Models\StockProduction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Psy\CodeCleaner\FunctionReturnInWriteContextPass;

class StockProducctionController extends Controller
{
    protected $stockService;
    protected $supplierService;

    public function __construct(StockService $stockService, SupplierService $supplierService)
    {
        $this->stockService = $stockService;
        $this->supplierService = $supplierService;
    }


    public function delete_stock($id)
    {
        try {
            DB::beginTransaction();
            $stockProduction = StockProduction::findOrFail($id);
            $supplierId = $stockProduction->suppliers_id;
            // dd($supplierId);
            $stockProduction->delete();
            DB::commit();
            return redirect()->route('supplier-view', ['id' => $supplierId])->with('success', SuccessMessages::STOCK_DELETED);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', ErrorMessages::STOCK_DELETE_ERROR);
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
            return redirect()->route('stock-list')->with('success', SuccessMessages::STOCK_UPDATED);
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('stock-list')->with('error', ErrorMessages::STOCK_UPDATE_ERROR);
        }
    }


    // public function update_stock(StockRequest $stockRequest, $idStock)
    // {
    //     try {
    //         $this->stockService->updateStock($stockRequest->all(), $idStock);
    //         return redirect()->route('stock-list')->with('success', SuccessMessages::STOCK_UPDATED);
    //     } catch (Exception $e) {
    //         return redirect()->route('stock-list')->with('error', ErrorMessages::STOCK_UPDATE_ERROR);
    //     }
    // }
}
