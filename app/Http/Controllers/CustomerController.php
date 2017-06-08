<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Sentinel;
use App\UserMeta;
use App\Suburbs;
use App\Property;
use App\User;
use App\Reviews;
use App\Transactions;
use App\Advertisement;
use View;
use Response;
use Mail;
use Hash;

class CustomerController extends Controller
{
    public function dashboard(Request $request)
    {   
        $data = [];
        if(is_null($request->route('id')) && Sentinel::check()) {
            $user = Sentinel::getUser();
            $data['isOwner'] = true;
        } else {
            $user = User::findOrfail($request->route('id'));
            $data['isOwner'] = false;
        }

        $data['isAdmin'] = is_admin();
        $data['user'] = $user;
        $userId = $user->id;
        $userName = $user->name;
        $userEmail = $user->email;
        $data['name'] = $userName ;
        $data['id'] = $userId;

        $user_info = UserMeta::where('user_id', $userId)->get();
        $property = Property::where('user_id', $userId)->get();
        $transactions = Transactions::where('user_id', $userId)->get();
        $reviews = Reviews::where('reviewer_id', $userId)->get();
        $tradesmen = DB::table('users')
                        ->join('role_users', function ($join) {
                            $join->on('users.id', '=', 'role_users.user_id')
                                 ->where('role_users.role_id', '=', 3);
                        })
                        ->get();

        $user_meta = DB::table('user_meta')->get();
        $property_code = '';
        $x = 0;
        $y = 0;
        $z = 0;
        $i = 0;

        foreach ($tradesmen as $tradesman) {
           foreach ($user_meta as $meta) {
                if($meta->user_id == $tradesman->id && $meta->meta_name == 'trading-name' ){
                    $data['tradesmen'][$y] = array('id' => $tradesman->id, 'trading-name' => $meta->meta_value);
                    $y++;
                }
           }
        }


        foreach ($user_info as $key) {
            $data['meta'][$key->meta_name] = $key->meta_value;
        }



        $data['meta']['name'] = $userName;
        $data['meta']['email'] = $userEmail;

        foreach ($property as $key) {

            if($property_code == ''){

                $data['property'][$x][$key->meta_name] = $key->meta_value;
                $data['property'][$x]['property-code'] = $key->property_code;
                $property_code = $key->property_code;

            }else if($key->meta_name == 'agent'){
                $data['agent'] = $this->find_agent_by_id($key->meta_value);
                $data['property'][$x][$key->meta_name] = $key->meta_value;
          } else if($property_code == $key->property_code){
                $data['property'][$x][$key->meta_name] = $key->meta_value;
                $property_code = $key->property_code;
            } else if($property_code != $key->property_code){
                $property_code = $key->property_code;
                $x++;
                $data['property'][$x][$key->meta_name] = $key->meta_value;
                $data['property'][$x]['property-code'] = $key->property_code;
            } else {
                $data['property'][$x][$key->meta_name] = $key->meta_value;
            }

        }

        $data['property']['user_id'] = $userId;

        $data['transactions'] = array();
        $data['code'] = $property_code;
		
        if(count($data['property']) > 1){
            $lastIndex = count($data['property']) - 2;
            $data['agents'] = $this->find_agent_by_suburb($data['property'][$lastIndex]['suburb']);

        } 
	       

        $total = 0;
        $li = 0;

        foreach ($transactions as $transaction ) {
            $business_name = UserMeta::where('user_id', $transaction->tradesman_id)->where('meta_name', 'trading-name')->get();
            if(count($business_name) > 0){
                $data['transactions'][$z]['name'] = $business_name[0]['meta_value'];
            }
            $data['transactions'][$z]['id'] = $transaction->id;
            $data['transactions'][$z]['tid'] = $transaction->tradesman_id;
            $data['transactions'][$z]['amount_spent'] = $transaction->amount_spent;
            $data['transactions'][$z]['receipt'] = $transaction->receipt;

            if (isset($data['transactions'][$li]['code'])) {
                if($data['transactions'][$li]['code'] == $transaction->property_code){
                    $total = $total + (int)$transaction->amount_spent;
                } else {
                    $total = 0 + (int)$transaction->amount_spent;
                }
            } else {
                $total = $total + (int)$transaction->amount_spent;
            }

            $data['transactions'][$z]['code'] = $transaction->property_code;

            $z++;
            $li = $z - 1;
        }

        $data['transaction_reviews'] = array();
        $average = 0;

        foreach ($reviews as $review ) {
            $data['transaction_reviews'][$i]['id'] = $review->reviewee_id;
            $data['transaction_reviews'][$i]['rate'] = (int)round(($review->communication + $review->work_quality + $review->price + $review->punctuality + $review->attitude) / 5);
            $data['transaction_reviews'][$i]['transaction_id'] = $review->transaction;
            $data['transaction_reviews'][$i]['communication'] = (int)$review->communication;
            $data['transaction_reviews'][$i]['work_quality'] = (int)$review->work_quality;
            $data['transaction_reviews'][$i]['price'] = (int)$review->price;
            $data['transaction_reviews'][$i]['punctuality'] = (int)$review->punctuality;
            $data['transaction_reviews'][$i]['attitude'] = (int)$review->attitude;
            $data['transaction_reviews'][$i]['title'] = $review->title;
            $i++;
        }

        $data['spending']['total'] = $total;

        if(isset($data['agent']) && count($data['property']) > 1) {
            $agency_commission = ((float)str_replace("%","",$data['agent']['rate']) / 100) * (float)$data['property'][$lastIndex]['value-to'];
            $customer_commission = ((float)str_replace("%","",$data['property'][$lastIndex]['commission']) / 100) * $agency_commission;
            $data['commission']['estimate'] = $customer_commission;
            //dd($customer_commission);
            if (isset($data['property'][$lastIndex]['commission-charged']) && strtolower($data['property'][$lastIndex]['commission-charged']) == 'yes') {
                $data['commission']['total'] =  isset($data['property'][$lastIndex]['commission-total']) ? $data['property'][$lastIndex]['commission-total'] : $customer_commission;
            } else {
                $data['commission']['total'] = $customer_commission;
            }
        } else {
            $data['commission']['total'] = 'N/A';
            $data['commission']['estimate'] = 'N/A';
        }

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
        
        
                
        if(count($data['property']) > 1) {
            $data['recent'] = $lastIndex;
            if (isset($data['property'][$lastIndex]['process'])){
                return View::make('dashboard/customer/profile')->with('data', $data);
            }
        }

        if ($data['isOwner']) {
            // Check of the last property added was proccessed
            return View::make('dashboard/customer/process')->with('data', $data);
        } else if(count($data['property']) > 1) {
            $data['recent'] = $lastIndex;
            if (isset($data['property'][$lastIndex]['process'])){
                return View::make('dashboard/customer/profile')->with('data', $data);
			} else{
				return View::make('dashboard/customer/process')->with('data', $data);
			}
    	}
        
        abort(230, "{$data['name']} haven't yet completed the registration process.");
    }

