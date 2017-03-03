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

    public function deleteCategory()
    {
        $id = $this->payload->input('id');

        try{

            Category::find($id)->delete();
            $response['success'] = [
                'message' => "Category successfully deleted."
            ];
            return Response::json($response, 200);
        }catch(Exception $e){
            $response['error'] = [
                'message' => $e->getMessage()
            ];
            return Response::json($response, 404);
        }


    }

    public function insertCategory()
    {
        $payload = $this->payload->all();

        $category = Category::create($payload);

        return Response::json([
            'category' => $category
        ], 200);
    }

    public function updateCategory()
    {
        $payload = $this->payload->all();

        $categoryId = $payload['id'];

        $category = Category::find($categoryId);
        $category->category = $payload['category'];
        $category->save();

        return Response::json([
            'category' => $category,
            'payload' => $payload
        ], 200);
    }

}
