<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use JWTAuth;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Contracts\JWTSubject;

class AuthController extends Controller {
  var $ctx = 'Auth.';

  public function login(Request $request) {
    $ctx = $this->ctx."login.";
    
    $validation = $this->validations($request->post(), 'login');
    if($validation->fails()){
      logData($ctx."generateToken", 'disini', 500);
      $err = $this->convertMessages( $validation->errors()->toArray() );
      return responseJson(false, $err, 400);
    }
    
    $credentials = [
      "nip"       => $request->input('nip'),
      "password"  => $request->input('password'),
    ];
    
    try {
      $generateToken = JWTAuth::attempt($credentials);
    } catch (JWTException $e) {
      logData($ctx."generateToken", $e->getMessage(), 500);
      return responseJson(false, "Internal server error", 500);
    }

    if (!$generateToken) {
      return responseJson(false, "NIP atau Password salah.", 400);
    }

    $token = ['token' => $generateToken];

    logData($ctx, "Login success", 200);
    return responseDataJson(true, "Login success", $token, 200);
  }

  public function logout(Request $request) {
    $ctx = $this->ctx."logout.";

    $validation = $this->validations($request->header(), 'logout');
    if($validation->fails()){
      $err = $validation->errors();
      return responseJson(false, $err, 400);
    }

    try {
      JWTAuth::invalidate($request->bearertoken());
    } catch (JWTException $e) {
      logData($ctx."deleteToken", $e->getMessage(), 500);
      return responseJson(false, "Internal server error", 500);
    }

    return responseJson(true, "User has been logged out", 200);
  } 

  private function validations($input, $scenario) {
    switch ($scenario){
      case 'login':
        $rules = [
          "nip"         => ['required'],
          "password"    => ['required'],
        ];
        $messages = [];
			break;
      case 'logout':
        $rules = [
          "authorization"  => ['required'],
        ];
        $messages = [];
    } 
    return Validator::make($input, $rules, $this->messages());
  }

  private function messages() {
    return [
      'nip.required'      => 'NIP tidak boleh kosong.',
      'password.required' => 'Password tidak boleh kosong.',
    ];
  }

  private function convertMessages($value) {
    $messages = [];
    foreach ($value as $key => $val) {
      $messages[$key] = $val[0];
    };
    return $messages;
  }
}
