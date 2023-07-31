<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigurationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configuration_details', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('status', [0, 1]);
            $table->unsignedBigInteger('type_id');
            $table->foreign('type_id')->references('id')->on('configuration_types')->onDelete('cascade');
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
        Schema::dropIfExists('configuration_details');
    }
}
