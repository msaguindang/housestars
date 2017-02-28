<?php

namespace App\Http\Controllers;

use App\Property;
use App\User;
use App\UserMeta;
use Illuminate\Http\Request;
use Sentinel;

class AdminController extends Controller
{
    public function showLogin()
    {
        if (Sentinel::check()) {
            return redirect('admin');
        }

        return view('admin.login');
    }

    public function logout()
    {
        Sentinel::removeCheckpoint('throttle');
        Sentinel::logout();

        return redirect('/admin');
    }

    public function showDashboard()
    {
        if (!Sentinel::check()) {
            return redirect('admin/login');
        }

        return view('layouts.admin');
    }

    public function showMembers()
    {
        if (!Sentinel::check()) {
            return redirect('admin');
        }

        return view('admin.members');
    }

    public function showProperties()
    {
        if (!Sentinel::check()) {
            return redirect('admin');
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
            return redirect('admin');
        }

        return view('admin.reviews');
    }

    public function showAdvertisements()
    {
        if (!Sentinel::check()) {
            return redirect('admin');
        }

        return view('admin.advertisements');
    }
}
