<?php

namespace App\Observers;

use App\Helpers\PeselHelper;
use App\Models\Customer;

class CustomerObserver
{
    public function saving(Customer $customer): void
    {
        $customer->birth_date = $customer->pesel
            ? PeselHelper::getBirthDate($customer->pesel)
            : null;
    }
}
