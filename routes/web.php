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

    $res = DB::table('products')
        ->select('id', 'name', 'barcode', 'sku')
        ->orWhere('name', 'test')
        ->orWhere('barcode', 'barcode')
        ->orWhere('sku', 'sku')
        ->orderBy('id', 'DESC')
        ->paginate(15);

    return $res;

});

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
