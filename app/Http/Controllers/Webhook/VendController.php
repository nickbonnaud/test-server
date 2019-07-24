<?php

namespace App\Http\Controllers\Webhook;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Webhook\VendRequest;

class VendController extends Controller {
  
  public function store(VendRequest $request) {
  	Log::info($request->all());
  	return response()->json(['success' => 'Received.'], 200);
	}

	public function storeProduct() {
		Log::info($request->all());
		return response()->json(['success' => 'Received.'], 200);
	}
}
