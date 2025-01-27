<?php

namespace App\Models\Repository;

use App\Models\Customer;

interface CustomerRepositoryInterface
{
    public function all();
    public function create(array $data);
    public function update($customer, array $data);
    public function delete($customer);
    public function find(int $id);
    public function findByCI($ci_customer);
    public function searchCustomers($query);


}
