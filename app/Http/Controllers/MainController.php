<?php

namespace App\Http\Controllers;

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

class MainController extends Controller
{
    function dashboard(){
    	if(Sentinel::check()){
          switch (Sentinel::getUser()->roles()->first()->slug){
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

    function home(){

        $ads = Advertisement::get();
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

        if(isset($advert['141x117'])){
            $numAds =  count($advert['141x117']) - 1;
            $index = rand(0, $numAds);
            $data['141x117'] = $advert['141x117'][$index ];

        } else if(isset($advert['728x90'])){
            $numAds =  count($advert['728x90']) - 1;
            $index = rand(0, $numAds);
            $data['728x90'] = $advert['728x90'][$index ];
        }

        return view('home')->with('advert', $data);
    }

    function agency(){
        $data['suburbs'] = Suburbs::all();
        $reviews = Reviews::all();
        $data['comments'] = array();

        foreach ($reviews as $review) {
            // check if review is for housestars
            if($review->reviewee_id == 1){
                //Check if agency review
                $isAgency = Role::where('user_id', '=', $review->reviewer_id)->get();
                if(count($isAgency) > 0){
                // get review details
                    $review_details['average'] = (int)round(($review->communication + $review->work_quality + $review->price + $review->punctuality + $review->attitude) / 5);
                    $review_details['title'] = $review->title;
                    $review_details['content'] = $review->content;
                    $review_details['helpful'] = $review->helpful;
                // get reviewer details
                    $user = UserMeta::where('user_id', '=', $review->reviewer_id)->get();
                    foreach ($user as $key) {
                        if($key->meta_name == 'agency-name'){
                            $review_details['name'] = $key->meta_value;
                        } else if($key->meta_name == 'profile-photo'){
                            $review_details['img'] = $key->meta_value;
                        }
                    }

                    array_push($data['comments'], $review_details);

                }
            }
       }

       //dd($data);
        return view('general.agency')->with('data', $data);
    }

    public function savingsCalculator(Request $request){

        $this->sendEmail($request);
        return Response::json('success', 200);
    }

      private function sendEmail($request){
        $email = $request->input('email');
        $name = $request->input('name');
        Mail::send(['html' => 'emails.savings-calculator'], [
                'name' => $request->input('name'),
                'email' => $request->input('phone'),
                'phone' => $request->input('email'),
                'suburb' => $request->input('suburb'),
                'type' => $request->input('property-type'),
                'price' => $request->input('estimated-price')
            ], function ($message) use ($name) {
                $message->from('info@housestars.com.au', 'Housestars');
                $message->to('info@housestars.com.au', 'Savings Estimation Calculator');
                $message->subject('Savings Estimation Calculator: '. $name);
            });
    }

    public function unpaid(){
      $suburbs = Suburbs::all();
      \Stripe\Stripe::setApiKey("sk_test_qaq6Jp8wUtydPSmIeyJpFKI1");
      $customer_info = \Stripe\Customer::retrieve(Sentinel::getUser()->customer_id);
      $payment_status = $customer_info->subscriptions->data[0]->status;
      return View::make('general/payment-status')->with('suburbs', $suburbs)->with('status', $payment_status);
    }
}
