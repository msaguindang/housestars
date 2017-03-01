<?php

namespace App\Http\Controllers;

use App\Category;
use App\Property;
use App\User;
use App\UserMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Sentinel;
use Response;

class CategoryController extends Controller
{
    protected $payload;

    public function __construct(Request $request)
    {
        $this->payload = $request;
    }

    public function getAllCategories()
    {

        $pageNo = $this->payload->input('page_no');

        if(!$pageNo){
            $pageNo = 1;
        }

        $limit = $this->payload->input('limit');

        if(!$limit){
            $limit = 10;
        }

        $offset = $limit*($pageNo-1);

        $length = DB::table('categories')->selectRaw('count(*) as length')->first()->length;

        $suburbsSql = "SELECT * FROM categories LIMIT {$limit} OFFSET {$offset}";
        $categories = json_decode(json_encode(DB::select($suburbsSql)),TRUE);

        $response = [
            'categories' => $categories,
            'length' => $length
        ];

        return Response::json($response, 200);
    }


}
