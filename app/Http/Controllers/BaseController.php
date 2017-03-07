<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;    
use Illuminate\Http\Request;
use DB;

class BaseController extends Controller
{
    public function __construct() {
        $businesses = DB::table('user_meta')
					->select('user_id', 'meta_name', 'meta_value')
					->where('meta_name', '=', 'agency-name')
					->orWhere('meta_name', '=', 'trade')
					->get(); 
        View::share('home', $businesses);
    }
}   
