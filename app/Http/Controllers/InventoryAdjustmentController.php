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
use Illuminate\Support\Facades\Mail;

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
        Log::info($request);
        $request->validate([
            'description' => 'nullable|string',
            'product_id' => 'required|exists:products,id',
            'store_id' => 'required|exists:stores,id',
            'type' => 'required|in:Ingreso,Egreso',
            'quantity' => 'required|integer|min:1',
        ]);
        Log::info($request);

        try {
            DB::transaction(function () use ($request) {
                Log::info('Iniciando transacción para ajuste de inventario.');

                $adjustment = InventoryAdjustment::create([
                    'date' => Carbon::now(),
                    'description' => $request->description,
                    'user_id' => auth()->user()->id,
                    'type' => $request->type,
                ]);

                $stock = StockSales::where('product_id', $request->product_id)
                    ->where('store_id', $request->store_id)
                    ->first();

                if (!$stock && $request->type === 'Ingreso') {
                    $stock = StockSales::create([
                        'product_id' => $request->product_id,
                        'store_id' => $request->store_id,
                        'quantity' => 0,
                        'created_by' => auth()->user()->id,
                        'updated_by' => auth()->user()->id,
                    ]);
                } elseif (!$stock && $request->type === 'Egreso') {
                    throw new \Exception("No hay stock disponible para el producto {$request->product_id} en la tienda {$request->store_id}.");
                }

                if ($request->type === 'Ingreso') {
                    $stock->increment('quantity', $request->quantity);
                } elseif ($request->type === 'Egreso') {
                    if ($stock->quantity < $request->quantity) {
                        throw new \Exception("Stock insuficiente para el producto {$request->product_id} en la tienda {$request->store_id}.");
                    }
                    $stock->decrement('quantity', $request->quantity);
                }

                DetailsAdjustment::create([
                    'inventory_adjustment_id' => $adjustment->id,
                    'stock_sale_id' => $stock->id,
                    'product_id' => $request->product_id,
                    'store_id' => $request->store_id,
                    'quantity' => $request->quantity,
                ]);
            });

            return redirect()->route('inventory-adjustments.create')->with('success', 'Ajuste de inventario registrado correctamente.');
        } catch (\Exception $e) {
            Log::error("Error en la transacción de ajuste de inventario: " . $e->getMessage());
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function generateAdjustmentReport(Request $request)
    {
        $request->validate([
            'store_id' => 'required|exists:stores,id',
            'adjustment_type' => 'required|in:Ingreso,Egreso',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Obtener la tienda
        $store = Store::findOrFail($request->store_id);

        // Obtener los ajustes de inventario con sus detalles
        $adjustments = InventoryAdjustment::with(['user', 'details.product'])
            ->whereHas('details', function ($query) use ($request) {
                $query->where('store_id', $request->store_id);
            })
            ->where('type', $request->adjustment_type)
            ->whereBetween('date', [$request->start_date, $request->end_date])
            ->orderBy('date', 'ASC')
            ->get();

        // Formatear los datos para la vista
        $reportData = $adjustments->flatMap(function ($adjustment) {
            return $adjustment->details->map(function ($detail) use ($adjustment) {
                return [
                    'date' => $adjustment->date,
                    'user' => $adjustment->user->username ?? 'Desconocido',
                    'product' => $detail->product->name ?? 'Producto desconocido',
                    'detail' => $adjustment->description,
                    'quantity' => $detail->quantity,
                ];
            });
        })->all();

        return view('content.reports.adjustment_report', [
            'reportData' => $reportData,
            'startDate' => $request->start_date,
            'endDate' => $request->end_date,
            'adjustmentType' => $request->adjustment_type,
            'store' => $store,
        ]);
    }

    public function sendAdjustmentReport(Request $request)
    {
        $request->validate([
            'store_id' => 'required|exists:stores,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'adjustment_type' => 'required|in:Ingreso,Egreso',
            'recipient_email' => 'required|email',
        ]);

        try {
            $store = Store::findOrFail($request->store_id);
            $user = auth()->user();
            $recipientEmail = $request->input('recipient_email');

            // Obtener los ajustes de inventario
            $adjustments = InventoryAdjustment::with(['user', 'details.product'])
                ->whereHas('details', function ($query) use ($request) {
                    $query->where('store_id', $request->store_id);
                })
                ->where('type', $request->adjustment_type)
                ->whereBetween('date', [$request->start_date, $request->end_date])
                ->get();

            // Formatear datos para el reporte
            $reportData = $adjustments->flatMap(function ($adjustment) {
                return $adjustment->details->map(function ($detail) use ($adjustment) {
                    return [
                        'date' => $adjustment->date,
                        'user' => $adjustment->user->username ?? 'Desconocido',
                        'product' => $detail->product->name ?? 'Producto desconocido',
                        'detail' => $adjustment->description,
                        'quantity' => $detail->quantity,
                    ];
                });
            })->all();

            // Datos para el correo
            $emailData = [
                'reportData' => $reportData,
                'store' => $store,
                'adjustmentType' => $request->adjustment_type,
                'startDate' => $request->start_date,
                'endDate' => $request->end_date,
                'userName' => $user->name,
            ];

            // Enviar correo
            Mail::send('content.emails.adjustment-report', $emailData, function ($message) use ($recipientEmail, $user, $store) {
                $message->to($recipientEmail)
                    ->from("ventas@ilaccesorios.shop", $user->name)
                    ->subject("Reporte de Ajustes de Inventario - Tienda: {$store->name}");
            });

            return redirect()->route('reports.adjustments.form')
                ->with('success', 'El reporte de ajustes de inventario se envió correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('reports.adjustments.form')
                ->with('error', 'Hubo un problema al enviar el correo: ' . $e->getMessage());
        }
    }



    public function adjustmentReportForm()
    {
        $stores = Store::all(); // Obtener todos los almacenes
        return view('content.reports.adjustment-report-form', compact('stores'));
    }
}
