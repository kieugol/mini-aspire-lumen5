<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_payment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('loan_id');
            $table->date('due_date');
            $table->double('amount', 8, 0);
            $table->double('principal_amount', 8, 0);
            $table->double('interest_amount', 8, 0);
            $table->double('balance', 8, 0);
            $table->string('remarks', 500);
            $table->integer('is_active')->default(0)->nullable(true);
            $table->integer('created_by')->default(0)->nullable(true);
            $table->integer('updated_by')->default(0)->nullable(true);
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable(true);
            $table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'))->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('loan_payment');
    }
}
