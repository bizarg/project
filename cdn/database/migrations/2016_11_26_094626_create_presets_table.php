<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePresetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('output_format');
            $table->string('output_resolutions');
            $table->smallInteger('audio_bitrate')->unsigned();
            $table->smallInteger('frame_rate')->unsigned();
            $table->string('resolution');
            $table->string('video_bitrate');
            $table->string('x264_vprofile');
            $table->string('x264_preset');
            $table->smallInteger('keyframe_interval')->unsigned();
            $table->integer('audio_sample_rate')->unsigned();
            $table->tinyInteger('audio_channels')->unsigned();
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
        Schema::dropIfExists('presets');
    }
}
