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
use App\User;

Route::get('/test', function () {

    $user = User::select('id')->where('phone', '009')->orWhere('email', 'ph@ph.com')->get();

    if (count($user) > 0) {
        return "1";
    } else {
        return 0;
    }
    

    // $user = User::create(
    //     ['name' => $args['name'], 'logo' => $args['logo'], 'business_cat_id' => $args['business_cat_id'], 'phone' => $args['phone'], 'email' => $args['email'], 'password' => $args['password'], 'state_id' => $args['state_id'], 'township_id' => $args['township_id'], 'address' => $args['address'], 'api_token' => Str::random(60)]
    // ); 
});

Route::get('/', function () {
    return view('welcome');
});