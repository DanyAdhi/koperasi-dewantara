<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;

use App\Models\Users;
use App\Models\Loans;
use App\Models\Installment;
use Illuminate\Http\Request;
use Carbon\Carbon;


class DashboardController extends Controller{
  
  public function index() {
    $countUser = Users::where('scope', 'user')->count();
    $countUserActive = Users::where('scope', 'user')->where('is_active', true)->count();
    $count_loans = Loans::where('is_paid_off', false)->count();
    $data = [
      'count_user'        => $countUser,
      'count_user_active' => $countUserActive,
      'count_loans'       => $count_loans,
    ];
    return view('dashboard.index', $data);
  }
}