    public function edit(Request $request)
    {
        $userId = $request->route('id') ? : Sentinel::getUser()->id;
        $meta = UserMeta::where('user_id', $userId)->get();
        $user = User::where('id', $userId)->get();
        $data = array();
        $data['profile-photo'] = 'assets/default.png';
        $data['cover-photo'] = 'assets/default_cover_photo.jpg';

        foreach ($meta as $key) {
            $data[$key->meta_name] = $key->meta_value;
        }

        foreach ($user as $key) {
            $data['email'] = $key->email;
            $data['name'] = $key->name;
        }
        $data['id'] = $userId;
        $data['profile-url'] = is_admin() ? "/profile/customer/$userId" : '/profile';
        return View::make('dashboard/customer/edit')->with('data', $data);
    }

    public function update(Request $request)
    {
        if(Sentinel::check())
        {
            $id = (is_admin() && $request->route('id') ?  $request->route('id') : Sentinel::getUser()->id);

            if ($request->input('password') == '') {
                User::updateOrCreate(
                    ['id' => $id],
                    ['id' => $id, 'email' => $request->input('email'), 'name' => $request->input('name')]);
            } else {
                $password = Hash::make($request->input('password'));
                User::updateOrCreate(
                    ['id' => $id],
                    ['id' => $id, 'email' => $request->input('email'), 'name' => $request->input('name'), 'password' => $password]);
            }

            UserMeta::updateOrCreate(
                ['user_id' => $id, 'meta_name' => 'address'],
                ['user_id' => $id, 'meta_name' => 'address', 'meta_value' => $request->input('address')]
            );

            return redirect()->back();

        } else {
            return redirect(env('APP_URL'));
        }

    }


