<?php
use Illuminate\Support\Facades\Route;

Route::permanentRedirect('/','/home');

Route::get('login','AuthController@index')->name('authenticate');
Route::post('login','AuthController@login');
Route::post('register','AuthController@register');

Route::middleware('auth')->group(function () {
    
    Route::get('home','HomeController@index')->name('home');
    
    Route::get('logout','AuthController@logout');
    
    Route::get('me','HomeController@read')->name('profile');
    Route::get('store_image/fetch_image/{userId}','HomeController@fetch_image');
    Route::put('me','HomeController@update');
    Route::put('change_password','AuthController@changePassword');

});