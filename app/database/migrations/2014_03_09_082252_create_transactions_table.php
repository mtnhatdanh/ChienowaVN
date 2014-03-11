<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Create transactions table
		Schema::create('transactions', function ($table) {
            $table->increments("id");
            $table->date('date');
            $table->integer('item_id');
            $table->string('type', 1);
            $table->float('amount');
            $table->text('note');
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
		//drop transactions table
		Schema::drop('transactions');
	}

}
