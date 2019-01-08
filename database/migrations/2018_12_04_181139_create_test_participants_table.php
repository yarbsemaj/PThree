<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_participants', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("police_force_id");
            $table->integer("route_into_role_id");
            $table->integer("test_series_id");
            $table->integer("training")->nullable();
            $table->integer("years_in_role");
            $table->integer("test_step")->default(0);
            $table->string("token");
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
        Schema::dropIfExists('test_participants');
    }
}
