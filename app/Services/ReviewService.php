<?php

namespace App\Services;

use App\PotentialCustomer;
use App\Reviews;
use Carbon\Carbon;

class ReviewService
{
	const MAX_PER_YEAR = 5;

    public function save($data = [], $review = null)
    {
        if (is_null($review)) {
            return Reviews::create($data);
        }

        $review->fill($data);
        $review->save();

        return $review;
    }

    public function validateCustomerReviews($user, $reviewee_id)
    {
        if (!is_null($user) && ($firstReview = Reviews::where('reviewer_id', $user->id)->where('reviewee_id', $reviewee_id)->first())) {
        	$diffInYears = Carbon::now()->diffInYears($firstReview->created_at);
        	$now = $firstReview->created_at->copy()->addYears($diffInYears);

        	$count = Reviews::where('reviewer_id', $user->id)
        						->where('reviewee_id', $reviewee_id)
            		    		->where('created_at', '>=', $now)
            		    		->where('created_at', '<=', $now->copy()->addYear())
                                ->groupBy('reviewer_id')
                                ->count();
        	return ($count >= self::MAX_PER_YEAR);
        }
        return false;
    }
}
