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

});

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
