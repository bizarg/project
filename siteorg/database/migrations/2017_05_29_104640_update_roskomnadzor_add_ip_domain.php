<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRoskomnadzorAddIpDomain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('roskomnadzor', function (Blueprint $table) {
            $table->string('ip')->nullable();
            $table->string('domain')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('roskomnadzor', function (Blueprint $table) {
            $table->dropColumn('ip');
            $table->dropColumn('domain');
        });
    }
}
