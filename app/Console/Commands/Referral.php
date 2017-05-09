<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\UserMeta;
use App\User;
use Stripe\Subscription;
use Mail;
use Carbon\Carbon;

class Referral extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:referral';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check trademans referral';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      $meta = UserMeta::where('meta_name', 'promotion-code')->get();
      $referral = array();
      foreach ($meta as $key) {
        array_push($referral, $key->meta_value);
      }
      $codes = array_unique($referral);
      $occurences = array_count_values($referral);
      // check how many referrals should be divisible by 2
      foreach ($codes as $value) {
        $discount = $occurences[$value] / 2;
        if($discount >= 1){
          $tradesman = UserMeta::where('meta_name', 'abn')->where('meta_value', $value)->get();
          if($tradesman[0]['user_id']){
            $customerID = User::where('id', $tradesman[0]['user_id'])->first()->customer_id;
            $email = User::where('id', $tradesman[0]['user_id'])->first()->email;
            $name = User::where('id', $tradesman[0]['user_id'])->first()->name;
            \Stripe\Stripe::setApiKey("sk_test_qaq6Jp8wUtydPSmIeyJpFKI1");
            $customer = \Stripe\Customer::retrieve($customerID);

            if($customer){
                $subscriptions = $customer->subscriptions->data;
                if(count($subscriptions)>0){

                  if($subscriptions[0]->plan->id == 'tradesman-00'){
                    exit;
                  }

                  $subscriptionId = $subscriptions[0]->id;

                  $endSubscription = $subscriptions[0]->current_period_end;

                    $extension =  $discount * 12;

                    $newFormattedEndSubscription = Carbon::createFromTimestamp($endSubscription)->addMonths($extension);
                    $newEndSubscription = $newFormattedEndSubscription->timestamp;

                    $currentSubscription = Subscription::retrieve($subscriptionId);

                    if($currentSubscription){
                        $currentSubscription->trial_end = $newEndSubscription;
                        $currentSubscription->prorate = false;
                        $currentSubscription->save();
                    }


                    Mail::send(['html' => 'emails.extend-subs-admin'], [
                            'email' => $email,
                            'name' => $name,
                            'date' => date_format($newFormattedEndSubscription, 'jS F Y'),
                            'referrals' => $discount * 2
                        ], function ($message) use ($email) {
                            $message->from('info@housestars.com.au', 'Housestars');
                            $message->to($email);
                            $message->subject('Good News! Your referrals paid off.');
                        });

                }
            }

          }
        }
      }

      //check referral code to match a tradesman

      //check if paid yearly

      //if yearly and has more referrals update subscription end + 1 year

      // send notification to admin and tradesman

    }
}
