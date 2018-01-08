<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFtpStatusRowToConvertFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('convert_files', function (Blueprint $table) {
            $table->smallInteger('ftp_status')->after('status')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('convert_files', function (Blueprint $table) {
            $table->dropColumn('ftp_status');
        });
    }
}
