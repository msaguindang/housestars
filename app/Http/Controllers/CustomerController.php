<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Sentinel;
use App\UserMeta;
use App\Suburbs;
use App\Property;
use App\Reviews;
use App\Transactions;
use View;
use Response;


class CustomerController extends Controller
{
    function dashboard(){
    	$user_info = UserMeta::where('user_id', Sentinel::getUser()->id)->get();
        $property = Property::where('user_id', Sentinel::getUser()->id)->get();
        $transactions = Transactions::where('user_id', Sentinel::getUser()->id)->get();
        $reviews = Reviews::where('reviewer_id', Sentinel::getUser()->id)->get();
        $suburbs = Suburbs::all();
        $tradesmen = DB::table('users')
                        ->join('role_users', function ($join) {
                            $join->on('users.id', '=', 'role_users.user_id')
                                 ->where('role_users.role_id', '=', 3);
                        })
                        ->get();

        $user_meta = DB::table('user_meta')->get();
        $data = array();
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

        $data['meta']['name'] = Sentinel::getUser()->name;
        $data['meta']['email'] = Sentinel::getUser()->email;

        foreach ($property as $key) {

        	if($property_code == ''){

        		$data['property'][$x][$key->meta_name] = $key->meta_value;
        		$data['property'][$x]['property-code'] = $key->property_code;
        		$property_code = $key->property_code;

        	} else if($property_code == $key->property_code){
        		$data['property'][$x][$key->meta_name] = $key->meta_value;
        		$property_code = $key->property_code;
        	}else {
        		$x++;
        		$data['property'][$x][$key->meta_name] = $key->meta_value;	
        	}
        	
        }

        $data['transactions'] = array();
        $total = 0;

        foreach ($transactions as $transaction ) {
            $business_name = UserMeta::where('user_id', $transaction->tradesman_id)->where('meta_name', 'business-name')->get();
            $data['transactions'][$z]['name'] = $business_name[0]['meta_value'];
            $data['transactions'][$z]['id'] = $transaction->id;
            $data['transactions'][$z]['tid'] = $transaction->tradesman_id;
            $data['transactions'][$z]['amount_spent'] = $transaction->amount_spent;
            $data['transactions'][$z]['receipt'] = $transaction->receipt;
            $total = $total + (int)$transaction->amount_spent;
            $z++;
        }

        $data['reviews'] = array();
        $average = 0;

        foreach ($reviews as $review ) {
            $data['reviews'][$i]['id'] = $review->reviewee_id;
            $data['reviews'][$i]['rate'] = (int)round(($review->communication + $review->work_quality + $review->price + $review->punctuality + $review->attitude) / 5);
            $i++;
        }

        $data['suburbs'] = $suburbs;
        $data['spending']['total'] = $total;
        
        //dd($data);

        return View::make('dashboard/customer/profile')->with('data', $data);
    }

    function spending(Request $request){
    	
        if($request->input('trades') != null && $request->input('amount-spent') != null ){
            $user_id = Sentinel::getUser()->id;
            $tradesman =  UserMeta::where('user_id', $request->input('trades'))->where('meta_name', 'business-name')->get();

            if ($request->hasFile('receipt') ) {
                
                $file = $request->file('receipt');
                $localpath = 'user/user-'.$user_id.'/uploads';
                $filename = 'img'.rand().'-'.Carbon::now()->format('YmdHis').'.'.$file->getClientOriginalExtension();
                $path = $file->move(public_path($localpath), $filename);
                $url = $localpath.'/'.$filename;
                $id = DB::table('transactions')->insertGetId(
                        ['user_id' => $user_id, 'tradesman_id' => $request->input('trades'), 'amount_spent' => $request->input('amount-spent'), 'receipt' => $url, 'created_at' => Carbon::now()]
                    );
                $data = array('tradesman' => $tradesman[0]['meta_value'], 'amount' => $request->input('amount-spent'), 'receipt' => $url, 'id' => $id, 'tid' => $request->input('trades'));

            } else {
                $id = DB::table('transactions')->insertGetId(
                        ['user_id' => $user_id, 'tradesman_id' => $request->input('trades'), 'amount_spent' => $request->input('amount-spent'), 'created_at' => Carbon::now()]
                    );
      
                $data = array('tradesman' => $tradesman[0]['meta_value'], 'amount' => $request->input('amount-spent'), 'id' => $id, 'tid' => $request->input('trades'));
            }


            $transactions = Transactions::where('user_id', Sentinel::getUser()->id)->get();
            $total = 0;
            foreach ($transactions as $transaction ) {
                $total = $total + (int)$transaction->amount_spent;
            }

            $data['total'] = $total;


            return Response::json($data, 200); 

        } else {
            return Response::json('Select a tradesman & add amount spent', 422); 
        }
        
    }

    function uploadReceipt(Request $request){


            if ($request->hasFile('receipt') ) {
                $user_id = Sentinel::getUser()->id;
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

    function updateAmount(Request $request){

        DB::table('transactions')->where('id', $request->input('id'))->update(['amount_spent' => $request->input('content')]);
        
        $transactions = Transactions::where('user_id', Sentinel::getUser()->id)->get();
        $total = 0;
        foreach ($transactions as $transaction ) {
            $total = $total + (int)$transaction->amount_spent;
        }

        $data['total'] = $total;

        return Response::json($data, 200); 

    }   

    function delete(Request $request){

        $tradesman_id = DB::table('transactions')->where('id', '=', $request->input('id'))->get();
        $tid = $tradesman_id[0]->tradesman_id;
        DB::table('transactions')->where('id', '=', $request->input('id'))->delete();
        DB::table('reviews')->where('reviewee_id', '=', $tid)->delete();

        $transactions = Transactions::where('user_id', Sentinel::getUser()->id)->get();
        $total = 0;
        foreach ($transactions as $transaction ) {
            $total = $total + (int)$transaction->amount_spent;
        }

        $data['total'] = $total;

        return Response::json($data, 200); 

    }  
}
