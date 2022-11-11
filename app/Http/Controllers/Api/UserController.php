<?php

namespace App\Http\Controllers\Api;

use JWTAuth;
use App\Http\Controllers\Controller;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller {
  var $ctx = "Users.";
   
  public function myProfile() {
    $ctx = $this->ctx."myProfile.";
    $user = JWTAuth::user();
    return responseDataJson(true, "Get user profile", $user, 200); 
  }
  

  public function changePassword(Request $request) {
    $ctx = $this->ctx."changePassword.";

    $user_id = JWTAuth::user()->id;
    $user_password = JWTAuth::user()->password;
    $current_password = $request->input('current_password');
    $new_password = $request->input('new_password');
    
    $validation = $this->validations($request->post(), 'changePassword');
    if($validation->fails()){
      logData($ctx."generateToken", 'disini', 500);
      $err = $this->convertMessages( $validation->errors()->toArray() );
      return responseJson(false, $err, 400);
    }

    // compare password
    if (!Hash::check($current_password, $user_password)) {
      return responseJson(false, 'Wrong password.', 400);
    }
    
    // update password.
    Users::where('id', $user_id)->update(['password' => Hash::make($new_password)]);
    
    return responseJson(true, "Success update password", 200); 
  }


  private function validations($input, $scenario) {
    switch ($scenario){
      case 'changePassword':
        $rules = [
          "current_password"  => ['required', 'string', 'min:8', 'max:50'],
          "new_password"      => ['required', 'string', 'min:8', 'max:50', 'same:confirm_password'],
          "confirm_password"  => ['required', 'string', 'min:8', 'max:50'],
        ];
        $messages = [];
		  }
    return Validator::make($input, $rules, $this->messages());
  }

  public function messages() {
    return [
      'current_password.required'     => 'Password lama tidak boleh kosong.',
      'current_password.min'          => 'Password lama minmal 8 karakter.',
      'current_password.max'          => 'Password lama maksimal 50 karakter.',
      'new_password.required'         => 'Password baru tidak boleh kosong.',
      'new_password.min'              => 'Password baru minmal 8 karakter.',
      'new_password.max'              => 'Password baru maksimal 50 karakter.',
      'new_password.same'             => 'Password baru dan konfirmasi password tidak sama.',
      'confirm_password.required'     => 'Konfirmasi password tidak boleh kosong.',
      'confirm_password.min'          => 'Konfirmasi password minmal 8 karakter.',
      'confirm_password.max'          => 'Konfirmasi password maksimal 50 karakter.',
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