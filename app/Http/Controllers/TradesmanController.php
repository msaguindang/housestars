<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Services\GalleryService;
use App\Services\ReviewService;
use View;
use Sentinel;
use App\User;
use App\UserMeta;
use App\Suburbs;
use App\Category;
use Carbon\Carbon;
use Hash;
use App\Agents;
use App\Advertisement;
use Response;
use Mail;
use App\Reviews;
use App\RoleUsers;
use Image;
use Cache;

class TradesmanController extends Controller
{
    const MAX_PHOTO  = 10,
          MAX_WIDTH_LANDSCAPE  = 1200,
          MAX_WIDTH_PORTRAIT  = 270,
          MAX_HEIGHT = 270;

    private $galleryService,
            $reviewService;

    public function __construct(GalleryService $galleryService, ReviewService $reviewService)
    {
        $this->galleryService = $galleryService;
        $this->reviewService = $reviewService;
    }

    public function dashboard()
    {
    	$meta = UserMeta::where('user_id', Sentinel::getUser()->id)->get();
    	$data = array();
        $data['summary'] = '';
        $data['profile-photo'] = 'assets/default.png';
        $data['cover-photo'] = 'assets/default_cover_photo.jpg';
        $x = 0; $y = 0; $t = 0;

    	foreach ($meta as $key) {
    		if($key->meta_name == 'gallery') {
    			$data[$key->meta_name][$y] = $key->meta_value;
    			$y = $y + 1;
    		} else if($key->meta_name == 'trade') {
                $categoryId = $key->meta_value;
                $cat = Cache::rememberForever("category_$categoryId", function() use ($categoryId) {
                    return Category::find($categoryId);
                });
                $data[$key->meta_name][$t] = $cat->category;
                $t ++;
            } else {
    			$data[$key->meta_name] = $key->meta_value;
    		}

    	}
        $data['rating'] = $this->getRating(Sentinel::getUser()->id);
        $data['reviews'] = $this->reviewService->getReviews(Sentinel::getUser()->id);
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

	   return View::make('dashboard/tradesman/profile')->with('data', $data);
    }

    public function edit(Request $request)
    {
        $data = [];
    	$suburbs = Suburbs::all();
        $userId = $request->route('id') ? : Sentinel::getUser()->id;
    	$meta = UserMeta::where('user_id', $userId)->get();
        $data['categories'] = Category::whereStatus(1)->orderBy('category', 'ASC')->groupBy('category')->get();
        $data['id'] = $userId;
        $data['summary'] = '';
        $data['profile-photo'] = 'assets/default.png';
        $data['cover-photo'] = 'assets/default_cover_photo.jpg';
        $x = 0; $y = 0; 
        $trades = [];
        // $t = 0;

    	foreach ($meta as $key) {
    		if ($key->meta_name == 'positions') {
    			$positions = explode(",", $key->meta_value);

    			foreach ($positions as $position) {
    				$code[$x] = preg_replace('/\D+/', '', $position);
    				$suburb[$x] = preg_replace('/[0-9]/', '', $position);
    				$data['suburbs'][$x] = array('code' => $code[$x], 'name' => $suburb[$x]);
  					$x = $x + 1;
    			}
    		} else if ($key->meta_name == 'trade') {
                $categoryId = $key->meta_value;
                array_push($trades, $categoryId);
                $data[$key->meta_name] = $trades;
            } else if($key->meta_name == 'gallery') {
    			$data[$key->meta_name][$y] = array('id'=>$key->id, 'url'=> $key->meta_value);
    			$y = $y + 1;
    		} else {
    			if(strlen($key->meta_value) > 30 && $key->meta_name == 'trade'){
    				$data[$key->meta_name] = substr($key->meta_value, 0, 30).'...';
    			} else {
    				$data[$key->meta_name] = $key->meta_value;
    			}
    		}

    	}

        $data['hasGallery'] = $y;
        $data['profile-url'] = "/profile";
        $data['name'] = Sentinel::getUser()->name;
        $data['isAdmin'] = is_admin();
        if ($data['isAdmin']) {
            $data['profile-url'] .= "/tradesman/$userId";
            $data['name'] = User::find($userId)->name;
        }
    	return View::make('dashboard/tradesman/edit')->with('data', $data);
    }

