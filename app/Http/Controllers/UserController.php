<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\Customer;
use Stripe\Stripe;
use Stripe\Subscription;
use View;
use Sentinel;
use Hash;
use Response;

class UserController extends Controller
{
    protected $payload;
    protected $stripeKey;

    public function __construct(Request $request)
    {
        $this->payload = $request;
        $this->stripeKey = "sk_test_qaq6Jp8wUtydPSmIeyJpFKI1";
    }

    public function getAllUsers()
    {
        $payload = $this->payload->all();
        $pageNo = 1;
        $limit = 10;

        if(isset($payload['page_no'])){
            $pageNo = $payload['page_no'];
        }

        if(isset($payload['limit'])){
            $limit = $payload['limit'];
        }

        if(isset($payload['slug'])){
            $slugSql = " AND roles.slug = {$payload['slug']} ";
        }else{
            $slugSql = "";
        }

        $offset = $limit*($pageNo-1);

        $length = DB::table('users')
            ->selectRaw('count(*) as length')
            ->where('name','!=',null)
            ->first()
            ->length;

        $userSql = "SELECT users.*, roles.name as role_name 
            FROM users 
            INNER JOIN role_users ON role_users.user_id = users.id 
            INNER JOIN roles ON roles.id = role_users.role_id
            WHERE users.name IS NOT NULL
            {$slugSql}
            LIMIT {$limit} OFFSET {$offset}";

        $users = json_decode(json_encode(DB::select($userSql)),TRUE);

        Stripe::setApiKey($this->stripeKey);

        $members = [];

        foreach($users as $user){

            $customerId = $user['customer_id'];

            $user['subscription_type'] = 'None';
            $user['sub_start'] = '';
            $user['sub_end'] = '';
            $user['sub_start_raw'] = '';
            $user['sub_end_raw'] = '';

            if($customerId != null && $customerId != ""){

                $customer = Customer::retrieve($customerId);

                if($customer){
                    $subscriptions = $customer->subscriptions->data;
                    if(count($subscriptions)>0){
                        $plan = $subscriptions[0]->plan->name;
                        $user['subscription_type'] = $plan;
                        $user['sub_start_raw'] = $subscriptions[0]->current_period_start;
                        $user['sub_end_raw'] = $subscriptions[0]->current_period_end;
                        $user['sub_start'] = Carbon::createFromTimestamp($subscriptions[0]->current_period_start)->format('F d, Y');
                        $user['sub_end'] = Carbon::createFromTimestamp($subscriptions[0]->current_period_end)->format('F d, Y');
                    }
                }


            }

            $members[] = $user;

        }

        return Response::json([
            'users' => $members,
            'length' => $length
        ], 200);
    }

    public function deleteUser()
    {
        $id = $this->payload->input('id');

        try{
            User::find($id)->delete();
            $response['success'] = [
                'message' => "User successfully deleted."
            ];
            return Response::json($response, 200);
        }catch(Exception $e){
            $response['error'] = [
                'message' => $e->getMessage()
            ];
            return Response::json($response, 404);
        }


    }

    public function extendUserSubscription()
    {
        $user = $this->payload->all();

        $customerId = $user['customer_id'];

        $newFormattedEndSubscription = "";

        try{
            Stripe::setApiKey($this->stripeKey);
            $customer = Customer::retrieve($customerId);

            if($customer){
                $subscriptions = $customer->subscriptions->data;
                if(count($subscriptions)>0){

                    $subscriptionId = $subscriptions[0]->id;
                    $endSubscription = $subscriptions[0]->current_period_end;
                    $newFormattedEndSubscription = Carbon::createFromTimestamp($endSubscription)->addMonth();
                    $newEndSubscription = $newFormattedEndSubscription->timestamp;

                    $currentSubscription = Subscription::retrieve($subscriptionId);

                    if($currentSubscription){
                        $currentSubscription->trial_end = $newEndSubscription;
                        $currentSubscription->prorate = false;
                        $currentSubscription->save();
                    }

                }
            }

            $response = [
                'type' => 'success',
                'msg' => "User's subscription successfully extended by 1 month.",
                'new_end_subscription' => $newFormattedEndSubscription->format('F d, Y')
            ];

            return Response::json($response, 200);
        }catch(Exception $e){
            $response['error'] = [
                'message' => $e->getMessage()
            ];
            return Response::json($response, 404);
        }
    }

}
