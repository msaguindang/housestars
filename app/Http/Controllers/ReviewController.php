<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use View;
use Sentinel;
use App\Reviews;
use App\UserMeta;
use App\User;
use App\Agents;
use App\Advertisement;
use App\Property;
use Response;
use Socialite;
use App\PotentialCustomer;
use App\Services\ReviewService;

class ReviewController extends Controller
{

    protected $payload;

    public function __construct(Request $request)
    {
        $this->payload = $request;
    }

    public function review()
    {

        $request = $this->payload;
        $user_id = Sentinel::getUser()->id;
        $id = $request->input('id');

        $tradesmen = DB::table('users')
            ->join('user_meta', function ($join) use ($id) {
                $join->on('users.id', '=', 'user_meta.user_id')
                    ->where('user_meta.user_id', '=', $id);
            })->get();

        $data['name'] = $tradesmen[0]->name;
        $data['photo'] = 'assets/default.png';

        foreach ($tradesmen as $tradesman) {
            if ($tradesman->meta_name == 'profile-photo') {
                $data['photo'] = $tradesman->meta_value;
                $data['isPhotoUrl'] = filter_var($data['photo'], FILTER_VALIDATE_URL);
            }
        }


        return Response::json($data, 200);
    }

    public function addReview()
    {

        $request = $this->payload;

        $user_id = Sentinel::getUser()->id;
        if($request->input('transaction_id') != null || $request->input('transaction_id') != ''){
          DB::table('reviews')->insert(
              ['reviewee_id' => $request->input('tradesman_id'), 'reviewer_id' => $user_id, 'communication' => $request->input('communication'), 'work_quality' => $request->input('work-quality'), 'price' => $request->input('price'), 'punctuality' => $request->input('punctuality'), 'attitude' => $request->input('attitude'), 'title' => $request->input('review-title'), 'content' => $request->input('review-text'), 'created_at' => Carbon::now(), 'transaction' => $request->input('transaction_id')]
          );
        } else{
          DB::table('reviews')->insert(
              ['reviewee_id' => $request->input('tradesman_id'), 'reviewer_id' => $user_id, 'communication' => $request->input('communication'), 'work_quality' => $request->input('work-quality'), 'price' => $request->input('price'), 'punctuality' => $request->input('punctuality'), 'attitude' => $request->input('attitude'), 'title' => $request->input('review-title'), 'content' => $request->input('review-text'), 'created_at' => Carbon::now()]
          );
        }


    	  $data['id'] = $request->input('tradesman_id');

    	return Response::json($data, 200);
    }

    public function getAllReviews()
    {

        $payload = $this->payload->all();
        $pageNo = 1;
        $limit = 10;

        if (isset($payload['page_no'])) {
            $pageNo = $payload['page_no'];
        }

        if (isset($payload['limit'])) {
            $limit = $payload['limit'];
        }

        $offset = $limit * ($pageNo - 1);

        $length = DB::table('reviews')
            ->selectRaw('count(*) as length')
            ->first()
            ->length;

		$sql = "SELECT
				  reviews.*,
				  (SELECT
					users.`name`
				  FROM
					users
				  WHERE users.id = reviews.`reviewee_id`) AS reviewee_name,
				  (SELECT
					users.`name`
				  FROM
					users
				  WHERE users.id = reviews.`reviewer_id`) AS reviewer_name
				FROM
				  reviews
				LIMIT {$limit}
				OFFSET {$offset}";


        $reviews = json_decode(json_encode(DB::select($sql)), TRUE);

        $response = [
            'reviews' => $reviews,
            'length' => $length
        ];

        return Response::json($response, 200);
    }

    public function getAllReviewees()
    {

        $payload = $this->payload->all();

        $sql = "SELECT DISTINCT
				  (reviews.reviewee_id),
				  (SELECT
					users.`name`
				  FROM
					users
				  WHERE users.id = reviews.`reviewee_id`) AS reviewee_name
				FROM
				  reviews
				WHERE reviewee_id != '-1' ";

        $reviewees = json_decode(json_encode(DB::select($sql)), TRUE);

        $response = [
            'reviewees' => $reviewees,
            'payload' => $payload
        ];

        return Response::json($response, 200);
    }

