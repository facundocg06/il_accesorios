<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerApiController extends Controller
{
    public function searchCustomerApi($query)
{

    // Realizar la búsqueda en la base de datos o donde sea que tengas almacenados los clientes
    $clients = Customer::where('ci_customer', 'like', "%$query%")
        ->orWhere('name_customer', 'like', "%$query%")
        ->orWhere('last_name_customer', 'like', "%$query%")
        ->get();

    return response()->json(['data' => $clients]);
}
}
