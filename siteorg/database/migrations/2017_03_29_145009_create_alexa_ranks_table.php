<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlexaRanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alexa_ranks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('site_id');
            $table->string('global_rank');
            $table->string('country_rank');
            $table->string('bounce_rate');
            $table->string('daily_ppv');
            $table->string('daily_tos');
            $table->string('sev');
            $table->string('traffic');
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
        Schema::dropIfExists('alexa_ranks');

    }
}
