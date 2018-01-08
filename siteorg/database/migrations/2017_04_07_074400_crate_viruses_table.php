<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrateVirusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('viruses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('site_id');
            $table->string('scan_id')->nulleble();
            $table->integer('vir_count')->default(-1);
            $table->boolean('retrieve')->default(0);
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
        Schema::dropIfExists('viruses');
    }
}
