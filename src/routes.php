<?php

Route::group(['prefix' => config('adminamazing.path').'/tickets', 'middleware' => ['web','CheckAccess']], function() {
	Route::get('/', 'selfreliance\tickets\TicketsController@index')->name('AdminTickets');
	Route::get('/chat/{id}', 'selfreliance\tickets\TicketsController@chat')->name('AdminTicketsChat');
	Route::post('/send/{id}', 'selfreliance\tickets\TicketsController@send')->name('AdminTicketsSend');
	Route::delete('/delete', 'selfreliance\tickets\TicketsController@destroy')->name('AdminTicketsDelete');
	Route::post('/create_ticket', 'selfreliance\tickets\TicketsController@create_ticket')->name('AdminTicketsCreate');
});