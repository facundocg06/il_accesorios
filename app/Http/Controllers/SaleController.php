<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\SalesRequest;
use App\Http\Messages\ErrorMessages;
use App\Models\Services\SaleService;
use App\Http\Messages\SuccessMessages;
use App\Models\Services\QRService;
use App\Mail\SalesReportMail;
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
        return view('content.sale.sale-add');
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
}
