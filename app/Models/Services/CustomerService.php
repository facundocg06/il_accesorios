<?php

namespace App\Models\Services;

use Illuminate\Support\Facades\DB;
use App\Http\Messages\ErrorMessages;
use App\Models\Repository\CustomerRepositoryInterface;

class CustomerService
{
    protected $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }
    public function getAll()
    {
        return $this->customerRepository->all();
    }
    public function find($id)
    {
        return $this->customerRepository->find($id);
    }
    public function createCustomer($data)
    {
        return DB::transaction(function () use ($data) {
            $customer = $this->customerRepository->create($data);
            return $customer;
        });
    }
    public function deleteCustomer($idCustomer)
    {
        return DB::transaction(function () use ($idCustomer) {
            $customer = $this->customerRepository->find($idCustomer);
            if (!$customer) {
                return ErrorMessages::CUSTOMER_NOT_FOUND;
            }
            $Customer = $this->customerRepository->delete($customer);
            return $Customer;
        });
    }
    public function updateCustomer($idCustomer, $data)
    {
        return DB::transaction(function () use ($idCustomer, $data) {
            $customer = $this->customerRepository->find($idCustomer);
            if (!$customer) return ErrorMessages::CUSTOMER_NOT_FOUND;

            return $this->customerRepository->update($customer, $data);
        });
    }
    public function searchCustomer($query){
        return $this->customerRepository->searchCustomers($query);
    }
}
