<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Order;
use App\Product;

Route::get('/test', function () {

    $res = DB::table('orders')
    ->join("order_details", "orders.id", "=", "order_details.order_id")
    ->join("products", "order_details.product_id", "=", "products.id")
    ->join("categories", "products.category_id", "=", "categories.id")
    ->select('products.name as name', 'categories.name as catName', DB::raw('SUM(order_details.qty) as qty'), DB::raw('SUM((order_details.qty * order_details.price) - (order_details.qty * products.buy_price)) as total'), DB::raw("DATE_FORMAT(orders.order_date, '%Y') year"), DB::raw("DATE_FORMAT(orders.order_date, '%m') month"), DB::raw('MONTH(orders.order_date) months'))
    // DB::raw('SUM((buy_price - discount_price) - sell_price) as total')
    // ->whereBetween('order_date', [$dateS, $dateE])
    ->groupby('name', 'catName', 'month', 'year', 'months')
    // ->groupby('')
    ->orderBy('year', 'DESC')
    ->orderBy('months', 'DESC')
    ->orderBy('qty', 'ASC')
    // ->limit(5)
    ->get()
    // ->reverse()
    ->all();   
    
    return $res;

});

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
