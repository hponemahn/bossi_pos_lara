<?php

namespace App\GraphQL\Queries;
use App\Order;
use App\Product;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ChartQuery
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function getCapital($_, array $args)
    {
      
      // $time = strtotime($args['endDate']);
      // $dateE = date("Y-m-d", strtotime("+1 month", $time));
      $res;
      
      if($args['startDate'] != "0" && $args['endDate'] != "0" && $args['filter'] == "m"){
        
        $res = Product::select(DB::raw('SUM(buy_price) as total'), DB::raw("DATE_FORMAT(created_at, '%Y') year"), DB::raw("DATE_FORMAT(created_at, '%m') month"), DB::raw('MONTH(created_at) months'))
        ->whereBetween('created_at', [$args['startDate'], $args['endDate']])
        ->groupby('month', 'year', 'months')
        ->orderBy('year', 'DESC')
        ->orderBy('months', 'DESC')
        // ->limit(5)
        ->get()
        // ->reverse()
        ->all();   

      } elseif ($args['startDate'] != "0" && $args['endDate'] != "0" && $args['filter'] == "y") {

        $res = Product::select(DB::raw('SUM(buy_price) as total'), DB::raw("DATE_FORMAT(created_at, '%Y') year"))
        ->whereBetween('created_at', [$args['startDate'], $args['endDate']])
        ->groupby('year')
        ->orderBy('year', 'DESC')
        ->get()
        ->all(); 
        
      } elseif ($args['startDate'] != "0" && $args['endDate'] != "0" && $args['filter'] == "d") {

        $res = Product::select(DB::raw('SUM(buy_price) as total'), DB::raw("DATE_FORMAT(created_at, '%d') day"), DB::raw("DATE_FORMAT(created_at, '%Y') year"), DB::raw("DATE_FORMAT(created_at, '%m') month"), DB::raw('MONTH(created_at) months'))
        ->whereBetween('created_at', [$args['startDate'], $args['endDate']])
        ->groupby('day', 'month', 'year', 'months')
        ->orderBy('year', 'DESC')
        ->orderBy('months', 'DESC')
        ->orderBy('day', 'DESC')
        ->get()
        ->all();  
        
      } elseif ($args['filter'] == "y") {
        $res = Product::select(DB::raw('SUM(buy_price) as total'), DB::raw("DATE_FORMAT(created_at, '%Y') year"))
        ->groupby('year')
        ->orderBy('year', 'DESC')
        ->get()
        ->all();  
      } elseif ($args['filter'] == "d") {
        $res = Product::select(DB::raw('SUM(buy_price) as total'), DB::raw("DATE_FORMAT(created_at, '%d') day"), DB::raw("DATE_FORMAT(created_at, '%Y') year"), DB::raw("DATE_FORMAT(created_at, '%m') month"), DB::raw('MONTH(created_at) months'))
        ->groupby('day', 'month', 'year', 'months')
        ->orderBy('year', 'DESC')
        ->orderBy('months', 'DESC')
        ->orderBy('day', 'DESC')
        ->get()
        ->all();  
      } else {
        $res = Product::select(DB::raw('SUM(buy_price) as total'), DB::raw("DATE_FORMAT(created_at, '%Y') year"), DB::raw("DATE_FORMAT(created_at, '%m') month"), DB::raw('MONTH(created_at) months'))
        // ->whereBetween('created_at', [$dateS, $dateE])
        ->groupby('month', 'year', 'months')
        ->orderBy('year', 'DESC')
        ->orderBy('months', 'DESC')
        // ->limit(5)
        ->get()
        // ->reverse()
        ->all();   
      }

      return $res;
    }

    public function getSale($_, array $args)
    {
      $res;
      
      if($args['startDate'] != "0" && $args['endDate'] != "0" && $args['filter'] == "m"){

        $res = Order::select(DB::raw('SUM(total) as total'), DB::raw("DATE_FORMAT(order_date, '%Y') year"), DB::raw("DATE_FORMAT(order_date, '%m') month"), DB::raw('MONTH(order_date) months'))
        ->whereBetween('order_date', [$args['startDate'], $args['endDate']])
        ->groupby('month', 'year', 'months')
        ->orderBy('year', 'DESC')
        ->orderBy('months', 'DESC')
        // ->limit(5)
        ->get()
        // ->reverse()
        ->all();  

      } elseif ($args['startDate'] != "0" && $args['endDate'] != "0" && $args['filter'] == "y") {

        $res = Order::select(DB::raw('SUM(total) as total'), DB::raw("DATE_FORMAT(order_date, '%Y') year"))
        ->whereBetween('order_date', [$args['startDate'], $args['endDate']])
        ->groupby('year')
        ->orderBy('year', 'DESC')
        ->get()
        ->all();  
        
      } elseif ($args['startDate'] != "0" && $args['endDate'] != "0" && $args['filter'] == "d") {

        $res = Order::select(DB::raw('SUM(total) as total'), DB::raw("DATE_FORMAT(order_date, '%d') day"), DB::raw("DATE_FORMAT(order_date, '%Y') year"), DB::raw("DATE_FORMAT(order_date, '%m') month"), DB::raw('MONTH(order_date) months'))
        ->whereBetween('order_date', [$args['startDate'], $args['endDate']])
        ->groupby('day', 'month', 'year', 'months')
        ->orderBy('year', 'DESC')
        ->orderBy('months', 'DESC')
        ->orderBy('day', 'DESC')
        ->get()
        ->all();  
        
      } elseif ($args['filter'] == "y") {
        $res = Order::select(DB::raw('SUM(total) as total'), DB::raw("DATE_FORMAT(order_date, '%Y') year"))
        ->groupby('year')
        ->orderBy('year', 'DESC')
        ->get()
        ->all();  
      } elseif ($args['filter'] == "d") {
        $res = Order::select(DB::raw('SUM(total) as total'), DB::raw("DATE_FORMAT(order_date, '%d') day"), DB::raw("DATE_FORMAT(order_date, '%Y') year"), DB::raw("DATE_FORMAT(order_date, '%m') month"), DB::raw('MONTH(order_date) months'))
        ->groupby('day', 'month', 'year', 'months')
        ->orderBy('year', 'DESC')
        ->orderBy('months', 'DESC')
        ->orderBy('day', 'DESC')
        ->get()
        ->all();  
      } else {
        $res = Order::select(DB::raw('SUM(total) as total'), DB::raw("DATE_FORMAT(order_date, '%Y') year"), DB::raw("DATE_FORMAT(order_date, '%m') month"), DB::raw('MONTH(order_date) months'))
        // ->whereBetween('order_date', [$dateS, $dateE])
        ->groupby('month', 'year', 'months')
        ->orderBy('year', 'DESC')
        ->orderBy('months', 'DESC')
        // ->limit(5)
        ->get()
        // ->reverse()
        ->all();   
      }

      return $res;
    }

    public function getProfit($_, array $args)
    {
      
      $res;
      
      if($args['startDate'] != "0" && $args['endDate'] != "0" && $args['filter'] == "m"){
        
        $res = DB::table('orders')
        ->join("order_details", "orders.id", "=", "order_details.order_id")
        ->join("products", "order_details.product_id", "=", "products.id")
        ->select(DB::raw('SUM((order_details.qty * order_details.price) - (order_details.qty * products.buy_price)) as total'), DB::raw("DATE_FORMAT(orders.order_date, '%Y') year"), DB::raw("DATE_FORMAT(orders.order_date, '%m') month"), DB::raw('MONTH(orders.order_date) months'))
        ->whereBetween('orders.order_date', [$args['startDate'], $args['endDate']])
        ->groupby('month', 'year', 'months')
        ->orderBy('year', 'DESC')
        ->orderBy('months', 'DESC')
        // ->limit(5)
        ->get()
        // ->reverse()
        ->all();  

      } elseif ($args['startDate'] != "0" && $args['endDate'] != "0" && $args['filter'] == "y") {
        
        $res = DB::table('orders')
        ->join("order_details", "orders.id", "=", "order_details.order_id")
        ->join("products", "order_details.product_id", "=", "products.id")
        ->select(DB::raw('SUM((order_details.qty * order_details.price) - (order_details.qty * products.buy_price)) as total'), DB::raw("DATE_FORMAT(orders.order_date, '%Y') year"))
        ->whereBetween('orders.order_date', [$args['startDate'], $args['endDate']])
        ->groupby('year')
        ->orderBy('year', 'DESC')
        // ->limit(5)
        ->get()
        // ->reverse()
        ->all();  
      } elseif ($args['startDate'] != "0" && $args['endDate'] != "0" && $args['filter'] == "d") {

        $res = DB::table('orders')
        ->join("order_details", "orders.id", "=", "order_details.order_id")
        ->join("products", "order_details.product_id", "=", "products.id")
        ->select(DB::raw('SUM((order_details.qty * order_details.price) - (order_details.qty * products.buy_price)) as total'), DB::raw("DATE_FORMAT(order_date, '%d') day"), DB::raw("DATE_FORMAT(orders.order_date, '%Y') year"), DB::raw("DATE_FORMAT(orders.order_date, '%m') month"), DB::raw('MONTH(orders.order_date) months'))
        ->whereBetween('orders.order_date', [$args['startDate'], $args['endDate']])
        ->groupby('day', 'month', 'year', 'months')
        ->orderBy('year', 'DESC')
        ->orderBy('months', 'DESC')
        ->orderBy('day', 'DESC')
        // ->limit(5)
        ->get()
        // ->reverse()
        ->all();  
        
      } elseif ($args['filter'] == "y") {

        $res = DB::table('orders')
        ->join("order_details", "orders.id", "=", "order_details.order_id")
        ->join("products", "order_details.product_id", "=", "products.id")
        ->select(DB::raw('SUM((order_details.qty * order_details.price) - (order_details.qty * products.buy_price)) as total'), DB::raw("DATE_FORMAT(orders.order_date, '%Y') year"))
        // DB::raw('SUM((buy_price - discount_price) - sell_price) as total')
        // ->whereBetween('order_date', [$dateS, $dateE])
        ->groupby('year')
        ->orderBy('year', 'DESC')
        // ->limit(5)
        ->get()
        // ->reverse()
        ->all();  

      } elseif ($args['filter'] == "d") {

        $res = DB::table('orders')
        ->join("order_details", "orders.id", "=", "order_details.order_id")
        ->join("products", "order_details.product_id", "=", "products.id")
        ->select(DB::raw('SUM((order_details.qty * order_details.price) - (order_details.qty * products.buy_price)) as total'), DB::raw("DATE_FORMAT(order_date, '%d') day"), DB::raw("DATE_FORMAT(orders.order_date, '%Y') year"), DB::raw("DATE_FORMAT(orders.order_date, '%m') month"), DB::raw('MONTH(orders.order_date) months'))
        // DB::raw('SUM((buy_price - discount_price) - sell_price) as total')
        // ->whereBetween('order_date', [$dateS, $dateE])
        ->groupby('day', 'month', 'year', 'months')
        ->orderBy('year', 'DESC')
        ->orderBy('months', 'DESC')
        ->orderBy('day', 'DESC')
        // ->limit(5)
        ->get()
        // ->reverse()
        ->all();  

      } else {
        $res = DB::table('orders')
        ->join("order_details", "orders.id", "=", "order_details.order_id")
        ->join("products", "order_details.product_id", "=", "products.id")
        ->select(DB::raw('SUM((order_details.qty * order_details.price) - (order_details.qty * products.buy_price)) as total'), DB::raw("DATE_FORMAT(orders.order_date, '%Y') year"), DB::raw("DATE_FORMAT(orders.order_date, '%m') month"), DB::raw('MONTH(orders.order_date) months'))
        // DB::raw('SUM((buy_price - discount_price) - sell_price) as total')
        // ->whereBetween('order_date', [$dateS, $dateE])
        ->groupby('month', 'year', 'months')
        ->orderBy('year', 'DESC')
        ->orderBy('months', 'DESC')
        // ->limit(5)
        ->get()
        // ->reverse()
        ->all();   
      }

      return $res;
    }

    public function getItemProfit($_, array $args)
    {

      $res;
      
      if($args['startDate'] != "0" && $args['endDate'] != "0" && $args['filter'] == "m"){
        
        $res = DB::table('orders')
        ->join("order_details", "orders.id", "=", "order_details.order_id")
        ->join("products", "order_details.product_id", "=", "products.id")
        ->select('products.name as name', DB::raw('SUM(order_details.qty) as qty'), DB::raw('SUM((order_details.qty * order_details.price) - (order_details.qty * products.buy_price)) as total'), DB::raw("DATE_FORMAT(orders.order_date, '%Y') year"), DB::raw("DATE_FORMAT(orders.order_date, '%m') month"), DB::raw('MONTH(orders.order_date) months'))
        ->whereBetween('orders.order_date', [$args['startDate'], $args['endDate']])
        ->groupby('name', 'month', 'year', 'months')
        ->orderBy('year', 'DESC')
        ->orderBy('months', 'DESC')
        // ->limit(5)
        ->get()
        // ->reverse()
        ->all();  

      } elseif ($args['startDate'] != "0" && $args['endDate'] != "0" && $args['filter'] == "y") {
        
        $res = DB::table('orders')
        ->join("order_details", "orders.id", "=", "order_details.order_id")
        ->join("products", "order_details.product_id", "=", "products.id")
        ->select('products.name as name', DB::raw('SUM(order_details.qty) as qty'), DB::raw('SUM((order_details.qty * order_details.price) - (order_details.qty * products.buy_price)) as total'), DB::raw("DATE_FORMAT(orders.order_date, '%Y') year"))
        ->whereBetween('orders.order_date', [$args['startDate'], $args['endDate']])
        ->groupby('name', 'year')
        ->orderBy('year', 'DESC')
        // ->limit(5)
        ->get()
        // ->reverse()
        ->all();  
      } elseif ($args['startDate'] != "0" && $args['endDate'] != "0" && $args['filter'] == "d") {

        $res = DB::table('orders')
        ->join("order_details", "orders.id", "=", "order_details.order_id")
        ->join("products", "order_details.product_id", "=", "products.id")
        ->select('products.name as name', DB::raw('SUM(order_details.qty) as qty'), DB::raw('SUM((order_details.qty * order_details.price) - (order_details.qty * products.buy_price)) as total'), DB::raw("DATE_FORMAT(order_date, '%d') day"), DB::raw("DATE_FORMAT(orders.order_date, '%Y') year"), DB::raw("DATE_FORMAT(orders.order_date, '%m') month"), DB::raw('MONTH(orders.order_date) months'))
        ->whereBetween('orders.order_date', [$args['startDate'], $args['endDate']])
        ->groupby('name', 'day', 'month', 'year', 'months')
        ->orderBy('year', 'DESC')
        ->orderBy('months', 'DESC')
        ->orderBy('day', 'DESC')
        // ->limit(5)
        ->get()
        // ->reverse()
        ->all();  
        
      } elseif ($args['filter'] == "y") {

        $res = DB::table('orders')
        ->join("order_details", "orders.id", "=", "order_details.order_id")
        ->join("products", "order_details.product_id", "=", "products.id")
        ->select('products.name as name', DB::raw('SUM(order_details.qty) as qty'), DB::raw('SUM((order_details.qty * order_details.price) - (order_details.qty * products.buy_price)) as total'), DB::raw("DATE_FORMAT(orders.order_date, '%Y') year"))
        // DB::raw('SUM((buy_price - discount_price) - sell_price) as total')
        // ->whereBetween('order_date', [$dateS, $dateE])
        ->groupby('name', 'year')
        ->orderBy('year', 'DESC')
        // ->limit(5)
        ->get()
        // ->reverse()
        ->all();  

      } elseif ($args['filter'] == "d") {

        $res = DB::table('orders')
        ->join("order_details", "orders.id", "=", "order_details.order_id")
        ->join("products", "order_details.product_id", "=", "products.id")
        ->select('products.name as name', DB::raw('SUM(order_details.qty) as qty'), DB::raw('SUM((order_details.qty * order_details.price) - (order_details.qty * products.buy_price)) as total'), DB::raw("DATE_FORMAT(order_date, '%d') day"), DB::raw("DATE_FORMAT(orders.order_date, '%Y') year"), DB::raw("DATE_FORMAT(orders.order_date, '%m') month"), DB::raw('MONTH(orders.order_date) months'))
        // DB::raw('SUM((buy_price - discount_price) - sell_price) as total')
        // ->whereBetween('order_date', [$dateS, $dateE])
        ->groupby('name', 'day', 'month', 'year', 'months')
        ->orderBy('year', 'DESC')
        ->orderBy('months', 'DESC')
        ->orderBy('day', 'DESC')
        // ->limit(5)
        ->get()
        // ->reverse()
        ->all();  

      } else {
        $res = DB::table('orders')
              ->join("order_details", "orders.id", "=", "order_details.order_id")
              ->join("products", "order_details.product_id", "=", "products.id")
              ->select('products.name as name', DB::raw('SUM(order_details.qty) as qty'), DB::raw('SUM((order_details.qty * order_details.price) - (order_details.qty * products.buy_price)) as total'), DB::raw("DATE_FORMAT(orders.order_date, '%Y') year"), DB::raw("DATE_FORMAT(orders.order_date, '%m') month"), DB::raw('MONTH(orders.order_date) months'))
              // DB::raw('SUM((buy_price - discount_price) - sell_price) as total')
              // ->whereBetween('order_date', [$dateS, $dateE])
              ->groupby('name', 'month', 'year', 'months')
              // ->groupby('')
              ->orderBy('year', 'DESC')
              ->orderBy('months', 'DESC')
              // ->limit(5)
              ->get()
              // ->reverse()
              ->all();  
      }

      return $res; 
    }

    public function orderForSevenDays($_, array $args)
    {
        return DB::table('orders')
        ->select(DB::raw("
        DATE_FORMAT(order_date,'%W-%d') as order_date"), DB::raw("SUM(total) as total"))
        ->whereDate('order_date', '>', date('Y-m-d',strtotime("-7 days")))->orderBy(DB::raw("
      DATE_FORMAT(order_date,'%d')"), 'asc')
        ->groupby(DB::raw("
        DATE_FORMAT(order_date,'%W-%d')"))
        ->get();
    }

    public function netForFiveMonths($_, array $args)
    {
      
      $dateS = Carbon::now()->startOfMonth()->subMonth(5);
      $dateE = Carbon::now()->startOfMonth()->addMonths(1);

      return $order = Order::select(DB::raw('SUM(total) as total'), DB::raw("DATE_FORMAT(order_date, '%Y') year"),DB::raw('MONTH(order_date) months'),  DB::raw("DATE_FORMAT(order_date, '%m') month"))
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
  
      return $order = Product::select(DB::raw('SUM(buy_price) as total'), DB::raw("DATE_FORMAT(created_at, '%Y') year"),DB::raw('MONTH(created_at) months'),  DB::raw("DATE_FORMAT(created_at, '%m') month"))
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
      $res = DB::table("orders")
              ->join("order_details", "orders.id", "=", "order_details.order_id")
              ->join("products", "order_details.product_id", "=", "products.id")
              ->join("categories", "products.category_id", "=", "categories.id")
              ->select("categories.name as name", DB::raw('SUM(orders.total) as total'))
              ->groupBy("name")
              ->orderby("orders.order_date", "asc")
              ->limit(4)
              ->get();

      $object = new \stdClass();
      $object->all = $res->sum('total');
      $res[] = $object;
  
      return $res;        
    }

    public function buyForFour($_, array $args)
    {
      $res = DB::table("products")
      ->join("categories", "products.category_id", "=", "categories.id")
      ->select("categories.name as name", DB::raw('SUM(products.buy_price) as total'))
      ->groupBy("name")
      ->orderby("products.created_at", "desc")
      ->limit(4)
      ->get();

      $object = new \stdClass();
      $object->all = $res->sum('total');
      $res[] = $object;

      return $res;   
    }

    public function stockForFour($_, array $args)
    {
      $res = DB::table("products")
      ->join("categories", "products.category_id", "=", "categories.id")
      ->select("categories.name as name", DB::raw('SUM(products.stock) as total'))
      ->groupBy("name")
      ->limit(4)
      ->orderby("products.created_at", "desc")
      ->get();

      return $res;   
    }
}
