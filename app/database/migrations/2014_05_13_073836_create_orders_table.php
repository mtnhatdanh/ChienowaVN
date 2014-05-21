<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//create Orders table
		Schema::create('orders', function ($table) {
            $table->increments("id");
            $table->integer('user_id');
            $table->date('date');
            $table->integer('supplier_id');
            $table->string('order_product');
            $table->string('order_value');
            $table->date('due_date');
            $table->date('delivery_date');
            $table->smallInteger('status');
            $table->text("note");
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
		//drop Supplier table
		Schema::drop('orders');
	}

}
