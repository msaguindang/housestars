<?php

namespace App\Http\Controllers;

use App\RoleUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Sentinel;
use App\Suburbs;
use App\Reviews;
use App\Role;
use App\UserMeta;
use App\Advertisement;
use Response;
use Mail;
use View;
use Ajax;
use Session;
use App\PotentialCustomer;
use App\Services\PotentialCustomerService;
use App\Services\ReviewService;
use App\User;
use App\Video;
use DB;
use Carbon\Carbon;
use Stripe\Customer;
use Stripe\Stripe;
use Stripe\Subscription;

class MainController extends Controller
{
    public function dashboard(Request $request)
    {
        if (Sentinel::check()) {
            switch (Sentinel::getUser()->roles()->first()->slug) {
                case 'agency':
                    return redirect(env('APP_URL').'/dashboard/agency/profile');
                    break;
                case 'tradesman':
                    return redirect(env('APP_URL').'/dashboard/tradesman/profile');
                    break;
                case 'customer':
                    return redirect(env('APP_URL').'/dashboard/customer/profile');
                    break;
                case 'agent':
                    return redirect(env('APP_URL').'/dashboard/agent/profile');
                    break;
                default:
                    return redirect(URL::previous());
                    break;
            }

        } else {
            return redirect(env('APP_URL'));
        }
    }

    public function home(Request $request)
    {
        $ads = Advertisement::getByPage('home')->get();
        // $numAds =  count($ads['728x90'] );
        // $index = rand(0, $numAds);
        $x = 0; $z = 0; $y = 0;
        
        foreach ($ads  as $ad) {
            switch ($ad->type) {
                case '728x90':
                    $advert[$ad->type][$x]['url'] = $ad->image_path;
                    $x++;
                    break;
                case '141x117':
                    $advert[$ad->type][$z]['url'] = $ad->image_path;
                    $z++;
                    break;
                default:
                    $advert[$ad->type][$y]['url'] = $ad->image_path;
                    $y++;
                    break;
            }

        }

        $data = array();
        if (isset($advert['141x117'])) {
            $numAds =  count($advert['141x117']) - 1;
            $index = rand(0, $numAds);
            $data['141x117'] = $advert['141x117'][$index ];
		}
        
        if (isset($advert['728x90'])) {
            $numAds =  count($advert['728x90']) - 1;
            $index = rand(0, $numAds);
            $data['728x90'] = $advert['728x90'][$index ];   
        }
        
        

        return view('home')->with('advert', $data);
    }

    public function agency()
    {
        $data['suburbs'] = Suburbs::all();
        $reviews = Reviews::all();
        $data['comments'] = array();

        foreach ($reviews as $review) {
            // check if review is for housestars
            if ($review->reviewee_id == 1) {
                //Check if agency review
                $isAgency = RoleUsers::where('user_id', '=', $review->reviewer_id)->count();

                if ($isAgency > 0) {
                    // get review details
                    $review_details['average'] = (int)round(($review->communication + $review->work_quality + $review->price + $review->punctuality + $review->attitude) / 5);
                    $review_details['title'] = $review->title;
                    $review_details['content'] = $review->content;
                    $review_details['helpful'] = $review->helpful;
                    $review_details['post_date'] = $review->created_at;
                    // get reviewer details
                    $user = UserMeta::where('user_id', '=', $review->reviewer_id)->get();
                    foreach ($user as $key) {
                        if ($key->meta_name == 'agency-name') {
                            $review_details['name'] = $key->meta_value;
                        } else if ($key->meta_name == 'profile-photo') {
                            $review_details['img'] = $key->meta_value;
                        }
                    }

                    array_push($data['comments'], $review_details);

                }
            }
        }

        if($video = Video::active('agency')->first()) {
            $data['video'] = $video->url . '?autoplay=1&rel=0';
        }

        return view('general.agency')->with('data', $data);
    }

    public function unpaid()
    {
        $suburbs = Suburbs::all();
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $customer_info = \Stripe\Customer::retrieve(Sentinel::getUser()->customer_id);
        $payment_status = $customer_info->subscriptions->data[0]->status;
        return View::make('general/payment-status')->with('suburbs', $suburbs)->with('status', $payment_status);
    }

