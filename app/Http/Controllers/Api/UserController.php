<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Users;
use JWTAuth;


class UserController extends Controller {
  var $ctx = "Users.";
   
  public function myProfile() {
    $ctx = $this->ctx."myProfile.";
    $user = JWTAuth::user();
    return responseDataJson(true, "Get user profile", $user, 200); 
  }
}
