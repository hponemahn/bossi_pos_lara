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

    return \App\Order::select(DB::raw('SUM(total) as total'), DB::raw("DATE_FORMAT(order_date, '%y') year"),DB::raw('MONTH(order_date) months'),  DB::raw('MONTHNAME(order_date) month'))
        ->groupby('month', 'year', 'months')
        ->orderBy('year', 'ASC')
        ->orderBy('months', 'ASC')
        ->get();

    // return DB::table('orders')
    //         ->select(DB::raw('SUM(total) as total'), DB::raw("DATE_FORMAT(order_date,'%M-%y') as monY"))
    //         ->groupby('monY')
    //         ->orderBy('monY', 'desc')
    //         ->get();

            // , DB::raw("DATE_FORMAT(order_date,'%m') as orderM")
});

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
