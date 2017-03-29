<?php

namespace App\Services;

use App\PotentialCustomer;
use App\Reviews;

class ReviewService
{
    public function save($data = [], $review = null)
    {
        if (is_null($review)) {
            return Reviews::create($data);
        }

        $review->fill($data);
        $review->save();

        return $review;
    }
}