    public function upload(Request $request) {
        $validator = app('validator')->make($request->all(),[
                        'file' => 'max:2048'
                    ]);
        
        if ($validator->fails()) {
            return Response::json(['error' => "photo(s) should not be greater than 2MB."], 422);
        }

        $user_id = $request->route('id') ? $request->route('id') : Sentinel::getUser()->id;
        if ($request->hasFile('file') && UserMeta::where('meta_name','gallery')->where('user_id', $user_id)->count() < self::MAX_PHOTO) {
            $file = $request->file('file');
            $data = array();
	        $localpath = 'user/user-'.$user_id.'/uploads';
	        $filename = 'img'.rand().'-'.Carbon::now()->format('YmdHis').'.'.$file->getClientOriginalExtension();
			$path = $file->move(public_path($localpath), $filename);
            $filePath = public_path($localpath . '/' . $filename);
            list($width, $height) = getimagesize($filePath);
            $image = Image::make($filePath)->orientate();
            $h = ($height > self::MAX_HEIGHT ? self::MAX_HEIGHT : $height);
            if ($width > $height && $width > self::MAX_WIDTH_LANDSCAPE) {
                // Landscape
                $image->resize(self::MAX_WIDTH_LANDSCAPE, $h, function($c) {
                    $c->aspectRatio();
                    $c->upsize();
                })->save($filePath);
            } else if ($width < $height && $width > self::MAX_WIDTH_PORTRAIT) {
                // Portrait or Square
                $image->resize(self::MAX_WIDTH_PORTRAIT, $h, function($c) {
                    $c->aspectRatio();
                    $c->upsize();
                })->save($filePath);
            }

			$url = $localpath.'/'.$filename;
			UserMeta::updateOrCreate(['user_id' => $user_id, 'meta_name' => 'gallery', 'meta_value' => $url]);
            array_push($data, $url);
            $meta = ['w' => $width, 'h' => $height];
	        return Response::json(['data' => $this->galleryService->getGalleryItemsPartials($user_id), 'meta' => $meta], 200);
        } else if (UserMeta::where('meta_name', 'gallery')->where('user_id', $user_id)->count() >= self::MAX_PHOTO) {
            $max = self::MAX_PHOTO;
            return Response::json(['error' => "You can only upload up to $max photos!"], 422);
        } else {
            return Response::json(['error' => "You have uploaded beyond the filesize limit!"], 422);
        }

        return Response::json('error', 400);
    }

