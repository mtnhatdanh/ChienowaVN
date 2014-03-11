<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatAttRefTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Create Reference table
		Schema::create('references', function($table){
            $table->integer("category_id");
            $table->integer("attribute_id");
            $table->primary(array('category_id','attribute_id'));
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
		//Drop Reference Table
		Schema::drop('references');
	}

}
