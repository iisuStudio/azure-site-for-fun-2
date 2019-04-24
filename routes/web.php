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

Route::group(
    [
        'middleware' => 'auth:web',
        'namespace' => 'Web',
        'prefix' => 'web'
    ],
    function () {
        Route::get('/', 'IndexController@index');

        Route::get('/datatable', 'IndexController@datatable');

        Route::get('/calendar', 'IndexController@calendar');

        Route::get('/gallery', 'IndexController@gallery');

        Route::get('/gmap-xml', 'IndexController@gmap_xml');

        Route::get('/inbox', 'IndexController@inbox');

        Route::get('/invoice', 'IndexController@invoice');

        Route::get('/profile', 'IndexController@profile');

        Route::group(
            [
                'namespace' => 'Member',
                'prefix' => 'member'
            ],
            function () {
                Route::get('/user', 'UserController@index');
                Route::get('/user/getlist', 'UserController@getList');
            }
        );
    }
);