<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMousePositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mouse_positions', function (Blueprint $table) {
            $table->increments('id');
            $table->double("x");
            $table->double("y");
            $table->bigInteger("time_stamp");
            $table->longText("event")->nullable();
            $table->integer("test_id");
            $table->integer("test_participant_id");
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
        Schema::dropIfExists('mouse_positions');
    }
}
