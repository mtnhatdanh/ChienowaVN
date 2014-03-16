<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeasuringEquipmentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Create Mesuring_equipment_table
		Schema::create('measuring_equipments', function ($table) {
            $table->increments("id");
            $table->string("name")->unique();
            $table->string("description");
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
		//drop meassuring_equipments table
		Schema::drop('measuring_equipments');
	}

}
