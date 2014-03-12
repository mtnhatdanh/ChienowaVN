<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpensesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Create expenses table
		Schema::create('expenses', function ($table) {
            $table->increments("id");
            $table->date('date');
            $table->integer('user_id');
            $table->bigInteger('amount');
            $table->smallInteger('status');
            $table->text('description');
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
		//drop expenses table
		Schema::drop('expenses');
	}

}
