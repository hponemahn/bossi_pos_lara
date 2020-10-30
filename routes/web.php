<?php

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
use Illuminate\Support\Facades\Route;
use App\Order;

Route::get('/test', function () {
    return Order::get();
    // return $order = Order::create(['total' => 1, 'order_date' => "2020-10-30 15:47:28"]);
});

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
