<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToReponsesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('reponses', function(Blueprint $table)
		{
			$table->foreign('Question_id', 'reponses_foreignKey_Question')->references('question_ID')->on('questions')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('reponses', function(Blueprint $table)
		{
			$table->dropForeign('reponses_foreignKey_Question');
		});
	}

}
