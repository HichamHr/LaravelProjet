<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToExamsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('exams', function(Blueprint $table)
		{
			$table->foreign('etudiant', 'exams_foreignKey_Etudiant')->references('CIN')->on('etudiant')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('Pile', 'exams_foreignKey_Pile')->references('id')->on('piles')->onUpdate('CASCADE')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('exams', function(Blueprint $table)
		{
			$table->dropForeign('exams_foreignKey_Etudiant');
			$table->dropForeign('exams_foreignKey_Pile');
		});
	}

}