    public function deleteReview()
    {
        $id = $this->payload->input('id');

        try {

            Reviews::find($id)->delete();
            $response['success'] = [
                'message' => "Review successfully deleted."
            ];
            return Response::json($response, 200);
        } catch (Exception $e) {
            $response['error'] = [
                'message' => $e->getMessage()
            ];
            return Response::json($response, 404);
        }
    }

    public function getReviewsByFilter()
    {
        $payload = $this->payload->all();

        $filterBy = $payload['filter_by'];
        $filterId = $payload['filter_id'];

        $pageNo = 1;
        $limit = 10;

        if (isset($payload['page_no'])) {
            $pageNo = $payload['page_no'];
        }

        if (isset($payload['limit'])) {
            $limit = $payload['limit'];
        }

        $offset = $limit * ($pageNo - 1);

        switch($filterBy){
            case 'reviewee':
                $length = DB::table('reviews')
                    ->selectRaw('count(*) as length')
                    ->where('reviewee_id', $filterId)
                    ->first()
                    ->length;
                $filterSql = " AND reviews.reviewee_id = {$filterId} ";
                break;
        }

        $sql = "SELECT
				  reviews.*,
				  (SELECT
					users.`name`
				  FROM
					users
				  WHERE users.id = reviews.`reviewee_id`) AS reviewee_name,
				  (SELECT
					users.`name`
				  FROM
					users
				  WHERE users.id = reviews.`reviewer_id`) AS reviewer_name
				FROM
				  reviews
				  WHERE reviews.id IS NOT NULL
				  {$filterSql}
				LIMIT {$limit}
				OFFSET {$offset}";

        $reviews = json_decode(json_encode(DB::select($sql)), TRUE);

        $response = [
            'reviews' => $reviews,
            'length' => $length
        ];

        return Response::json($response, 200);


    }

	public function addAReview (Request $request)
    {
		$params = $request->all();
        $businessId = $params['businessId'];
        
        if(session()->has('email') && session()->has('user_type')) {
            $type = "App\\".ucfirst(camel_case(session()->get('user_type')));
            $user = app($type)->where('email', session()->get('email'))->first();
            $hasReachedLimit = app(ReviewService::class)->validateCustomerReviews($user, $businessId);
            if(filter_var($hasReachedLimit, FILTER_VALIDATE_BOOLEAN)) {
                session()->flash('rate-error', 'You have reached the limit to rate this trade/service!');
                return redirect('/');
            }
        }

		$businessPhoto = DB::table('user_meta')->select('meta_value')->where('user_id', $businessId)->where('meta_name', 'profile-photo')->first();
		$agencyName = DB::table('user_meta')->select('meta_value')->where('user_id', $businessId)->where('meta_name', 'agency-name')->first();
        $businessName = DB::table('user_meta')->select('meta_value')->where('user_id', $businessId)->where('meta_name', 'business-name')->first();
		$businessInfo = array(
			'id' => $businessId,
			'name' => isset($agencyName->meta_value) ? $agencyName->meta_value : $businessName->meta_value,
			'photo' => isset($businessPhoto->meta_value) ? $businessPhoto->meta_value : NULL
		);

		return view('review_business')->with(compact('businessInfo'));
	}

    public function reviewBusiness ($id)
    {
        $role = $this->checkRole($id);
        if ($role == 'agency') {
            $data = $this->agency($id);
        }
        elseif ($role == 'tradesman') {
            $data = $this->tradesman($id);
        }

        $listings = $this->property_listing($id);
        $data['property-listings'] = $listings;
        $data['total-listings'] = count($listings);

        if ($role == 'agency') {
            return view('general.profile.agency-review')->with('data', $data)->with('category', $role);
        }
        elseif ($role == 'tradesman') {
            return view('general.profile.tradesman-review')->with('data', $data)->with('category', $role);
        }

    }

