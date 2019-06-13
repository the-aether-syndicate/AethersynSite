<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixRefreshTokenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('refreshToken');
        Schema::create('refreshToken', function (Blueprint $table) {
            $table->bigInteger('character_id');

            $table->mediumText('refresh_token');
            $table->json('scopes');
            $table->timestamp('expires_on');
            $table->string('token');
            $table->string('description');
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
