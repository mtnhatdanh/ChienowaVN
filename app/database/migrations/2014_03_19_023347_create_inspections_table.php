<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInspectionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Create Inspections Table
		Schema::create('inspections', function ($table) {
            $table->increments("id");
            $table->integer("report_id");
            $table->integer("user_id");
            $table->integer("amount");
            $table->boolean("quality");
            $table->text("description");
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
		//Drop Inspections table
		Schema::drop('inspections');
	}

}
