<?php

namespace App\Http\Controllers;

use App\Models\InventoryAdjustment;
use App\Models\DetailsAdjustment;
use App\Models\StockSales;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $request->validate([
            'date' => 'required|date',
            'description' => 'nullable|string',
            'product_id' => 'required|exists:products,id',
            'store_id' => 'required|exists:stores,id',
            'type' => 'required|in:Ingreso,Egreso',
            'quantity' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            $adjustment = InventoryAdjustment::create([
                'date' => $request->date,
                'description' => $request->description,
                'user_id' => auth()->user()->id,
                'product_id' => $request->product_id,
                'store_id' => $request->store_id,
                'type' => $request->type,
            ]);

            $stock = StockSales::where('product_id', $request->product_id)
                ->where('store_id', $request->store_id)
                ->first();

            if (!$stock && $request->type === 'Ingreso') {
                // Si no hay stock registrado y es un ingreso, crear el registro inicial
                $stock = StockSales::create([
                    'product_id' => $request->product_id,
                    'store_id' => $request->store_id,
                    'quantity' => $request->quantity,
                    'created_by' => auth()->user()->id,  // Usuario autenticado
                    'updated_by' => auth()->user()->id,  // Usuario autenticado
                ]);
            } elseif (!$stock && $request->type === 'Egreso') {
                return back()->withErrors(['error' => 'No hay stock disponible en esta tienda para hacer un egreso.']);
            }

            if ($request->type === 'Ingreso') {
                $stock->increment('quantity', $request->quantity);
            } elseif ($request->type === 'Egreso') {
                if ($stock->quantity < $request->quantity) {
                    return back()->withErrors(['error' => 'Stock insuficiente para egreso en esta tienda.']);
                }
                $stock->decrement('quantity', $request->quantity);
            }

            DetailsAdjustment::create([
                'inventory_adjustment_id' => $adjustment->id,
                'stock_sale_id' => $stock->id,
                'quantity' => $request->quantity,
            ]);
        });
        return redirect()->route('inventory-adjustments.create')->with('success', 'Ajuste de inventario registrado correctamente.');
    }
}
