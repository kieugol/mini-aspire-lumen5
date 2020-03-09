<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepaymentFrequencyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repayment_frequency', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->integer('value');
            $table->integer('is_active')->default(1)->nullable(true);
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable(true);
            $table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'))->nullable(true);
        });
        
        DB::table("repayment_frequency")->insert([
            [
                'name'  => 'Monthly',
                'value' => 1,
            ],
            [
                'name'  => 'Quarter',
                'value' => 3,
            ], [
                'name'  => 'Year',
                'value' => 12,
            ],
        ]);
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('repayment_frequency');
    }
}
