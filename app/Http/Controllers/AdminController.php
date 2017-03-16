<?php

namespace App\Http\Controllers;

use App\Property;
use App\User;
use App\UserMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Sentinel;
use Response;
use Excel;

class AdminController extends Controller
{
    protected $appUrl;
    protected $payload;

    public function __construct(Request $request)
    {
        $this->appUrl = env('APP_URL').'/';
        $this->payload = $request;
    }

    public function test()
    {


    }

    public function showLogin()
    {
        if (Sentinel::check()) {
            return redirect($this->appUrl.'admin');
        }

        return view('admin.login');
    }

    public function postLogin()
    {

        $request = $this->payload;

        $validation = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        try{
            if( Sentinel::authenticate($request->all()))
            {

                $role = Sentinel::getUser()->roles()->first()->slug;

                if($role == "admin" || $role == "staff"){
                    return \Ajax::redirect(env('APP_URL').'/admin');
                }else{
                    
                    Sentinel::removeCheckpoint('throttle');
                    Sentinel::logout();

                    $validation->getMessageBag()->add('login_error', "Please login as an admin or staff role");
                    // redirect back with inputs and validator instance
                    return redirect(env('APP_URL').'/admin/login')->withErrors($validation)->withInput();
                }



            }else{

                $validation->getMessageBag()->add('login_error', "Sorry, our system doesn't recognize your credentials");
                // redirect back with inputs and validator instance
                return redirect(env('APP_URL').'/admin/login')->withErrors($validation)->withInput();


            }


        }catch(ThrottlingException $e){

            $validation->getMessageBag()->add('login_error', 'You are denied access for suspicious activity! Login again after '.$e->getDelay().' seconds');
            // redirect back with inputs and validator instance
            return redirect(env('APP_URL').'/admin/login')->withErrors($validation)->withInput();

        }



    }

    public function logout()
    {
        Sentinel::removeCheckpoint('throttle');
        Sentinel::logout();

        return redirect($this->appUrl.'admin');
    }

    private function getAngularDirectiveAlert() {
        return '<uib-alert on-ready-state style="display: none;" ng-repeat="alert in $alerts" type="{{alert.type}}" close="closeAlert($index)">{{alert.msg}}</uib-alert>';
    }

    public function showDashboard()
    {
        if (!Sentinel::check()) {
            return redirect($this->appUrl.'admin/login');
        }

        $alertHtml = $this->getAngularDirectiveAlert();

        return view('layouts.admin', compact(
            'alertHtml'
        ));
    }

    public function showMembers()
    {
        if (!Sentinel::check()) {
            return redirect($this->appUrl.'admin');
        }

        return view('admin.members');
    }

    public function showProperties()
    {
        if (!Sentinel::check()) {
            return redirect($this->appUrl.'admin');
        }

        $properties = [];

        $propertyCodes = Property::where('user_id', '!=', null)
            ->groupBy('property_code')
            ->pluck('property_code')
            ->toArray();

        //dump($propertyCodes);

        foreach($propertyCodes as $propertyCode){

            $propertyMetas = Property::where('property_code', $propertyCode)
                ->join('users','users.id','=','property_meta.user_id')
                ->get()
                ->toArray();

            $singleRow = [];

            //dump($propertyMetas);

            foreach($propertyMetas as $propertyMeta){

                $vendorName = $propertyMeta['name'];
                $singleRow[$propertyMeta['meta_name']] = $propertyMeta['meta_value'];

            }

            $singleRow['vendor-name'] = $vendorName;
            $singleRow['property-code'] = $propertyCode;
            $singleRow['agent-name'] = '';
            $agentUserMeta = null;

            if(isset($singleRow['agent'])){
                $agentUserMeta = UserMeta::where('user_id', $singleRow['agent'])
                    ->where('meta_name', 'agency-name')
                    ->first();
            }

            if($agentUserMeta){
                $singleRow['agent-name'] = $agentUserMeta->meta_value;
            }

            $properties[] = $singleRow;

        }

        return view('admin.properties', compact(
            'properties'
        ));
    }

    public function showReviews()
    {
        if (!Sentinel::check()) {
            return redirect($this->appUrl.'admin');
        }

        return view('admin.reviews');
    }

    public function showAdvertisements()
    {
        if (!Sentinel::check()) {
            return redirect($this->appUrl.'admin');
        }

        return view('admin.advertisements');
    }

    public function toggleStatus()
    {
        $payload = $this->payload->all();

        $newStatus = 1;

        $column = 'id';

        if(isset($payload['column'])){
            $column = $payload['column'];
        }

        $table = $payload['table'];
        $value = $payload['value'];
        $status = $payload['status'];

        if($status){
            $newStatus = 0;
        }

        $tableInstance = DB::table($table)
            ->where($column,$value)
            ->update([
            'status' => $newStatus
        ]);

        return Response::json([
            'status' => $newStatus
        ], 200);


    }
}
