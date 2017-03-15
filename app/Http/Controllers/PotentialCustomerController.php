<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PotentialCustomer;
use Response;
use Mail;

class PotentialCustomerController extends Controller
{
    public function store (Request $request) 
    {   
        $customer = PotentialCustomer::firstOrCreate([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone
        ]);

        $this->sendEmail($request);
        return Response::json('success', 200);      
    }

    private function sendEmail($request)
    {
        $email = $request->input('email');
        $name = $request->input('name');
        Mail::send(['html' => 'emails.savings-calculator'], [
                'name' => $request->input('name'),
                'email' => $request->input('phone'),
                'phone' => $request->input('email'),
                'suburb' => $request->input('suburb'),
                'type' => $request->input('property-type'),
                'price' => $request->input('estimated-price')
            ], function ($message) use ($name) {
                $message->from('info@housestars.com.au', 'Housestars');
                $message->to('info@housestars.com.au', 'Savings Estimation Calculator');
                $message->subject('Savings Estimation Calculator: '. $name);
            });
    }
}
