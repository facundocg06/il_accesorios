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
use Illuminate\Support\Facades\Mail;


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
        //return view('content.sale.sale-add');
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
        return view('content.reports.ventasReport');
    }

    public function generateSalesReport(Request $request)
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
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'recipient_email' => 'required|email',
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $recipientEmail = $request->input('recipient_email');
        $user = auth()->user(); // Usuario autenticado
        try {
            // Usamos el servicio para obtener las ventas
            $sales = $this->saleService->getSalesBetweenDates($startDate, $endDate);

            // Creamos los datos para el correo
            $emailData = [
                'sales' => $sales,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'userName' => $user->name,
            ];

            // Enviamos el correo
            Mail::send('content.emails.sales_report', $emailData, function ($message) use ($recipientEmail, $user) {
                $message->to($recipientEmail)
                    ->from($user->email, $user->name) // Remitente
                    ->subject('Reporte de Ventas'); // Asunto
            });
            return redirect()->route('reports.ventas.form')->with('success', 'El reporte de ventas se envió correctamente.');
        } catch (\Exception $e) {
            // Redirigir al inicio con un mensaje de error
            return redirect()->route('reports.ventas.form')->with('error', 'Hubo un problema al enviar el correo: ' . $e->getMessage());
        }
    }

    /**
     * Envía el reporte de ventas por producto por correo electrónico.
     *
     * @param mixed  $sales
     * @param mixed  $product
     * @param string $startDate
     * @param string $endDate
     * @param string $recipientEmail
     */
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
                'userName'  => $user->name,
            ];

            // Enviar correo
            Mail::send('content.emails.sales_by_product_report', $emailData, function ($message) use ($recipientEmail, $user, $product) {
                $message->to($recipientEmail)
                    ->from($user->email, $user->name)
                    ->subject("Reporte de Ventas - Producto: {$product->name}");
            });

            return redirect()->route('reports.ventas.producto.form')
                ->with('success', 'El reporte de ventas por producto se envió correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('reports.ventas.producto.form')
                ->with('error', 'Hubo un problema al enviar el correo: ' . $e->getMessage());
        }
    }





    protected function sendSalesEmail($sales, $subject, $recipientEmail, $user, $view, $extraData = [])
    {
        try {
            $emailData = array_merge([
                'sales' => $sales,
                'userName' => $user->name,
            ], $extraData);

            Mail::send($view, $emailData, function ($message) use ($recipientEmail, $user, $subject) {
                $message->to($recipientEmail)
                    ->from($user->email, $user->name)
                    ->subject($subject);
            });

            return back()->with('success', 'El reporte de ventas se envió correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Hubo un problema al enviar el correo: ' . $e->getMessage());
        }
    }
}
