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
        $searchQuery = $this->payload->get('query', '');
        $searchTradesmanId = "'%" . $this->payload->get('tradesman_id', '') . "%'";
        $searchTradesman   = $this->payload->get('tradesman', '');
        $searchTrade       = $this->payload->get('trade', '');
        $hasSearchByField  = (!is_query_empty($searchTradesman) || !is_query_empty($searchTrade));

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
                AND maint.`tradesman_id` LIKE $searchTradesmanId
                GROUP BY tradesman_id ";

        $reportJson = DB::select($sql);

        if (!empty($searchQuery) || $hasSearchByField) {
          $report = collect($reportJson)->filter(function($value, $key) use ($searchQuery, $searchTradesman, $searchTrade) {
            $valids = [];
            $value = (array) $value;
            array_push($valids, empty($searchQuery) ? : (strpos(strtolower(implode(' ', $value)), strtolower($searchQuery)) !== false));
            array_push($valids, array_contains($searchTradesman, $value, 'tradesman'));
            array_push($valids, array_contains($searchTrade, $value, 'trade'));
            return !in_array(false, $valids);
          })->values()->all();
        } else {
          $report = json_decode(json_encode($reportJson), TRUE);
        }

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
        $reportDate = $this->payload->get('reportDate', 'all');
        $fromDate = $this->payload->get('from', '');
        $toDate = $this->payload->get('to', '');
        $transactionsCount = 0;
        $subDate = '';

        if($reportDate != 'all') {
            $subDate = Carbon::now()->{$reportDate}()->toDateString();
            $transactionsCount = Transactions::where(DB::raw("DATE_FORMAT(transactions.created_at, '%Y-%m-%d')"), '<', $subDate)->count();
        } else if(!empty($fromDate) && !empty($toDate)) {
            $fromDate = Carbon::createFromFormat('Y-m-d H:i:s', $fromDate .' 00:00:00')->toDateTimeString();
            $toDate = Carbon::createFromFormat('Y-m-d H:i:s', $toDate .' 00:00:00')->toDateTimeString();
            $transactionsCount = Transactions::whereBetween('transactions.created_at', [$fromDate, $toDate])->count();
        }else {
            $transactionsCount = Transactions::count();
        }

        return Response::json([
            'total'  => $transactionsCount,
            'subDate'=> $reportDate
        ], 200);
    }

    public function getAverageAgentCommission()
    {

      $reportDate = $this->payload->get('reportDate', 'all');
      $fromDate = $this->payload->get('from', '');
      $toDate = $this->payload->get('to', '');
      $searchDateQuery = '';

      if($reportDate != 'all') {
        $subDate = Carbon::now()->{$reportDate}()->toDateString();
        $searchDateQuery = " AND DATE_FORMAT(user_meta.created_at, '%Y-%m-%d') < '{$subDate}' ";
      } else if(!empty($fromDate) && !empty($toDate)) {
          $fromDate = Carbon::createFromFormat('Y-m-d H:i:s', $fromDate .' 00:00:00')->toDateTimeString();
          $toDate = Carbon::createFromFormat('Y-m-d H:i:s', $toDate .' 00:00:00')->toDateTimeString();
          $searchDateQuery = " AND (user_meta.created_at BETWEEN '{$fromDate}' AND '{$toDate}') ";
      }

      $sql = "SELECT 
                TRUNCATE(AVG(user_meta.meta_value),2) AS average_agent_commission
              FROM
                user_meta 
                INNER JOIN users ON users.id = user_meta.user_id
                INNER JOIN role_users ON role_users.`user_id` = user_meta.user_id
                INNER JOIN roles ON role_users.`role_id` = roles.`id`
              WHERE meta_name = 'base-commission'
              {$searchDateQuery}
              AND meta_value REGEXP '^[0-9]+$'";

        $avgAgentCommissionObject = DB::select($sql);

        $avgAgentCommssion = $avgAgentCommissionObject[0]->average_agent_commission;

        return Response::json([
            'average' => (is_null($avgAgentCommssion) ? 0 : $avgAgentCommssion)
        ], 200);
    }
}
