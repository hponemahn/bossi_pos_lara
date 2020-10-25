<?php

namespace App;

use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class Order extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders';
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function getSale($_, array $args)
    {
      $res;
      
      if($args['startDate'] != "0" && $args['endDate'] != "0" && $args['filter'] == "m"){

        $res = DB::table("orders")->select(DB::raw('SUM(total) as total'), DB::raw("DATE_FORMAT(order_date, '%Y') year"), DB::raw("DATE_FORMAT(order_date, '%m') month"), DB::raw('MONTH(order_date) months'))
        ->whereBetween('order_date', [$args['startDate'], $args['endDate']])
        ->groupby('month', 'year', 'months')
        ->orderBy('year', 'DESC')
        ->orderBy('months', 'DESC');
        // ->limit(5)
        // ->reverse()

      } elseif ($args['startDate'] != "0" && $args['endDate'] != "0" && $args['filter'] == "y") {

        $res = DB::table("orders")->select(DB::raw('SUM(total) as total'), DB::raw("DATE_FORMAT(order_date, '%Y') year"))
        ->whereBetween('order_date', [$args['startDate'], $args['endDate']])
        ->groupby('year')
        ->orderBy('year', 'DESC');
        
      } elseif ($args['startDate'] != "0" && $args['endDate'] != "0" && $args['filter'] == "d") {

        $res = DB::table("orders")->select(DB::raw('SUM(total) as total'), DB::raw("DATE_FORMAT(order_date, '%d') day"), DB::raw("DATE_FORMAT(order_date, '%Y') year"), DB::raw("DATE_FORMAT(order_date, '%m') month"), DB::raw('MONTH(order_date) months'))
        ->whereBetween('order_date', [$args['startDate'], $args['endDate']])
        ->groupby('day', 'month', 'year', 'months')
        ->orderBy('year', 'DESC')
        ->orderBy('months', 'DESC')
        ->orderBy('day', 'DESC');
        
      } elseif ($args['filter'] == "y") {
        $res = DB::table("orders")->select(DB::raw('SUM(total) as total'), DB::raw("DATE_FORMAT(order_date, '%Y') year"))
        ->groupby('year')
        ->orderBy('year', 'DESC');
      } elseif ($args['filter'] == "d") {
        $res = DB::table("orders")->select(DB::raw('SUM(total) as total'), DB::raw("DATE_FORMAT(order_date, '%d') day"), DB::raw("DATE_FORMAT(order_date, '%Y') year"), DB::raw("DATE_FORMAT(order_date, '%m') month"), DB::raw('MONTH(order_date) months'))
        ->groupby('day', 'month', 'year', 'months')
        ->orderBy('year', 'DESC')
        ->orderBy('months', 'DESC')
        ->orderBy('day', 'DESC');
      } else {
        $res = DB::table("orders")->select(DB::raw('SUM(total) as total'), DB::raw("DATE_FORMAT(order_date, '%Y') year"), DB::raw("DATE_FORMAT(order_date, '%m') month"), DB::raw('MONTH(order_date) months'))
        // ->whereBetween('order_date', [$dateS, $dateE])
        ->groupby('month', 'year', 'months')
        ->orderBy('year', 'DESC')
        ->orderBy('months', 'DESC');
        // ->limit(5)
        // ->reverse()
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
        ->orderBy('months', 'DESC');
        // ->limit(5)
        
        // ->reverse()
        

      } elseif ($args['startDate'] != "0" && $args['endDate'] != "0" && $args['filter'] == "y") {
        
        $res = DB::table('orders')
        ->join("order_details", "orders.id", "=", "order_details.order_id")
        ->join("products", "order_details.product_id", "=", "products.id")
        ->select(DB::raw('SUM((order_details.qty * order_details.price) - (order_details.qty * products.buy_price)) as total'), DB::raw("DATE_FORMAT(orders.order_date, '%Y') year"))
        ->whereBetween('orders.order_date', [$args['startDate'], $args['endDate']])
        ->groupby('year')
        ->orderBy('year', 'DESC');
        // ->limit(5)
        
        // ->reverse()
        
      } elseif ($args['startDate'] != "0" && $args['endDate'] != "0" && $args['filter'] == "d") {

        $res = DB::table('orders')
        ->join("order_details", "orders.id", "=", "order_details.order_id")
        ->join("products", "order_details.product_id", "=", "products.id")
        ->select(DB::raw('SUM((order_details.qty * order_details.price) - (order_details.qty * products.buy_price)) as total'), DB::raw("DATE_FORMAT(order_date, '%d') day"), DB::raw("DATE_FORMAT(orders.order_date, '%Y') year"), DB::raw("DATE_FORMAT(orders.order_date, '%m') month"), DB::raw('MONTH(orders.order_date) months'))
        ->whereBetween('orders.order_date', [$args['startDate'], $args['endDate']])
        ->groupby('day', 'month', 'year', 'months')
        ->orderBy('year', 'DESC')
        ->orderBy('months', 'DESC')
        ->orderBy('day', 'DESC');
        // ->limit(5)
        
        // ->reverse()
        
        
      } elseif ($args['filter'] == "y") {

        $res = DB::table('orders')
        ->join("order_details", "orders.id", "=", "order_details.order_id")
        ->join("products", "order_details.product_id", "=", "products.id")
        ->select(DB::raw('SUM((order_details.qty * order_details.price) - (order_details.qty * products.buy_price)) as total'), DB::raw("DATE_FORMAT(orders.order_date, '%Y') year"))
        // DB::raw('SUM((buy_price - discount_price) - sell_price) as total')
        // ->whereBetween('order_date', [$dateS, $dateE])
        ->groupby('year')
        ->orderBy('year', 'DESC');
        // ->limit(5)
        
        // ->reverse()
        

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
        ->orderBy('day', 'DESC');
        // ->limit(5)
        
        // ->reverse()
        

      } else {
        $res = DB::table('orders')
        ->join("order_details", "orders.id", "=", "order_details.order_id")
        ->join("products", "order_details.product_id", "=", "products.id")
        ->select(DB::raw('SUM((order_details.qty * order_details.price) - (order_details.qty * products.buy_price)) as total'), DB::raw("DATE_FORMAT(orders.order_date, '%Y') year"), DB::raw("DATE_FORMAT(orders.order_date, '%m') month"), DB::raw('MONTH(orders.order_date) months'))
        // DB::raw('SUM((buy_price - discount_price) - sell_price) as total')
        // ->whereBetween('order_date', [$dateS, $dateE])
        ->groupby('month', 'year', 'months')
        ->orderBy('year', 'DESC')
        ->orderBy('months', 'DESC');
        // ->limit(5)
        
        // ->reverse()
         
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
        ->orderBy('months', 'DESC');
        // ->limit(5)
        
        // ->reverse()
        

      } elseif ($args['startDate'] != "0" && $args['endDate'] != "0" && $args['filter'] == "y") {
        
        $res = DB::table('orders')
        ->join("order_details", "orders.id", "=", "order_details.order_id")
        ->join("products", "order_details.product_id", "=", "products.id")
        ->select('products.name as name', DB::raw('SUM(order_details.qty) as qty'), DB::raw('SUM((order_details.qty * order_details.price) - (order_details.qty * products.buy_price)) as total'), DB::raw("DATE_FORMAT(orders.order_date, '%Y') year"))
        ->whereBetween('orders.order_date', [$args['startDate'], $args['endDate']])
        ->groupby('name', 'year')
        ->orderBy('year', 'DESC');
        // ->limit(5)
        
        // ->reverse()
        
      } elseif ($args['startDate'] != "0" && $args['endDate'] != "0" && $args['filter'] == "d") {

        $res = DB::table('orders')
        ->join("order_details", "orders.id", "=", "order_details.order_id")
        ->join("products", "order_details.product_id", "=", "products.id")
        ->select('products.name as name', DB::raw('SUM(order_details.qty) as qty'), DB::raw('SUM((order_details.qty * order_details.price) - (order_details.qty * products.buy_price)) as total'), DB::raw("DATE_FORMAT(order_date, '%d') day"), DB::raw("DATE_FORMAT(orders.order_date, '%Y') year"), DB::raw("DATE_FORMAT(orders.order_date, '%m') month"), DB::raw('MONTH(orders.order_date) months'))
        ->whereBetween('orders.order_date', [$args['startDate'], $args['endDate']])
        ->groupby('name', 'day', 'month', 'year', 'months')
        ->orderBy('year', 'DESC')
        ->orderBy('months', 'DESC')
        ->orderBy('day', 'DESC');
        // ->limit(5)
        
        // ->reverse()
        
        
      } elseif ($args['filter'] == "y") {

        $res = DB::table('orders')
        ->join("order_details", "orders.id", "=", "order_details.order_id")
        ->join("products", "order_details.product_id", "=", "products.id")
        ->select('products.name as name', DB::raw('SUM(order_details.qty) as qty'), DB::raw('SUM((order_details.qty * order_details.price) - (order_details.qty * products.buy_price)) as total'), DB::raw("DATE_FORMAT(orders.order_date, '%Y') year"))
        // DB::raw('SUM((buy_price - discount_price) - sell_price) as total')
        // ->whereBetween('order_date', [$dateS, $dateE])
        ->groupby('name', 'year')
        ->orderBy('year', 'DESC');
        // ->limit(5)
        
        // ->reverse()
        

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
        ->orderBy('day', 'DESC');
        // ->limit(5)
        
        // ->reverse()
        

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
              ->orderBy('months', 'DESC');
              // ->limit(5)
              
              // ->reverse()
              
      }

      return $res; 
    }

    public function getItemCatProfit($_, array $args)
    {

      $res;
      
      if($args['startDate'] != "0" && $args['endDate'] != "0" && $args['filter'] == "m"){
        
        $res = DB::table('orders')
        ->join("order_details", "orders.id", "=", "order_details.order_id")
        ->join("products", "order_details.product_id", "=", "products.id")
        ->join("categories", "products.category_id", "=", "categories.id")
        ->select('categories.name as name', DB::raw('SUM(order_details.qty) as qty'), DB::raw('SUM((order_details.qty * order_details.price) - (order_details.qty * products.buy_price)) as total'), DB::raw("DATE_FORMAT(orders.order_date, '%Y') year"), DB::raw("DATE_FORMAT(orders.order_date, '%m') month"), DB::raw('MONTH(orders.order_date) months'))
        ->whereBetween('orders.order_date', [$args['startDate'], $args['endDate']])
        ->groupby('name', 'month', 'year', 'months')
        ->orderBy('year', 'DESC')
        ->orderBy('months', 'DESC');
        // ->limit(5)
        
        // ->reverse()
        

      } elseif ($args['startDate'] != "0" && $args['endDate'] != "0" && $args['filter'] == "y") {
        
        $res = DB::table('orders')
        ->join("order_details", "orders.id", "=", "order_details.order_id")
        ->join("products", "order_details.product_id", "=", "products.id")
        ->join("categories", "products.category_id", "=", "categories.id")
        ->select('categories.name as name', DB::raw('SUM(order_details.qty) as qty'), DB::raw('SUM((order_details.qty * order_details.price) - (order_details.qty * products.buy_price)) as total'), DB::raw("DATE_FORMAT(orders.order_date, '%Y') year"))
        ->whereBetween('orders.order_date', [$args['startDate'], $args['endDate']])
        ->groupby('name', 'year')
        ->orderBy('year', 'DESC');
        // ->limit(5)
        
        // ->reverse()
        
      } elseif ($args['startDate'] != "0" && $args['endDate'] != "0" && $args['filter'] == "d") {

        $res = DB::table('orders')
        ->join("order_details", "orders.id", "=", "order_details.order_id")
        ->join("products", "order_details.product_id", "=", "products.id")
        ->join("categories", "products.category_id", "=", "categories.id")
        ->select('categories.name as name', DB::raw('SUM(order_details.qty) as qty'), DB::raw('SUM((order_details.qty * order_details.price) - (order_details.qty * products.buy_price)) as total'), DB::raw("DATE_FORMAT(order_date, '%d') day"), DB::raw("DATE_FORMAT(orders.order_date, '%Y') year"), DB::raw("DATE_FORMAT(orders.order_date, '%m') month"), DB::raw('MONTH(orders.order_date) months'))
        ->whereBetween('orders.order_date', [$args['startDate'], $args['endDate']])
        ->groupby('name', 'day', 'month', 'year', 'months')
        ->orderBy('year', 'DESC')
        ->orderBy('months', 'DESC')
        ->orderBy('day', 'DESC');
        // ->limit(5)
        
        // ->reverse()
        
        
      } elseif ($args['filter'] == "y") {

        $res = DB::table('orders')
        ->join("order_details", "orders.id", "=", "order_details.order_id")
        ->join("products", "order_details.product_id", "=", "products.id")
        ->join("categories", "products.category_id", "=", "categories.id")
        ->select('categories.name as name', DB::raw('SUM(order_details.qty) as qty'), DB::raw('SUM((order_details.qty * order_details.price) - (order_details.qty * products.buy_price)) as total'), DB::raw("DATE_FORMAT(orders.order_date, '%Y') year"))
        // DB::raw('SUM((buy_price - discount_price) - sell_price) as total')
        // ->whereBetween('order_date', [$dateS, $dateE])
        ->groupby('name', 'year')
        ->orderBy('year', 'DESC');
        // ->limit(5)
        
        // ->reverse()
        

      } elseif ($args['filter'] == "d") {

        $res = DB::table('orders')
        ->join("order_details", "orders.id", "=", "order_details.order_id")
        ->join("products", "order_details.product_id", "=", "products.id")
        ->join("categories", "products.category_id", "=", "categories.id")
        ->select('categories.name as name', DB::raw('SUM(order_details.qty) as qty'), DB::raw('SUM((order_details.qty * order_details.price) - (order_details.qty * products.buy_price)) as total'), DB::raw("DATE_FORMAT(order_date, '%d') day"), DB::raw("DATE_FORMAT(orders.order_date, '%Y') year"), DB::raw("DATE_FORMAT(orders.order_date, '%m') month"), DB::raw('MONTH(orders.order_date) months'))
        // DB::raw('SUM((buy_price - discount_price) - sell_price) as total')
        // ->whereBetween('order_date', [$dateS, $dateE])
        ->groupby('name', 'day', 'month', 'year', 'months')
        ->orderBy('year', 'DESC')
        ->orderBy('months', 'DESC')
        ->orderBy('day', 'DESC');
        // ->limit(5)
        
        // ->reverse()
        

      } else {
        $res = DB::table('orders')
              ->join("order_details", "orders.id", "=", "order_details.order_id")
              ->join("products", "order_details.product_id", "=", "products.id")
              ->join("categories", "products.category_id", "=", "categories.id")
              ->select('categories.name as name', DB::raw('SUM(order_details.qty) as qty'), DB::raw('SUM((order_details.qty * order_details.price) - (order_details.qty * products.buy_price)) as total'), DB::raw("DATE_FORMAT(orders.order_date, '%Y') year"), DB::raw("DATE_FORMAT(orders.order_date, '%m') month"), DB::raw('MONTH(orders.order_date) months'))
              // DB::raw('SUM((buy_price - discount_price) - sell_price) as total')
              // ->whereBetween('order_date', [$dateS, $dateE])
              ->groupby('name', 'month', 'year', 'months')
              // ->groupby('')
              ->orderBy('year', 'DESC')
              ->orderBy('months', 'DESC');
              // ->limit(5)
              
              // ->reverse()
              
      }

      return $res; 
    }
}
