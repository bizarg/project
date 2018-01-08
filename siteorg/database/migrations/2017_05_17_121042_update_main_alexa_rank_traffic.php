<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMainAlexaRankTraffic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alexa_ranks', function (Blueprint $table) {
            $table->longText('traffic')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alexa_ranks', function (Blueprint $table) {
            $table->string('traffic')->nullable()->change();
        });
    }
}
