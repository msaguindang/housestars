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
use Excel;
use App\Utilities\UserQueryBuilder;

class UserController extends Controller
{
    protected $payload;
    protected $stripeKey;

    public function __construct(Request $request)
    {
        $this->payload = $request;
        $this->stripeKey = env('STRIPE_SECRET_KEY');
    }

    public function getAllUsers(Request $request)
    {
        $role = Sentinel::getUser()->roles()->first()->slug;
        $userQueryBuilder = app(UserQueryBuilder::class);

        $roleSql = "";
        $searchQuery = "";
        $sortQuery = "";
        $field = $request->get('sort', '');
        $fromDate = $request->get('from', '');
        $toDate = $request->get('to', '');
        $direction = $request->get('direction', 'asc');
        $hasRangeDate = (!empty($fromDate) && !empty($toDate));
        $searchName = $request->get('name', '');
        $searchEmail = $request->get('email', '');
        $searchRole = $request->get('role', '');
        $searchType = $request->get('type', '');
        $searchStart = $request->get('start', '');
        $searchEnd = $request->get('end', '');
        $searchCreatedAt = $request->get('created_at', '');
        $query = $request->get('query', '');
        $searchDateField = $request->get('date_field', '');
        $isSearchCreatedAt = ($searchDateField == 'created_at');
        $hasSearch = (!empty($query) || !empty($searchName) || !empty($searchEmail) || !empty($searchRole) || !empty($searchStart) || !empty($searchEnd));

        switch ($role) {
            case 'admin':
                $roleSql = " AND roles.slug NOT IN('admin','superadmin') ";
                break;
            case 'superadmin':
                $roleSql = " AND roles.slug != 'superadmin' ";
                break;
            default:
                $roleSql = " AND roles.slug NOT IN('admin','superadmin') ";
                break;
        }

        $payload = $this->payload->all();
        $pageNo = 1;
        $limit = 10;

        if (isset($payload['page_no'])) {
            $pageNo = $payload['page_no'];
        }

        if (isset($payload['limit'])) {
            $limit = $payload['limit'];
        }

        if (isset($payload['slug'])) {
            $slugSql = " AND roles.slug = {$payload['slug']} ";
        } else {
            $slugSql = "";
        }

        $offset = $limit*($pageNo-1);

        $length = DB::table('users')
            ->selectRaw('count(*) as length')
            ->where('name', '!=', null)
            ->first()
            ->length;

        $paginateQuery = " LIMIT {$limit} OFFSET {$offset} ";

        $searchQuery = $userQueryBuilder->searchQueryBuilder($query, $searchName, $searchEmail, $searchRole, $searchCreatedAt, $isSearchCreatedAt, $fromDate, $toDate);

        if (!empty($field)) {
            if (in_array($field, ['name', 'email', 'role_name'])) {
                $sortQuery = " ORDER BY {$field} {$direction} ";
            } else {
                $paginateQuery = '';
            }
        }

        $userSql = "SELECT users.*, roles.name as role_name, roles.id as role
            FROM users 
            INNER JOIN role_users ON role_users.user_id = users.id 
            INNER JOIN roles ON roles.id = role_users.role_id
            WHERE users.name IS NOT NULL
            {$searchQuery}            
            {$roleSql}
            {$slugSql}
            {$sortQuery}
            {$paginateQuery}";

        $users = json_decode(json_encode(DB::select($userSql)), TRUE);

        Stripe::setApiKey($this->stripeKey);

        $members = [];

        foreach ($users as $user) {

            $customerId = $user['customer_id'];

            $user['subscription_type'] = 'None';
            $user['sub_start'] = '';
            $user['sub_end'] = '';
            $user['sub_start_raw'] = '';
            $user['sub_end_raw'] = '';

            if ($customerId != null && $customerId != "") {

                $customer = Customer::retrieve($customerId);

                if ($customer) {
                    $subscriptions = $customer->subscriptions->data;
                    if ($hasRangeDate && count($subscriptions) > 0 && !$isSearchCreatedAt) {
                        $subscriptionDate = $subscriptions[0]->{$searchDateField}; 
                        if(($subscriptionDate < strtotime($fromDate) || $subscriptionDate > strtotime($toDate))) {
                            continue;
                        }
                    } if (count($subscriptions) > 0) {
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
        
        if (($hasRangeDate || $hasSearch) && !$isSearchCreatedAt) {
            $members = collect($members)->filter(function ($value, $key) {
                return (!is_null($value['sub_start']) && !empty($value['sub_start']));
            })->values()->all();
        }

        $members = collect($members)->filter(function ($value, $key) use ($searchType, $searchStart, $searchEnd) {
            $valids = [];
            array_push($valids, array_contains($searchType, $value, 'subscription_type'));
            array_push($valids, array_contains($searchStart, $value, 'sub_start'));
            array_push($valids, array_contains($searchEnd, $value, 'sub_end'));
            return !in_array(false, $valids);
        })->values()->all();

        if (!empty($field) && empty($paginateQuery)) {
            $members = collect($members)->sortBy($field, SORT_REGULAR, ($direction=='desc'));
            $members = $members->values()->all();
            $members = collect($members)->forPage($pageNo, $limit)->toArray();
        }

        return Response::json([
            'users'  => $members,
            'length' => (($hasRangeDate || $hasSearch) ? count($members) : $length)
        ], 200);
    }

    public function deleteUser()
    {
        $id = $this->payload->input('id');

        try {

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

            $uploads = public_path() . '/user/user-' . $id . "/uploads/*";
            array_map('unlink', glob($uploads));

            $user->delete();
            $response['success'] = [
                'message' => "User successfully deleted."
            ];
            return Response::json($response, 200);
        } catch(Exception $e) {
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
                $roles = Role::whereNotIn('slug', ['superadmin', 'admin','agent'])->get()->toArray();
                break;
            case 'superadmin':
                $roles = Role::whereNotIn('slug', ['superadmin','agent'])->get()->toArray();
                break;
            case 'staff':
                $roles = Role::whereNotIn('slug', ['superadmin', 'admin','agent','staff'])->get()->toArray();
                break;
            default:
                $roles = Role::whereNotIn('slug', ['superadmin', 'admin','agent','staff'])->get()->toArray();
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

    public function exportUsers()
    {
        $excel = Excel::create('members', function($excel) {
            $excel->sheet('Members', function(\PHPExcel_Worksheet $sheet) {

                $members = User::where('users.id','!=',null)
                    ->join('role_users', 'role_users.user_id','=','users.id')
                    ->join('roles','roles.id','=','role_users.role_id')
                    ->whereNotIn('roles.slug', ['admin','superadmin'])
                    ->select('users.name','users.email','roles.name as role')
                    ->orderBy('roles.name')
                    ->get()
                    ->toArray();


                $sheet->fromArray($members);

            });
        })->store('xlsx', public_path('exports'));

        $response = [
            'excel' => $excel
        ];

        return Response::json($response, 200);
    }

    public function getTotalCountByRole()
    {
        $payload = $this->payload->all();
        $reportDate = $this->payload->get('reportDate', 'all');
        $fromDate = $this->payload->get('from', '');
        $toDate = $this->payload->get('to', '');
        $role = $payload['role'];

        $members = User::where('users.id','!=',null)
            ->join('role_users', 'role_users.user_id','=','users.id')
            ->join('roles','roles.id','=','role_users.role_id')
            ->whereIn('roles.slug', [$role])
            ->select('users.name','users.email','roles.name as role');

        if($reportDate != 'all') {
            $subDate = Carbon::now()->{$reportDate}()->toDateString();
            $members->where(DB::raw("DATE_FORMAT(users.created_at, '%Y-%m-%d')"), '<', $subDate);
        } else if(!empty($fromDate) && !empty($toDate)) {
            $fromDate = Carbon::createFromFormat('Y-m-d H:i:s', $fromDate .' 00:00:00')->toDateTimeString();
            $toDate = Carbon::createFromFormat('Y-m-d H:i:s', $toDate .' 00:00:00')->toDateTimeString();
            $members->whereBetween('users.created_at', [$fromDate, $toDate]);
        }

        return Response::json([
            'count' => $members->count()
        ]);
    }

    public function getUsersMailingList()
    {
        $role = $this->payload->get('filter_type', 'agency');
        $searchQuery = $this->payload->get('query', '');
        $field = $this->payload->get('sort', '');
        $direction = $this->payload->get('direction', '');
        $searchId = $this->payload->get('id', '');
        $searchName = $this->payload->get('name', '');
        $searchEmail = $this->payload->get('email', '');
        $searchPhone = $this->payload->get('phone', '');
        $fromDate = $this->payload->get('from', '');
        $toDate = $this->payload->get('to', '');
        $pageNo = $this->payload->get('page_no', 1);
        $limit = $this->payload->get('limit', 10);
        $offset = $limit * ($pageNo - 1);

        $mailingList = User::whereNotNull('users.id')
            ->leftJoin('user_meta', function($join) {
                $join
                    ->on('users.id', '=', 'user_meta.user_id')
                    ->where('meta_name', '=', 'phone');
            })
            ->join('role_users', 'role_users.user_id','=','users.id')
            ->join('roles','roles.id','=','role_users.role_id')
            ->whereIn('roles.slug', [$role])
            ->select('users.id', 'users.name', 'users.email', 'users.created_at', 'roles.name as role', 'user_meta.meta_value as phone')
            ->where('users.id', 'LIKE', '%'. $searchId.'%')
            ->where('users.name', 'LIKE', '%'. $searchName.'%')
            ->where('users.email', 'LIKE', '%'. $searchEmail.'%')
            ->where('user_meta.meta_value', 'LIKE', '%'. $searchPhone.'%');
        
        if(!empty($fromDate) && !empty($toDate)) {
            $fromDate = Carbon::createFromFormat('Y-m-d H:i:s', $fromDate .' 00:00:00')->toDateTimeString();
            $toDate = Carbon::createFromFormat('Y-m-d H:i:s', $toDate .' 00:00:00')->toDateTimeString();
            
            $mailingList->whereBetween('users.created_at', [$fromDate, $toDate]);
        }

        $mailingListCount = $mailingList->newQuery()->count();

        if (!empty($field)) {
            $mailingList = $mailingList->orderBy("users.$field", $direction);
        }

        $mailingList = $mailingList
                        ->take($limit)
                        ->skip($offset)
                        ->get();

        return Response::json([
            'length' => $mailingListCount,
            'users'  => $mailingList
        ]);
    }

    public function getTotalBilledPayment()
    {
        $fromDate = $this->payload->get('from', '');
        $toDate = $this->payload->get('to', '');
        $users = User::whereNotNull('customer_id')->where('customer_id', '<>', '');
        $hasDateRange = (!empty($fromDate) && !empty($toDate));
        $totalBilled = 0;

        if($hasDateRange) {
            $fromDate = Carbon::createFromFormat('Y-m-d H:i:s', $fromDate .' 00:00:00');
            $toDate = Carbon::createFromFormat('Y-m-d H:i:s', $toDate .' 00:00:00');
        }

        Stripe::setApiKey($this->stripeKey);
        
        foreach($users->get() as $user)
        {
            if ($customer = Customer::retrieve($user->customer_id)) {
                $charges = $customer->charges();
                foreach ($charges->data as $data) {
                    $dateCreated = Carbon::createFromTimestamp($data->created);
                    if( $data->paid && $hasDateRange && ($dateCreated->gte($fromDate) && $dateCreated->lt($toDate)) ) {
                        $totalBilled = $totalBilled + ($data->amount/100);
                    }else if($data->paid && !$hasDateRange) {
                        $totalBilled = $totalBilled + ($data->amount/100);
                    }
                }
            }
        }

        return Response::json([
            'totalBilled' => $totalBilled
        ]);
    }
}
