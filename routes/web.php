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
});

Route::get('/login', function () {
    return view('login');
});


Route::group(
    ['namespace' => 'Auth'],
    function () {
        Route::get('/fire', 'FirebaseController@index');
    }
);

Route::get('/chat', 'View@chat');

Route::get('/chat_log', 'View@chat_log');

Route::post('/chat_message', 'View@chat_message');

Route::get('/session', 'Session@fire');