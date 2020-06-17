<?php
use Illuminate\Support\Facades\Route;

Route::permanentRedirect('/','/home');

Route::get('login','AuthController@index')->name('authenticate');
Route::post('login','AuthController@login');
Route::post('register','AuthController@register');

Route::middleware('auth')->group(function () {

    Route::get('home','HomeController@index')->name('home');

    Route::get('logout','AuthController@logout');

    Route::get('me','HomeController@read');
    Route::put('me','HomeController@update');

});