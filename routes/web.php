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

Route::get('/test', function () {

    return $users = DB::table('orders')
  ->select("total", DB::raw("
  DATE_FORMAT(order_date,'%W-%d') as order_date")
)->whereDate('order_date', '>', date('Y-m-d',strtotime("-7 days")))->orderBy(DB::raw("
DATE_FORMAT(order_date,'%d')"), 'asc')->get();

    return DB::table('orders')->select("total", DB::raw("DATE_FORMAT(order_date,'%Y-%m')"))->whereDate('order_date', '>', date('Y-m-d',strtotime("-7 days")))->get();

    // return DB::table('orders')->selectRaw("total, DATE_FORMAT('order_date', '%d/%l/%Y') as order_date")->whereDate('order_date', '>', date('Y-m-d',strtotime("-7 days")))->orderBy('order_date','asc')->get();
});

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
