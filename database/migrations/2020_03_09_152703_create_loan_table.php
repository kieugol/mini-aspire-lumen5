<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->smallInteger('loan_status_id');
            $table->smallInteger('repayment_frequency_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('term');
            $table->double('amount', 8, 0);
            $table->double('interest_rate', 8, 0);
            $table->double('payment_amount', 8, 0)->default(0)->nullable(true);
            $table->double('interest_amount', 8, 0)->default(0)->nullable(true);
            $table->string('remarks', 500);
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
        Schema::drop('loan');
    }
}
