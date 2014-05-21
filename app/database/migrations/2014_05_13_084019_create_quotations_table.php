<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//create Quotations table
		Schema::create('quotation', function ($table) {
            $table->increments("id");
            $table->integer('user_id');
            $table->date('date');
            $table->integer('supplier_id');
            $table->string('product');
            $table->string('price');
            $table->date('due_date');
            $table->smallInteger('status');
            $table->text("note");
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
		//Drop Quotations table
		Schema::drop('quotations');
	}

}