    public function checkRole ($id)
    {
        $agency = UserMeta::select('meta_name')->where('user_id', $id)->where('meta_name', 'agency-name')->get();
        $tradesman = UserMeta::select('meta_name')->where('user_id', $id)->where('meta_name', 'business-name')->get();

        if(count($agency) > 0 ) {
            return 'agency';
        }
        elseif(count($tradesman) > 0) {
            return 'tradesman';
        }

    }

    public function showAgencyProfile ($id)
    {
        $role = 'agency';
        $data = $this->agency($id);
        $listings = $this->property_listing($id);
        $data['property-listings'] = $listings;
        $data['total-listings'] = count($listings);
        return view('general.profile.agency-profile')->with('data', $data)->with('category', $role);
    }

    public function agency($id)
    {
        $user = User::where('id', $id)->get();
        $meta = UserMeta::where('user_id', $id)->get();
        $data = array();
        $data['agency-id'] = $id;
        $data['summary'] = '';
        $data['profile-photo'] = 'assets/default.png';
        $data['cover-photo'] = 'assets/default_cover_photo.jpg';
        $data['email'] = $user[0]['email'];
        $x = 0; $y = 0;

        foreach ($meta as $key) {
            if($key->meta_name == 'gallery') {
                $data[$key->meta_name][$y] = $key->meta_value;
                $y = $y + 1;
            } else {
                $data[$key->meta_name] = $key->meta_value;
            }
        }

        $data['rating'] = $this->getRating($id);
        $data['reviews'] = $this->getReviews($id);
        $data['total'] = count($data['reviews']);

        $ads = Advertisement::where('type', '=', '270x270')->get();
        $y = 0;

        foreach ($ads  as $ad) {
            $advert[$ad->type][$y]['url'] = $ad->image_path;
            $y++;
        }

        if(isset($advert['270x270'])){
            $numAds =  count($advert['270x270']) - 1;
            $index1 = rand(0, $numAds);
            $data['advert'][0] = $advert['270x270'][$index1];
            $index2 = rand(0, $numAds);

            if($index1 == $index2){
                $index2 = rand(0, $numAds);
            }
            $data['advert'][1] = $advert['270x270'][$index2];

        }
        //dd($data);
        return $data;
    }

    public function tradesman($id)
    {
    	$meta = UserMeta::where('user_id', $id)->get();
        $user = User::where('id', $id)->get();
    	$data = array();
        $data['tradesman-id'] = $id;
        $data['summary'] = '';
        $data['profile-photo'] = 'assets/default.png';
        $data['cover-photo'] = 'assets/default_cover_photo.jpg';
        $data['email'] = $user[0]['email'];
        $x = 0; $y = 0;

    	foreach ($meta as $key) {
    		if($key->meta_name == 'gallery'){
    			$data[$key->meta_name][$y] = $key->meta_value;
    			$y = $y + 1;

    		} else {

    			$data[$key->meta_name] = $key->meta_value;

    		}

    	}
    	$data['rating'] = $this->getRating($id);
        $data['reviews'] = $this->getReviews($id);
        $data['total'] = count($data['reviews']);

        $ads = Advertisement::where('type', '=', '270x270')->get();
        $y = 0;

        foreach ($ads  as $ad) {
            $advert[$ad->type][$y]['url'] = $ad->image_path;
            $y++;
        }

        if(isset($advert['270x270'])){
            $numAds =  count($advert['270x270']) - 1;
            $index1 = rand(0, $numAds);
            $data['advert'][0] = $advert['270x270'][$index1];
            $index2 = rand(0, $numAds);

            if($index1 == $index2){
                $index2 = rand(0, $numAds);
            }
            $data['advert'][1] = $advert['270x270'][$index2];

        }
        //dd($data);
    	return $data;
    }

