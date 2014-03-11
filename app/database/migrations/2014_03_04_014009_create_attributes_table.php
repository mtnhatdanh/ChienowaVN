<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Create attributes Table
		Schema::create('attributes', function($table){
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
		//Drop attributes Table
		Schema::drop('attributes');
	}

}
