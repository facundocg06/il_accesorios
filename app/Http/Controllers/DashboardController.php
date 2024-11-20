<?php

namespace App\Http\Controllers;

use App\Models\PurchaseDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseNotes;
use App\Models\SaleDetail;
use Carbon\Carbon;

class DashboardController extends Controller
{

    public function inicio()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $user = Auth::user();
        if ($user->hasRole('Administrador')) {
            $data = $this->insumosReportes();
            $data['topProductsMonth'] = $this->topProducts('month');
            $data['topProductsYear'] = $this->topProducts('year');

            return view('home', $data);
        } else {
            return redirect()->route('sales-list');
        }
    }

    public function ventasReporte()
    {
        $data = $this->getVentasReportData();
        return view('content.reports.ventas', $data);
    }

    private function getVentasReportData()
    {
        $topProductsMonth = $this->getTopProducts('month');

        $topProductsYear = $this->getTopProducts('year');

        $dailySales = $this->getSalesByPeriod('day');

        $monthlySales = $this->getSalesByPeriod('month');

        return compact('topProductsMonth', 'topProductsYear', 'dailySales', 'monthlySales');
    }

    private function getTopProducts($period)
    {
        $query = SaleDetail::select(
            'products.name',
            DB::raw('SUM(sale_details.amount) as total_amount')
        )
            ->join('stock_sales', 'sale_details.stock_sale_id', '=', 'stock_sales.id')
            ->join('products', 'stock_sales.product_id', '=', 'products.id');

        if ($period === 'month') {
            $query->whereMonth('sale_details.created_at', Carbon::now()->month);
        } else if ($period === 'year') {
            $query->whereYear('sale_details.created_at', Carbon::now()->year);
        }

        $topProducts = $query->groupBy('products.name')
            ->orderBy('total_amount', 'desc')
            ->take(5)
            ->get();

        $productNames = [];
        $productAmounts = [];

        foreach ($topProducts as $product) {
            $productNames[] = $product->name;
            $productAmounts[] = (float) $product->total_amount;
        }

        return compact('productNames', 'productAmounts');
    }

    private function getSalesByPeriod($period)
    {
        if ($period == 'day') {
            $query = SaleDetail::select(
                DB::raw('TO_CHAR(sale_details.created_at, \'Day\') as day'),
                DB::raw('SUM(sale_details.amount) as total_amount')
            )
                ->join('stock_sales', 'sale_details.stock_sale_id', '=', 'stock_sales.id')
                ->join('products', 'stock_sales.product_id', '=', 'products.id')
                ->whereMonth('sale_details.created_at', Carbon::now()->month)
                ->groupBy(DB::raw('TO_CHAR(sale_details.created_at, \'Day\')'))
                ->orderBy(DB::raw('TO_CHAR(sale_details.created_at, \'Day\')'))
                ->get();

            $daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            $salesData = array_fill(0, 7, 0);

            foreach ($query as $sale) {
                $index = array_search(trim($sale->day), $daysOfWeek);
                if ($index !== false) {
                    $salesData[$index] = (float) $sale->total_amount;
                }
            }

            return ['labels' => $daysOfWeek, 'data' => $salesData];
        } elseif ($period == 'month') {
            $query = SaleDetail::select(
                DB::raw('TO_CHAR(sale_details.created_at, \'Month\') as month'),
                DB::raw('SUM(sale_details.amount) as total_amount')
            )
                ->join('stock_sales', 'sale_details.stock_sale_id', '=', 'stock_sales.id')
                ->join('products', 'stock_sales.product_id', '=', 'products.id')
                ->whereYear('sale_details.created_at', Carbon::now()->year)
                ->groupBy(DB::raw('TO_CHAR(sale_details.created_at, \'Month\')'))
                ->orderBy(DB::raw('TO_CHAR(sale_details.created_at, \'Month\')'))
                ->get();

            $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            $salesData = array_fill(0, 12, 0);

            foreach ($query as $sale) {
                $index = array_search(trim($sale->month), $months);
                if ($index !== false) {
                    $salesData[$index] = (float) $sale->total_amount;
                }
            }

            return ['labels' => $months, 'data' => $salesData];
        }

        return [];
    }


    public function insumosReportes()
    {
        $year = Carbon::now()->year;
        $monthlyPurchases = PurchaseNotes::select(
            DB::raw('sum(total_quantity) as total_spent'),
            DB::raw('EXTRACT(MONTH FROM purchase_date) as month')
        )
            ->whereYear('purchase_date', $year)
            ->groupBy(DB::raw('EXTRACT(MONTH FROM purchase_date)'))
            ->orderBy(DB::raw('EXTRACT(MONTH FROM purchase_date)'), 'asc')
            ->get();

        $months = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
        $spendings = array_fill(0, 12, 0);

        foreach ($monthlyPurchases as $purchase) {
            $spendings[$purchase->month - 1] = (float) $purchase->total_spent;
        }

        $currentWeek = Carbon::now()->startOfWeek();
        $dailyPurchases = PurchaseNotes::select(
            DB::raw('sum(total_quantity) as total_spent'),
            DB::raw('EXTRACT(DOW FROM purchase_date) as day')
        )
            ->whereBetween('purchase_date', [$currentWeek, Carbon::now()->endOfWeek()])
            ->groupBy(DB::raw('EXTRACT(DOW FROM purchase_date)'))
            ->orderBy(DB::raw('EXTRACT(DOW FROM purchase_date)'), 'asc')
            ->get();

        $daysOfWeek = ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'];
        $dailySpendings = array_fill(0, 7, 0);

        foreach ($dailyPurchases as $purchase) {
            $dailySpendings[$purchase->day] = (float) $purchase->total_spent;
        }

        return compact('months', 'spendings', 'daysOfWeek', 'dailySpendings');
    }

    public function topProducts($period)
    {
        $query = PurchaseDetail::select(
            'stock_productions.name',
            DB::raw('SUM(purchase_details.amount) as total_amount')
        )
            ->join('stock_productions', 'purchase_details.stock_production_id', '=', 'stock_productions.id');

        if ($period === 'month') {
            $query->whereMonth('purchase_details.created_at', Carbon::now()->month);
        } else if ($period === 'year') {
            $query->whereYear('purchase_details.created_at', Carbon::now()->year);
        }

        $topProducts = $query->groupBy('stock_productions.name')
            ->orderBy('total_amount', 'desc')
            ->take(5)
            ->get();

        $productNames = [];
        $productAmounts = [];

        foreach ($topProducts as $product) {
            $productNames[] = $product->name;
            $productAmounts[] = (float) $product->total_amount;
        }

        return compact('productNames', 'productAmounts');
    }
}
