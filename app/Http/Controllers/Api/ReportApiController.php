<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\Services\ReportService;

class ReportApiController extends Controller
{
    protected $reportService;
    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }
    public function salesReport(){
        try {
            $data = $this->reportService->salesReports();
            return ApiResponse::success('REPORTE DE VENTAS',$data,[],200);
        } catch (Exception $e) {
            return ApiResponse::error($e->getMessage(),[],[],500);
        }
    }
}
