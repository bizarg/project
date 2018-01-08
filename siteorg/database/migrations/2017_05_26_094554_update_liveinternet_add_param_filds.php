<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateLiveinternetAddParamFilds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('liveinternet', function (Blueprint $table) {
            $table->integer('li_month_hit')->nullable();
            $table->integer('li_month_vis')->nullable();
            $table->integer('li_week_hit')->nullable();
            $table->integer('li_week_vis')->nullable();
            $table->integer('li_day_hit')->nullable();
            $table->integer('li_day_vis')->nullable();
            $table->integer('li_today_hit')->nullable();
            $table->integer('li_today_vis')->nullable();
            $table->integer('li_online_hit')->nullable();
            $table->integer('li_online_vis')->nullable();
            $table->string('li_error')->nullable();

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
            $table->dropColumn('li_month_hit');
            $table->dropColumn('li_month_vis');
            $table->dropColumn('li_week_hit');
            $table->dropColumn('li_week_vis');
            $table->dropColumn('li_day_hit');
            $table->dropColumn('li_day_vis');
            $table->dropColumn('li_today_hit');
            $table->dropColumn('li_today_vis');
            $table->dropColumn('li_online_hit');
            $table->dropColumn('li_online_vis');
            $table->dropColumn('li_error');

        });
    }
}
