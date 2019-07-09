<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Zttp\Zttp;
use Illuminate\Http\Request;
use Log;

class ShopifyController extends Controller {
  
  public function oauth(Request $request) {
  	if ($this->validateHmac($request)) {
  		if ($request->has('code')) {
  			if ($this->authenticateRedirect($request)) {
  				if ($this->validateShop($request)) {
  					$accessTokenData = $this->getAccessToken($request);
  					dd($accessTokenData);
  				} else {
  					dd('not validated shop');
  				}
  			} else {
  				dd('not authenticated');
  			}
  		} else {
  			$apiKey = env('SHOPIFY_API_KEY');
	  		$scopes = "read_products,read_customers,write_customers,read_orders,read_draft_orders,write_draft_orders";
	  		$redirectUri = "https://pockeyt-test.com/shopify";
	  		$state = 'test_state';

	  		$url = "https://{$request->shop}/admin/oauth/authorize?client_id={$apiKey}&scope={$scopes}&redirect_uri={$redirectUri}&state={$state}";

	  		return redirect($url);
  		}
  	} else {
  		dd("not valid");
  	}
  }

  public function show(Request $request) {
  	return view('shopify');
  }

  public function orders() {
  	$url = 'https://pockeyt-test.myshopify.com/admin/api/2019-04/orders/995295952945';
    $headers = [
      "X-Shopify-Access-Token" => env("SHOPIFY_ACCESS_TOKEN"),
      "Content-Type" => "application/json",
      "Accept" => "application/json"
    ];
    $response = Zttp::withOptions(['headers' => $headers])->get($url);
    dd($response->json());
  }



  private function getAccessToken($request) {
  	$url = "https://{$request->shop}/admin/oauth/access_token";
  	$headers = [
			"Content-Type" => "application/json",
			"Accept" => "application/json"
		];

		$body = [
			'client_id' => env('SHOPIFY_API_KEY'),
			'client_secret' => env('SHOPIFY_SECRET_KEY'),
			'code' => $request->code
		];

		$response = Zttp::withOptions(['headers' => $headers])->post($url, $body);
		return $response->json();
  }

  private function validateShop($request) {
		if ($request->has('shop')) {
			return (preg_match("/[A-Za-z0-9.-]/", $request->shop) === 1) && (Str::endsWith($request->shop, 'myshopify.com'));
		}
		return false;
	}

  private function authenticateRedirect($request) {
  	return $request->has('state') && ($request->state == 'test_state');
  }

  private function validateHmac($request) {
		if ($request->has('hmac')) {
			$queryUrl = "";
			foreach ($request->except('hmac') as $key => $value) {
				$queryUrl = "{$queryUrl}{$key}={$value}&";
			}
			$queryUrl = hash_hmac('sha256', substr($queryUrl, 0, -1), env('SHOPIFY_SECRET_KEY'));
			return hash_equals($queryUrl, $request->hmac);
		}
		return false;
	}





  public function webhook() {
    $responseOne = $this->registerWebhook("orders/paid");
    $responseTwo = $this->registerWebhook("refunds/create");
    dd($responseOne, $responseTwo);
  }

  private function registerWebhook($type) {
    $url = "https://pockeyt-test.myshopify.com/admin/api/2019-04/webhooks";
    $body = [
      'webhook' => [
        'topic' => $type,
        'address' => env('APP_URL') . '/api/webhook/shopify',
        'format' => 'json'
      ]
    ];

    $headers = [
      "X-Shopify-Access-Token" => env("SHOPIFY_ACCESS_TOKEN"),
      "Content-Type" => "application/json",
      "Accept" => "application/json"
    ];

    return $response = Zttp::withOptions(['headers' => $headers])->post($url, $body);
  }

  public function webhookPost(Request $request) {
    Log::debug($request->all());
    return response()->json(['success' => 'Received Webhook.'], 200);
  }

  public function listWebhooks() {
    $url = "https://pockeyt-test.myshopify.com/admin/api/2019-04/webhooks";
    $headers = [
      "X-Shopify-Access-Token" => env("SHOPIFY_ACCESS_TOKEN"),
      "Content-Type" => "application/json",
      "Accept" => "application/json"
    ];
    $response = Zttp::withOptions(['headers' => $headers])->get($url);
    dd($response->json());
  }

  public function deleteWebHook() {
    $id = '460391022641';
    $url = "https://pockeyt-test.myshopify.com/admin/api/2019-04/webhooks/{$id}";
    $headers = [
      "X-Shopify-Access-Token" => env("SHOPIFY_ACCESS_TOKEN"),
      "Content-Type" => "application/json",
      "Accept" => "application/json"
    ];
    $response = Zttp::withOptions(['headers' => $headers])->delete($url);
    dd($response->json());
  }
}
