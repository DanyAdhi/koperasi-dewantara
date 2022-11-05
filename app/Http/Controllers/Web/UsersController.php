<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;

use App\Models\Users;
use App\Models\Loans;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;


class UsersController extends Controller {

  public function index() {
    $users = Users::where('scope', 'User')->orderBy('id', 'DESC')->get();
    return view('user.index', ['users' => $users]);
  }

  public function create() {
    return view('user.create');
  }

  public function store(Request $request) {
    // Modify input status
    $requestData = $request->all();
    $requestData['status'] = Arr::exists($requestData, 'status') ? true : false;

    $validator = Validator::make($requestData,[
      'nip'      => 'required|numeric|digits_between:10,12|unique:users',
      'name'     => 'required|string',
      'gender'   => 'required|string|in:Pria,Wanita',
      'email'    => 'required|string|unique:users',
      'address'  => 'string|nullable',
      'status'   => 'required|boolean',
    ], $this->messages());
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput($request->all());
    }

    $createUser = Users::firstOrCreate([
      'nip'       => $requestData['nip'],
      'name'      => $requestData['name'],
      'gender'    => $requestData['gender'],
      'email'     => $requestData['email'],
      'address'   => $requestData['address'],
      'is_active' => $requestData['status'],
      'password'  => Hash::make('password'),
    ]);

    return Redirect::to('users')->with('success', 'Berhasil menambahkan user baru');
  }

  public function show($id) {
    $user = Users::where('id', $id)->firstOrFail();
    return view('user.show', ['user'=>$user]);
  }

  public function edit($id) {
    $user = Users::where('id', $id)->firstOrFail();
    return view('user.edit', ['user'=>$user]);
  }

  public function update(Request $request, $id) {
    // Modify input status
    $requestData = $request->all();
    $requestData['status'] = Arr::exists($requestData, 'status') ? true : false;

    $validator = Validator::make($requestData,[
      'nip'      => 'required|numeric|digits_between:10,12|unique:users,nip,'.$id,
      'name'     => 'required|string',
      'gender'   => 'required|string|in:Pria,Wanita',
      'email'    => 'required|string|unique:users,email,'.$id,
      'address'  => 'string|nullable',
      'status'   => 'required|boolean',
    ], $this->messages());
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput($requestData);
    }

    Users::where('id', $id)->update([
      'nip'       => $requestData['nip'],
      'name'      => $requestData['name'],
      'gender'    => $requestData['gender'],
      'email'     => $requestData['email'],
      'address'   => $requestData['address'],
      'is_active' => $requestData['status'],
    ]);
    return Redirect::to('users')->with('success', 'Berhasil memperbaharui data user');
  }

  public function destroy($id) {
    // check user
    $getData = Loans::where('user_id', $id)->count();
    if ($getData !== 0) {
      return Redirect::to('users')->with('error', 'User tidak bisa dihapus karena sudah memiliki riwayat peminjaman.');
    }
    Users::where('id', $id)->delete();
    return Redirect::to('users')->with('success', 'Berhasil menghapus data user');
  }


  // custom error message
  public function messages() {
    return [
      'nip.required'        => 'NIP tidak boleh kosong.',
      'nip.numeric'         => 'NIP harus diisi dengan angka.',
      'nip.digits_between'  => 'NIP harus dengan angka dari 10 sampai 12 digit.',
      'nip.unique'          => 'NIP sudah terdaftar.',
      'name.required'       => 'Nama tidak boleh kosong.',          
      'email.required'      => 'Email tidak boleh kosong.',           
      'email.unique'        => 'Email sudah terdaftar.',           
    ];
  }
}
