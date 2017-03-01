<?php

namespace App\Http\Controllers;

use App\Category;
use App\Property;
use App\Suburbs;
use App\User;
use App\UserMeta;
use Illuminate\Http\Request;
use Sentinel;
use Response;

class SuburbController extends Controller
{
    protected $payload;

    public function __construct(Request $request)
    {
        $this->payload = $request;
    }

    public function getAllSuburbs()
    {

        $pageNo = 5;

        $limit = 5;
        $offset = 5;

        $suburbs = Suburbs::all();

        $response = [
            'suburbs' => $suburbs
        ];

        return Response::json($response, 200);
    }
}
