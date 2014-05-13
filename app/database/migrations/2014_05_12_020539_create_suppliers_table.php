<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuppliersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//create Suppliers table
		Schema::create('suppliers', function ($table) {
            $table->increments("id");
            $table->string("name");
            $table->string("address");
            $table->string("email");
            $table->string("phone");
            $table->string("representative");
            $table->string("mobile");
            $table->string("website");
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
		//Drop Suppliers table
		Schema::drop('suppliers');
	}

}
