<?php

namespace App\GraphQL\Queries;
use App\Order;
use DB;

class OrderQuery
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function orderForSevenDays($_, array $args)
    {
        return DB::table('orders')
        ->select("total", DB::raw("
        DATE_FORMAT(order_date,'%W-%d') as order_date")
      )->whereDate('order_date', '>', date('Y-m-d',strtotime("-7 days")))->orderBy(DB::raw("
      DATE_FORMAT(order_date,'%d')"), 'asc')->get();
    }

    public function netForFiveMonths($_, array $args)
    {
      return $order = Order::select(DB::raw('SUM(total) as total'), DB::raw("DATE_FORMAT(order_date, '%Y') year"),DB::raw('MONTH(order_date) months'),  DB::raw('MONTHNAME(order_date) month'))
      ->groupby('month', 'year', 'months')
      ->orderBy('year', 'DESC')
      ->orderBy('months', 'DESC')
      ->limit(5)
      ->get()
      ->reverse()
      ->all();
    }
}
