<?php

namespace App\Models\Repository;

use App\Models\Customer;
use App\Models\Repository\CustomerRepositoryInterface;

class CustomerRepository implements CustomerRepositoryInterface
{
    public function all()
    {
        return Customer::all();
    }

    public function create(array $data)
    {
        return Customer::create($data);
    }

    public function update($Customer, array $data)
    {
        return $Customer->update($data);
    }

    public function delete($Customer)
    {
        return $Customer->delete();
    }

    public function find(int $id)
    {
        return Customer::find($id);
    }
    public function findByCI($ci_customer){
        return Customer::where('ci_customer',$ci_customer)->first();
    }
    public function searchCustomers($query){
        return Customer::where('name_customer', 'like', '%' . $query . '%')
        ->orWhere('ci_customer', 'like', '%' . $query . '%')
        ->get();
    }
}
