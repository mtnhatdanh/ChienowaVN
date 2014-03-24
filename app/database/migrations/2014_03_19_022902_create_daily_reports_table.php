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
		//Drop Daily_reports table
		Schema::drop('daily_reports');
	}

}
