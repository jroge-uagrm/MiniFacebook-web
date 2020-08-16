<?php
use Illuminate\Support\Facades\Route;

Route::redirect('/','/home');

Route::get('login','AuthController@index')->name('authenticate');
Route::post('login','AuthController@login')->name('login');
Route::post('register','AuthController@register')->name('register');

Route::middleware('auth')->group(function () {
    
    Route::get('delete','AuthController@delete')->name('account.delete');

    Route::get('home','HomeController@index')->name('home');

    Route::get('profile/{userId}','UserController@index')->name('profile');
    Route::get('profile_picture/{userId}','UserController@profilePicture')->name('profile_picture');
    
    Route::get('logout','AuthController@logout')->name('logout');
    Route::put('change_password','AuthController@changePassword')->name('password.save');
    
    Route::get('configurations','UserController@configurations')->name('configurations');
    Route::put('configurations','UserController@update')->name('configurations.save');

    Route::post('search','HomeController@search')->name('search');

    Route::get('friend_request/{userId}','FriendRequestController@send')->name('friend.request');
    Route::get('friend_delete/{userId}','ContactController@delete')->name('friend.delete');
    Route::get('friend_request_all_mine','FriendRequestController@allMine')->name('friendRequest.allMine');
    Route::get('friend_request_accept/{userId}','FriendRequestController@accept')->name('friendRequest.accept');
    Route::get('friend_request_reject/{userId}','FriendRequestController@reject')->name('friendRequest.reject');

    Route::get('chats','ChatController@allMine')->name('chats');
    Route::get('chat/{userId}','ChatController@index')->name('chat.index');
    Route::post('chat/send_message','ChatController@sendMessage')->name('chat.sendMessage');
    Route::post('chat/search_message','ChatController@searchMessage')->name('chat.search');
    
    Route::get('message/{userId}','ChatController@message')->name('message');

    Route::get('publications/{publicationId}','PublicationController@index')->name('publications.index');
    Route::post('publications','PublicationController@create')->name('publications.new');
    Route::get('publications_delete/{publicationId}','PublicationController@delete')->name('publications.delete');

    Route::post('comments','CommentController@create')->name('comments.new');

});