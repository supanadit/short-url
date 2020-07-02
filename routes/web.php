<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', "UrlShortenerController@viewHome");
Route::post('/s/g', "UrlShortenerController@createShortURL");
Route::get('/s/{pathGenerated}', "UrlShortenerController@openDestination");
Route::post('/s/{pathGenerated}/open/protection', "UrlShortenerController@openProtectedDestination");

Route::middleware('auth.web')->group(function () {
    Route::get('/list', "UrlShortenerController@viewList");

    // URL Shortener Controller
    Route::get('/web/url/address/list', "UrlShortenerController@urlAddressList");
    Route::delete('/web/url/address/delete/{id}', "UrlShortenerController@urlAddressDelete");

    // Security Controller
    Route::post('/web/change/password', "SecurityController@formChangePassword");
});

Route::post('/web/login', "SecurityController@formLogin");
Route::post('/web/forgot', "SecurityController@formForgotPassword");
Route::post('/web/register', "SecurityController@formRegister");
Route::get('/web/logout', "SecurityController@formLogout");

