<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->default(0);
            $table->integer('user_id');
            $table->decimal('loan_amount', 9, 0); //jumlah pinjaman
            $table->decimal('loan_interest', 9, 0); //bunga pinjaman
            $table->integer('installment_times'); //kali angsuran
            $table->decimal('installment_amount', 9, 0); //jumlah angsuran
            $table->boolean('is_paid_off')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loans');
    }
}
