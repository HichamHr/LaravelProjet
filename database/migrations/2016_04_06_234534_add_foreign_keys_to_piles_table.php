<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('piles', function(Blueprint $table)
		{
			$table->foreign('module_ID', 'piles_foreignKey_Module')->references('numero')->on('modules')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('prof', 'piles_foreignKey_Prof')->references('CIN')->on('prof')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('piles', function(Blueprint $table)
		{
			$table->dropForeign('piles_foreignKey_Module');
			$table->dropForeign('piles_foreignKey_Prof');
		});
	}

}
