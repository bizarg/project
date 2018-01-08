<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMainInfoValidHtml extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('main_info', function (Blueprint $table) {
            $table->longText('valid_html')->nulleble()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('main_info', function (Blueprint $table) {
            $table->string('valid_html')->nullable()->change();
        });
    }
}
