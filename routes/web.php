<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::group(
    ['namespace' => 'Auth'],
    function () {
        Route::get('/fire', 'FirebaseController@index');
    }
);

Route::get('/chat', 'ChatWindow@chat')->name('chat');;

Route::get('/chat_log', 'ChatWindow@chat_log');

Route::post('/chat_message', 'ChatWindow@chat_message');