    public function spending(Request $request){

        if($request->input('trades') != null && $request->input('amount-spent') != null ){

            $user_id = $request->input('user_id');
            $tradesman =  UserMeta::where('user_id', $request->input('trades'))->where('meta_name', 'business-name')->get();

            if ($request->hasFile('receipt') ) {

                $file = $request->file('receipt');
                $localpath = 'user/user-'.$user_id.'/uploads';
                $filename = 'img'.rand().'-'.Carbon::now()->format('YmdHis').'.'.$file->getClientOriginalExtension();
                $path = $file->move(public_path($localpath), $filename);
                $url = $localpath.'/'.$filename;
                $id = DB::table('transactions')->insertGetId(
                        ['user_id' => $user_id, 'tradesman_id' => $request->input('trades'), 'amount_spent' => $request->input('amount-spent'), 'property_code' => $request->input('property-code'), 'receipt' => $url, 'created_at' => Carbon::now()]
                    );
                $data = array('tradesman' => $tradesman[0]['meta_value'], 'amount' => $request->input('amount-spent'), 'property_code' => $request->input('property-code'), 'receipt' => $url, 'id' => $id, 'tid' => $request->input('trades'));

            } else {
                $id = DB::table('transactions')->insertGetId(
                        ['user_id' => $user_id, 'tradesman_id' => $request->input('trades'), 'amount_spent' => $request->input('amount-spent'), 'property_code' => $request->input('property-code'), 'created_at' => Carbon::now()]
                    );

                $data = array('tradesman' => $tradesman[0]['meta_value'], 'amount' => $request->input('amount-spent'), 'property_code' => $request->input('property-code'), 'id' => $id, 'tid' => $request->input('trades'));
            }


            $transactions = Transactions::where('user_id', Sentinel::getUser()->id)->get();

            $total = 0;
            $z = 0; $li = 0;
            foreach ($transactions as $transaction ) {

                if(isset($data['transactions'][$li]['code'])){
                    if($data['transactions'][$li]['code'] == $transaction->property_code){
                        $total = $total + (int)$transaction->amount_spent;
                    } else {
                        $total = 0 + (int)$transaction->amount_spent;
                    }
                } else {
                    $total = $total + (int)$transaction->amount_spent;
                }

                $data['transactions'][$z]['code'] = $transaction->property_code;

                $z++;
                $li = $z - 1;
            }

            $data['total'] = $total;


            return Response::json($data, 200);

        } else {
            return Response::json('Select a tradesman & add amount spent', 422);
        }

    }

    function uploadReceipt(Request $request){


            if ($request->hasFile('receipt') ) {
	            $user_id = $request->input('user_id');
                $file = $request->file('receipt');
                $localpath = 'user/user-'.$user_id.'/uploads';
                $filename = 'img'.rand().'-'.Carbon::now()->format('YmdHis').'.'.$file->getClientOriginalExtension();
                $path = $file->move(public_path($localpath), $filename);
                $url = $localpath.'/'.$filename;

                DB::table('transactions')->where('id', $request->input('id'))->update(['receipt' => $url]);

                $data = array('url' => $url, 'tid' => $request->input('tid'), 'id' => $request->input('id'));

                return Response::json($data, 200);

            }

    }

