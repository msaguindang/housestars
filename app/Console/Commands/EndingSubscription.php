<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\UserMeta;
use App\User;
use Mail;
use Carbon\Carbon;
use Stripe\Customer;
use Stripe\Stripe;
use Stripe\Subscription;

class EndingSubscription extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'housestars:check-subscriptions';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Check Ending Subscriptions';


  /**
   * Stripe Key
   *
   * @var string
   */
  private $stripeKey = 'sk_test_qaq6Jp8wUtydPSmIeyJpFKI1';

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
    Stripe::setApiKey($this->stripeKey);

    $users = User::select('users.*')
                  ->join('role_users', 'role_users.user_id', '=', 'users.id')
                  ->join('roles', 'roles.id', '=', 'role_users.role_id')
                  ->where(function ($sub) {
                      $sub
                        ->whereNotNull('users.name')
                        ->whereNotNull('users.customer_id')
                        ->where('users.name', '<>', '')
                        ->where('users.customer_id', '<>', '');
                  })->get();

    $nextMonth = Carbon::now()->addMonth()->format('Y-m-d');
    foreach($users as $user) {
      $customer = Customer::retrieve($user->customer_id);
      $subscriptions = $customer->subscriptions->data;
      if (count($subscriptions)) {
        $endDate = Carbon::createFromTimestamp($subscriptions[0]->current_period_end)->format('Y-m-d');
        if ($nextMonth < $endDate) {
          $formattedEndDate = Carbon::createFromTimestamp($subscriptions[0]->current_period_end)->format('F j, Y');
          $this->sendEmail($user->name, $user->email, $formattedEndDate);
          echo "*";
        }
      }
    }
  }

  private function sendEmail($name, $email, $endDate)
  {
    Mail::send(['html' => 'emails.ending-subscription-in-one-month'], [
      'email' => $email,
      'name'  => $name,
      'date'  => $endDate
    ], function ($message) use ($email, $name) {
      $message->from('info@housestars.com.au', 'Housestars');
      $message->to($email, $name);
      $message->bcc('info@housestars.com.au', 'Housestars');
      $message->subject('Subscription Notice');
    });
  }
}
