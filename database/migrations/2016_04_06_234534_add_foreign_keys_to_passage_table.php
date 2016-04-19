<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPassageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('passage', function(Blueprint $table)
		{
			$table->foreign('Question', 'passage_foreignKey_Question')->references('question_ID')->on('questions')->onUpdate('CASCADE')->onDelete('RESTRICT');
			$table->foreign('Rep', 'passage_foreignKey_Reponse')->references('id')->on('reponses')->onUpdate('CASCADE')->onDelete('RESTRICT');
			$table->foreign('exam_ID', 'passage_foreignKey_Exam')->references('id')->on('exams')->onUpdate('CASCADE')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('passage', function(Blueprint $table)
		{
			$table->dropForeign('passage_foreignKey_Question');
			$table->dropForeign('passage_foreignKey_Reponse');
			$table->dropForeign('passage_foreignKey_Exam');
		});
	}

}
