<?php

namespace App\Models\Services;

use Carbon\Carbon;
use App\Models\SaleNote;
use Illuminate\Support\Facades\DB;

class ReportService
{
    public function salesReports()
    {
        $endDate = Carbon::now();
        $startDate = $endDate->copy()->subMonths(12);

        $salesReports = SaleNote::select(
                DB::raw('EXTRACT(YEAR FROM sale_date) as year'),
                DB::raw('EXTRACT(MONTH FROM sale_date) as month'),
                DB::raw('SUM(total_quantity) as total_quantity')
            )
            ->whereBetween('sale_date', [$startDate, $endDate])
            ->groupBy(DB::raw('EXTRACT(YEAR FROM sale_date)'), DB::raw('EXTRACT(MONTH FROM sale_date)'))
            ->orderBy(DB::raw('EXTRACT(YEAR FROM sale_date)'), 'asc')
            ->orderBy(DB::raw('EXTRACT(MONTH FROM sale_date)'), 'asc')
            ->get();



        return $salesReports;
    }
}
