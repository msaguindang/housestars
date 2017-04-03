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
        
        $propertyCodesSql = "SELECT property_code FROM property_meta WHERE user_id IS NOT NULL GROUP BY property_code {$paginationQuery}";
        $propertyCodes = json_decode(json_encode(DB::select($propertyCodesSql)), TRUE);

        foreach ($propertyCodes as $propertyCode) {

            $propertyMetas = Property::where('property_code', $propertyCode)
                ->join('users', 'users.id', '=', 'property_meta.user_id')
                ->get()
                ->toArray();

            $singleRow = [];

            foreach ($propertyMetas as $propertyMeta) {

                $vendorName = $propertyMeta['name'];
                $singleRow[$propertyMeta['meta_name']] = $propertyMeta['meta_value'];

            }

            $singleRow['vendor-name'] = $vendorName;
            $singleRow['vendor-user-id'] = $propertyMeta['user_id'];
            $singleRow['property-code'] = $propertyMeta['property_code'];
            $singleRow['agent-name'] = '';
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

        if (!empty($query)) {
            $properties = collect($properties)
                                ->filter(function ($value, $key) use ($query) {
                                    $query = strtolower($query);
                                    $val = strtolower(implode(' ', $value));
                                    return (strpos($val, $query) !== false);
                                })
                                ->values()->all();
        }

        if (!empty($field)) {
            $properties = collect($properties)->sortBy($field, SORT_REGULAR, ($direction=='desc'));
            $properties = $properties->values()->all();
        }

        if (empty($paginationQuery)) {
            $properties = collect($properties)->forPage($pageNo, $limit)->toArray();
        }

        $response = [
            'properties' => $properties,
            'length' => $length,
            'query'  => $query
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
