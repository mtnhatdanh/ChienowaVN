<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductRefsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Create product_refs table
		Schema::create('product_refs', function($table){
			$table->increments("id");
            $table->integer("product_id");
            $table->integer("product_att_id");
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
		//Drop product_refs table
		Schema::drop('product_refs');
	}

}
