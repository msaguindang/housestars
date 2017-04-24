<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PotentialCustomer;
use App\UserMeta;
use Carbon\Carbon;
use App\User;
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
      $validator = $this->validate($request, [
          'name' => 'required',
          'suburb' => 'required',
          'email' => 'required',
          'property-type' => 'required',
          'phone' => 'required',
          'estimated-price' => 'required',
      ]);

        $customer = PotentialCustomer::firstOrCreate([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone
        ]);

        $this->sendEmail($request, 'admin', null);

        $price = explode(" - ", $request->input('estimated-price'));
        $estimate = (int)preg_replace('/\D+/', '', $price[1]) * 0.025 * 0.2;
        $this->sendEmail($request, 'client', $estimate);
        return Response::json('success', 200);


    }

    private function sendEmail($request, $to, $estimate)
    {
      $email = $request->input('email');
      $name = $request->input('name');

      switch ($to) {
        case 'admin':
          Mail::send(['html' => 'emails.savings-calculator'], [
                  'name' => $request->input('name'),
                  'phone' => $request->input('phone'),
                  'email' => $request->input('email'),
                  'suburb' => $request->input('suburb'),
                  'type' => $request->input('property-type'),
                  'price' => $request->input('estimated-price')
              ], function ($message) use ($name) {
                  $message->from('info@housestars.com.au', 'Housestars');
                  $message->to('info@housestars.com.au', 'Savings Estimation Calculator');
                  $message->subject('Savings Estimation Calculator: '. $name);
              });
          break;

        default:
        Mail::send(['html' => 'emails.savings-calculator-client'], [
                'name' => $request->input('name'),
                'email' => $request->input('phone'),
                'phone' => $request->input('email'),
                'suburb' => $request->input('suburb'),
                'type' => $request->input('property-type'),
                'price' => $request->input('estimated-price'),
                'estimate' => $estimate
            ], function ($message) use ($name, $email) {
                $message->from('info@housestars.com.au', 'Housestars');
                $message->to($email, $name);
                $message->subject('Savings Estimation Calculator.');
            });
          break;
      }


    }

    public function getAllPotentialCustomers()
    {
        $payload = $this->payload->all();
        $searchQuery = $this->payload->get('query', '');
        $field = $this->payload->get('sort', '');
        $direction = $this->payload->get('direction', '');
        $searchId = $this->payload->get('id', '');
        $searchName = $this->payload->get('name', '');
        $searchEmail = $this->payload->get('email', '');
        $searchPhone = $this->payload->get('phone', '');
        $fromDate = $this->payload->get('from', '');
        $toDate = $this->payload->get('to', '');
        $sortQuery = $searchDateQuery = '';
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

        if (!empty($field)) {
            $sortQuery = " ORDER BY {$field} {$direction}";
        }
        
        $query = "WHERE (id LIKE '%$searchId%' AND name LIKE '%$searchName%' AND email LIKE '%$searchEmail%' AND phone LIKE '%$searchPhone%') ";

        if (!empty($searchQuery)) {
            $query .= " OR (id LIKE '%$searchQuery%' OR name LIKE '%$searchQuery%' OR email LIKE '%$searchQuery%') ";
        }
        
        if(!empty($fromDate) && !empty($toDate)) {
            $fromDate = Carbon::createFromFormat('Y-m-d H:i:s', $fromDate .' 00:00:00')->toDateTimeString();
            $toDate = Carbon::createFromFormat('Y-m-d H:i:s', $toDate .' 00:00:00')->toDateTimeString();
            $searchDateQuery = " AND (created_at BETWEEN '{$fromDate}' AND '{$toDate}') ";
        }

        $sql = "SELECT 
                    * FROM 
        			potential_customers 
                    {$query} 
                    {$searchDateQuery} 
                    {$sortQuery} 
        			LIMIT {$limit} 
        			OFFSET {$offset}";
        
        $potential_customers = json_decode(json_encode(DB::select($sql)), TRUE);

        $response = [
            'potential_customers' => $potential_customers,
            'length'              => (!empty($searchQuery) || !empty($searchDateQuery) ? count($potential_customers) : $length)
        ];
        
        return Response::json($response, 200);
    }

    public function deletePotentialCustomer()
    {
        $id = $this->payload->input('id');
        $isPotentialUser = $this->payload->get('isPotentialUser', true);

        try {
            if (!filter_var($isPotentialUser, FILTER_VALIDATE_BOOLEAN) === false) {
                PotentialCustomer::find($id)->delete();
            } else {
                User::find($id)->delete();
            }
            
            $response['success'] = [
                'message' => "User successfully deleted."
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
            $excel->sheet('Users', function(\PHPExcel_Worksheet $sheet) {

                $users = User::whereNotNull('users.id')
                                ->leftJoin('user_meta', function($join) {
                                    $join
                                        ->on('users.id', '=', 'user_meta.user_id')
                                        ->where('meta_name', '=', 'phone');
                                })
                                ->select('users.name', 'users.email', 'user_meta.meta_value as phone')
                                ->get()->toArray();
                $potentialCustomers = PotentialCustomer::whereNotNull('id')->select('name','email','phone')->get()->toArray();
                $sheet->fromArray(array_merge($users, $potentialCustomers));

            });
        })->store('xlsx', public_path('exports'));

        $response = [
            'excel' => $excel
        ];

        return Response::json($response, 200);
    }
}
