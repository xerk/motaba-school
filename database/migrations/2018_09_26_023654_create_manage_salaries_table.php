<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManageSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manage_salaries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')
            ->onUpdate('cascade')->onDelete('set null');
            
            $table->integer('salary_id')->unsigned()->nullable();
            $table->foreign('salary_id')->references('id')->on('salaries')
            ->onUpdate('cascade')->onDelete('set null');
            
            $table->integer('hourly_salary_id')->unsigned()->nullable();
            $table->foreign('hourly_salary_id')->references('id')->on('hourly_salaries')
            ->onUpdate('cascade')->onDelete('set null');
            
            $table->integer('type');
                
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
        Schema::dropIfExists('manage_salaries');
    }
}
