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
        Schema::dropIfExists('punch');
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
        Schema::create('punch', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamp('in_time')->nullable();
            $table->timestamp('out_time')->nullable();
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
        Schema::dropIfExists('punch');
    }
}
