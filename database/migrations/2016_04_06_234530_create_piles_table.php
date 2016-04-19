<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('piles', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('Description');
			$table->integer('duree');
			$table->integer('Max_Score')->default(1000);
			$table->integer('valide_Score')->default(700);
			$table->integer('module_ID')->index('module');
			$table->string('prof', 10)->index('prof');
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
		Schema::drop('piles');
	}

}
