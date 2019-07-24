<?php

namespace App\Http\Controllers\Webhook;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\requests\Webhook\VendRequest;

class VendController extends Controller {
  
  public function store(VendRequest $request) {
  	Log::info($request->all());
	}
}
