<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotationDetailTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Create Quotation Details table
		Schema::create('quotation_details', function ($table) {
            $table->increments("id");
            $table->integer('quotation_id');
            $table->integer('order_product_id');
            $table->integer('price');
            $table->integer('quantity');
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
		//Drop Quotation Details table
		Schema::drop('quotation_details');
	}

}
