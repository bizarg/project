<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateVirusRenameRetrive extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('viruses', function (Blueprint $table) {
            $table->renameColumn('retrieve', 'scanning');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('viruses', function (Blueprint $table) {
            $table->renameColumn('scanning', 'retrieve');
        });
    }

}
