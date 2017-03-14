<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PotentialCustomer;

class PotentialCustomerController extends Controller
{
    public function store (Request $request) 
    {
        $customer = new PotentialCustomer;
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer_inquiry = array(
            'inquiry_info' => array(
                'suburb' => $request->suburb,
                'property_type' => $request->property_type,
                'esimated_price' => $reques->estimated_price
            )
        );

        $customer->save();

    }
}
