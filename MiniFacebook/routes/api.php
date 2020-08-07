<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('chat/send_message','ChatController@sendMessage')->name('chat.sendMessage');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
