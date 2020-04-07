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

Route::auth();

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('welcome');
});

Route::get('/user/profile', 'AppAuthController@webShowPasswordCredentials')
    ->name('user.profile')
    ->middleware(['auth:web']);

Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
