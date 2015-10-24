<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlockTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('block', function(Blueprint $table)
		{
			$table->increments('id');
                                                $table->boolean('act');
                                                $table->integer('parent');
                                                $table->string('path');
                                                $table->boolean('autopath');                                                
                                                $table->string('part', 16);
                                                $table->string('name');
                                                $table->text('content');
                                                $table->string('title');
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
		Schema::drop('block');
	}

}
