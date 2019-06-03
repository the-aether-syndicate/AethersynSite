<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFleetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fleet', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('fc');
            $table->string('fleet_name');
            $table->boolean('active');
            $table->boolean('complete');
            $table->text('loot');
            $table->timestamps();
        });
        Schema::create('punch', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamp('in_time');
            $table->timestamp('out_time');
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
