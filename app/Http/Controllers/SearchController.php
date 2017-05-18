<?php

namespace App\Http\Controllers;

use App\RoleUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Session;
use App\Suburbs;
use App\UserMeta;
use App\User;
use App\Role;
use App\Category;
use App\Advertisement;
use Response;
use Mail;

class SearchController extends Controller
{
    public function search(Request $request, $item)
    {
    	switch ($item) {
    		case 'category':
    			$data['cat'] = Category::whereStatus(1)
    							->orderBy("category", "asc")
    							->groupBy('category')
    							->get();
                $data['suburb_id'] = $data['suburb_name'] ='';
                $data['suburb'] = $request->get('suburb', '');

                preg_match_all('!\d!', $data['suburb'], $matches);
                if (isset($matches[0])) {
                    $data['suburb_id']   = implode('', $matches[0]);
                    $data['suburb_name'] = trim(str_replace($data['suburb_id'], '', $data['suburb']));
                }
                $data['item'] = $this->hasResults($data['suburb_id']);
		        return Response::json($data, 200);
    			break;
    		case 'agency':
                $data = $this->agencyListing($request->get('term', ''));
				
				
				
                if(count($data) > 1 && $request->get('term', '') != ''){
                  $request->session()->put('data', $data);
                  return Response::json('redirect', 200);

                } else if($request->get('term', '') != ''){

                    $data = $this->nearbyAgency($request->get('term', ''));
                    if($data != false){
                        return Response::json($data, 200);
                    } else {
                      return redirect()->back()->with('error', 'No result found for '. $request->get('term', ''));
                    }

                } else {
                    return Response::json('error', 200);
                }

                break;
    		default:
    			break;
    	}

    }

    public function showResults(Request $request){
      if(Session::has('data')){
        return view('general.agency-listings')->with('data', $request->session()->get('data'));
      } else {
        return redirect()->back();
      }
    }

    public function hasResults($suburb)
    {
    	$suburbExists = UserMeta::where('meta_value', 'LIKE', '%'.$suburb.'%')->get();
    	$tradesmen = array();

    	foreach ($suburbExists as $key) {
            if($activeUser = User::where('id', '=', $key->user_id)->first()){
    			if ($activeUser->role && ($activeUser->role->role_id == 3)) {
    				$tradesman = $activeUser->usermetas->toArray(); //$activeUser->usermetas->where('meta_name', 'trade')->toArray();
                    if (!in_array($tradesman, $tradesmen)) {
    	    			array_push($tradesmen, $tradesman);
                    }
	    		}
            }
    	}

    	$data = array();

    	if (count($tradesmen) == 0) {
    		$data['msg'] = 'No result found for '. $suburb;
    		return $data;
    	}

    	foreach ($tradesmen as $key => $tradesman) {
            $mapped = collect($tradesman)->mapWithKeys(function ($item) {
                return [$item['meta_name'] => $item['meta_value']];
            });
            $mapped = $mapped->put('id', $tradesman[0]['user_id']);
            array_push($data, $mapped);
    	}

    	return $data;
    }

    public function tradesmenListing($category, $suburb)
    {	


                preg_match_all('!\d!', $suburb, $matches);
                if (isset($matches[0])) {
                    $data['suburb_id']   = implode('', $matches[0]);
                }
        $trade = UserMeta::where('meta_value', 'LIKE', '%'.$data['suburb_id'].'%')->get();
        $tradesmen = array();

        foreach ($trade as $key) {
          if(isset($key->user_id)) {
            $verifyRole =  RoleUsers::where('user_id', $key->user_id)->first();
            if($verifyRole['role_id'] ==  3) {
              if(!in_array($key->user_id, $tradesmen)){
                  array_push($tradesmen, $key->user_id);
              }
            }
          }
        }



        $data = array();
        $x = 0;
        foreach ($tradesmen as $id) {
           $activeUser = User::where('id', '=', $id)->get();
           if(count($activeUser) > 0){

                 $tradesmenArray = UserMeta::where('user_id', $id)->get();
                 foreach ($tradesmenArray as $tradie) {

                   if ($tradie->meta_name == 'trade' && ($tradie->meta_value == $category || strtolower($category) == 'all')) {
                     $tradesmanData = UserMeta::where('user_id', '=', $tradie->user_id)->get();
                     foreach ($tradesmanData as $value) {
                         $data[$x][$value->meta_name] = $value->meta_value;
/*
                         $data[$x+ 1][$value->meta_name] = $value->meta_value;
                         $data[$x+ 2][$value->meta_name] = $value->meta_value;
                          $data[$x+ 3][$value->meta_name] = $value->meta_value;
                         $data[$x+ 4][$value->meta_name] = $value->meta_value;
                          $data[$x+ 5][$value->meta_name] = $value->meta_value;
                         $data[$x+ 6][$value->meta_name] = $value->meta_value;
                          $data[$x+ 7][$value->meta_name] = $value->meta_value;
                         $data[$x+ 8][$value->meta_name] = $value->meta_value;
*/
                     }
                     $data[$x]['rating'] = $this->getRating($id);
                     $data[$x]['id'] = $value->user_id;
                     
// For Testing Banner Advert
/*
                     $data[$x + 1]['rating'] = $this->getRating($id);
                     $data[$x + 1]['id'] = $value->user_id;
                     
                     $data[$x + 2]['rating'] = $this->getRating($id);
                     $data[$x + 2]['id'] = $value->user_id;
                     
                     $data[$x + 3]['rating'] = $this->getRating($id);
                     $data[$x + 3]['id'] = $value->user_id;
                     
                     $data[$x + 4]['rating'] = $this->getRating($id);
                     $data[$x + 4]['id'] = $value->user_id;
                     
                     $data[$x + 5]['rating'] = $this->getRating($id);
                     $data[$x + 5]['id'] = $value->user_id;
                     
                     $data[$x + 6]['rating'] = $this->getRating($id);
                     $data[$x + 6]['id'] = $value->user_id;
                     
                     $data[$x + 7]['rating'] = $this->getRating($id);
                     $data[$x + 7]['id'] = $value->user_id;
                     
                     $data[$x + 8]['rating'] = $this->getRating($id);
                     $data[$x + 8]['id'] = $value->user_id;
*/
                     $x++;
                   }
                 }
           }
        }

        $data['cat'] = $category;
        $data['suburb'] = preg_replace('/[0-9]/', '', $suburb). ' (' . preg_replace('/\D+/', '', $suburb) . ')';

        $hasPriority = (Advertisement::hasPriority(0)->exists() && Advertisement::hasPriority(1)->exists());
        
        if ($ads = Advertisement::getByPage('tradies')->randomPriority($hasPriority)->inRandomOrder()->first()) {
          $data['ads'] = $ads;
        }
        
        //dd($data);
                
        return view('general.tradesman-listings')->with('data', $data);
    }


