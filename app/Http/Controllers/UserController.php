<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Stripe\Customer;
use Stripe\Stripe;
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
        $users = User::where('users.name', '!=', null)
            ->join('role_users', 'role_users.user_id', '=','users.id')
            ->join('roles','roles.id','=','role_users.role_id')
            ->select('users.*','roles.name as role_name')
            ->get()
            ->toArray();

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
            'users' => $members
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

}
