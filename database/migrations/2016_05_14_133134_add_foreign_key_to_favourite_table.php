<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyToFavouriteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('favourites', function(Blueprint $table)
        {
            $table->foreign('id_etudiant', 'favourite_foreignKey_Etudiant')->references('CIN')->on('etudiant')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('id_pile', 'favourite_foreignKey_Pile')->references('id')->on('piles')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('favourites', function(Blueprint $table)
        {
            $table->dropForeign('favourite_foreignKey_Etudiant');
            $table->dropForeign('favourite_foreignKey_Pile');
        });
    }
}
