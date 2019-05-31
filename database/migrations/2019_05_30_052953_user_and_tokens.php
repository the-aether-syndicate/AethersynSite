<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserAndTokens extends Migration
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
        Schema::create('refreshToken', function (Blueprint $table) {
            $table->bigInteger('character_id')->primary();
            $table->mediumText('refresh_token');
            $table->json('scopes');
            $table->dateTime('expires_on');
            $table->dateTime('deleted_at');
            $table->string('token');
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
    }
}
