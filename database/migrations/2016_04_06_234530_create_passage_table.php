<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePassageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('passage', function(Blueprint $table)
		{
			$table->integer('exam_ID');
			$table->integer('Question')->index('Question_pass');
			$table->integer('Rep')->index('Reponse_pass');
			$table->primary(['exam_ID','Question','Rep']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('passage');
	}

}
