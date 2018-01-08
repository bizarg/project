<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateLiveinternetTraffic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('liveinternet', function (Blueprint $table) {
            $table->longText('traffic')->nulleble()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('liveinternet', function (Blueprint $table) {
            $table->string('traffic')->nullable()->change();
        });
    }
}
