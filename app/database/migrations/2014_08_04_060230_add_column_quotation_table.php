<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnQuotationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Add project_id column to quotation table
		Schema::table('quotation', function($table)
		{
			// add new columns
		    $table->integer('project_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//Drop project_id columns from quotation table
		Schema::table('quotation', function($table)
		{
			// remove columns
		    $table->dropColumn('project_id');
		});
	}

}
