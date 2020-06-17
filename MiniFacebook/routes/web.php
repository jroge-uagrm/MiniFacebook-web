<?php
use Illuminate\Support\Facades\Route;

Route::permanentRedirect('/','/home');

Route::get('login','AuthController@index')->name('authenticate');
Route::post('login','AuthController@login');
Route::post('register','AuthController@register');

Route::middleware('auth')->group(function () {

    Route::get('home','HomeController@index');

    Route::get('logout','AuthController@logout');

});