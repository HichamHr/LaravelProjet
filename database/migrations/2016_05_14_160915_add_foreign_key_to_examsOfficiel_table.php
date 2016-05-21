<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyToExamsOfficielTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::table('examsOfficiel', function(Blueprint $table)
        {
            $table->foreign('id_pile', 'exam_foreignKey_Pile')->references('id')->on('piles')->onUpdate('CASCADE')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('examsOfficiel', function(Blueprint $table)
        {
            $table->dropForeign('exam_foreignKey_Pile');
        });
    }
}
