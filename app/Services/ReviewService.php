<?php

namespace App\Services;

use Sentinel;
use App\PotentialCustomer;
use App\Reviews;
use Carbon\Carbon;
use Mail;
use DB;

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

    public function validateBusinessReview($ip, $businessId, $redirect = '/', $postcode = '')
    {
        if(session()->has('email') && session()->has('user_type')) {
            $type = "App\\".ucfirst(camel_case(session()->get('user_type')));
            $user = app($type)->where('email', session()->get('email'))->first();
            $hasReachedLimit = $this->validateCustomerReviews($user, $businessId);
        } else if($user = Sentinel::getUser()) {
            $hasReachedLimit = $this->validateCustomerReviews($user, $businessId);
        }

        if(filter_var($hasReachedLimit, FILTER_VALIDATE_BOOLEAN)) {
            Mail::send(['html' => 'emails.review-redflag'], [
                    'ip' => $ip,
                    'email' => session()->get('email')
                ], function ($message) use ($ip) {
                    $message->from('info@housestars.com.au', 'Housestars');
                    $message->to('info@housestars.com.au', 'Housestars');
                    $message->subject('Oops!');
                });
            session()->flash('rate-error', 'You have reached the limit to rate this trade/service!');
            return redirect($redirect);
        }

        $businessPhoto = DB::table('user_meta')->select('meta_value')->where('user_id', $businessId)->where('meta_name', 'profile-photo')->first();
        $agencyName = DB::table('user_meta')->select('meta_value')->where('user_id', $businessId)->where('meta_name', 'agency-name')->first();
        $businessName = DB::table('user_meta')->select('meta_value')->where('user_id', $businessId)->where('meta_name', 'business-name')->first();
        
        $businessInfo = array(
            'id' => $businessId,
            'name' => isset($agencyName->meta_value) ? $agencyName->meta_value : $businessName->meta_value,
            'photo' => isset($businessPhoto->meta_value) ? $businessPhoto->meta_value : NULL,
            'postcode' => $postcode
        );

        return $businessInfo;
    }

    public function getReviews($id)
    {
        $data = array();
        $x = 0;
        $average = 0;

        foreach (Reviews::where('reviewee_id', '=', $id)->get() as $review) {
            $userType = "App\\".ucfirst(camel_case($review->user_type));
            $user = app($userType)->findOrFail($review->reviewer_id);
            $data[$x]['name'] = $user->name ? : $user->email;
            $data[$x]['average'] = (int)round(($review->communication + $review->work_quality + $review->price + $review->punctuality + $review->attitude) / 5);
            $data[$x]['communication'] = (int)$review->communication;
            $data[$x]['work_quality'] = (int)$review->work_quality;
            $data[$x]['price'] = (int)$review->price;
            $data[$x]['punctuality'] = (int)$review->punctuality;
            $data[$x]['attitude'] = (int)$review->attitude;
            $data[$x]['title'] = $review->title;
            $data[$x]['content'] = $review->content;
            $data[$x]['created'] = $review->created_at->format('M d, Y');
            $data[$x]['helpful'] = $review->helpful;
            $data[$x]['id'] = $review->id;
            $x++;
        }

        return $data;
    }
}
