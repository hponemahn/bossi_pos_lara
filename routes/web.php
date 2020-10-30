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

Route::get('/test', function () {
    $isSell = 0;
    $search = "";
    if ($search === "" && $isSell === 0) {
        $res = DB::table('products')->select('id', 'name', 'category_id', 'barcode', 'sku', 'stock', 'buy_price', 'sell_price', 'discount_price')
        ->get();
    } else {
        return 1;
    }

    return $res;

});

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