    public function contact(Request $request)
    {
        $this->sendInquiry($request);
        return Response::json('success', 200);
    }

    public function verifyPotentialUser(Request $request)
    {
        $email = $request->get('email');
        session()->forget('email');
        session()->forget('user_type');
        session()->forget('business');
        session()->forget('role');
        $potentialCustomer = PotentialCustomer::where('email', $email)->first();
        $user = User::where('email', $email)->first();
        $hasBusiness = $request->exists('business');

        if (!is_null($potentialCustomer) && $potentialCustomer->status == 1) {
            session()->put('email', $email);
            session()->put('user_type', 'potential_customer');
            if ($hasBusiness) {
                session()->put('business', $request->get('business'));
                session()->put('role', $request->get('role'));
            }
            return response()->json(['url' => url('/choose-business')], 200);
        } else if (!is_null($user) && $user->status == 1) {
            session()->put('email', $email);
            session()->put('user_type', 'user');
            if ($hasBusiness) {
                session()->put('business', $request->get('business'));
                session()->put('role', $request->get('role'));
            }
            return response()->json(['url' => url('/choose-business')], 200);
        }
        
        Mail::send(['html' => 'emails.customer-rate-verification'], [
                    'subject'  => 'Email Verification',
                    'email'    => $email
                ], function ($message) use ($email) {
                    $message->from('info@housestars.com.au', 'Housestars');
                    $message->to($email, 'Housestars');
                    $message->subject('Email Verification');
                });

        app(PotentialCustomerService::class)->save([
            'email'  => $email,
            'status' => 0
        ], $potentialCustomer);

        return response()->json(['error' => '', 'verifying' => true], 200);
    }

    private function sendInquiry($data)
    {
        $subject = $data->input('subject');
        $topic = $data->input('topic');
        Mail::send(['html' => 'emails.contact-us'], [
                'subject' => $data->input('subject'),
                'content' => $data->input('message'),
                'name' => $data->input('name'),
                'email' => $data->input('email')
            ], function ($message) use ($subject, $topic) {
                $message->from('info@housestars.com.au', 'Housestars');
                $message->to('info@housestars.com.au', 'Housestars');
                $message->subject($topic.': ' . $subject);
            });
    }
    
    public function termsConditions()
    {
         return view('general.terms');
    }
    
    public function privacyPolicy()
    {
         return view('general.policy');
    }
    
    
    public function test(){
	    	echo "SENDING NOTICE TO SUBSCRIBERS... \n";
    
		    Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
		
		    $users = User::select('users.*')
		                  ->join('role_users', 'role_users.user_id', '=', 'users.id')
		                  ->join('roles', 'roles.id', '=', 'role_users.role_id')
		                  ->where(function ($sub) {
		                      $sub
		                        ->whereNotNull('users.name')
		                        ->whereNotNull('users.customer_id')
		                        ->where('users.name', '<>', '')
		                        ->where('users.customer_id', '<>', '');
		                  })->get();
		
		    $nextMonth = Carbon::now()->addMonth()->format('Y-m-d');
		    $nextTwoWeeks = Carbon::now()->addWeeks(2)->format('Y-m-d');
		    $nextWeek = Carbon::now()->addWeek()->format('Y-m-d');
		    $now = Carbon::now()->format('Y-m-d');
		
		    foreach($users as $user) {
		      $customer = Customer::retrieve($user->customer_id);
		      $subscriptions = $customer->subscriptions->data;
		      if (count($subscriptions)) {
		        $endDate = Carbon::createFromTimestamp($subscriptions[0]->current_period_end)->format('Y-m-d');
		        if ($nextMonth == $endDate || $nextTwoWeeks == $endDate || $nextWeek == $endDate) {
		          $formattedEndDate = Carbon::createFromTimestamp($subscriptions[0]->current_period_end)->format('F j, Y');
		          //$this->sendEmail($user->name, $user->email, $formattedEndDate);
		          echo "End Date: " . $formattedEndDate . '</br>';
		        } else if($now <= $endDate){
			        User::where('id', $user->id)
		          ->update(['subs_status' => 0]);
		        }
		      }
		      
		       echo 'Subscription checked for :' . $user->name . '</br>';
		    }
    }
    
}
