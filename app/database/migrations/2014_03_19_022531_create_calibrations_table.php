<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalibrationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Create calibrations table
		Schema::create('calibrations', function ($table) {
            $table->increments("id");
            $table->integer("report_id");
            $table->integer("equipment_id");
            $table->string("before_inspection");
            $table->string("after_inpsection");
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
		//Dropt calibrations table
		Schema::drop('calibrations');
	}

}
