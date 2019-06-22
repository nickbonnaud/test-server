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


Route::view('/oauth-test', 'oauth')->name('oauth');

Route::get('/oauth-test/redirect', 'OauthController@store')->name('redirect');

Route::get('/oauth-test/refund', 'OauthController@refund');
Route::get('/oauth-test/sale', 'OauthController@sale');


Route::get('/shopify', 'ShopifyController@oauth');
Route::get('/shopify/open', 'ShopifyController@show');