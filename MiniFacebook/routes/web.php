<?php
use Illuminate\Support\Facades\Route;

Route::permanentRedirect('/','/home');

Route::get('login','AuthController@index')->name('authenticate');
Route::post('login','AuthController@login')->name('login');
Route::post('register','AuthController@register')->name('register');

Route::get('profile/{userId}','HomeController@profile')->name('profile');
Route::get('profile_picture/{userId}','HomeController@profilePicture')->name('profile_picture');



Route::middleware('auth')->group(function () {
    
    Route::get('home','HomeController@publications')->name('home');
    
    Route::get('logout','AuthController@logout')->name('logout');
    Route::put('change_password','AuthController@changePassword')->name('password.save');
    
    Route::get('configurations','HomeController@configurations')->name('configurations');
    Route::put('configurations','HomeController@update')->name('configurations.save');

    Route::post('search','HomeController@search')->name('search');

    Route::get('friend_request/{userId}','FriendController@request')->name('friend.request');
    Route::get('friend_delete/{userId}','FriendController@delete')->name('friend.delete');
    Route::get('friend_request_all_mine','FriendRequestController@allMine')->name('friendRequest.allMine');
    Route::get('friend_request_accept/{userId}','FriendRequestController@accept')->name('friendRequest.accept');
    Route::get('friend_request_reject/{userId}','FriendRequestController@reject')->name('friendRequest.reject');

    Route::get('chats','HomeController@chats')->name('chats');
    Route::get('chat/{userId}','ChatController@index')->name('chat');
    
    Route::get('message/{userId}','ChatController@message')->name('message');

    Route::post('notifications','HomeController@notifications')->name('notifications');

});