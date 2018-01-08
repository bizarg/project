<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFtpSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ftp_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('adr')->nullable();
            $table->string('login')->nullable();
            $table->string('password')->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ftp_settings', function (Blueprint $table) {
            Schema::dropIfExists('ftp_settings');
        });
    }
}
