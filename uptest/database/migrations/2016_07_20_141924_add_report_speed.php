<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReportSpeed extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reports', function ($table) {
            $table->integer('speed_upload');
            $table->double('speed_download',5,5 );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reports', function ($table) {
            $table->dropColumn('speed_upload');
            $table->dropColumn('speed_download');
        });
    }
}
