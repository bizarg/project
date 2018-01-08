<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTaskIntensity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function ($table) {
            $table->integer('intensity');
            $table->integer('intensity_step');
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
            $table->dropColumn('intensity');
            $table->dropColumn('intensity_step');
        });
    }
}
