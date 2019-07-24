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

Route::post("webhook/shopify", 'ShopifyController@webhookPost');

Route::post("mailgun/test", "MailgunController@store");


Route::prefix('business')->group(function() {
	Route::prefix('pos')->group(function() {
		Route::get('vend/oauth', 'Business\VendAccountController@store')->name('vend_oauth');
		Route::get('vend/webhook', 'Business\VendAccountController@setUpWebhook')->name('vend_webhook');
	});
});

Route::prefix('webhook')->group(function() {
	Route::post('vend', 'Webhook\VendController@store');
	Route::post('vend/product', 'Webhook\VendController@storeProduct');
});