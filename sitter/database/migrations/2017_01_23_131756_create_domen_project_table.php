<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDomenProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * 
     */
    public function up()
    {
        Schema::create('domen_project', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('project_id')->unsigned();
            $table->foreign('project_id')->references('id')->on('projects');

            $table->integer('domen_id')->unsigned();
            $table->foreign('domen_id')->references('id')->on('domens');

            $table->integer('priority')->unsigned()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('domen_project');
    }
}
