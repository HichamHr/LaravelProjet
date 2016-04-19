<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToModulesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('modules', function(Blueprint $table)
		{
			$table->foreign('specialite', 'modules_foreignKey_Specialite')->references('id')->on('specialite')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('modules', function(Blueprint $table)
		{
			$table->dropForeign('modules_foreignKey_Specialite');
		});
	}

}
