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
use Mail;

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
            } else {
                $data[$tradesman->meta_name] = $tradesman->meta_value;
            }
        }

        return Response::json($data, 200);
    }

    public function addReview()
    {

        $request = $this->payload;
		if($request->input('user_id')){
			 $user_id = $request->input('user_id');
		}else{
			 $user_id = Sentinel::getUser()->id;
		}
        //$user_id = Sentinel::getUser()->id;
        $userReviews = Reviews::where('reviewer_id', $user_id)->where('reviewee_id', $request->input('tradesman_id'))->whereYear('created_at', '=', date('Y'))->count();

        if($userReviews >= 5 ){
          $ip = $request->ip();
          Mail::send(['html' => 'emails.review-redflag'], [
                  'ip' => $ip,
                  'email' => Sentinel::getUser()->email
              ], function ($message) use ($ip) {
                  $message->from('info@housestars.com.au', 'Housestars');
                  $message->to('info@housestars.com.au', 'Housestars');
                  $message->subject('Rating Red Flag: '. $ip);
              });
        } else {

                  if($request->input('transaction_id') != null || $request->input('transaction_id') != ''){
                    DB::table('reviews')->insert(
                        ['reviewee_id' => $request->input('tradesman_id'), 'reviewer_id' => $user_id, 'communication' => $request->input('communication'), 'work_quality' => $request->input('work-quality'), 'price' => $request->input('price'), 'punctuality' => $request->input('punctuality'), 'attitude' => $request->input('attitude'), 'title' => $request->input('review-title'), 'content' => $request->input('review-text'), 'created_at' => Carbon::now(), 'transaction' => $request->input('transaction_id'), 'postcode' => $request->input('postcode')]
                    );
                  } else{
                    DB::table('reviews')->insert(
                        ['reviewee_id' => $request->input('tradesman_id'), 'reviewer_id' => $user_id, 'communication' => $request->input('communication'), 'work_quality' => $request->input('work-quality'), 'price' => $request->input('price'), 'punctuality' => $request->input('punctuality'), 'attitude' => $request->input('attitude'), 'title' => $request->input('review-title'), 'content' => $request->input('review-text'), 'created_at' => Carbon::now(), 'postcode' => $request->input('postcode')]
                    );
                  }
        }



        $data['id'] = $request->input('tradesman_id');

        return Response::json($data, 200);
    }

    public function getAllReviews(Request $request)
    {

        $payload = $this->payload->all();
        $fromDate = $request->get('from', '');
        $toDate = $request->get('to', '');
        $dateRangeQuery = '';

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

        if (!empty($fromDate) && !empty($toDate)) {
            $dateRangeQuery = " WHERE reviews.created_at between '{$fromDate}' AND '{$toDate}' ";
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
                  WHERE users.id = reviews.`reviewer_id`) AS reviewer_name,
                  (SELECT
                    user_meta.`meta_value`
                  FROM
                    user_meta
                  WHERE user_meta.`user_id` = reviews.`reviewee_id` 
                  AND user_meta.`meta_name` = 'agency-name') AS business
                FROM
                  reviews
                {$dateRangeQuery}
                LIMIT {$limit}
                OFFSET {$offset}";

        $reviews = json_decode(json_encode(DB::select($sql)), TRUE);

        $response = [
            'reviews' => $reviews,
            'length'  => $length
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
        $reviewees = array_where($reviewees, function ($value, $key) {
                        return (!is_null($value['reviewee_name']) && !empty($value['reviewee_name']));
                    });

        $response = [
            'reviewees' => $reviewees,
            'payload'   => $payload
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
        $hasReachedLimit = false;
        $ip = $request->ip();
        $postcode = $request->get('postcode', '');

        $businessInfo = app(ReviewService::class)->validateBusinessReview($ip, $businessId);

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
        $validator = $this->validate($request, [
            'review-title' => 'required',
            'review-text' => 'required'
        ]);

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
        $ip = $request->ip();
        $email = '';
        
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
            'updated_at'    => Carbon::now(),
            'postcode'      => $request->get('postcode')
        ];
        
        if (session()->has('email') && session()->has('user_type')) {
            $email = session()->get('email');
            $userType = session()->get('user_type');
            $type = "App\\".ucfirst(camel_case($userType));
            $user = app($type)->where('email', $email)->first();
            $data['reviewer_id'] = $user->id;
            $data['user_type']  = $userType;

            $userReviews = Reviews::where('reviewer_id', $user->id)->where('reviewee_id', $businessId)->whereYear('created_at', '=', date('Y'))->count();

            if($userReviews >= 5 ){
              Mail::send(['html' => 'emails.review-redflag'], [
                      'ip' => $ip,
                      'email' => $email
                  ], function ($message) use ($ip) {
                      $message->from('info@housestars.com.au', 'Housestars');
                      $message->to('info@housestars.com.au', 'Housestars');
                      $message->subject('Rating Red Flag: '. $ip);
                  });
            } else {
              app(ReviewService::class)->save($data);
            }
            session()->forget('email');
            session()->forget('user_type');
            session()->forget('business');
            session()->forget('role');
        } else if ($user = Sentinel::getUser()) {
            $data['reviewer_id'] = $user->id;
            $data['user_type']   = 'user';
            $email = $user->email;
            $userReviews = Reviews::where('reviewer_id', $user->id)->where('reviewee_id', $businessId)->whereYear('created_at', '=', date('Y'))->count();

            if($userReviews >= 5 ){
              Mail::send(['html' => 'emails.review-redflag'], [
                      'ip' => $ip,
                      'email' => $user->email
                  ], function ($message) use ($ip) {
                      $message->from('info@housestars.com.au', 'Housestars');
                      $message->to('info@housestars.com.au', 'Housestars');
                      $message->subject('Rating Red Flag: '. $ip);
                  });
            } else {
              app(ReviewService::class)->save($data);
            }
        } else if($latestRow = DB::table('reviews')->select('id', 'reviewer_id')->where('reviewee_id', -1)->orderBy('id', 'desc')->first()) {
            $reviewId = $latestRow->id;
            $reviewerId = $latestRow->reviewer_id;
            $review = DB::table('reviews')->where('reviewee_id', '=', $businessId)->where('reviewer_id', '=', $reviewerId)->first();
            if (!is_null($review)) {
                $reviewId = $review->id;
            }
            $userReviews = Reviews::where('reviewer_id', $reviewerId)->where('reviewee_id', $businessId)->whereYear('created_at', '=', date('Y'))->count();

            if($userReviews >= 5 ){
              Mail::send(['html' => 'emails.review-redflag'], [
                      'ip' => $ip,
                      'email' => ''
                  ], function ($message) use ($ip) {
                      $message->from('info@housestars.com.au', 'Housestars');
                      $message->to('info@housestars.com.au', 'Housestars');
                      $message->subject('Rating Red Flag: '. $ip);
                  });
            } else {
              app(ReviewService::class)->save($data, Reviews::where('id', $reviewId)->where('reviewer_id', $reviewerId)->first());
            }
        }

        Mail::send(['html' => 'emails.leaves-review'], [
                      'ip'       => $ip,
                      'email'    => $email,
                      'business' => UserMeta::where('user_id', $businessId)->where('meta_name', 'trading-name')->first()
                  ], function ($message) use ($ip) {
                      $message->from('info@housestars.com.au', 'Housestars');
                      $message->to('info@housestars.com.au', 'Housestars');
                      $message->subject('User leaves a review');
                  });

        return redirect('/');
    }

    public function searchReviews(Request $request)
    {
        $query = $request->get('query', '');
        $sort  = $request->get('sort', 'asc');
        $field  = $request->get('field', null);
        $fromDate = $request->get('from', '');
        $toDate = $request->get('to', '');
        $searchBusiness = $request->get('business', '');
        $searchReviewee = $request->get('reviewee', '');
        $searchReviewer = $request->get('reviewer', '');
        $searchTitle = $request->get('title', '');
        $searchContent = $request->get('content', '');
        $searchCreatedAt = $request->get('created_at', '');

        $length = 0;
        $pageNo = 1;
        $limit = 10;

        if ($request->has('page_no')) {
            $pageNo = $request->get('page_no');
        }

        if ($request->has('limit')) {
            $limit = $request->get('limit');
        }

        $offset = $limit * ($pageNo - 1);

        $reviews = Reviews::searchReview($query, $fromDate, $toDate, $searchReviewee, $searchReviewer, $searchTitle, $searchContent, $searchCreatedAt, $searchBusiness);
        $length = $reviews->count();
        $reviews = $reviews->get();
        
        if(!is_null($field)) {
            $reviews = $reviews->sortBy($field, SORT_REGULAR, ($sort=='desc'));
            // $reviews = $reviews->take($limit)->skip($offset);
        }
        
        $reviews = $reviews->forPage($pageNo, $limit);
        $reviews = $reviews->values()->all();

        $response = [
            'reviews' => (is_array($reviews) ? $reviews : $reviews->toArray()),
            'length'  => $length
        ];

        return Response::json($response, 200);
    }
}
