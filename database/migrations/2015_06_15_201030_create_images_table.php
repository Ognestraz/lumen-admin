<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('images', function(Blueprint $table)
		{
			$table->increments('id');
                        $table->boolean('act');
                        $table->string('part', 16);
                        $table->string('model', 16);
                        $table->integer('model_id');
                        $table->integer('user_id');
                        $table->string('path');
                        $table->boolean('autopath');
                        $table->string('name');
                        $table->string('description');
                        $table->string('filename');
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
		Schema::drop('images');
	}

}
