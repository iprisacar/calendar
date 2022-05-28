<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_dates', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('allDay')->default(false);
            $table->timestamp('start')->nullable();
            $table->timestamp('end')->nullable();
            $table->unsignedInteger('event_id');
            $table->foreign('event_id')
                ->references('id')->on('events')
                ->onDelete('cascade');
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
        Schema::dropIfExists('event_date');
    }
};
