<?php

namespace App\Http\Controllers\Business;

use Zttp\Zttp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VendAccountController extends Controller {
  
  public function store(Request $request) {
		if ($request->has('code')) {
			return $this->getAccessToken($request);
		} else {
			return $this->redirectOauth($request);
		}
	}

	private function redirectOauth($request) {
		$clientId = env('VEND_CLIENT_ID');
		$redirectUrl = url('/api/business/pos/vend/oauth');
		$url = "https://secure.vendhq.com/connect?response_type=code&client_id={$clientId}&redirect_uri={$redirectUrl}";
		return redirect($url);
	}

	private function getAccessToken($request) {
		if ($request->has('domain_prefix')) {
			$this->authorizeVend($request->domain_prefix, $request->code);
			return response()->json(['success' => 'Vend account connected.'], 200);
		}
		return response()->json(['error' => 'No domain prefix.'], 200);
	}



	private function authorizeVend($domainPrefix, $code) {
		$accessToken = $this->postAccessCode($domainPrefix, $code);
	}

	private function postAccessCode($domainPrefix, $code) {
		$url = "https://{$domainPrefix}.vendhq.com/api/1.0/token";
		$headers = [
			"Content-Type" => "application/x-www-form-urlencoded",
		];
		$body = [
			'code' => $code,
			'client_id' => env('VEND_CLIENT_ID'),
			'client_secret' => env('VEND_SECRET'),
			'grant_type' => 'authorization_code',
			'redirect_uri' => url('/api/business/pos/vend/oauth')
		];

		dd($body);

		$response = Zttp::withOptions(['headers' => $headers])->post($url, $body);
		dd($response->json());
	}
}
