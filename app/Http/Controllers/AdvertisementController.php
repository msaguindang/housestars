<?php

namespace App\Http\Controllers;

use App\Advertisement;
use App\Reviews;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use View;
use Sentinel;
use App\UserMeta;
use Response;
use Validator;

class AdvertisementController extends Controller
{

    protected $payload;

    public function __construct(Request $request)
    {
        $this->payload = $request;
    }

    public function getAllAdvertisements()
    {

        $payload = $this->payload->all();
        $pageNo = 1;
        $limit = 10;

        if(isset($payload['page_no'])){
            $pageNo = $payload['page_no'];
        }

        if(isset($payload['limit'])){
            $limit = $payload['limit'];
        }

        $offset = $limit*($pageNo-1);

        $length = DB::table('advertisements')
            ->selectRaw('count(*) as length')
            ->first()
            ->length;

        $sql = "SELECT 
				  *
				FROM
				  advertisements 
				LIMIT {$limit}
				OFFSET {$offset}";

        $reviews = json_decode(json_encode(DB::select($sql)),TRUE);

        $response = [
            'advertisements' => $reviews,
            'length' => $length
        ];

        return Response::json($response, 200);
    }

    public function deleteAdvertisement()
    {
        $id = $this->payload->input('id');

        try{

            Advertisement::find($id)->delete();
            $response['success'] = [
                'message' => "Advertisement successfully deleted."
            ];
            return Response::json($response, 200);
        }catch(Exception $e){
            $response['error'] = [
                'message' => $e->getMessage()
            ];
            return Response::json($response, 404);
        }


    }

    public function insertAdvertisement()
    {
        $payload = $this->payload->all();

        $validator = Validator::make($payload, [
            'name' => 'required|unique:advertisements',
            'type' => 'required',
            'adFile' => 'mimes:jpeg,bmp,png,jpg',
            'priority' => 'required'
        ],[
            'adFile.required' => 'Advertisement Image is required.',
            'adFile.mimes' => 'The file must be of type: jpeg,bmp,png,jpg'
        ]);

        if ($validator->fails()) {
            return Response::json([
                'validator' => $validator->errors(),
            ], 400);
        }

        $advertisement = Advertisement::create([
            'name' => $payload['name'],
            'type' => $payload['type'],
            'priority' => $payload['priority']
        ]);

        if($this->payload->hasFile('adFile')){
            $path = $this->payload->adFile->store('public/uploads/advertisements');
            $advertisement->image_path = $path;
            $advertisement->save();
        }

        return Response::json([
            'payload' => $payload,
            'path' => $path
        ], 200);
    }
}
