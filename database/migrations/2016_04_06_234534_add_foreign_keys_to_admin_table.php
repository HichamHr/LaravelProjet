<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAdminTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('admin', function(Blueprint $table)
		{
			$table->foreign('compte', 'admin_foreignKey_Compt')->references('id')->on('comptes')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('admin', function(Blueprint $table)
		{
			$table->dropForeign('admin_foreignKey_Compt');
		});
	}

}
