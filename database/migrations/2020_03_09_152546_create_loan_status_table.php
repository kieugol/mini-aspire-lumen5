<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanStatusTable extends Migration
{
    protected $fillable = [
        'user_id',
        'loan_status_id',
        'repayment_frequency_id',
        'start_date',
        'end_date',
        'term',
        'amount',
        'interest_rate',
        'payment_amount',
        'interest_amount',
        'remarks',
        'created_by',
        'updated_by'
    ];
    
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_status', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->integer('is_active')->default(1)->nullable(true);
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable(true);
            $table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'))->nullable(true);
        });
        
        DB::table("loan_status")->insert([
            [
                'id'   => LOAN_STATUS_NEW,
                'name' => 'New',
            ],
            [
                'id'   => LOAN_STATUS_PAYING,
                'name' => 'Paying',
            ],
            [
                'id'   => LOAN_STATUS_PAID,
                'name' => 'Paid',
            ]
        ]);
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('loan_status');
    }
}
