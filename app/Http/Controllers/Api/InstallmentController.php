<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Installment;


class InstallmentController extends Controller {
  var $ctx = "Installment.";

  public function getAllInstallment($loan_id) {
    $ctx = $this->ctx."getAllInstallment.";

    try {
      $installment = Installment::select('id', 'loan_id', 'due_date', 'is_paid', 'created_at', 'updated_at')
                    ->where('loan_id', $loan_id)
                    ->orderBy('id', 'DESC')
                    ->get();
    } catch(QueryException $e) {
      logData($ctx."installment", $e->getMessage(), 500);
      return responseJson(false, "Internal server error", 500);
    }
    if (count($installment) === 0) {
      return responseJson(false, "Data not found", 404);
    }

    return responseDataJson(true, "Data all installment", $installment, 200);
  }

  public function getRemainingInstallment($loan_id) {
    $ctx = $this->ctx."getRemainingInstallment.";

    try {
      $remainingInstallment = Installment::where('loan_id', $loan_id)
                                          ->where('is_paid', 0)
                                          ->count();
    } catch(QueryException $e) {
      logData($ctx."remainingInstallment", $e->getMessage(), 500);
      return responseJson(false, "Internal server error", 500);
    }
    $data = ['remaining' => $remainingInstallment ];
    return responseDataJson(true, "Data all installment", $data, 200);
  }
}
