<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTaskConfs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function ($table) {
            $table->boolean('css')->default(0);
            $table->boolean('js')->default(0);;
            $table->boolean('img')->default(0);;

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function ($table) {
            $table->dropColumn('css');
            $table->dropColumn('js');
            $table->dropColumn('img');
        });
    }
}
