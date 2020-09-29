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

      // $time = strtotime($args['endDate']);
      // $dateE = date("Y-m-d", strtotime("+1 month", $time));
      // $dateE = $args['endDate'];
      $res;
      
      
        $res = Product::select(DB::raw('SUM(buy_price) as total'), DB::raw("DATE_FORMAT(created_at, '%Y') year"), DB::raw("DATE_FORMAT(created_at, '%m') month"), DB::raw('MONTH(created_at) months'))
        ->whereBetween('created_at', ['2019-12-05 3:30:34', '2020-06-05 3:30:34'])
        // ->whereDate('created_at','>=','2019-06-05 3:30:34')
        // ->whereDate('created_at','<=','2020-08-05 3:30:34')
        ->groupby('month', 'year', 'months')
        ->orderBy('year', 'DESC')
        ->orderBy('months', 'DESC')
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
