<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixFleetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('fleet');
        Schema::create('fleet', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('fc');
            $table->string('fleet_name');
            $table->boolean('active');
            $table->boolean('complete');
            $table->text('loot');
            $table->timestamp('ended_at');
            $table->timestamp('start_at');
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
        Schema::dropIfExists('fleet');

    }
}
