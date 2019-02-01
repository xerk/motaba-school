<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSemstersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('semsters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');

            $table->integer('school_year_id')->unsigned()->nullable();
            $table->foreign('school_year_id')->references('id')->on('school_years')
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
        Schema::dropIfExists('semsters');
    }
}
