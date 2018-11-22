<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassEdusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_edus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');

            $table->integer('stage_edu_id')->unsigned()->nullable();
            $table->foreign('stage_edu_id')->references('id')->on('stage_edus')
                ->onUpdate('cascade')->onDelete('set null');

            $table->integer('egy_edu_system_id')->unsigned()->nullable();
            $table->foreign('egy_edu_system_id')->references('id')->on('egy_edu_systems')
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
        Schema::dropIfExists('class_edus');
    }
}
