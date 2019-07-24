<?php

namespace App\Http\Requests\Webhook;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Http\FormRequest;

class VendRequest extends FormRequest {
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize() {
    return $this->verifyHeaders();
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
      return [
          //
      ];
  }

  private function verifyHeaders() {
    Log::info($this->all());
    return  $this->headers->has('X-Signature') && $this->checkHeaderSignature();
  }

  private function checkHeaderSignature() {
    $algo = strtolower(Str::after($this->header('X-Signature'), 'algorithm=HMAC-'));
    Log::info($algo);

    $signature = Str::before(Str::after($this->header('X-Signature'), "signature="), ',algorithm');
    Log::info($signature);
    Log::info($this->getContent());

    $calcHash = hash_hmac($algo, $this->getContent(), env('VEND_SECRET'), true);
    Log::info(hash_equals($calcHash, $signature));

    return hash_equals($calcHash, $signature);
  }
}
