<?php

Route::group(['prefix' => config('adminamazing.path').'/tickets', 'middleware' => ['web','CheckAccess']], function() {
	Route::get('/', 'selfreliance\tickets\TicketsController@index')->name('AdminTicketsHome');
	Route::get('/chat/{id?}', 'selfreliance\tickets\TicketsController@chat')->name('AdminTicketsChat');
	Route::get('/{id}', 'selfreliance\tickets\TicketsController@close')->name('AdminTicketsClose');
	Route::post('/{id}', 'selfreliance\tickets\TicketsController@send')->name('AdminTicketsSend');
	Route::post('/create_ticket', 'selfreliance\tickets\TicketsController@create_ticket')->name('AdminTicketsCreate');
	Route::delete('/{id?}', 'selfreliance\tickets\TicketsController@destroy')->name('AdminTicketsDelete');
});