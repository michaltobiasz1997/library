<?php

namespace App\Services;

use App\Models\Customer;

class CustomerService
{
    public function create(array $customerData): Customer
    {
        return Customer::create($customerData);
    }

    public function delete(int $customerId): bool
    {
        return Customer::findOrFail($customerId)->delete();
    }
}
