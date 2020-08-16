<?php

namespace App\GraphQL\Queries;
use App\Order;
use App\Product;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
      
      $dateS = Carbon::now()->startOfMonth()->subMonth(5);
      $dateE = Carbon::now()->startOfMonth()->addMonths(1);

      return $order = Order::select(DB::raw('SUM(total) as total'), DB::raw("DATE_FORMAT(order_date, '%Y') year"),DB::raw('MONTH(order_date) months'),  DB::raw('MONTHNAME(order_date) month'))
      ->whereBetween('order_date', [$dateS, $dateE])
      ->groupby('month', 'year', 'months')
      ->orderBy('year', 'DESC')
      ->orderBy('months', 'DESC')
      ->limit(5)
      ->get()
      ->reverse()
      ->all();
    }

    public function lostForFiveMonths($_, array $args)
    {
      $dateS = Carbon::now()->startOfMonth()->subMonth(5);
      $dateE = Carbon::now()->startOfMonth()->addMonths(1);
  
      return $order = Product::select(DB::raw('SUM(buy_price) as total'), DB::raw("DATE_FORMAT(created_at, '%Y') year"),DB::raw('MONTH(created_at) months'),  DB::raw('MONTHNAME(created_at) month'))
      ->whereBetween('created_at', [$dateS, $dateE])
      ->groupby('month', 'year', 'months')
      ->orderBy('year', 'DESC')
      ->orderBy('months', 'DESC')
      ->limit(5)
      ->get()
      ->reverse()
      ->all();
    }

    public function saleForFour($_, array $args)
    {
      return DB::table("orders")
              ->join("order_details", "orders.id", "=", "order_details.order_id")
              ->join("products", "order_details.product_id", "=", "products.id")
              ->join("categories", "products.category_id", "=", "categories.id")
              ->select("categories.name as name", DB::raw('SUM(orders.total) as total'))
              ->groupBy("name")
              ->limit(4)
              ->get();
    }
}
