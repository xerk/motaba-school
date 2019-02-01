<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialMediaSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social_media_schools', function (Blueprint $table) {
            $table->increments('id');
            $table->string('link');

            $table->integer('social_id')->unsigned()->nullable();
            $table->foreign('social_id')->references('id')->on('social_media')
                ->onUpdate('cascade')->onDelete('set null');

            $table->integer('school_config_id')->unsigned()->nullable();
            $table->foreign('school_config_id')->references('id')->on('school_configs')
                ->onUpdate('cascade')->onDelete('set null');

            $table->timestamps();

            // $table->engine = 'InnoDB';
            // $table->charset = 'utf8';
            // $table->collation = 'utf8_unicode_ci';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('social_media_schools');
    }
}