    function uploadContract(Request $request){

            if ($request->hasFile('contract') ) {
               $data = [];
		        $role = Sentinel::getUser()->roles()->first()->slug;
        
				if ($role == 'customer') {
		            $user = Sentinel::getUser();
		            $data['isOwner'] = true;
		        } else {
		            $user = User::findOrfail($request->route('id'));
		            $data['isOwner'] = false;
		        }
		
		        $data['user'] = $user;
	            $user_id = $user->id;
                $file = $request->file('contract');
                $localpath = 'user/user-'.$user_id.'/uploads';
                $filename = 'img'.rand().'-'.Carbon::now()->format('YmdHis').'.'.$file->getClientOriginalExtension();
                $path = $file->move(public_path($localpath), $filename);
                $url = $localpath.'/'.$filename;

                $property = new Property;

                $property->user_id = $user_id;
                $property->meta_name = 'contract';
                $property->meta_value = $url;
                $property->property_code = $request->input('property_code');

                $property->save();

                return Response::json('success', 200);

            }

    }

    public function confirm(Request $request) 
    {
        
        $user_id = $request->input('userid');
        $code = $request->input('code');
        $meta = $request->input('meta');
        $amount = validate_amount($request->get('meta_amount_value', 0));
        $isChecked = strtolower($request->input('checked', 'no'));
        $exists =  Property::getProperty($code, $meta)->exists();
        $updateAmount = Property::getProperty($code, $request->get('meta_amount_name', ''))->exists();

        if(!$exists) {
            $property = new Property;
            $property->user_id = $user_id;
            $property->meta_name = $meta;
            $property->meta_value = $isChecked;
            $property->property_code = $code;
            $property->save();
        } else if($exists) {
            Property::getProperty($code, $meta)->update(['meta_value' => $isChecked]);
        }
        
        if(!$updateAmount && $request->exists('meta_amount_name')) {
            $property = new Property;
            $property->user_id = $user_id;
            $property->meta_name = $request->get('meta_amount_name');
            $property->meta_value = $amount;
            $property->property_code = $code;
            $property->save();
        } else if ($updateAmount && $request->exists('meta_amount_name')) {
            Property::getProperty($code, $request->get('meta_amount_name'))->update(['meta_value' => $amount]);
        }
        
        return Response::json('success', 200);
    }

    function processForm(Request $request){

        $user_id = Sentinel::getUser()->id;
        $code = $request->input('property_code');
        $meta = array('process', 'discount');

        foreach ($meta as $key) {
            $exist =  Property::where('property_code', '=', $code)->where('meta_name','=', $key)->get();

            if(count($exist) == 0){
                $property = new Property;
                $property->user_id = $user_id;
                $property->meta_name = $key;
                if($key == 'process'){
                    $property->meta_value = 'Pending';
                }else{
                    $property->meta_value = $request->input('commission');
                }
                $property->property_code = $code;
                $property->save();
            }
        }

        $property = Property::where('property_code', '=', $code)->get();
        $user = array('name' => Sentinel::getUser()->name, 'email' => Sentinel::getUser()->email);
        $transactions = Transactions::where('user_id', Sentinel::getUser()->id)->get();


        foreach ($property as $key) {
            $data['property'][$key->meta_name] = $key->meta_value;
        }

        $z = 0;
        $total = 0;
        $li = 0;

        foreach ($transactions as $transaction ) {
            if($transaction->property_code == $code){
                $business_name = UserMeta::where('user_id', $transaction->tradesman_id)->where('meta_name', 'business-name')->get();
                if(count($business_name) > 0){
                    $data['property']['transactions'][$z]['name'] = $business_name[0]['meta_value'];
                }
                $data['property']['transactions'][$z]['amount_spent'] = $transaction->amount_spent;
                $data['property']['transactions'][$z]['date'] = date_format($transaction->created_at, 'd/m/y');

                 if(isset($data['property']['transactions'][$li]['code'])){
                    if($data['property']['transactions'][$li]['code'] == $transaction->property_code){
                        $total = $total + (int)$transaction->amount_spent;
                    } else {
                        $total = 0 + (int)$transaction->amount_spent;
                    }
                } else {
                    $total = $total + (int)$transaction->amount_spent;
                }

                $data['property']['transactions'][$z]['code'] = $transaction->property_code;

                $z++;
                $li = $z - 1;
            }
        }

         $data['property']['total'] =  $total;


        $this->sendEmail($user, $data['property']);

        return Response::json('success', 200);
    }

