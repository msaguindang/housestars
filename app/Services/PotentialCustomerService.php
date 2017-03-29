<?php

namespace App\Services;

use App\PotentialCustomer;
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

    public function validateCustomerReviews($customer)
    {
    	$reviews = $customer->reviews;
    	$firstReview = $reviews->first();
    	$diffInYears = Carbon::now()->diffInYears($firstReview->created_at);
    	$now = $firstReview->created_at->copy()->addYear($diffInYears);

    	$count = $customer
		    		->reviews
		    		->where('created_at', '>=', $now)
		    		->where('created_at', '<=', $now->copy()->addYear(1))
		    		->count();
		    		
    	return ($count >= 5);
    }
}
