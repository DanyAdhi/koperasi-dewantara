<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;

use App\Models\Loans;
use App\Models\Installment;
use App\Models\History;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;


class LoansController extends Controller {

  public function index() {

    $loans = DB::table('loans')
                ->select('loans.id', 'loans.loan_amount', 'loans.is_paid_off', 'users.nip', 'users.name')
                ->leftJoin('users', 'users.id', '=', 'loans.user_id')
                ->get();
    return view('loan.index', ['loans' => $loans]);
  }

  public function create() {
    $users = Users::where([ ['scope', '=','User'], ['is_active', '=', '1'], ])->orderBy('id', 'DESC')->get();

    return view('loan.create', ['users' => $users]);
  }

  public function store(Request $request) {
    $requestData = $request->all();

    $requestData['loan_amount'] = str_replace('.','', $requestData['loan_amount']);
    $requestData['admin']       = str_replace('.','', $requestData['admin']);
    $validator = Validator::make($requestData,[
      'user_id'               => 'required|integer',
      'loan_amount'           => 'required|integer',
      'loan_interest'         => 'required|integer|min:0|max:100',
      'installment_times'     => 'required|integer|min:10|max:60',
      'admin'                 => 'required|integer',
    ], $this->messages());

    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput($request->all());
    }
    
    // Insert data loan
    $angsuran = $this->perhitunganAnsuran($requestData['loan_amount'], $requestData['admin'], $requestData['loan_interest'], $requestData['installment_times']);
    $createLoan = Loans::create([
      'user_id'               => $requestData['user_id'],
      'loan_amount'           => $requestData['loan_amount'],
      'loan_interest'         => $requestData['loan_interest'],
      'installment_times'     => $requestData['installment_times'],
      'installment_amount'    => $angsuran,
      'admin'                 => $requestData['admin'],
      'transaction_id'        => 0
    ]);

    // set transaction id
    $now = Carbon::now()->format('Ymd');
    $transaction_id = 'TRX-'.$now.'LN'.$requestData['user_id']. str_pad($createLoan->id, 7, "0", STR_PAD_LEFT);
    Loans::where('id', $createLoan->id)->update(['transaction_id' => $transaction_id]);

    // Insert data history loan
    History::create([
      'user_id'         => $requestData['user_id'],
      'type_id'         => $createLoan->id,
      'type'            => 'loan',
      'transaction_id'  => $transaction_id,
      'amount'          => $requestData['loan_amount']
    ]);

    // Insert data Installment
    for ($i=1; $i <= $requestData['installment_times']; $i++) { 
      $date = Carbon::now()->addMonths($i)->endOfMonth()->format('d-m-Y');
      $due_date = Carbon::parse($date);
      Installment::create([
        'loan_id'     => $createLoan->id,
        'due_date'    => $due_date,
        'is_paid'     => 0
      ]);
    }

    return Redirect::to('loans')->with('success', 'Berhasil menyimpan data pinjaman');
  }

  public function show($id) {
    $loan = DB::table('loans')
                ->select('loans.*', 'users.nip', 'users.name')
                ->join('users', 'users.id', '=', 'loans.user_id')
                ->where('loans.id', $id)
                ->get();
    $installment = DB::table('installments')
                        ->select('installments.*')
                        ->where('installments.loan_id', $id)
                        ->get()
                        ->all();
    $data = [
      'loan' => $loan[0],
      'installment' => $installment
    ];
    return view('loan.show', $data);
  }

  private function perhitunganAnsuran($jumlah, $biaya_admin, $bunga, $kali_angsuran) {
    $data = [$jumlah, $biaya_admin, $bunga, $kali_angsuran];
   
    // perhitungan bunga
    $jumlah_bunga = ($jumlah / 100) * $bunga;

    $angsuran = ($jumlah + $jumlah_bunga + $biaya_admin) / $kali_angsuran;    

    // pembulatan 100 rupiah
    $sub = substr($angsuran, -2);
    if ($sub == 00) {
    	$result =  $angsuran;
    } elseif ($sub > 49) {
    	$result =  round($angsuran, -2);
    } else {
    	 $result = round($angsuran, -2) + 100;
    }
   
    return $result;
  }

  // custom error message
  public function messages() {
    return [
      'user_id.required'              => 'User tidak boleh kosong.',
      'user_id.integer'               => 'Input user tidak valid.',
      'loan_amount.required'          => 'Julah pinjaman tidak boleh kosong.',
      'loan_amount.integer'           => 'Input jumlah pinjaman tidak valid.',
      'loan_interest.required'        => 'Bunga tidak boleh kosong.',
      'loan_interest.integer'         => 'Input bunga tidak valid.',
      'installment_times.min'         => 'Bunga pinjaman minmal 0 persen.',
      'installment_times.max'         => 'Bunga pinjaman maksimal 100 persen.',
      'installment_times.required'    => 'Kali angsuran tidak boleh kosong.',
      'installment_times.integer'     => 'Input kali angsuran tidak valid.',
      'installment_times.min'         => 'Kali angsuran minmal 10 bulan.',
      'installment_times.max'         => 'Kali angsuran maksimal 60 bulan.',
      'admin.required'                => 'Biaya admin tidak boleh kosong.',
      'admin.integer'                 => 'Input biaya admin tidak valid.',
    ];
  }

}