    function updateAmount(Request $request){

        DB::table('transactions')->where('id', $request->input('id'))->update(['amount_spent' => $request->input('content')]);

        $transactions = Transactions::where('user_id', Sentinel::getUser()->id)->get();
        $total = 0;
        $z = 0; $li = 0;
            foreach ($transactions as $transaction ) {

                if(isset($data['transactions'][$li]['code'])){
                    if($data['transactions'][$li]['code'] == $transaction->property_code){
                        $total = $total + (int)$transaction->amount_spent;
                    } else {
                        $total = 0 + (int)$transaction->amount_spent;
                    }
                } else {
                    $total = $total + (int)$transaction->amount_spent;
                }

                $data['transactions'][$z]['code'] = $transaction->property_code;

                $z++;
                $li = $z - 1;
            }

        $data['total'] = $total;

        return Response::json($data, 200);

    }

    function updateCommission(Request $request){

      $value = preg_replace('/\D/', '', $request->input('content'));
      DB::table('property_meta')->where('user_id', $request->input('id'))->where('property_code',$request->input('code'))->where('meta_name', 'commission')->update(['meta_value' => $value]);
      return Response::json('success', 200);
    }

    function delete(Request $request){

        $tradesman_id = DB::table('transactions')->where('id', '=', $request->input('id'))->get();
        $tid = $tradesman_id[0]->tradesman_id;
        DB::table('transactions')->where('id', '=', $request->input('id'))->delete();
        DB::table('reviews')->where('reviewee_id', '=', $tid)->where('transaction', '=', $request->input('id'))->delete();

        $transactions = Transactions::where('user_id', Sentinel::getUser()->id)->get();
        $total = 0;
        foreach ($transactions as $transaction ) {
            $total = $total + (int)$transaction->amount_spent;
        }

        $data['total'] = $total;

        return Response::json($data, 200);

    }

    function find_agent_by_suburb($suburb){

        $sub = preg_replace('/[0-9]+/', '', $suburb);
        $postcode = preg_replace('/\D/', '', $suburb);

        $suburbInfo =  Suburbs::where('name', $sub)->first();
        $lat = $suburbInfo->latitude;
        $long = $suburbInfo->longitude;


        $qry = "SELECT name , id, (3956 * 2 * ASIN(SQRT( POWER(SIN(( $lat - latitude) *  pi()/180 / 2), 2) +COS( $lat * pi()/180) * COS(latitude * pi()/180) * POWER(SIN(( $long - longitude) * pi()/180 / 2), 2) ))) as distance
                from suburbs
                having  distance <= 10000
                order by distance
                limit 10";

        $nearby = DB::select($qry);
        
        $agents = array();

        $searchInArray = array_search($sub, $nearby);
        if($searchInArray == false){
          $users = DB::table('user_meta')->where('meta_value', 'LIKE', '%'. $sub .'%')->get();

          foreach ($users as $user) {
              if($this->is_agent($user->user_id) == true){
                  $agent_info = DB::table('user_meta')->where('user_id', '=',$user->user_id)->get();


                  foreach ($agent_info as $info) {
                      if($info->meta_name == 'agency-name'){
                          $name =  $info->meta_value;
                      } else if($info->meta_name == 'profile-photo'){
                          $photo = $info->meta_value;
                      }
                  }

                  $rating = $this->getRating($user->user_id);

                  if(isset($photo)){
                      $agent = array('id' => $user->user_id, 'name' => $name, 'photo' => $photo, 'rating' => $rating, 'suburb' => $sub);
                  } else {
                      $agent = array('id' => $user->user_id, 'name' => $name, 'rating' => $rating, 'suburb' => $sub);
                  }


                  array_push($agents, $agent);
              }
          }
        }

        foreach ($nearby as $key) {
          if($sub != $key->name){
            $users = DB::table('user_meta')->where('meta_value', 'LIKE', '%'. $key->name .'%')->get();

            foreach ($users as $user) {
                if($this->is_agent($user->user_id) == true){
                    $agent_info = DB::table('user_meta')->where('user_id', '=',$user->user_id)->get();


                    foreach ($agent_info as $info) {
                        if($info->meta_name == 'agency-name'){
                            $name =  $info->meta_value;
                        } else if($info->meta_name == 'profile-photo'){
                            $photo = $info->meta_value;
                        }
                    }

                    $rating = $this->getRating($user->user_id);

                    if(isset($photo)){
                      $agent = array('id' => $user->user_id, 'name' => $name, 'photo' => $photo, 'rating' => $rating, 'suburb' => $key->name);
                    } else {
                      $agent = array('id' => $user->user_id, 'name' => $name, 'rating' => $rating, 'suburb' => $key->name);
                    }

                    array_push($agents, $agent);
                }
            }
          }
        }
        return $agents;
    }

