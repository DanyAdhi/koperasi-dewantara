<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;

use App\Models\Installment;
use App\Models\History;
use App\Models\Loans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class InstallmentController extends Controller {

  public function update_status($id) {
    $getOne = DB::table('installments')
                  ->select('installments.id', 'installments.loan_id', 'loans.user_id', 'loans.installment_amount')
                  ->join('loans', 'loans.id', '=', 'installments.loan_id')
                  ->where('installments.id', $id)
                  ->first();
    $loan_id = $getOne->loan_id;

    Installment::where('id', $id)->update(['is_paid' => true]);

    // Insert data history installments
    History::create([
      'user_id'   => $getOne->user_id,
      'type_id'   => $id,
      'type'      => 'installment',
      'amount'    => $getOne->installment_amount
    ]);

    // check is last installment?
    $latest = Installment::where('loan_id', $loan_id)->latest('id')->first();
    if ($latest->id == $id) {
      Loans::where('id', $loan_id)->update(['is_paid_off' => true]);
    }
    
    return Redirect::to('loans/'.$loan_id)->with('success', 'Angsuran berhasil dibayar');
  }
}
