<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConvertFilesCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('convert_files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid')->nullable();
            $table->string('output_file_name')->nullable();
            $table->smallInteger('status')->unsigned()->nullable();
            $table->mediumInteger('time')->unsigned()->nullable();
            $table->string('output_format', 9)->nullable();
            $table->smallInteger('progress')->unsigned()->nullable();
            $table->integer('file_id')->unsigned()->nullable();
            $table->foreign('file_id')->references('id')->on('files')
                ->onDelete('cascade');
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');
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
        Schema::dropIfExists('convert_files');
    }
}
