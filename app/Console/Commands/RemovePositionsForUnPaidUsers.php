<?php

namespace App\Console\Commands;

use App\UserMeta;
use Illuminate\Console\Command;
use Carbon\Carbon;
use DB;

class RemovePositionsForUnPaidUsers extends Command
{
    const AGENT_ROLE = 5;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'housestars:unpaid-users-remove-positions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to remove positions for unpaid users';

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
        $users = DB::table('users')
                    ->join('role_users', 'role_users.user_id', '=', 'users.id')
                    ->where('role_users.role_id', self::AGENT_ROLE)
                    ->get();

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        foreach ($users as $user) {
            if (is_null($user->customer_id) || empty($user->customer_id)) {
                $this->removePositionMeta($user->id);
                echo "*";
            } else {
                $customer_info = \Stripe\Customer::retrieve($user->customer_id);
                if(count($customer_info->subscriptions->data) == 0) {
                    $this->removePositionMeta($user->id);
                    echo "*";
                }
            }
        }
        echo "\n DONE! \n";
    }

    private function removePositionMeta($userId = null)
    {
        UserMeta::where('user_id', $userId)
            ->where('meta_name', 'positions')
            ->where('created_at', '<=', Carbon::yesterday())
            ->delete();
    }
}
