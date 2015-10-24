<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('menu', function(Blueprint $table)
		{
			$table->increments('id');
                                                $table->boolean('act');
                                                $table->integer('parent');
                                                $table->integer('element_id');
                                                $table->string('module', 16);
                                                $table->string('path');
                                                $table->boolean('autopath');
                                                $table->string('name');
                                                $table->string('preview');
                                                $table->integer('sort');
			$table->timestamps();
                                                $table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('menu');
	}

}
