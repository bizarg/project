<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->increments('id');
            /**id задачи  */
            $table->integer('task_id')->unsigned()->index();
            /**пользователей сгенерированно*/
            $table->integer('users_send')->unsigned();
            /**получено ответов пользователей */
            $table->integer('users_request')->unsigned();
            /**всего запросов сгенерировано */
            $table->integer('all_request')->unsigned();
            /**среднее время выполнениния загрузки для пользователя*/
            $table->bigInteger('work_time')->length(15);
            /**коды ответов, масси в json*/
            $table->text('codes_requests');
            $table->timestamps();
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('reports');
    }
}
