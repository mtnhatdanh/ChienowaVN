<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdjustReportTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Adjust daily_reports table structure
		Schema::table('daily_reports', function($table)
		{
			// Delete old columns
			$table->dropColumn('equipment', 'rs_worker', 'molding', 'slight_stop', 'metal_mold', 'method', 'materials', 'other', 'material_grade', 'material_color', 'material_lot_no');


			// add new columns
		    $table->string('part_no');
		    $table->string('part_name');
		    $table->string('lot_no');
		    $table->date('delivery_date');
		    $table->integer('sample_qty');
		    $table->integer('total_qty');
		    $table->integer('inspection_qty');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
