<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReportParams extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        Schema::table('reports', function ($table) {
            $table->bigInteger('upload_time')->length(15);
            $table->bigInteger('download_time')->length(15);
            $table->bigInteger('traff_download')->length(15);
            $table->bigInteger('traff_upload')->length(15);
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
            $table->dropColumn('upload_time');
            $table->dropColumn('download_time');
            $table->dropColumn('traff_download');
            $table->dropColumn('traff_upload');
        });
    }
}
