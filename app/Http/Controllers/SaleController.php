<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\SalesRequest;
use App\Http\Messages\ErrorMessages;
use App\Models\Services\SaleService;
use App\Http\Messages\SuccessMessages;
use App\Models\Services\QRService;

class SaleController extends Controller
{
    protected $saleService;
    protected $qrService;
    public function __construct(SaleService $saleService, QRService $qrService){
        $this->saleService = $saleService;
        $this->qrService = $qrService;
    }
    public function sales_list(){
        $sales= $this->saleService->getAll();
        return view('content.sale.sale-list',compact('sales'));
    }
    public function sales_preview($sale, $requestData)
    {
        return view('content.sale.sale-preview', compact('sale', 'requestData'));
    }

    public function sales_print(){
        $pageConfigs = ['myLayout' => 'blank'];
        return view('content.sale.sale-print', ['pageConfigs' => $pageConfigs]);
    }
    public function sales_add(){
        return view('content.sale.sale-add');
    }
    public function register_sale(SalesRequest $salesRequest)
    {
        try {
            $sale = $this->saleService->registerSale($salesRequest->all());
            if($sale->payment_method== 'QR'){
                $this->qrService->generateQr($sale);
            }
            $requestData = base64_encode(serialize($salesRequest->all()));
            $saleData = base64_encode(serialize($sale));
            return redirect()->route('sales-preview', ['sale' => $saleData, 'requestData' => $requestData]);
        } catch (Exception $e) {
            return redirect()->route('sales-list')->with('error', $e->getMessage());
        }
    }
    public function confirm_sale($id_sale){
        try {
            $this->saleService->confirmSale($id_sale);
            return redirect()->route('sales-list')->with('success', SuccessMessages::SALE_CREATED);
        } catch (Exception $e) {
            return redirect()->route('sales-list')->with('error', $e->getMessage());
        }
    }

}
