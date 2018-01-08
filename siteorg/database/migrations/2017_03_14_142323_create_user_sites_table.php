<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_sites', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('site_id');
            $table->integer('notify_level')->default(1);
            $table->enum('status', ['enabled', 'disabled'])->default('enabled');
            $table->enum('confirm', ['not_confirm', 'file', 'meta'])->default('not_confirm');
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
        Schema::dropIfExists('user_sites');

    }
}
