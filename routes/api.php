<?php

use App\Http\Controllers\Api\CustomerApiController;
use App\Http\Controllers\Api\ReportApiController;
use App\Http\Controllers\ReportController;
use App\Models\Services\ReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/search-customers/{query}', [CustomerApiController::class, 'searchCustomerApi']);


/*-----------------------REPORTS----------------------------------------------------- */
Route::get('/reportsSales', [ReportApiController::class, 'salesReport']);

