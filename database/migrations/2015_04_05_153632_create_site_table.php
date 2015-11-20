<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('site', function(Blueprint $table)
		{
			$table->increments('id');
                        $table->boolean('act');
                        $table->boolean('approved');
                        $table->boolean('block');
                        $table->boolean('system');
                        $table->integer('parent');
                        $table->string('part', 16);
                        $table->string('name');
                        $table->string('path');
                        $table->boolean('autopath');
                        $table->tinyInteger('level');
                        $table->text('preview');
                        $table->text('content');
                        $table->string('title');
                        $table->string('keywords');
                        $table->string('description');
                        $table->string('template');
                        $table->string('template_childs');
                        $table->integer('sort');
                        $table->text('settings');
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
		Schema::drop('site');
	}

}
