<?php

namespace App\Http\Controllers;

use App\Property;
use App\UserMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Sentinel;
use Response;

class AdminController extends Controller
{
    protected $appUrl;
    protected $payload;

    public function __construct(Request $request)
    {
        $this->appUrl = env('APP_URL').'/';
        $this->payload = $request;
    }

    public function showLogin()
    {
        if (Sentinel::check()) {
            return redirect($this->appUrl.'admin');
        }

        return view('admin.login');
    }

    public function logout()
    {
        Sentinel::removeCheckpoint('throttle');
        Sentinel::logout();

        return redirect($this->appUrl.'admin');
    }

    public function showDashboard()
    {
        if (!Sentinel::check()) {
            return redirect($this->appUrl.'admin/login');
        }

        return view('layouts.admin');
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
