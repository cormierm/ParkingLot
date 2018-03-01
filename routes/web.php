<?php

Route::get('/', 'HomeController@index');

Route::post('/ticket/create', 'TicketsController@create');
Route::get('/ticket/status', 'TicketsController@status');

Route::post('/payment/details', 'PaymentsController@details');
Route::post('/payment/pay', 'PaymentsController@processPayment');

Route::post('/parking/exit', 'ParkingController@processExit');

Route::post('/waitlist', 'WaitListController@store');