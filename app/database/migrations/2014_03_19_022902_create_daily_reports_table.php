<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDailyReportsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Create Daily_reports table
		Schema::create('daily_reports', function ($table) {
            $table->increments("id");
            $table->integer("product_id");
            $table->date("date");
            $table->boolean('judgement');
            $table->string('app_staff_id');
            $table->string('measurement_staff_id');
            $table->string('equipment');
            $table->string('rs_worker');
            $table->string('molding');
            $table->string('slight_stop');
            $table->string('metal_mold');
            $table->string('method');
            $table->string('materials');
            $table->string('other');
            $table->string('material_grade');
            $table->string('material_color');
            $table->string('material_lot_no');
            $table->boolean('judgement_grade');
            $table->boolean('judgement_color');
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
		//Drop Daily_reports table
		Schema::drop('daily_reports');
	}

}
