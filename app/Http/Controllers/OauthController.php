<?php

namespace App\Http\Controllers;

use Zttp\Zttp;
use Illuminate\Http\Request;

class OauthController extends Controller {
  
  public function store(Request $request) {
  	$code = $request->code;

  	$url = 'https://cloud.lightspeedapp.com/oauth/access_token.php';
  	$body = [
			'client_id' => env('LIGHTSPEED_RETAIL_CLIENT_ID'),
			'client_secret' => env('LIGHTSPEED_RETAIL_SECRET'),
			'code' => $code,
			'grant_type' => 'authorization_code'
		];
		$headers = [
			"Content-Type" => "application/json",
			"Accept" => "application/json"
		];

		$response = Zttp::withOptions(['headers' => $headers])->post($url, $body);
		dd($response->json());
  }

  public function refund(Request $request) {
  	dd($request->query());
  }

  public function sale(Request $request) {
  	dd($request->query());
  }
}
