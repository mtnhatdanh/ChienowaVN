<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPriceUsdColumnToOrderDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Add price_usd column to order_details table
		Schema::table('order_details', function($table)
		{
			// add new columns
		    $table->float('price_usd');
		    $table->float('price_jpy');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//Drop float columns from order_details table
		Schema::table('order_details', function($table)
		{
			// remove columns
		    $table->dropColumn('price_usd');
		    $table->dropColumn('price_jpy');
		});
	}

}
