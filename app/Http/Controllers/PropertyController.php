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

    public function getAllProperties()
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

        $properties = [];

        $lengthSql = "SELECT COUNT(*) AS length FROM (SELECT count(*) FROM property_meta GROUP BY property_code) AS property_query";
        $length = DB::select($lengthSql)[0]->length;

        $propertyCodesSql = "SELECT property_code FROM property_meta WHERE user_id IS NOT NULL GROUP BY property_code LIMIT {$limit} OFFSET {$offset}";
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
            $singleRow['property-code'] = $propertyCode;
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

        $response = [
            'properties' => $properties,
            'length' => $length
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

}