    public function updateProfile(Request $request)
    {
        $validator = app('validator')->make($request->all(), [
            'profile-photo' => 'max:2048',
            'cover-photo'   => 'max:2048'
        ],[
            'profile-photo.max' => 'Profile photo should not be greater than 2MB.',
            'cover-photo.max'   => 'Cover photo should not be greater than 2MB.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else if(Sentinel::check()) {
            try {
        		$user_id = $request->route('id') ? : Sentinel::getUser()->id;
        		$meta_name = array('cover-photo', 'profile-photo', 'gallery', 'business-name', 'positions', 'summary', 'trade', 'website', 'abn', 'charge-rate', 'phone');
        		foreach ($meta_name as $meta) {
                    if ($request->hasFile($meta))  {
                    	$file = $request->file($meta);
                    	$localpath = 'user/user-'.$user_id.'/uploads';
    	                $filename = 'img'.rand().'-'.Carbon::now()->format('YmdHis').'.'.$file->getClientOriginalExtension();
    					$path = $file->move(public_path($localpath), $filename);
    					$value = $localpath.'/'.$filename;
                        list($width, $height) = getimagesize($value);
                        $image = Image::make($value)->orientate();
                        $h = ($height > self::MAX_HEIGHT ? self::MAX_HEIGHT : $height);
                        if ($width > $height && $width > self::MAX_WIDTH_LANDSCAPE) {
                            // Landscape
                            $image->resize(self::MAX_WIDTH_LANDSCAPE, $h, function($c) {
                                $c->aspectRatio();
                                $c->upsize();
                            })->save($value);
                        } else if ($width < $height && $width > self::MAX_WIDTH_PORTRAIT) {
                            // Portrait or Square
                            $image->resize(self::MAX_WIDTH_PORTRAIT, $h, function($c) {
                                $c->aspectRatio();
                                $c->upsize();
                            })->save($value);
                        }
    				} else if(!empty($request->get($meta.'-drag', ''))) {
                        $value = $request->input($meta.'-drag');
                    } else if(($meta == 'trade') && ($trades = $request->get('trade', []))) {
                        foreach ($trades as $tradeId) {
                            UserMeta::updateOrCreate(
                                ['user_id' => $user_id, 'meta_name' => $meta, 'meta_value' => $tradeId],
                                ['user_id' => $user_id, 'meta_name' => $meta, 'meta_value' => $tradeId]
                            );
                        }
                        UserMeta::where('user_id', $user_id)
                                    ->where('meta_name', $meta)
                                    ->whereNotIn('meta_value', $trades)
                                    ->delete();
                        continue;
                    } else {
    					$value = $request->input($meta);
    				}

    				if($meta == 'positions' && $request->input($meta) != null && $meta != ''){
                        $suburbs = $request->input($meta);
                        $value = '';

                        foreach ($suburbs as $suburb) {
                            $value .= $suburb . ',';
                        }
                    }

    				if($value !== null) {
                    	UserMeta::updateOrCreate(
                        	['user_id' => $user_id, 'meta_name' => $meta],
                        	['user_id' => $user_id, 'meta_name' => $meta, 'meta_value' => $value]
                    	);
    				}
        		}
                return redirect(env('APP_URL').'/dashboard/tradesman/profile');
            } catch (\Exception $e) {
                dd($e->getMessage());
            }
    	} else {
    		return redirect(env('APP_URL'));
    	}
    }

    public function deleteItem(Request $request){
    	if(Sentinel::check()){
    		DB::table('user_meta')->where('id', '=', $request->input('item-id'))->delete();
    		return Response::json('success', 200);
    	} else {
    		return redirect(env('APP_URL'));
    	}
    }

     public function settings()
    {

        $meta = UserMeta::where('user_id', Sentinel::getUser()->id)->get();
        $data = array();


        foreach ($meta as $key) {
            $data[$key->meta_name] = $key->meta_value;
        }

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $customer_info = \Stripe\Customer::retrieve(Sentinel::getUser()->customer_id);

        $data['credit-card'] = $customer_info->sources->data[0]->last4;
        $data['expiry-month'] = $customer_info->sources->data[0]->exp_month;
        $data['expiry-year'] = $customer_info->sources->data[0]->exp_year;
        $data['name'] = Sentinel::getUser()->name;
        $data['email'] = Sentinel::getUser()->email;
        $data['password'] = Sentinel::getUser()->password;
        $data['plan'] = $customer_info->subscriptions->data[0]->items->data[0]->plan->name;
        $data['subscription-status'] = $customer_info->subscriptions->data[0]->status;
        $data['subscription-expiry'] = date('F d, Y', $customer_info->subscriptions->data[0]->current_period_end);

        return View::make('dashboard/tradesman/settings')->with('data', $data);
    }

    public function orderBC(Request $request){

        $this->sendOrder($request);

        return Response::json('success', 200);
    }

    private function sendOrder($data){
        Mail::send(['html' => 'emails.order-bc'], [
                'name' => $data->input('name'),
                'address' => $data->input('address'),
                'contact' => $data->input('contact'),
                'email' => $data->input('email'),
                'website' => $data->input('website')
            ], function ($message) {
                $message->from('info@housestars.com.au', 'Housestars');
                $message->to('info@housestars.com.au', 'Housestars');
                $message->subject('Order Review Card');
            });
    }


     public function getRating($id) {
        $ratings = DB::table('reviews')->where('reviewee_id', '=', $id)->get();
        $average = 0;
        $numRatings = count($ratings);
		$rate = 0;
		$zero = 0; $one = 0; $two = 0; $three= 0; $four = 0; $five = 0;
		
        if($numRatings > 0){
            foreach ($ratings as $rating) {	
	            $ratingAverage = (int)round(($average + (int)round(($rating->communication + $rating->work_quality + $rating->price + $rating->punctuality + $rating->attitude) / 5))); 
	            $rate = $rate + $ratingAverage;
            }
            $average =  (int)round($rate / $numRatings);
        }
		
        return $average;
    }

    public function helpful(Request $request){
        $review = Reviews::where('id', '=', $request->input('id'))->get();

        $data['count'] = $review[0]['helpful'] + 1;

        Reviews::where('id', '=', $request->input('id'))->update(['helpful' => $data['count']]);

        return Response::json($data, 200);
    }

    public function searchSuburb(Request $request)
    {
        $query = $request->input('query');

        $suburbs = Suburbs::where(DB::raw("CONCAT(suburbs.id,' ',suburbs.name)"), 'LIKE', "%{$query}%")
            ->select("suburbs.*", DB::raw("CONCAT(suburbs.id,'',suburbs.name) as value"))
            ->get()
            ->toArray();

        $response = [
            'request' => $request->all(),
            'suburbs' => $suburbs
        ];

        return Response::json($response, 200);
    }

    public function validateSuburbAvailability(Request $request)
    {
        $id = $request->input('data');

        $suburb = Suburbs::find($id);

        $valid = true;

        if($suburb->availability >= 3){
            $valid = false;
        }

        $response = [
            'request' => $request->all(),
            'valid' => $valid
        ];

        return Response::json($response, 200);
    }

    public function validateAvailability(Request $request)
    {
        $id = $request->input('data');

        $suburb = Suburbs::where(DB::raw("CONCAT(id, name)"), $id)->first();
        $valid = true;

        // count number of traders per area
        // $tradersCount = DB::table('users')
        //         ->join('role_users', function ($join) {
        //             $join->on('users.id', '=', 'role_users.user_id')
        //                  ->where('role_users.role_id', '=', '3');
        //         })->get();

        $tradesPerArea= UserMeta::where('meta_value', 'LIKE', '%'.$suburb->name.'%')->get();
        $tradersCount = 0;
        foreach ($tradesPerArea as $key) {
            if(!is_null(RoleUsers::hasRole($key->user_id,3)->first())) {
              $tradersCount++;
            }
        }

        if ($tradersCount >= $suburb->max_tradie) {
            $valid = false;
        }

        $response = [
            'request' => $request->all(),
            'valid' => $valid
        ];

        return Response::json($response, 200);
    }

    public function referral(Request $request){
        //check if user already added referral
        $verifyReferral = UserMeta::where('user_id', Sentinel::getUser()->id)->where('meta_name', 'referral')->get();
        $abn = UserMeta::where('user_id', Sentinel::getUser()->id)->where('meta_name', 'abn')->get();
        if ($abn[0]['meta_value'] == $request->get('referral-code')) {
          $response = 'I see what you did there. Sorry, you can\'t add your own ABN.';
        } else if(count($verifyReferral) == 0) {
          UserMeta::updateOrCreate(
              ['user_id' => Sentinel::getUser()->id, 'meta_name' => 'referral'],
              ['user_id' => Sentinel::getUser()->id, 'meta_name' => 'referral', 'meta_value' => $request->input('referral-code')]
          );
          $response = 'Referral successfully added.';
          Mail::send(['html' => 'emails.tradesman-referral'], [
                'name'     => Sentinel::getUser()->name,
                'referral' => $request->get('referral-code')
            ], function ($message) {
                $message->from('info@housestars.com.au', 'Housestars');
                $message->to('info@housestars.com.au');
                $message->subject('Referral');
            });
        } else {
          $response = 'You already added a referral.';
        }

        return Response::json($response, 200);
          //if none add referral meta
        //else return error
    }

}