    function find_agent_by_id($id){

        $agent_info = DB::table('user_meta')->where('user_id', '=',$id)->get();

        foreach ($agent_info as $info) {
            if($info->meta_name == 'agency-name'){
                $name =  $info->meta_value;
            } else if($info->meta_name == 'profile-photo'){
                $photo = $info->meta_value;
            } else if($info->meta_name == 'base-commission'){
                $rate = $info->meta_value;
            }
        }

        $rating = $this->getRating($id);

        if(isset($name)){

          if(!isset($photo)){
            $photo = 'assets/default.png';
          }
            $agent = array('id' => $id, 'name' => $name, 'photo' => $photo, 'rating' => $rating, 'rate' => $rate);
        } else {
            $agent = null;
        }

        return $agent;

    }

    function is_agent($id){
        $agents = DB::table('role_users')->where('user_id', '=', $id)->get();
        $isAgent = false;

        foreach ($agents as $agent) {
            if($agent->role_id == 2){
                $isAgent = true;
            }
        }

        return $isAgent;
    }

    function getRating($id){
        $ratings = DB::table('reviews')->where('reviewee_id', '=', $id)->get();
        $average = 0;
        $numRatings = count($ratings);

        foreach ($ratings as $rating) {
            $average = ($average + (int)round(($rating->communication + $rating->work_quality + $rating->price + $rating->punctuality + $rating->attitude) / 5)) / $numRatings;
        }

        return $average;
    }

    function agentInfo(Request $request){
        $user_id = $request->input('userid');
        $agent_meta = DB::table('user_meta')->where('user_id', '=', $request->input('id'))->get();

        $data = array();

        foreach ($agent_meta as $agent) {
            if($agent->meta_name == 'agency-name'){
                $name =  $agent->meta_value;
                $data['name'] = $name;
            }
        }

        $propertyInfo = Property::where('property_code', $request->input('code'))->get();

        $agencyEmail =  User::where('id', $request->input('id'))->first()->email;

        foreach ($propertyInfo as $info) {
          $data[$info->meta_name] = $info->meta_value;
        }
        $data['code'] = $request->input('code');

        $this->notifyAgency($data, $agencyEmail);


        Property::updateOrCreate(
                        ['user_id' => $user_id, 'meta_name' => 'agent', 'property_code' => $request->input('code')],
                        ['user_id' => $user_id, 'meta_name' => 'agent', 'meta_value' => $request->input('id'), 'property_code' => $request->input('code')]
                    );

        $data['rating'] =  $this->getRating($request->input('id'));
        
        $property['customer_name'] = Sentinel::getUser()->name;
        $property['customer_email'] = Sentinel::getUser()->email;
        $property['property-address'] = Property::where('property_code', $request->input('code'))->where('meta_name', 'property-address')->first()->meta_value;
        $property['suburb'] = Property::where('property_code', $request->input('code'))->where('meta_name', 'suburb')->first()->meta_value;
        if(Property::where('property_code', $request->input('code'))->where('meta_name', 'state')->first()){
	         $property['state'] = Property::where('property_code', $request->input('code'))->where('meta_name', 'state')->first()->meta_value;

        }
        $property['agent'] = $request->input('id');
        $property['agency'] =  UserMeta::where('user_id', $request->input('id'))->where('meta_name', 'trading-name')->first()->meta_value;
        
        $adminEmail = 'info@housestars.com.au';
        $this->notifyAdmin($property, $adminEmail);

        return Response::json($data, 200);
    }
    
