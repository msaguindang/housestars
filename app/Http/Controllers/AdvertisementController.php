<?php

namespace App\Http\Controllers;

use App\Advertisement;
use App\Reviews;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
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

        $searchQuery = $this->payload->get('query', '');
        $field = $this->payload->get('sort', '');
        $direction = $this->payload->get('direction', '');
        $searchName = $this->payload->get('name', '');
        $searchType = $this->payload->get('type', '');
        $searchPriority = $this->payload->get('priority', '');
        $sortQuery = '';
        $pageNo = 1;
        $limit = 10;

        if (isset($payload['page_no'])) {
            $pageNo = $payload['page_no'];
        }

        if (isset($payload['limit'])) {
            $limit = $payload['limit'];
        }

        $offset = $limit * ($pageNo - 1);

        $length = DB::table('advertisements')
            ->selectRaw('count(*) as length')
            ->first()
            ->length;

        if (!empty($field)) {
            $sortQuery = " ORDER BY {$field} {$direction}";
        }
        
        $query = " WHERE (name LIKE '%$searchName%' AND type LIKE '%$searchType%' AND priority LIKE '%$searchPriority%')";

        if (!empty($searchQuery)) {
            $query .= " OR (name LIKE '%$searchQuery%' OR type LIKE '%$searchQuery%') ";
        }

        $sql = "SELECT
				  *
				FROM
				  advertisements
                {$query}
                {$sortQuery}
				LIMIT {$limit}
				OFFSET {$offset}";

        $ads = json_decode(json_encode(DB::select($sql)), TRUE);

        $response = [
            'advertisements' => $ads,
            'length'         => (empty($query) ? $length : count($ads))
        ];

        return Response::json($response, 200);
    }

    public function deleteAdvertisement()
    {
        $id = $this->payload->input('id');

        try {

            $advertisement = Advertisement::find($id);

            if (file_exists(public_path($advertisement->image_path))) {
                unlink(public_path($advertisement->image_path));
            }

            $advertisement->delete();
            $response['success'] = [
                'message' => "Advertisement successfully deleted."
            ];
            return Response::json($response, 200);
        } catch (Exception $e) {
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
        ], [
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

        if ($this->payload->hasFile('adFile')) {
            $filenameUponDownload = $this->payload->adFile->getClientOriginalName();
            $extension = $this->payload->adFile->getClientOriginalExtension();
            $filename = str_replace('.' . $extension, '', $filenameUponDownload);

            $uploadPath = "uploads/advertisements";
            $filename = $filename . '_' . time() . '.' . $extension;

            $this->payload->adFile->move(public_path($uploadPath), $filename);
            $path = $uploadPath .'/'. $filename;
            $advertisement->image_path = $path;
            $advertisement->save();
        }

        return Response::json([
            'payload' => $payload,
        ], 200);
    }

    public function updateAdvertisement()
    {
        $payload = $this->payload->all();

        $validationRules = [
            'name' => "required|unique:advertisements,name,{$payload['id']}",
            'type' => 'required',
            'priority' => 'required'
        ];

        if ($this->payload->hasFile('adFile')) {
            $validationRules = $validationRules+['adFile' => 'mimes:jpeg,bmp,png,jpg'];
        }


        $validator = Validator::make($payload, $validationRules, [
            'adFile.required' => 'Advertisement Image is required.',
            'adFile.mimes' => 'The file must be of type: jpeg,bmp,png,jpg'
        ]);

        if ($validator->fails()) {
            return Response::json([
                'validator' => $validator->errors(),
            ], 400);
        }

        $advertisement = Advertisement::find($payload['id']);

        $advertisement->update([
            'name' => $payload['name'],
            'type' => $payload['type'],
            'priority' => $payload['priority']
        ]);

        if ($this->payload->hasFile('adFile')) {
            $filenameUponDownload = $this->payload->adFile->getClientOriginalName();
            $extension = $this->payload->adFile->getClientOriginalExtension();
            $filename = str_replace('.' . $extension, '', $filenameUponDownload);

            $uploadPath = "uploads/advertisements";
            $filename = $filename . '_' . time() . '.' . $extension;

            $this->payload->adFile->move(public_path($uploadPath), $filename);
            $path = $uploadPath . $filename;
            $advertisement->image_path = $path;
            $advertisement->save();
        }

        return Response::json([
            'payload' => $payload,
        ], 200);
    }

    public function getAdvertisement()
    {
        $payload = $this->payload->all();
        $advertisementId = $payload['id'];

        $advertisement = Advertisement::find($advertisementId);

        return Response::json([
            'advertisement' => $advertisement,
        ], 200);
    }
}
