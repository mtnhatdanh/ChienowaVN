<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInspectionDetailTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Create Inspection_details table
		Schema::create('inspection_details', function ($table) {
            $table->increments("id");
            $table->integer("inspection_id");
            $table->integer('product_ref_id');
            $table->string('value');
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
		//Drop inspection_details table
		Schema::drop('inspection_details');
	}

}
