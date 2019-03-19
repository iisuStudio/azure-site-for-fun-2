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
    [ 'middleware' => 'auth:web', 'namespace' => 'Web' ],
    function () {
        Route::get('/web', 'IndexController@index');

        Route::get('/web/datatable', 'IndexController@datatable');

        Route::get('/web/calendar', 'IndexController@calendar');

        Route::get('/web/gallery', 'IndexController@gallery');

        Route::get('/web/gmap-xml', 'IndexController@gmap_xml');

        Route::get('/web/inbox', 'IndexController@inbox');

        Route::get('/web/invoice', 'IndexController@invoice');

        Route::get('/web/profile', 'IndexController@profile');
    }
);