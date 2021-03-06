<?php

namespace App\Http\Controllers;

use App\Property;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use View;
use Sentinel;
use App\UserMeta;
use Hash;
use Response;
use Carbon\Carbon;

class PropertyController extends Controller
{
    protected $payload;

    public function __construct(Request $request)
    {
        $this->payload = $request;
    }

    public function getAllProperties(Request $request)
    {
        $payload = $this->payload->all();
        $pageNo = 1;
        $limit = 10;
        $field = $request->get('sort', '');
        $direction = $request->get('direction', 'asc');
        $query = $request->get('query', '');
        $hasSearch = (!empty($query));
        $searchName = $request->get('name', '');
        $searchType = $request->get('type', '');
        $searchRooms = $request->get('rooms', '');
        $searchSuburb = $request->get('suburb', '');
        $searchValue = $request->get('value', '');
        $searchAgent = $request->get('agent', '');
        $fromDate = $request->get('from', '');
        $toDate = $request->get('to', '');
        $searchDateQuery = '';

        if (isset($payload['page_no'])) {
            $pageNo = $payload['page_no'];
        }

        if (isset($payload['limit'])) {
            $limit = $payload['limit'];
        }

        $offset = $limit*($pageNo-1);

        $properties = [];

        $lengthSql = "SELECT COUNT(*) AS length FROM (SELECT count(*) FROM property_meta GROUP BY property_code) AS property_query";
        $length = DB::select($lengthSql)[0]->length;
        $paginationQuery = "LIMIT {$limit} OFFSET {$offset}";
        
        if (!empty($field) || !empty($query)) {
            $paginationQuery = '';
        }
        
        if(!empty($fromDate) && !empty($toDate)) {
            $fromDate = Carbon::createFromFormat('Y-m-d H:i:s', $fromDate .' 00:00:00')->toDateTimeString();
            $toDate = Carbon::createFromFormat('Y-m-d H:i:s', $toDate .' 00:00:00')->toDateTimeString();
            $searchDateQuery = " AND (property_meta.created_at BETWEEN '{$fromDate}' AND '{$toDate}') ";
        }

        $propertyCodesSql = "SELECT property_code FROM property_meta WHERE user_id IS NOT NULL {$searchDateQuery} GROUP BY property_code {$paginationQuery}";
        $propertyCodes = json_decode(json_encode(DB::select($propertyCodesSql)), TRUE);

        foreach ($propertyCodes as $propertyCode) {

            $propertyMetas = Property::where('property_code', $propertyCode)
                ->selectRaw('users.name, property_meta.*')
                ->join('users', 'users.id', '=', 'property_meta.user_id')
                ->get()
                ->toArray();

            $singleRow = [];

            foreach ($propertyMetas as $propertyMeta) {
                $vendorName = $propertyMeta['name'];
                $singleRow[$propertyMeta['meta_name']] = $propertyMeta['meta_value'];
                $created_at = $propertyMeta['created_at'];
            }

            $singleRow['vendor-name'] = $vendorName;
            $singleRow['vendor-user-id'] = $propertyMeta['user_id'];
            $singleRow['property-code'] = $propertyMeta['property_code'];
            $singleRow['agent-name'] = '';
            $singleRow['created_at'] = $created_at;
            $agentUserMeta = null;

            if (isset($singleRow['agent'])) {
                $agentUserMeta = UserMeta::where('user_id', $singleRow['agent'])
                    ->where('meta_name', 'agency-name')
                    ->first();
            }

            if ($agentUserMeta) {
                $singleRow['agent-name'] = $agentUserMeta->meta_value;
            }

            $properties[] = $singleRow;
        }

        $properties = collect($properties)
                        ->filter(function ($value, $key) use ($query, $searchName, $searchType, $searchRooms, $searchSuburb, $searchValue, $searchAgent) {
                            $valids = [];
                            array_push($valids, empty($query) ? : (strpos(strtolower(implode(' ', $value)), strtolower($query)) !== false));
                            array_push($valids, array_contains($searchName, $value, 'vendor-name'));
                            array_push($valids, array_contains($searchType, $value, 'property-type'));
                            array_push($valids, array_contains($searchRooms, $value, 'number-rooms'));
                            array_push($valids, array_contains($searchSuburb, $value, 'suburb') || array_contains($searchSuburb, $value, 'state') || array_contains($searchSuburb, $value, 'post-code'));
                            array_push($valids, array_contains($searchValue, $value, 'value-to'));
                            array_push($valids, array_contains($searchAgent, $value, 'agent-name'));
                            return !in_array(false, $valids);
                        })
                        ->values()->all();

        if (!empty($field)) {
            $properties = collect($properties)->sortBy($field, SORT_REGULAR, ($direction=='desc'));
            $properties = $properties->values()->all();
        }

        if (empty($paginationQuery)) {
            $properties = collect($properties)->forPage($pageNo, $limit)->toArray();
        }

        $response = [
            'properties' => $properties,
            'length'     => (empty($paginationQuery) ? count($properties) : $length)
        ];

        return Response::json($response, 200);
    }

    public function getProperty()
    {
        //if(Sentinel::check()){

        $code = $this->payload->input('property-code');

        $propertyMeta = Property::where('property_code', $code);

        $neededMetas = $propertyMeta->whereIn('meta_name', [
            'property-type',
            'number-rooms',
            'post-code',
            'suburb',
            'state',
            'leased',
            'value-from',
            'value-to',
            'more-details',
            'agent'
        ])
            ->get()
            ->toArray();

        $propertyProperties = [];

        foreach ($neededMetas as $meta) {
            $propertyProperties[$meta['meta_name']] = [
                'id' => $meta['id'],
                'value' => $meta['meta_value']
            ];
        }

        $userId = $propertyMeta->first()->user_id;

        $response = [
            'code' => $code,
            'user_id' => $userId,
            'metas' => $propertyProperties
        ];

        return Response::json($response, 200);

        /*} else {
            $error['message'] = array('You are not authorized.');
            return Response::json($error, 422);
        }*/
    }

    public function deleteProperty()
    {
        $code = $this->payload->input('property-code');

        try{
            Property::where('property_code', $code)->delete();
            $response['success'] = [
                'message' => "Property successfully deleted."
            ];
            return Response::json($response, 200);
        }catch(Exception $e){
            $response['error'] = [
                'message' => $e->getMessage()
            ];
            return Response::json($response, 404);
        }


    }

    public function updateProperty()
    {
        $code = $this->payload->input('code');
        $userId = $this->payload->input('user_id');
        $metas = $this->payload->input('metas');

        $propertyMetas = Property::where('property_code', $code);

        $propertyMetas->update([
            'user_id' => $userId
        ]);

        foreach ($metas as $meta){
            $singleMeta = Property::find($meta['id']);
            $singleMeta->update([
                'meta_value' => $meta['value']
            ]);
        }

        return Response::json([
            'message' => "Property successfully updated.",
            'user_id' => $userId,
            'metas' => $metas
        ], 200);
    }

    public function updatePropertyProcessStatus()
    {
        $property = $this->payload->all();

        $userId = $property['vendor-user-id'];
        $processStatus = $property['process'];
        $propertyCode = $property['property-code'];

        switch($processStatus){
            case 'Pending':
                $newProcessStatus = 'Completed';
                Property::where('user_id', $userId)
                    ->where('meta_name', 'process')
                    ->where('property_code', $propertyCode)
                    ->update([
                        'meta_value' => $newProcessStatus
                    ]);
                break;
        }

        $response = [
            'process' => $newProcessStatus
        ];

        return Response::json($response, 200);

    }

}
