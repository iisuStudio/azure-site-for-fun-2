<?php

Auth::routes(['verify' => true]);

Route::group( [
    'prefix' => 'auth',
], function () {
    Route::get( '{provider}', 'Auth\AuthController@redirectToProvider' )->name( 'auth.provider' );
    Route::get( '{provider}/callback', 'Auth\AuthController@handleProviderCallback' );
} );
