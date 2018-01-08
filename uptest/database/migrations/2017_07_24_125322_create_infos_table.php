<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('infos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('site_id')->unsigned();
            $table->integer('node_id')->unsigned();;
            $table->decimal('speed_bps', 20, 5);
            $table->bigInteger('size');
            $table->bigInteger('time');
            $table->integer('code');
            $table->string('message');
            $table->string('error')->nullable();
            
            $table->string('ip');
            $table->timestamps();

            $table->index(['site_id', 'node_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('infos');
    }
}
