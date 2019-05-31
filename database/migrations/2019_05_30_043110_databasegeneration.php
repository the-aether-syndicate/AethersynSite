<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Databasegeneration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('doctrine', function (Blueprint $table) {
            $table->integer('id');
            $table->string('name');
            $table->timestamps();
        });
        //'id', 'shiptype','fitname','eftfitting'
        Schema::create('fitting', function (Blueprint $table) {
            $table->integer('id');
            $table->integer('shiptype');
            $table->string('fitname');
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
        //
        Schema::dropIfExists('doctrine');
        Schema::dropIfExists('fitting');
    }
}
