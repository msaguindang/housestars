<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;    
use Illuminate\Http\Request;
use DB;

class BaseController extends Controller
{
    public function __construct() {
        $businesses = DB::table('user_meta')
						->select('user_meta.user_id', 'user_meta.meta_name', 'user_meta.meta_value')
						->join('users', 'users.id', '=', 'user_meta.user_id')
						->where('user_meta.meta_name', '=', 'agency-name')
						->orWhere('user_meta.meta_name', '=', 'trade')
						->get();
					
        View::share('home', $businesses);
    }
}   