    private function notifyAdmin($property, $email){
        // $property_name = $property->suburb. ', '.$property->state;
        Mail::send(['html' => 'emails.admin-property'], [
                'property' => $property
            ], function ($message) use ($property) {
                $message->from('info@housestars.com.au', 'Housestars');
                $message->to('info@housestars.com.au');
                $message->subject('Customer ' . $property['customer_name'] . ' added new property');
            });
    }

    private function sendEmail($user, $data){
        $name = $user['name'];
        $email = $user['email'];
        $subject = $data['suburb']. ', '.$data['state'];

        Mail::send(['html' => 'emails.process-property'], [
                'user' => $user,
                'data' => $data
            ], function ($message) use ($name, $email, $subject) {
                $message->from('info@housestars.com.au', 'Housestars');
                $message->to('info@housestars.com.au');
                $message->subject('Processing property in '. $subject);
        });
    }

    function property(){
        $suburbs = Suburbs::all();
        return view('dashboard.customer.add-property')->with('suburbs', $suburbs);
    }

    public function addProperty(Request $request)
    {
        $user_id = Sentinel::getUser()->id;
        $property_meta = array('property-type', 'property-address', 'number-rooms','post-code','suburb','state','leased','value-from','value-to','more-details','agent', 'commission');
        $property_code = md5(uniqid(rand(), true));
        $isNew = (Property::where('user_id', $user_id)->count() <= 1);

        foreach ($property_meta as $meta) {
            if ($request->exists($meta) && $request->has($meta) && $request->input($meta) != '') {
                $value = $request->input($meta);

                Property::updateOrCreate(
                        ['user_id' => $user_id, 'meta_name' => $meta, 'property_code' => $property_code],
                        ['user_id' => $user_id, 'meta_name' => $meta, 'meta_value' => $value, 'property_code' => $property_code]
                    );
            }

            if($meta == 'agent' && $request->has($meta)) {
              $propertyInfo = Property::where('property_code', $property_code)->get();
              
              foreach ($propertyInfo as $info) {
                $data[$info->meta_name] = $info->meta_value;
              }
              $data['code'] = $request->input('code');
              if($request->input('agent')){
	              $agencyEmail =  User::where('id', $request->input('agent'))->first()->email;
				  $this->notifyAgency($data, $agencyEmail); 
              }
             
            }
        }

        if ($isNew) {
            $this->sendWelcomeEmail(Sentinel::getUser());
        }

        return redirect(env('APP_URL').'/dashboard/customer/profile');
    }
    
    private function sendWelcomeEmail($user)
    {
        Mail::send(['html' => 'emails.welcome-customer'], [
            'name' => $user->name
        ], function ($message) use ($user) {
            $message->from('info@housestars.com.au', 'Housestars');
            $message->to($user->email);
            $message->subject('Welcome to Housestars!');
        });
    }

    private function notifyAgency($property, $email) {
        // $property_name = $property->suburb. ', '.$property->state;
        Mail::send(['html' => 'emails.property-offer'], [
            'property' => $property
        ], function ($message) use ($email) {
            $message->from('info@housestars.com.au', 'Housestars');
            $message->to($email);
            $message->subject('Property Offer');
        });
    }
}
