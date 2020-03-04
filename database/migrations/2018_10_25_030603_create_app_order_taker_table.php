<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppOrderTakerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_order_taker', function (Blueprint $table) {
            $table->increments('id');
            $table->string('version', 50)->nullable(false);
            $table->text('base_url')->nullable(false);
            $table->text('file_name')->nullable(false);
            $table->text('description');
            $table->tinyInteger('is_active')->default('1')->nullable(true);
            $table->integer('created_by')->default('0')->nullable(true);
            $table->dateTime('created_date')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable(true);
            $table->integer('updated_by')->default('0')->nullable(true);
            $table->dateTime('updated_date')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
