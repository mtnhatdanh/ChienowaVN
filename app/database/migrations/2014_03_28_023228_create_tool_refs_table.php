<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateToolRefsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Create tool_refs_table
		Schema::create('tool_refs', function($table){
			$table->increments("id");
            $table->integer("product_ref_id");
            $table->string('item');
            $table->integer('equipment_id');
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
		//Drop tool_refs_table
		Schema::drop('tool_refs');
	}

}
