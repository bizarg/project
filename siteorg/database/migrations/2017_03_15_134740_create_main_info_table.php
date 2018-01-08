<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMainInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('main_info', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('site_id');
            $table->string('title')->nullable();
            $table->string('keywords')->nullable();
            $table->string('description')->nullable();
            $table->string('cms')->nullable();
            $table->text('favicon')->nullable();
            $table->integer('status')->nullable();
            $table->string('server')->nullable();
            $table->string('ip')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('time_zone')->nullable();
            $table->string('css_framework')->nullable();
            $table->string('js_framework')->nullable();
            $table->string('valid_html')->nullable();
            $table->boolean('yandex_metrica')->default(0);
            $table->boolean('google_analytics')->default(0);


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
        Schema::dropIfExists('main_info');

    }
}
