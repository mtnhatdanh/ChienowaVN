<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//create Requests table
		Schema::create('requests', function ($table) {
            $table->increments("id");
            $table->integer('user_id');
            $table->integer('incharge_staff_id');
            $table->date('date');
            $table->string('request_content');
            $table->date('due_date');
            $table->text("note");
            $table->smallInteger('status');
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
		//Drop Requests table
		Schema::drop('requests');
	}

}
