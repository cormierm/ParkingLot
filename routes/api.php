<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/ticket/create', 'TicketsController@create');
Route::get('/ticket/status', 'TicketsController@status');

Route::post('/payment/details', 'PaymentsController@details');
Route::post('/payment/pay', 'PaymentsController@processPayment');

Route::post('/parking/exit', 'ParkingController@processExit');
Route::post('/parking/waitListBypass', 'ParkingController@waitListBypass');

Route::post('/waitlist', 'WaitListController@store');