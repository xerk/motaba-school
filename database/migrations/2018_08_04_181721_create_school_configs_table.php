<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_configs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('school_name');

            $table->integer('edu_system_id')->unsigned()->nullable();
            $table->foreign('edu_system_id')->references('id')->on('edu_systems')
                ->onUpdate('cascade')->onDelete('set null');

            $table->integer('government_id')->unsigned()->nullable();
            $table->foreign('government_id')->references('id')->on('governments')
                ->onUpdate('cascade')->onDelete('set null');

            $table->integer('edu_manag_id')->unsigned()->nullable();
            $table->foreign('edu_manag_id')->references('id')->on('edu_manags')
                ->onUpdate('cascade')->onDelete('set null');

            $table->string('address')->nullable();
            $table->string('school_manager')->nullable();
            $table->string('follow_manager')->nullable();
            $table->string('website')->nullable();
            $table->string('license_number')->nullable();
            $table->string('school_logo')->nullable();
            $table->string('school_cover')->nullable();
            $table->text('footer')->nullable();

            $table->timestamps();

            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('school_configs');
    }
}
