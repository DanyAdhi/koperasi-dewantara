<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Loans extends Model {
  use HasFactory;

  protected $fillable = [
    'user_id',
    'loan_amount',
    'service_fee',
    'installment_due_date',
    'installment_times',
    'installment_amount',
    'admin',
  ];

}
