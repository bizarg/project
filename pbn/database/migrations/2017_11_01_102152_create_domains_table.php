<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('domains', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('ip_id')->unsigned()->index();
            $table->integer('ns1_id')->unsigned()->index();
            $table->integer('ns2_id')->unsigned()->index();
            $table->integer('build_id')->unsigned()->index();

            $table->foreign('ip_id')->references('id')->on('servers');
            $table->foreign('ns1_id')->references('id')->on('n_s');
            $table->foreign('ns2_id')->references('id')->on('n_s');
            $table->foreign('build_id')->references('id')->on('builds');

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
        Schema::dropIfExists('domains');
    }
}
