<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->string('email', 255);
            $table->string('phone', 20);
            $table->date('birthday');
            $table->string('address', 500);
            $table->integer('is_active')->default(1)->nullable(true);
            $table->integer('is_delete')->default(0)->nullable(true);
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
        Schema::drop('user');
    }
}
