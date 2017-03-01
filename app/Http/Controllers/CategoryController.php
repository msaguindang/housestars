<?php

namespace App\Http\Controllers;

use App\Category;
use App\Property;
use App\User;
use App\UserMeta;
use Illuminate\Http\Request;
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
        $categories = Category::all();

        $response = [
            'categories' => $categories
        ];

        return Response::json($response, 200);
    }
}
