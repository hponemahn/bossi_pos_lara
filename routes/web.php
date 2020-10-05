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

    $res = DB::table('products')
    ->select('name', DB::raw('SUM(stock) as qty'))
    ->groupby('name')
    ->orderBy('qty', 'DESC')
    ->get()
    ->all();  

    return $res;

});

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
