<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Create users table
		Schema::create('users', function ($table) {
            $table->increments("id");
            $table->string("username");
            $table->string("password");
            $table->string("name");
            $table->integer("position_id");
            $table->string("mobile");
            $table->string("email");
            $table->string("address");
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
		//drop users table
		Schema::drop('users');
	}

}
