<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('domain_id')->unsigned()->index();
            /**основной запрос*/
            $table->string('main_url');
            /**урлы ресурсов, массив в json*/
            $table->text('res_urls');
            $table->enum('status', ['new', 'inprogress', 'finished', 'error'])->default('new');
            $table->foreign('domain_id')->references('id')->on('domains')->onDelete('cascade');
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
        Schema::drop('tasks');
    }
}
