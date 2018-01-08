<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nodes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('gs_id')->unsigned();
            $table->string('name');
            $table->string('ip');
            $table->integer('port');
            $table->string('country');
            $table->string('city');
            $table->string('dc');
            $table->string('aiso');
            $table->enum('status', ['active', 'inactive']);;
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
        Schema::drop('nodes');
    }
}
