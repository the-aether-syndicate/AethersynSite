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
        Schema::create('user', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->string('name');
            $table->boolean('active');
            $table->rememberToken();
            $table->timestamps();
        });
        Schema::create('role', function (Blueprint $table) {
            $table->increments('id')->primary();
            $table->string('name');
            $table->string('description');
            $table->timestamps();
        });
        Schema::create('role_user', function (Blueprint $table) {
            $table->increments('id')->primary();
            $table->integer('role_id');
            $table->integer('user_id');
            $table->timestamps();
        });
        Schema::create('refreshToken', function (Blueprint $table) {
            $table->bigInteger('character_id')->primary();
            $table->mediumText('refresh_token');
            $table->json('scopes');
            $table->dateTime('expires_on');
            $table->dateTime('deleted_at');
            $table->string('token');
            $table->timestamps();
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
            $table->integer('doctrine_id');
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