    public function property_listing($id)
    {
        $property_meta = Property::where('meta_name', '=', 'agent')->where('user_id', '=', $id)->get();
        $x = 0;

        foreach ($property_meta as $meta) {
            $prop[$x]['id'] = $meta->user_id;
            $prop[$x]['code'] = $meta->property_code;
            $x++;
        }

        $properties = array();

        if(isset($prop)) {
            foreach ($prop as $key) {
                $property = Property::where('user_id', '=', $key['id'])->where('property_code', '=', $key['code'])->get();
                foreach ($property as $meta) {
                    $info[$meta->meta_name] = $meta->meta_value;
                }

                array_push($properties, $info);
            }
        }
        return $properties;
    }

    public function getRating($id)
    {
        $ratings = DB::table('reviews')->where('reviewee_id', '=', $id)->get();
        $average = 0;
        $numRatings = count($ratings);

        if($numRatings > 0){
            foreach ($ratings as $rating) {
                $average = ($average + (int)round(($rating->communication + $rating->work_quality + $rating->price + $rating->punctuality + $rating->attitude) / 5)) / $numRatings;
            }
        }

        return $average;
    }

    public function getReviews($id)
    {

    	$reviews = Reviews::where('reviewee_id', '=', $id)->get();
    	$data = array(); $x = 0; $average = 0;
    	foreach ($reviews as $review) {
            if ($user = User::where('id', $review->reviewer_id)->first()) {
                $data[$x]['name'] = $user->name;
            }
            else {
                $data[$x]['name'] = $review->name;
            }
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

	public function create (Request $request)
    {   
        $params = $request->all();
        $businessId = $params['tradesman_id'];		
		$communication = isset($params['communication']) ? $params['communication'] : NULL;
		$workQuality = isset($params['work-quality']) ? $params['work-quality'] : NULL;
		$price = isset($params['price']) ? $params['price'] : NULL;
		$punctuality = isset($params['punctuality']) ? $params['punctuality'] : NULL;
		$attitude = isset($params['attitude']) ? $params['attitude'] : NULL;
		$reviewTitle = isset($params['review-title']) ? $params['review-title'] : NULL;
		$reviewText = isset($params['review-text']) ? $params['review-text'] : NULL;
		$helpful = isset($params['helpful']) ? $params['helpful'] : 0;
        
        $data = [
            'reviewee_id'   => $businessId,
            'communication' => $communication,
            'work_quality'  => $workQuality,
            'price'         => $price,
            'punctuality'   => $punctuality,
            'attitude'      => $attitude,
            'title'         => $reviewTitle,
            'content'       => $reviewText,
            'helpful'       => $helpful,
            'status'        => 0,
            'updated_at'    => Carbon::now()
        ];

        if (session()->has('email') && session()->has('user_type')) {
            $email = session()->get('email');
            $userType = session()->get('user_type');
            $type = "App\\".ucfirst(camel_case($userType));
            $user = app($type)->where('email', $email)->first();
            $data['reviewer_id'] = $user->id;
            $data['user_type']  = $userType;
            app(ReviewService::class)->save($data);
            session()->forget('email');
            session()->forget('user_type');
        } else if ($user = Sentinel::getUser()) {
            $data['reviewer_id'] = $user->id;
            $data['user_type']   = 'user';
            app(ReviewService::class)->save($data);
        } else if($latestRow = DB::table('reviews')->select('id', 'reviewer_id')->where('reviewee_id', -1)->orderBy('id', 'desc')->first()) {
            $reviewId = $latestRow->id;
            $reviewerId = $latestRow->reviewer_id;
            $review = DB::table('reviews')->where('reviewee_id', '=', $businessId)->where('reviewer_id', '=', $reviewerId)->first();
            if (!is_null($review)) {
                $reviewId = $review->id;
            }
            app(ReviewService::class)->save($data, Reviews::where('id', $reviewId)->where('reviewer_id', $reviewerId)->first());
        }

		return redirect('/');
	}
}
