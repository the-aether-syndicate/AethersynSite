<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctrineFittingTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctrine_fitting', function (Blueprint $table) {
            $table->unsignedInteger('doctrine_id');
            $table->unsignedInteger('fitting_id');
        });
        Schema::create('doctrine', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('fitting', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fitname');
            $table->string('shiptype');
            $table->text('eftfitting');
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
        Schema::dropIfExists('doctrine_fitting_tables');
    }
}
