<?php

namespace App\Services;

use App\PotentialCustomer;

class PotentialCustomerService
{
    public function save($data = [], $potentialCustomer = null)
    {
        if (is_null($potentialCustomer)) {
            $data['status'] = 0;
            return PotentialCustomer::create($data);
        }

        $potentialCustomer->fill($data);
        $potentialCustomer->save();

        return $potentialCustomer;
    }
}