    public function agencyListing($term)
    {
        //check if term has result
        $results = UserMeta::where('meta_value', 'LIKE', '%'.$term.'%')->get();
        // return no result

        if(count($results) == 0) {
            return $data['cat'] = $term;
        }
        //process result
        $agencies = [];
        foreach ($results as $result) {
            if(!is_null(RoleUsers::hasRole($result->user_id,2)->first())) {
              if(!in_array($result->user_id, $agencies)) {
                  array_push($agencies, $result->user_id);
              }
            }
        }

        $x = 0;
        foreach ($agencies as $id) {
            $activeUser = User::where('id', '=', $id)->get();
            if(count($activeUser) > 0) {
                $agencyData = UserMeta::where('user_id', '=', $id)->get();
                foreach ($agencyData as $value) {
                if ($value->meta_name == 'summary') {
                    $data[$x][$value->meta_name] = substr($value->meta_value, 0, 150);
                } else {
                    $data[$x][$value->meta_name] = $value->meta_value;
                }

                }
                $data[$x]['id'] = $value->user_id;
                $x++;
           }
        }
        $data['cat'] = $term;
        return $data;
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

    public function send(Request $request, $type){
        $suburb = $request->get('suburb', '');

        if ($request->has('suburb-name') && !empty($suburb)) {
            $suburb = $request->get('suburb-name', '');
        }

        switch ($type) {
            case 'tradesman':
                $this->sendEmail($request->input('name'), $request->input('contact'), $suburb, 'emails.suggest-tradesman', null);
                return Response::json('success', 200);
                break;
            case 'agency':
                $this->sendEmail($request->input('name'), $request->input('contact'), $suburb, 'emails.suggest-agency', null);
                return Response::json('success', 200);
                break;
            case 'category':
                $this->sendEmail($request->input('name'), $request->input('trade'), null, 'emails.suggest-category', $request->input('email'));
                return Response::json('success', 200);
                break;
        }
    }

    private function sendEmail($name, $contact, $suburb = null, $template, $from){
        Mail::send(['html' => $template], [
                'name'    => $name,
                'contact' => $contact,
                'suburb'  => $suburb,
                'from'    => $from
            ], function ($message) {
                $message->from('info@housestars.com.au', 'Housestars');
                $message->to('info@housestars.com.au', 'Housestars');
                $message->subject('Suggestion');
            });
    }

    public function nearbyAgency($sub){

      $suburb = preg_replace('/[0-9]+/', '', $sub);
      $postcode = preg_replace('/\D/', '', $sub);

      $suburbInfo =  Suburbs::where('name', $suburb)->first();

      if(count($suburbInfo ) > 0){
        $lat = $suburbInfo->latitude;
        $long = $suburbInfo->longitude;
      } else {
        return false;
      }



      	$qry = "SELECT name , id, (3956 * 2 * ASIN(SQRT( POWER(SIN(( $lat - latitude) *  pi()/180 / 2), 2) +COS( $lat * pi()/180) * COS(latitude * pi()/180) * POWER(SIN(( $long - longitude) * pi()/180 / 2), 2) ))) as distance
              from suburbs
              having  distance <= 1000
              order by distance
              limit 1000";

        $nearby = DB::select($qry);
       
        
        $agencies = DB::table('users')
                        ->join('role_users', function ($join) {
                            $join->on('users.id', '=', 'role_users.user_id')
                                 ->where('role_users.role_id', '=', 2);
                        })
                        ->get();
        $search = array();
        $nearbySearch = array();

        foreach ($nearby as $key) {

          if($key->name != $suburb){
            $suburbs = DB::table('user_meta')->where('meta_value', 'LIKE', '%'.$key->name.'%')->get();

            foreach ($agencies as $agency) {
               foreach ($suburbs as $suburb) {
                    if($suburb->user_id == $agency->id){
                        $agencyInfo['id'] = $agency->id;
                        $agencyInfo['name'] = $agency->name;
                        $data = UserMeta::where('user_id', $agency->id)->where('meta_name', 'profile-photo')->first();
                        $agencyInfo['photo'] = $data['meta_value'];
                        $agencyInfo['suburb'] = $key->name .', '.$key->id;
                        array_push($nearbySearch, $agencyInfo);
                    }
               }
            }
          }
        }

        return $nearbySearch;

    }

    public function postSearchAgency(Request $request)
    {
        $term = $request->get('term', '');
        $data = $this->agencyListing($term);
        if(count($data) <= 1) {
            return redirect()->back()->with('error', 'No result found for '. $request->get('term', ''));
        }
        return view('general.agency-listings')->with('data', $data);
    }
}
