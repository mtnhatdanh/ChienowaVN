<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Create project_details table
		Schema::create('project_details', function ($table) {
            $table->increments("id");
            $table->integer("project_id");
            $table->integer("order_product_id");
            $table->smallInteger('status');
            $table->integer('repeat_times');
            $table->integer('sg_quotation_detail_id');
            $table->text('sg_note');
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
		//Drop prject_details table
		Schema::drop('project_details');
	}

}
