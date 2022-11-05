<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
  public function index() {
    if ($user = Auth::user()) {
      return Redirect::to('dashboard');
    }
    return view('auth.login');
  }

  public function login(Request $request) {
    $validator = Validator::make($request->all(), [
      'email'     => 'required|string',
      'password'  => 'required|string',
    ]);
    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput($request->all());
    }

    $data = [
      'email'     => $request->input('email'),
      'password'  => $request->input('password'),
    ];

    if (!Auth::attempt($data)) {
      return Redirect::to('login')->with('errorLogin', 'Email or password wrong.');
    }

   return Redirect::to('dashboard');
  }

  public function logout(Request $request) {
    $request->session()->flush();
    Auth::logout();
    return Redirect::to('login');
  }

  public function changePassword() {
    return view('auth.change_password');
  }

  public function updatePassword(Request $request) {
    $validator = Validator::make($request->all(), [
      'currentPassword'           => 'required|string',
      'newPassword'               => 'required|string|confirmed',
      'newPassword_confirmation'  => 'required|string',
    ], $this->messages());
    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput($request->all());
    }

    $data = [
      'email'     => Auth::user()->email,
      'password'  => $request->input('currentPassword'),
    ];

    if (!Auth::attempt($data)) {
      return Redirect::to('auth/change-password')->with('error', 'Password salah.');
    }

    Users::where('id', Auth::user()->id)->update(['password' => Hash::make($request->input('newPassword'))]);
    return Redirect::to('auth/change-password')->with('success', 'Success update password');
  }


  // custom error message
  public function messages() {
    return [
      'currentPassword.required'            => 'Password lama tidak boleh kosong.',
      'currentPassword.string'              => 'Input Password lama tidak valid.',
      'newPassword.required'                => 'Password baru tidak boleh kosong.',
      'newPassword.string'                  => 'Input Password baru tidak valid.',
      'newPassword.confirmed'               => 'Password baru tidak sama dengan konfirmasi password.',
      'newPassword_confirmation.required'   => 'Konfirmasi password tidak boleh kosong.',
      'newPassword_confirmation.string'     => 'Input konfirmasi password tidak valid.',
    ];  
  }

}
