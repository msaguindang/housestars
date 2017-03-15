<?php

namespace App\Http\Controllers;

use App\Agents;
use App\Property;
use App\Reviews;
use App\Role;
use App\RoleUsers;
use App\Transactions;
use App\User;
use App\UserMeta;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Stripe\Customer;
use Stripe\Stripe;
use Stripe\Subscription;
use View;
use Sentinel;
use Hash;
use Response;
use Validator;

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

        $userSql = "SELECT users.*, roles.name as role_name, roles.id as role
            FROM users 
            INNER JOIN role_users ON role_users.user_id = users.id 
            INNER JOIN roles ON roles.id = role_users.role_id
            WHERE users.name IS NOT NULL
            AND roles.slug != 'admin'
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

            $user = User::find($id);

            UserMeta::where('user_id', $id)->delete();
            Transactions::where('user_id', $id)->delete();
            DB::table('role_users')->where('user_id', $id)->delete();
            Reviews::where('reviewee_id', $id)->delete();
            Reviews::where('reviewer_id', $id)->delete();
            DB::table('reminders')->where('user_id', $id)->delete();
            Property::where('user_id', $id)->delete();
            DB::table('persistences')->where('user_id', $id)->delete();
            Agents::where('agent_id', $id)->delete();
            Agents::where('agency_id', $id)->delete();
            DB::table('activations')->where('user_id', $id)->delete();


            $user->delete();
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
        $noOfMonths = $user['months'];

        $newFormattedEndSubscription = "";

        try{
            Stripe::setApiKey($this->stripeKey);
            $customer = Customer::retrieve($customerId);

            if($customer){
                $subscriptions = $customer->subscriptions->data;
                if(count($subscriptions)>0){

                    $subscriptionId = $subscriptions[0]->id;
                    $endSubscription = $subscriptions[0]->current_period_end;

                    if($noOfMonths<0){
                        $newFormattedEndSubscription = Carbon::createFromTimestamp($endSubscription)->subMonths(abs($noOfMonths));
                    }else{
                        $newFormattedEndSubscription = Carbon::createFromTimestamp($endSubscription)->addMonths($noOfMonths);
                    }


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

    public function getAllRoles()
    {
        $payload = $this->payload->all();

        $currentRole = Sentinel::getUser()->roles()->first()->slug;

        switch($currentRole){
            case 'admin':
                $roles = Role::whereNotIn('slug', ['admin','agent'])->get()->toArray();
                break;
            case 'staff':
                $roles = Role::whereNotIn('slug', ['admin','agent','staff'])->get()->toArray();
                break;
            default:
                $roles = Role::whereNotIn('slug', ['admin','agent','staff'])->get()->toArray();
                break;
        }

        $response = [
            'roles' => $roles,
            'current_role' => $currentRole
        ];

        return Response::json($response, 200);
    }

    public function createUser()
    {
        $payload = $this->payload->all();

        $validator = Validator::make($payload, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'role' => 'required'
        ]);

        if ($validator->fails()) {
            return Response::json([
                'validator' => $validator->errors(),
            ], 400);
        }

        $credentials = [
            'email' => $payload['email'],
            'password' => $payload['password']
        ];

        Sentinel::registerAndActivate($credentials);

        $user = User::where('email', $payload['email'])->first();
        $user->update(['name' => $payload['name']]);

        RoleUsers::firstOrCreate([
            'user_id' => $user->id,
            'role_id' => $payload['role']
        ]);

        Mail::send(['html' => 'emails.new-member'], [
            'name' => explode(' ', $payload['name'])[0],
            'password' => $payload['password'],
            'email' => $payload['email']
        ], function ($message) use ($payload) {
            $message->from('info@housestars.com.au', 'Housestars');
            $message->to($payload['email']);
            $message->subject('Welcome to Housestars');
        });

        return Response::json([
            'user' => $user
        ], 200);
    }

    public function updateUser()
    {
        $payload = $this->payload->all();

        $user = User::find($payload['id']);

        $validator = Validator::make($payload, [
            'name' => 'required',
            'email' => [
                'required',
                Rule::unique('users')->ignore($user->email, 'email'),
            ],
            'role' => 'required'
        ]);

        if ($validator->fails()) {
            return Response::json([
                'validator' => $validator->errors(),
            ], 400);
        }

        $user->update([
            'name' => $payload['name'],
            'email' => $payload['email']
        ]);

        $roleUser = RoleUsers::where('user_id', $user->id)->first();
        $roleUser->role_id = $payload['role'];
        $roleUser->save();

        return Response::json([
            'user' => $user
        ], 200);
    }

}
