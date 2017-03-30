<?php

namespace App\Services;

use App\PotentialCustomer;
use App\Reviews;
use Carbon\Carbon;

class PotentialCustomerService
{
    public function save($data = [], $potentialCustomer = null)
    {
        if (is_null($potentialCustomer)) {
            return PotentialCustomer::create($data);
        }

        $potentialCustomer->fill($data);
        $potentialCustomer->save();

        return $potentialCustomer;
    }
}
