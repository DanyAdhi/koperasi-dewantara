<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Loans;
use JWTAuth;


class LoanController extends Controller {
  var $ctx = "Loans.";
  
  public function getTotalLoans() {
    $ctx = $this->ctx."getTotalLoans.";

    $user_id = JWTAuth::user()->id;

    //Get pinjaman yang belum lunas dan angsuran yang belum lunas
    $get_loans = Loans::select('user_id', 'is_paid_off', 'installment_amount', 'installments.loan_id', DB::raw('count(installments.id) as jumlah'))
                  ->where('user_id', $user_id)
                  ->where('is_paid_off', false)
                  ->join('installments', 'installments.loan_id', '=', 'loans.id')
                  ->where('installments.is_paid', false)
                  ->groupBy('installments.loan_id')
                  ->get();
    $total = 0;
    foreach ($get_loans as $value) {
      $total += $value['installment_amount'] * $value['jumlah'];
    }
    
    $data = ['total' => $total];
    return responseDataJson(true, "Total user loan", $data, 200); 
  }

  public function getAllLoans(Request $request) {
    $ctx = $this->ctx."getAllLoans.";
    
    $user_id = JWTAuth::user()->id;
    $page = (int)$request->query('page', 1);
    $limit = (int)$request->query('limit', 10);

    $skip = 0;
    if($page > 1) {
      $skip = ($page - 1) * $limit;
    }

    try {
      $loans = Loans::select('id', 'transaction_id', 'user_id', 'loan_amount', 'is_paid_off', 'created_at')
                    ->where('user_id', $user_id)
                    ->latest()
                    ->get();
    } catch(QueryException $e) {
      logData($ctx."loans", $e->getMessage(), 500);
      return responseJson(false, "Internal server error", 500);
    }
    if (count($loans) === 0) {
      return responseJson(false, "Data not found", 404);
    }

    return responseDataJson(true, "Data all loan", $loans, 200);
  }

  public function getOneLoans($id) {
    $ctx = $this->ctx."getOneLoans.";

    try {
      $loans = Loans::select('id', 'transaction_id', 'user_id', 'loan_amount', 'installment_times', 'installment_amount', 'is_paid_off', 'created_at')
                    ->where('id', $id)
                    ->first();
    } catch(QueryException $e) {
      logData($ctx."loans", $e->getMessage(), 500);
      return responseJson(false, "Internal server error", 500);
    }
    if ($loans === null) {
      return responseJson(false, "Data not found", 404);
    }

    return responseDataJson(true, "Detail data loan", $loans, 200); 
  }
}
