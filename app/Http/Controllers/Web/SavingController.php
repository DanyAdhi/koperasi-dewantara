<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;


use App\Models\Saving;
use App\Models\Users;
use App\Models\SavingType;
use App\Models\History;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SavingController extends Controller {

    public function index() {
        $savings = DB::table('savings')
                ->select('savings.id', 'savings.savings_amount', 'savings.created_at', 'saving_types.name as saving_category', 'users.nip', 'users.name')
                ->leftJoin('users', 'users.id', '=', 'savings.user_id')
                ->leftJoin('saving_types', 'saving_types.id', '=', 'savings.category_id')
                ->orderBy('savings.id', 'DESC')
                ->get();
        return view('saving.index', ['savings' => $savings]);
    }

    public function create() {
        $users = Users::where([ ['scope', '=','User'], ['is_active', '=', '1'], ])->orderBy('id', 'DESC')->get();
        $types = SavingType::get();

        return view('saving.create', ['users' => $users, 'types' => $types]);
    }

    public function store(Request $request) {
        $requestData = $request->all();

        $requestData['savings_amount'] = str_replace('.','', $requestData['savings_amount']);
        $validator = Validator::make($requestData,[
        'user_id'               => 'required|integer',
        'savings_amount'        => 'required|integer|gt:0',
        'category_id'           => 'required|integer',
        ], $this->messages());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $createSaving = Saving::create([
            'user_id'               => $requestData['user_id'],
            'savings_amount'        => $requestData['savings_amount'],
            'category_id'           => $requestData['category_id'],
            'transaction_id'        => 0
        ]);

        // set transaction id
        $now = Carbon::now()->format('Ymd');
        $transaction_id = 'TRX-'.$now.'SV'.$requestData['user_id']. str_pad($createSaving->id, 7, "0", STR_PAD_LEFT);
        Saving::where('id', $createSaving->id)->update(['transaction_id' => $transaction_id]);

        // Insert data history loan
        History::create([
            'user_id'         => $requestData['user_id'],
            'type_id'         => $createSaving->id,
            'type'            => 'saving',
            'transaction_id'  => $transaction_id,
            'amount'          => $requestData['savings_amount']
        ]);

        return Redirect::to('savings')->with('success', 'Berhasil menyimpan data tabungan');

    }

    public function show(Saving $saving) {
        //
    }


    // custom error message
  public function messages() {
    return [
      'user_id.required'              => 'User tidak boleh kosong.',
      'user_id.integer'               => 'Input user tidak valid.',
      'savings_amount.required'       => 'Jumlah tabungan tidak boleh kosong.',
      'savings_amount.integer'        => 'Input jumlah tabungan tidak valid.',
      'savings_amount.gt'             => 'Jumlah tabungan harus lebih besari dari 0',
      'category_id.required'          => 'Kategori tidak boleh kosong.',
      'category_id.integer'           => 'Input kategori tidak valid.',
    ];
  }
    
}
