<?php

Route::get('/', 'HomeController@index');

Route::get('/waitlist/cancel', 'TicketsController@cancel');

Route::get('/clear', function () {
    App\Ticket::truncate();
    App\Waitlist::truncate();
    return "Cleared database.";
});