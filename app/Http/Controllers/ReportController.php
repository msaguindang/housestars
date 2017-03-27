<?php

namespace App\Http\Controllers;

use App\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use View;
use Sentinel;
use Response;
use Socialite;

class ReportController extends Controller
{

    protected $payload;

    public function __construct(Request $request)
    {
        $this->payload = $request;
    }

    public function getTradesmanEarningsReport()
    {
        $payload = $this->payload->all();

        $year = $payload['year'];

        $sql = "SELECT 
                  maint.tradesman_id,
                  users.`name`,
                  (SELECT 
                    meta_value 
                  FROM
                    user_meta 
                  WHERE meta_name = 'trading-name' 
                    AND user_id = maint.`tradesman_id`) AS tradesman,
                  (SELECT 
                    meta_value 
                  FROM
                    user_meta 
                  WHERE meta_name = 'trade' 
                    AND user_id = maint.`tradesman_id`) AS trade,
                  YEAR(maint.created_at) AS created_at_year,
                  MONTH(maint.created_at) AS created_at_month,
                  SUM(maint.amount_spent) AS yearly_earnings,
                  (SELECT 
                    SUM(amount_spent) 
                  FROM
                    transactions subt 
                  WHERE MONTH(created_at) = MONTH(NOW()) 
                    AND YEAR(created_at) = {$year}
                    AND subt.tradesman_id = maint.`tradesman_id`) AS monthly_earnings,
                  (SELECT 
                    SUM(amount_spent) 
                  FROM
                    transactions subt 
                  WHERE subt.tradesman_id = maint.`tradesman_id`) AS total_earnings 
                FROM
                  transactions maint 
                  JOIN users 
                    ON users.`id` = maint.`tradesman_id` 
                WHERE YEAR(maint.created_at) = {$year}
                GROUP BY tradesman_id ";

        $reportJson = DB::select($sql);

        $report = json_decode(json_encode($reportJson), TRUE);

        return Response::json([
            'report' => $report,
            'year' => $year
        ], 200);


    }

    public function getAllTransactionYears()
    {
        $sql = "SELECT DISTINCT(YEAR(created_at)) as year FROM transactions ORDER BY YEAR(created_at) ASC";

        $yearObject = DB::select($sql);

        $years = json_decode(json_encode($yearObject), TRUE);

        $yearsArray = [];

        foreach($years as $yearItem){
            $yearsArray[] = $yearItem['year'];
        }

        return Response::json([
            'years' => $yearsArray
        ], 200);
    }

    public function getTotalTransactions()
    {

        $payload = $this->payload->all();

        $totalTransactions = Transactions::all()->count();

        return Response::json([
            'total' => $totalTransactions
        ], 200);

    }

    public function getAverageAgentCommission()
    {
        $sql = "SELECT 
                  TRUNCATE(AVG(user_meta.meta_value),2) AS average_agent_commission
                FROM
                  user_meta 
                  INNER JOIN users ON users.id = user_meta.user_id
                  INNER JOIN role_users ON role_users.`user_id` = user_meta.user_id
                  INNER JOIN roles ON role_users.`role_id` = roles.`id`
                WHERE meta_name = 'base-commission' 
                AND meta_value REGEXP '^[0-9]+$'";

        $avgAgentCommissionObject = DB::select($sql);

        $avgAgentCommssion = $avgAgentCommissionObject[0]->average_agent_commission;

        return Response::json([
            'average' => $avgAgentCommssion
        ], 200);
    }
}
