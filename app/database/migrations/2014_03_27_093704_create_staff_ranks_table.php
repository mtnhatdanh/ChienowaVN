<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffRanksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Create staff_ranks table
		Schema::create('staff_ranks', function ($table) {
            $table->increments("id");
            $table->integer("user_id")->unique();
            $table->string('skill_rank');
            $table->string('description');
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
		//Drop table
		Schema::drop('staff_ranks');
	}

}
