<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsAttTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Create item_atts Table
		Schema::create('item_atts', function($table){
			$table->integer("item_id");
            $table->integer("attribute_id");
            $table->primary(array('item_id','attribute_id'));
            $table->string("value");
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
		//Drop item_atts table
		Schema::drop('item_atts');
	}

}
