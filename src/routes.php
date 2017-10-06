<?php

Route::group(['prefix' => config('adminamazing.path').'/tickets', 'middleware' => ['web','CheckAccess']], function() {
	Route::get('/', 'selfreliance\tickets\TicketsController@index')->name('AdminTickets');
	Route::get('/chat/{id}', 'selfreliance\tickets\TicketsController@chat')->name('AdminTicketsChat');
	Route::post('/send/{id}', 'selfreliance\tickets\TicketsController@send')->name('AdminTicketsSend');
});