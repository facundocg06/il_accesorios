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

use Pdfcrowd;
use Illuminate\Support\Facades\Storage;

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
        Log::info($request->all());

        // Validación actualizada para la nueva estructura
        $request->validate([
            'description' => 'nullable|string',
            'store_id' => 'required|exists:stores,id',
            'type' => 'required|in:Ingreso,Egreso',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::transaction(function () use ($request) {
                Log::info('Iniciando transacción para ajuste de inventario.');

                $adjustment = InventoryAdjustment::create([
                    'date' => Carbon::now(),
                    'description' => $request->description,
                    'user_id' => auth()->user()->id,
                    'type' => $request->type,
                ]);

                foreach ($request->products as $product) {
                    $productId = $product['product_id'];
                    $quantity = $product['quantity'];
                    $storeId = $request->store_id;
                    $type = $request->type;

                    $stock = StockSales::where('product_id', $productId)
                        ->where('store_id', $storeId)
                        ->first();

                    if (!$stock && $type === 'Ingreso') {
                        $stock = StockSales::create([
                            'product_id' => $productId,
                            'store_id' => $storeId,
                            'quantity' => 0,
                            'created_by' => auth()->user()->id,
                            'updated_by' => auth()->user()->id,
                        ]);
                    } elseif (!$stock && $type === 'Egreso') {
                        throw new \Exception("No hay stock disponible para el producto con ID {$productId} en la tienda seleccionada.");
                    }

                    if ($type === 'Ingreso') {
                        $stock->increment('quantity', $quantity);
                    } elseif ($type === 'Egreso') {
                        if ($stock->quantity < $quantity) {
                            $productName = Product::find($productId)->name;
                            throw new \Exception("Stock insuficiente para el producto '{$productName}'. Stock actual: {$stock->quantity}");
                        }
                        $stock->decrement('quantity', $quantity);
                    }

                    DetailsAdjustment::create([
                        'inventory_adjustment_id' => $adjustment->id,
                        'stock_sale_id' => $stock->id,
                        'product_id' => $productId,
                        'store_id' => $storeId,
                        'quantity' => $quantity,
                    ]);
                }
            });

            return redirect()->route('inventory-adjustments.create')
                ->with('success', 'Ajuste de inventario registrado correctamente.');
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
            'generate_pdf' => 'nullable|boolean'
        ]);

        $store = Store::findOrFail($request->store_id);

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
        $directoryPath = storage_path('app/public/reports');

        // Si el directorio no existe, crearlo con permisos adecuados
        if (!file_exists($directoryPath)) {
            mkdir($directoryPath, 0777, true);
            Log::info('Directorio creado: ' . $directoryPath);
        }

        $pdfPath = null;
        $pdfPath = $this->generatePdf($reportData, $request->start_date, $request->end_date, $request->adjustment_type, $store);

        Log::info($pdfPath);
        return view('content.reports.adjustment_report', [
            'reportData' => $reportData,
            'startDate' => $request->start_date,
            'endDate' => $request->end_date,
            'adjustmentType' => $request->adjustment_type,
            'store' => $store,
            'pdfPath' => $pdfPath
        ]);
    }

    private function generatePdf($reportData, $startDate, $endDate, $adjustmentType, $store)
    {
        try {
            Log::info('Generando PDF para el reporte...');


            $pdfView = view('content.reports.adjustment_pdf', [
                'reportData' => $reportData,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'adjustmentType' => $adjustmentType,
                'store' => $store,
            ])->render();

            Log::info('Vista renderizada correctamente.');


            $client = new Pdfcrowd\HtmlToPdfClient(env('PDFCROWD_USERNAME'), env('PDFCROWD_API_KEY'));


            $pdfPath = 'reports/adjustment_report_' . time() . '.pdf';
            $filePath = storage_path('app/public/' . $pdfPath);

            Log::info('Guardando PDF en: ' . $filePath);

            // Generar y guardar el PDF
            $client->convertStringToFile($pdfView, $filePath);

            // Verificar si el archivo fue creado
            if (file_exists($filePath)) {
                Log::info('PDF generado correctamente: ' . $pdfPath);
            } else {
                Log::error('Error: El archivo PDF no se creó en la ruta esperada.');
            }

            return $pdfPath; // Retorna la ruta del PDF generado

        } catch (\Exception $e) {
            Log::error('Error al generar el PDF: ' . $e->getMessage());
            return null;
        }
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

            // Formatear los datos
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

            // Recuperar la ruta del PDF generado en la vista
            $pdfPath = $request->input('pdf_path'); // Obtener del formulario si se pasó

            if (!$pdfPath || !file_exists(storage_path("app/public/$pdfPath"))) {
                return redirect()->route('reports.adjustments.form')
                    ->with('error', 'No se encontró el PDF del reporte.');
            }

            // Datos para el email
            $emailData = [
                'reportData' => $reportData,
                'store' => $store,
                'adjustmentType' => $request->adjustment_type,
                'startDate' => $request->start_date,
                'endDate' => $request->end_date,
                'userName' => $user->name,
            ];

            // Enviar el correo con el PDF adjunto
            Mail::send('content.emails.adjustment-report', $emailData, function ($message) use ($recipientEmail, $store, $pdfPath) {
                $message->to($recipientEmail)
                    ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                    ->subject("Reporte de Ajustes de Inventario - Tienda: {$store->name}")
                    ->attach(storage_path("app/public/$pdfPath")); // Adjuntar el PDF
            });
            // Eliminar el PDF después de enviarlo
            if (file_exists(storage_path("app/public/$pdfPath"))) {
                unlink(storage_path("app/public/$pdfPath"));
            }

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
