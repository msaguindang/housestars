<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Sentinel;
use Activation;
use App\PotentialCustomer;
use Session;
use App\Services\PotentialCustomerService;

class ActivationController extends Controller
{
    public function activate($email, $code, $account)
    {
        
    $user = User::whereEmail($email)->first();

        $sentinelUser = Sentinel::findById($user->id);
        Sentinel::login($sentinelUser);

        if (Activation::complete($sentinelUser, $code)) {

             switch ($account) {
                case 'agency':
                    return redirect(env('APP_URL').'/register/agency/step-one');
                break;
                case 'tradesman':
                    // sends email
                    return redirect(env('APP_URL').'/register/tradesman/step-one');
                break;
                case 'customer':
                    return redirect(env('APP_URL').'/register/customer/step-one');
                break;
            }
        } else {
            return redirect(env('APP_URL'));
        }
    }

    public function verifiedPotentialCustomer($email)
    {
        if ($customer = PotentialCustomer::whereEmail($email)->first()) {
            app(PotentialCustomerService::class)->save([
                'status' => 1
            ], $customer);
            session()->forget('email');
            session()->put('email', $email);
            return redirect('/choose-business');
        }
        return redirect(env('APP_URL'));
    }
}
