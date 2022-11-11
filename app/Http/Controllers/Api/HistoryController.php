<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\History;
use JWTAuth;


class HistoryController extends Controller {
  var $ctx = "History.";

  public function getAllHistory() {
    $ctx = $this->ctx."getAllHistory.";

    $user_id = JWTAuth::user()->id;

    try {
      $history = History::select('id', 'type_id', 'type', 'transaction_id', 'amount', 'created_at')
                    ->where('user_id', $user_id)
                    ->orderBy('id', 'DESC')
                    ->get();
    } catch(QueryException $e) {
      logData($ctx."history", $e->getMessage(), 500);
      return responseJson(false, "Internal server error", 500);
    }
    if (count($history) === 0) {
      return responseJson(false, "Data not found", 404);
    }

    return responseDataJson(true, "Data all history", $history, 200);
  }
}
