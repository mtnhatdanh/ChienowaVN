<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Create projects table
		Schema::create('projects', function ($table) {
            $table->increments("id");
            $table->string('name');
            $table->text("note");
            $table->smallInteger('status');
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
		//Drop projects table
		Schema::drop('projects');
	}

}
