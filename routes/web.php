<?php

Route::match(['get', 'post'], '/botman', 'BotManController@handle');
Route::get('/botman/tinker', 'BotManController@tinker');

Route::post('/webhook/{user}', '\App\Http\Controllers\WebhookReceivedController');