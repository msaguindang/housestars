<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PotentialCustomer;
use Illuminate\Support\Facades\DB;
use Response;
use Mail;
use Excel;

class PotentialCustomerController extends Controller
{
    protected $payload;

    public function __construct(Request $request)
    {
        $this->payload = $request;
    }

    public function store (Request $request) 
    {   
        $customer = PotentialCustomer::firstOrCreate([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone
        ]);

        $this->sendEmail($request);
        return Response::json('success', 200);      
    }

    private function sendEmail($request)
    {
        $email = $request->input('email');
        $name = $request->input('name');
        Mail::send(['html' => 'emails.savings-calculator'], [
                'name' => $request->input('name'),
                'email' => $request->input('phone'),
                'phone' => $request->input('email'),
                'suburb' => $request->input('suburb'),
                'type' => $request->input('property-type'),
                'price' => $request->input('estimated-price')
            ], function ($message) use ($name) {
                $message->from('info@housestars.com.au', 'Housestars');
                $message->to('info@housestars.com.au', 'Savings Estimation Calculator');
                $message->subject('Savings Estimation Calculator: '. $name);
            });
    }

    public function getAllPotentialCustomers()
    {
        $payload = $this->payload->all();
        $pageNo = 1;
        $limit = 10;

        if (isset($payload['page_no'])) {
            $pageNo = $payload['page_no'];
        }

        if (isset($payload['limit'])) {
            $limit = $payload['limit'];
        }

        $offset = $limit * ($pageNo - 1);

        $length = DB::table('potential_customers')
            ->selectRaw('count(*) as length')
            ->first()
            ->length;

        $sql = "SELECT
				  *
				FROM
				  potential_customers
				LIMIT {$limit}
				OFFSET {$offset}";


        $potential_customers = json_decode(json_encode(DB::select($sql)), TRUE);

        $response = [
            'potential_customers' => $potential_customers,
            'length' => $length
        ];

        return Response::json($response, 200);
    }

    public function deletePotentialCustomer()
    {
        $id = $this->payload->input('id');

        try {

            PotentialCustomer::find($id)->delete();
            $response['success'] = [
                'message' => "Potential Customer successfully deleted."
            ];
            return Response::json($response, 200);
        } catch (Exception $e) {
            $response['error'] = [
                'message' => $e->getMessage()
            ];
            return Response::json($response, 404);
        }
    }

    public function exportPotentialCustomers()
    {
        $excel = Excel::create('mailing-list', function($excel) {
            $excel->sheet('Potential Customers', function(\PHPExcel_Worksheet $sheet) {

                $potentialCustomers = PotentialCustomer::where('id','!=',null)->select('name','email','phone')->get()->toArray();
                $sheet->fromArray($potentialCustomers);

            });
        })->store('xlsx', public_path('exports'));

        $response = [
            'excel' => $excel
        ];

        return Response::json($response, 200);
    }
}
