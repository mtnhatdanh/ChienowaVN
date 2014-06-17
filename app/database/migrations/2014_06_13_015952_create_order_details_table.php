<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Create Order Details table
		Schema::create('order_details', function ($table) {
            $table->increments("id");
            $table->integer('order_id');
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
		//Drop Order Details table
		Schema::drop('order_details');
	}

}
