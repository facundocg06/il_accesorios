<?php

namespace App\Http\Controllers;

use App\Http\Messages\ErrorMessages;
use App\Http\Messages\SuccessMessages;
use App\Http\Requests\SalesRequest;
use App\Mail\SalesReportMail;
use App\Models\Product;
use App\Models\Services\QRService;
use App\Models\Services\SaleService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Pdfcrowd;

class SaleController extends Controller
{
    protected $saleService;
    protected $qrService;
    public function __construct(SaleService $saleService, QRService $qrService)
    {
        $this->saleService = $saleService;
        $this->qrService = $qrService;
    }
    public function sales_list()
    {
        $sales = $this->saleService->getAll();
        return view('content.sale.sale-list', compact('sales'));
    }
    public function sales_preview($sale, $requestData)
    {
        return view('content.sale.sale-preview', compact('sale', 'requestData'));
    }

    public function sales_print()
    {
        $pageConfigs = ['myLayout' => 'blank'];
        return view('content.sale.sale-print', ['pageConfigs' => $pageConfigs]);
    }
    public function sales_add()
    {
        $products = Product::with(['stockSales.store'])->get();
        return view('content.sale.sale-add', compact('products'));
    }
    public function register_sale(SalesRequest $salesRequest)
    {
        try {
            $sale = $this->saleService->registerSale($salesRequest->all());
            if ($sale->payment_method == 'QR') {
                $this->qrService->generateQr($sale);
            }
            $requestData = base64_encode(serialize($salesRequest->all()));
            $saleData = base64_encode(serialize($sale));
            return redirect()->route('sales-preview', ['sale' => $saleData, 'requestData' => $requestData]);
        } catch (Exception $e) {
            return redirect()->route('sales-list')->with('error', $e->getMessage());
        }
    }
    public function confirm_sale($id_sale)
    {
        try {
            $this->saleService->confirmSale($id_sale);
            return redirect()->route('sales-list')->with('success', SuccessMessages::SALE_CREATED);
        } catch (Exception $e) {
            return redirect()->route('sales-list')->with('error', $e->getMessage());
        }
    }
    public function salesReportForm()
    {
        $products = Product::all();

        return view('content.reports.ventasReport', compact('products'));
    }
    public function generateSalesReport(Request $request)
    {
        $request->validate([
            'product_id'  => 'nullable|exists:products,id',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
        ]);

        $productId = $request->input('product_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Obtener las ventas dependiendo si se seleccionó un producto o no
        if ($productId) {
            $product = Product::findOrFail($productId);
            $sales = $this->saleService->getSalesByProduct($productId, $startDate, $endDate);
        } else {
            $product = null;
            $sales = $this->saleService->getSalesBetweenDates($startDate, $endDate);
        }
        $pdfPath = null;
        Log::info($sales);

        $pdfPath = $this->generatePdfFile($sales, $startDate, $endDate, $product);

        // Mostrar el reporte en la vista junto con la ruta del PDF
        return view('content.reports.sale-report', [
            'sales'     => $sales,
            'product'   => $product,
            'startDate' => $startDate,
            'endDate'   => $endDate,
            'pdfPath'   => $pdfPath, // Pasar la ruta del PDF a la vista
        ]);
    }

    /**
     * Genera un archivo PDF y lo guarda en storage.
     */
    private function generatePdfFile($sales, $startDate, $endDate, $product)
    {
        try {
            $pdfView = view('content.reports.sales_pdf', [
                'sales'     => $sales,
                'product'   => $product,
                'startDate' => $startDate,
                'endDate'   => $endDate,
            ])->render();

            $client = new Pdfcrowd\HtmlToPdfClient(env('PDFCROWD_USERNAME'), env('PDFCROWD_API_KEY'));
            $pdfPath = 'reports/sales_report_' . time() . '.pdf';
            $filePath = storage_path('app/public/' . $pdfPath);
            $client->convertStringToFile($pdfView, $filePath);

            return $filePath; // Devolver la ruta del PDF generado
        } catch (\Exception $e) {
            return null; // Retornar null si hay un error
        }
    }
    public function generateSalesReport1(Request $request)
    {
        if ($request->method() !== 'POST') {
            return redirect()->route('reports.ventas.form')->with('error', 'Por favor, utiliza el formulario para generar un reporte.');
        }

        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $sales = $this->saleService->getSalesBetweenDates($request->start_date, $request->end_date);

        return view('content.reports.sale-report', [
            'sales' => $sales,
            'startDate' => $request->start_date,
            'endDate' => $request->end_date,
        ]);
    }




    public function salesReportByProductForm()
    {
        $products = Product::all();
        return view('content.reports.ventasProductoReport', compact('products'));
    }

    /**
     * Genera el reporte de ventas por producto filtrado por fechas.
     */
    public function generateSalesByProductReport(Request $request)
    {
        // Se comprueba que la petición sea de tipo POST
        if ($request->method() !== 'POST') {
            return redirect()->route('reports.ventas.producto.form')
                ->with('error', 'Por favor, utiliza el formulario para generar un reporte.');
        }

        // Validar los datos enviados
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);

        // Buscar el producto seleccionado
        $product = Product::findOrFail($request->product_id);

        // Obtener las ventas filtradas por producto y rango de fechas
        $sales = $this->saleService->getSalesByProduct(
            $request->product_id,
            $request->start_date,
            $request->end_date
        );

        // Si se indicó enviar correo, se procesa el envío
        if ($request->has('send_email')) {
            return $this->sendSalesByProductReport(
                $sales,
                $product,
                $request->start_date,
                $request->end_date,
                $request->recipient_email
            );
        }

        // Si no se envía por correo, se muestra el reporte en pantalla
        return view('content.reports.sales-by-product-report', [
            'sales'     => $sales,
            'product'   => $product,
            'startDate' => $request->start_date,
            'endDate'   => $request->end_date,
        ]);
    }
    public function sendSalesReport(Request $request)
    {
        $request->validate([
            'product_id'  => 'nullable|exists:products,id',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
            'recipient_email' => 'required|email',
            'pdf_path'        => 'required|string', // El PDF debe estar presente
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $recipientEmail = $request->input('recipient_email');
        $user = auth()->user(); // Usuario autenticado
        $recipientEmail = $request->input('recipient_email');
        $pdfPath = $request->input('pdf_path');
        $productId = $request->input('product_id');

        // Verificar si el PDF existe antes de enviarlo
        if (!file_exists($pdfPath)) {
            return redirect()->route('reports.ventas.form')->with('error', 'El PDF no se encontró o fue eliminado.');
        }

        try {
            if ($productId) {
                $product = Product::findOrFail($productId);
                $sales = $this->saleService->getSalesByProduct($productId, $startDate, $endDate);
            } else {
                $product = null;
                $sales = $this->saleService->getSalesBetweenDates($startDate, $endDate);
            }




            // Datos para el correo
            $emailData = [
                'sales'     => $sales,
                'product'   => $product,
                'startDate' => $startDate,
                'endDate'   => $endDate,
                'userName'  => $user->username,
            ];


            Mail::send('content.emails.sales_report', $emailData, function ($message) use ($recipientEmail, $pdfPath) {
                $message->to($recipientEmail)
                    ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                    ->subject('Reporte de Ventas')
                    ->attach($pdfPath, [
                        'as' => 'reporte_ventas.pdf',
                        'mime' => 'application/pdf',
                    ]);
            });

            return redirect()->route('reports.ventas.form')->with('success', 'El reporte de ventas se envió correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('reports.ventas.form')->with('error', 'Error al enviar el correo: ' . $e->getMessage());
        }
    }



    public function sendSalesByProductReport(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'recipient_email' => 'required|email',
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $recipientEmail = $request->input('recipient_email');
        $user = auth()->user(); // Usuario autenticado

        try {
            // Obtener el producto seleccionado
            $product = Product::findOrFail($request->product_id);

            // Obtener las ventas del producto en el rango de fechas
            $sales = $this->saleService->getSalesByProduct($product->id, $startDate, $endDate);

            // Datos para el correo
            $emailData = [
                'sales'     => $sales,
                'product'   => $product,
                'startDate' => $startDate,
                'endDate'   => $endDate,
                'userName'  => $user->username,
            ];

            // Enviar correo
            Mail::send('content.emails.sales_by_product_report', $emailData, function ($message) use ($recipientEmail, $user, $product) {
                $message->to($recipientEmail)
                    ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                    ->subject("Reporte de Ventas - Producto: {$product->name}");
            });

            return redirect()->route('reports.ventas.producto.form')
                ->with('success', 'El reporte de ventas por producto se envió correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('reports.ventas.producto.form')
                ->with('error', 'Hubo un problema al enviar el correo: ' . $e->getMessage());
        }
    }
}
