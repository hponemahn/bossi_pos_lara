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

    return DB::table("orders")
    ->join("order_details", "orders.id", "=", "order_details.order_id")
    ->join("products", "order_details.product_id", "=", "products.id")
    ->join("categories", "products.category_id", "=", "categories.id")
    ->select("categories.name as name", DB::raw('SUM(orders.total) as total'))
    ->groupBy("name")
    ->limit(4)
    ->get();
});

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
