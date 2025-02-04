<?php

namespace App\Http\Controllers;

use App\Models\DetailsAdjustment;
use App\Models\InventoryAdjustment;
use App\Models\Product;
use App\Models\StockSales;
use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InventoryAdjustmentController extends Controller
{
    public function create()
    {
        return view('content.adjustment.adjustment', [
            'products' => Product::all(),
            'stores' => Store::all(),
        ]);
    }

    public function store(Request $request)
    {

        //$request->merge(['date' => Carbon::now()->toDateString()]);
        Log::info($request);
        $request->validate([
            'description' => 'nullable|string',
            'product_id' => 'required|exists:products,id',
            'store_id' => 'required|exists:stores,id',
            'type' => 'required|in:Ingreso,Egreso',
            'quantity' => 'required|integer|min:1',
        ]);
        Log::info($request);

        DB::transaction(function () use ($request) {
            Log::info($request);
            $adjustment = InventoryAdjustment::create([
                'date' => Carbon::now(),
                'description' => $request->description,
                'user_id' => auth()->user()->id,
                'type' => $request->type,
            ]);

            // Iterar sobre los productos ajustados


            // Buscar stock existente
            $stock = StockSales::where('product_id', $request->product_id)
                ->where('store_id', $request->store_id)
                ->first();

            if (!$stock && $request->type === 'Ingreso') {
                // Si no hay stock registrado y es un ingreso, crear el registro inicial
                $stock = StockSales::create([
                    'product_id' => $request->product_id,
                    'store_id' => $request->store_id,
                    'quantity' => $request->quantity,
                    'created_by' => auth()->user()->id,
                    'updated_by' => auth()->user()->id,
                ]);
            } elseif (!$stock && $request->type === 'Egreso') {
                return back()->withErrors(['error' => "No hay stock disponible para el producto {$request->product_id} en la tienda {$request->store_id}."]);
            }

            if ($request->type === 'Ingreso') {
                $stock->increment('quantity', $request->quantity);
            } elseif ($request->type === 'Egreso') {
                if ($stock->quantity < $request->quantity) {
                    return back()->withErrors(['error' => "Stock insuficiente para el producto  {$request->product_id} en la tienda {$request->store_id}."]);
                }
                $stock->decrement('quantity', $request->quantity);
            }

            // Guardar el detalle del ajuste
            DetailsAdjustment::create([
                'inventory_adjustment_id' => $adjustment->id,
                'stock_sale_id' => $stock->id,
                'product_id' => $request->product_id,
                'store_id' => $request->store_id,
                'quantity' => $request->quantity,
            ]);
        });

        return redirect()->route('inventory-adjustments.create')->with('success', 'Ajuste de inventario registrado correctamente.');
    }
}
