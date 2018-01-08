<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFtpSettingIdRowToConvertFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('convert_files', function (Blueprint $table) {
            $table->integer('ftp_setting_id')->after('user_id')->unsigned()->nullable();
            $table->foreign('ftp_setting_id')->references('id')->on('ftp_settings')
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
        Schema::table('convert_files', function (Blueprint $table) {
            $table->dropForeign('convert_files_ftp_setting_id_foreign');
        });
    }
}
