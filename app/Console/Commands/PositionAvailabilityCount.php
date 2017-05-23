<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\UserMeta;
use App\User;
use App\Role;
use App\RoleUsers;
use App\Suburbs;
use Stripe\Subscription;
use Mail;
use Carbon\Carbon;

class PositionAvailabilityCount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:position-availability-count';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update availability';

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
			DB::table('suburbs')->update(array('availability' => 0));

    		$suburbs = UserMeta::where('meta_name', 'positions')->get();
	    	$positions = [];
	    	
	    	foreach($suburbs as $suburb){
		    	if(!is_null(RoleUsers::hasRole($suburb->user_id, 2)->first())) {
	              $subs = explode(",", $suburb->meta_value);
	              foreach($subs as $sub){
		              array_push($positions, $sub);
	              }
	            }
	    	}
	    	//dd($suburbCount);
	    	$availabilityCount = array_count_values($positions);
	    	
	    	foreach($availabilityCount as $suburb => $count){
		    	$postcode = preg_replace('/\D/', '', $suburb);
		    	$suburb_name = preg_replace('/\d/', '', $suburb);
		    	
		    	if($count > 3){
			    	$count = 3;
		    	}
		    	Suburbs::where('id', $postcode)->where('name', $suburb_name)->update(['availability' => $count]);
	    	}
	    	
    }
}
