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
use Carbon\Carbon;

class CategoryController extends Controller
{
    protected $payload;

    public function __construct(Request $request)
    {
        $this->payload = $request;
    }

    public function getAllCategories(Request $request)
    {

        $pageNo = $this->payload->input('page_no');
        $searchQuery = $request->get('query', '');
        $field = $request->get('sort', '');
        $searchId = $request->get('id', '');
        $searchCat = $request->get('category', '');
        $direction = $request->get('direction', 'asc');
        $sortQuery = '';

        if (!$pageNo) {
            $pageNo = 1;
        }

        $limit = $this->payload->input('limit');

        if (!$limit) {
            $limit = 10;
        }

        $offset = $limit*($pageNo-1);

        $length = DB::table('categories')->selectRaw('count(*) as length')->first()->length;

        if (!empty($field)) {
            $sortQuery = " ORDER BY {$field} {$direction}";
        }

        $query = " WHERE (id LIKE '%$searchId%' AND category LIKE '%$searchCat%') "; 

        if(!empty($searchQuery)) {
            $query .= " OR (id LIKE '%$searchQuery%' OR category LIKE '%$searchQuery%') ";
        }

        $lastWeek = Carbon::now()->subWeek()->toDateString();
        $suburbsSql = "SELECT categories.*,
                        (SELECT 
                            COUNT(um.id)
                            FROM
                                user_meta um
                            WHERE 
                                um.meta_name = 'trade'
                            AND um.meta_value = categories.`category`) AS total_enlisted,
                        (SELECT 
                            COUNT(um1.id)
                            FROM
                                user_meta um1
                            WHERE 
                                um1.meta_name = 'trade' AND 
                                um1.meta_value = categories.`category` AND 
                                um1.created_at >= '{$lastWeek}') AS last_week_enlisted
                        FROM categories {$query} {$sortQuery} LIMIT {$limit} OFFSET {$offset}";
        $categories = json_decode(json_encode(DB::select($suburbsSql)), TRUE);

        $response = [
            'categories' => $categories,
            'length'     => (empty($query) ? $length : count($categories))
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
