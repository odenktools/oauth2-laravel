<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// ONLY oAuth2 Password Grants
Route::post('/login', ['as' => 'api.login', 'uses' => 'ApiLoginController@login']);
Route::post('/login/refresh', ['as' => 'api.login.refresh', 'uses' => 'ApiLoginController@refresh']);
Route::delete('/logout', 'ApiLoginController@logout')->middleware('auth:api');

// === Check credentials

// Password grant
Route::get('/check-oauth-passwd', ['as' => 'get.oauth.password', 'uses' => 'AppAuthController@showPasswordCredentials'])
    ->middleware(['auth:api']);

// Client credential grant
Route::get('/check-oauth-cred', ['as' => 'get.oauth.credentials', 'uses' => 'AppAuthController@showClientCredentials'])
    ->middleware(['oauth-client']);
