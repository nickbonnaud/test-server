<?php

namespace App\Http\Controllers;

use Log;
use Illuminate\Http\Request;

class MailgunController extends Controller {
  
  public function store(Request $request) {
  	Log::debug($request->all());
  	return response()->json(['status' => 'ok'], 200);
  }
}
