<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEduManagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edu_manags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');

            $table->integer('government_id')->unsigned()->nullable();
            $table->foreign('government_id')->references('id')->on('governments')
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
        Schema::dropIfExists('edu_manags');
    }
}
