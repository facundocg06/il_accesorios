<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Http\Messages\ErrorMessages;
use App\Http\Messages\SuccessMessages;
use App\Http\Requests\CustomerRequest;
use App\Models\Services\CustomerService;
use App\Http\Controllers\Controller;


class CustomerController extends Controller
{
    protected $customerService;

    public function __construct(CustomerService $customerService){
        $this->customerService = $customerService;
    }
    public function customer_list() {
        $customers = $this->customerService->getAll();
        return view('content.customer.customer-list',compact('customers'));
    }

    public function register_customer(CustomerRequest $customerRequest){
        try {
            $this->customerService->createCustomer($customerRequest->all());
            return redirect()->route('customer-list')->with('success', SuccessMessages::CUSTOMER_CREATED);
        } catch (Exception $e) {
            return redirect()->route('customer-list')->with('error', ErrorMessages::CUSTOMER_CREATION_ERROR);
        }
    }

    public function delete_customer($idCustomer){
        try {
            $this->customerService->deleteCustomer($idCustomer);
            return redirect()->route('customer-list')->with('success', SuccessMessages::CUSTOMER_DELETED);
        } catch (Exception $e) {
            return redirect()->route('customer-list')->with('error', ErrorMessages::CUSTOMER_DELETE_ERROR);
        }
    }

    public function edit_customer($idCustomer){
    }

    public function update_customer(Request $request, $id){
        try {
            $this->customerService->updateCustomer($id , $request->all());
            return redirect()->route('customer-list')->with('success', SuccessMessages::CUSTOMER_UPDATED);
        } catch (Exception $e) {
            return redirect()->route('customer-list')->with('error', ErrorMessages::CUSTOMER_UPDATE_ERROR);
        }
    }


}
