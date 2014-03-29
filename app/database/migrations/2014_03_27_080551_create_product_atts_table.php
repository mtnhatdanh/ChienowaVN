<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductAttsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Create product_atts table
		Schema::create('product_atts', function ($table) {
            $table->increments("id");
            $table->string("name");
            $table->string("type");
            $table->integer("order_no");
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
		//Drop product_atts table
		Schema::drop('product_atts');
	}

}
